<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_companies_before_creating_employee()
    {
        $this->post('/company', [
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $company = Company::first();

        $this->assertCount(1, Company::all());

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_employee_can_be_added()
    {
        $this->withoutExceptionHandling();

        // $this->truncate_companies_table();

        $this->post('/company', [
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $this->assertCount(1, Company::all());
        $company = Company::first();

        $response = $this->post('/employees', [
            'company_id' => $company->id,
            'first_name' => 'Ram',
            'last_name' => 'Thapa',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625',
        ]);

        $employee = Employee::first();
        $this->assertCount(1, Employee::all());
        $response->assertRedirect($employee->path());

    }

    public function test_first_name_is_required()
    {
        // $this->withoutExceptionHandling();

        $this->post('/company', [
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $this->assertCount(1, Company::all());
        $company = Company::first();

        $response = $this->post('/employees', [
            'company_id' => $company->id,
            'first_name' => '',
            'last_name' => 'Thapa',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625',
        ]);

        $response->assertSessionHasErrors('first_name');

    }

    public function test_last_name_is_required()
    {
        // $this->withoutExceptionHandling();
        $this->post('/company', [
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $this->assertCount(1, Company::all());
        $company = Company::first();

        $response = $this->post('/employees', [
            'company_id' => $company->id,
            'first_name' => 'Ram',
            'last_name' => '',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625',
        ]);

        $response->assertSessionHasErrors('last_name');

    }

    public function test_company_is_required()
    {
        $response = $this->post('/employees', [
            'company_id' => '',
            'first_name' => 'Ram',
            'last_name' => '',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625',
        ]);

        $response->assertSessionHasErrors('company_id');

    }

    public function test_employee_can_be_updated()
    {

        $this->post('/company', [
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $this->assertCount(1, Company::all());
        $company = Company::first();

        $this->post('/employees', [
            'company_id' => $company->id,
            'first_name' => 'Ram',
            'last_name' => 'Thapa',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625',
        ]);

        $employee = Employee::first();

        $this->post('/company', [
            'name' => 'Shyam Corporation',
            'email' => 'shyamcorp@gmail.com',
            'website' => 'shyamcorp.com',
            // 'logo' => ''
        ]);

        $new_company = Company::where('name', 'Shyam Corporation')->first();

        $response = $this->patch($employee->path(), [
            'company_id' => $new_company->id,
            'first_name' => 'Rama',
            'last_name' => 'Lama',
            'email' => 'rama.lama007@gmail.com',
            'phone' => '9841253645',
        ]);

        $this->assertEquals('6', Employee::first()->company_id);
        $this->assertEquals('Rama', Employee::first()->first_name);
        $this->assertEquals('Lama', Employee::first()->last_name);
        $this->assertEquals('rama.lama007@gmail.com', Employee::first()->email);
        $this->assertEquals('9841253645', Employee::first()->phone);

        $response->assertRedirect($employee->path());
    }

    public function test_employee_can_be_deleted()
    {
        $this->post('/company', [
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $this->assertCount(1, Company::all());
        $company = Company::first();

        $this->assertCount(1, Company::all());

        $this->post('/employees', [
            'company_id' => $company->id,
            'first_name' => 'Ram',
            'last_name' => 'Thapa',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625',
        ]);

        $employee = Employee::first();

        $this->assertCount(1, Employee::all());

        $response = $this->delete($employee->path());

        $this->assertCount(0, Employee::all());

        $response->assertRedirect('/employees');
    }
}
