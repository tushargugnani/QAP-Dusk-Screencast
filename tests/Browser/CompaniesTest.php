<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\companiesCreate;
use Tests\Browser\Pages\companiesIndex;

class CompaniesTest extends DuskTestCase
{
    
    use WithFaker;

    public function setUp():void{
        parent::setUp();
    }


    /** @test */
    public function it_asserts_that_user_can_add_a_new_company()
    {

        factory('App\City',5)->create();
        factory('App\Category',5)->create();

        $fakeCompanyData = $this->getFakeCompanyData();

        $this->browse(function (Browser $browser) use($fakeCompanyData) {
            $browser->loginAs('admin@admin.com')
                    ->visit('/admin/companies')
                    ->clickLink('Add Company')
                    ->on(new companiesCreate)
                    ->fillFormDataAndSubmit($fakeCompanyData)
                    ->on(new companiesIndex)
                    ->assertCompanyDetails($fakeCompanyData);
        });
    }

    protected function getFakeCompanyData(){
        $faker = $this->faker;
        $name = $faker->company;
        $address = $faker->streetAddress;
        $description = $faker->sentences;
        $image = $faker->image('storage/app/public/images', 640, 480, 'cats', false);
        return compact('name', 'address', 'description', 'image');
    }
}
