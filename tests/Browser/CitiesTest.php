<?php

namespace Tests\Browser;

use Tests\QAPDuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CitiesTest extends QAPDuskTestCase
{

    use WithFaker;

    /** @test */
    public function it_asserts_that_user_can_read_all_cities(){
        $cities = factory('App\City', 10)->create();

        $this->browse(function(Browser $browser) use($cities){
            $browser->loginAs('admin@admin.com')
                    ->visit('/admin/cities')
                    ->assertSee($cities->random()->name);
        });
    }

    /** @test */
    public function it_asserts_that_user_can_read_a_single_cities(){
        $city = factory('App\City')->create();

        $this->browse(function(Browser $browser) use($city){
            $browser->loginAs('admin@admin.com')
                    ->visit('/admin/cities/'.$city->id)
                    ->assertSee($city->id)
                    ->assertSee($city->name);
        });
    }

    /** @test */
    public function it_asserts_that_user_can_add_a_new_city(){

        $city = $this->faker->city;

        $this->browse(function(Browser $browser) use ($city){
            $browser->loginAs('admin@admin.com')
                    ->visit('/admin/cities/create')
                    ->assertSee('Create City')
                    ->type('name', $city)
                    ->press('Save')
                    ->assertPathIs('/admin/cities')
                    ->assertSeeIn('#DataTables_Table_0 > tbody > tr:nth-child(1) > td:nth-child(3)',$city);
            
        });

        $this->assertDatabaseHas('cities', ['name' => $city]);
    }


     /** @test */
     public function it_asserts_that_user_can_edit_a_city(){

        $city = factory('App\City')->create();

        $this->browse(function(Browser $browser) use ($city){
            $browser->loginAs('admin@admin.com')
                    ->visit('/admin/cities/'.$city->id.'/edit')
                    ->assertSee('Edit City')
                    ->append('name', ' Edited')
                    ->press('Save')
                    ->assertPathIs('/admin/cities')
                    ->assertSeeIn('#DataTables_Table_0 > tbody > tr:nth-child(1) > td:nth-child(3)',$city->name.' Edited');
            
        });

        $this->assertDatabaseHas('cities', ['name' => $city->name.' Edited']);
    }


    /** @test */
    public function it_asserts_that_user_can_delete_a_city(){

        $city = factory('App\City')->create();

        $this->browse(function(Browser $browser) use ($city){
            $browser->loginAs('admin@admin.com')
                    ->visit('/admin/cities')
                    ->click('#DataTables_Table_0 > tbody > tr:nth-child(1) > td:nth-child(4) > form > input.btn.btn-xs.btn-danger')
                    ->assertDialogOpened('Are you sure?')
                    ->acceptDialog()
                    ->assertPathIs('/admin/cities')
                    ->pause(4000)
                    ->assertDontSee($city->name);
            
        });

        $this->assertSoftDeleted('cities', ['name' => $city->name]);
    }















    
 
}
