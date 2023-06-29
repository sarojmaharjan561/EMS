<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompaniesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_companies_can_be_added()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/company',[
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $company = Company::first();

        $this->assertCount(1,Company::all());

        $response->assertRedirect($company->path());
        
    }

    public function test_companies_name_is_required() 
    {
        
        $response = $this->post('/company',[
            'name' => '',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $response->assertSessionHasErrors('name');        
        
    }

    public function test_companies_can_be_updated() 
    {
        $this->withoutExceptionHandling();
        $this->post('/company',[
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $company = Company::first();

        $data = $this->patch($company->path(),[
            'name' => 'Shyam Corporation',
            'email' => 'shyamcorp@gmail.com',
            'website' => 'shyamcorp.com',
            // 'logo' => ''
        ]);

        $this->assertEquals('Shyam Corporation',Company::first()->name);  
        $this->assertEquals('shyamcorp@gmail.com',Company::first()->email);
        $this->assertEquals('shyamcorp.com',Company::first()->website);

        $data->assertRedirect($company->path());

    }

    public function test_companies_can_be_deleted() 
    {
        $company = $this->post('/company',[
            'name' => 'Ram Corporation',
            'email' => 'ramcorp@gmail.com',
            'website' => 'ramcorp.com',
            // 'logo' => ''
        ]);

        $company = Company::first();

        $this->assertCount(1,Company::all());

        $response = $this->delete('/company/'.$company->id);

        $this->assertCount(0,Company::all());

        $response->assertRedirect('/company');

    }
}
