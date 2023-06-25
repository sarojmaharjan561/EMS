<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_employee_can_be_added()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/employees',[
            'first_name' => 'Ram',
            'last_name' => 'Thapa',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625'
        ]);

        $response->assertOk();      
        $this->assertCount(1,Employee::all());
   
    }

    public function test_first_name_is_required() 
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/employees',[
            'first_name' => '',
            'last_name' => 'Thapa',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625'
        ]);

        $response->assertSessionHasErrors('first_name');

    }

    public function test_last_name_is_required() 
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/employees',[
            'first_name' => 'Ram',
            'last_name' => '',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625'
        ]);

        $response->assertSessionHasErrors('last_name');

    }

    public function test_employee_can_be_updated(){
    
        $this->withoutExceptionHandling();
        $this->post('/employees',[
            'first_name' => 'Ram',
            'last_name' => 'Thapa',
            'email' => 'ram.thapa007@gmail.com',
            'phone' => '9841253625'
        ]);

        $employee = Employee::first();

        $this->patch('/employees/'.$employee->id,[
            'first_name' => 'Rama',
            'last_name' => 'Lama',
            'email' => 'rama.lama007@gmail.com',
            'phone' => '9841253645'
        ]);

        $this->assertEquals('Rama',Employee::first()->first_name);      
        $this->assertEquals('Lama',Employee::first()->last_name);      
        $this->assertEquals('rama.lama007@gmail.com',Employee::first()->email);      
        $this->assertEquals('9841253645',Employee::first()->phone);     
    }
}
