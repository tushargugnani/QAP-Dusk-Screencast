<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\QAPDuskTestCase;
use Tests\Browser\Pages\citiesEdit;
use Tests\Browser\Pages\citiesShow;
use Tests\Browser\Pages\citiesIndex;
use Tests\Browser\Pages\citiesCreate;
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
                    ->visit(new citiesIndex)
                    ->assertSeeCities($cities);
        });
    }

    /** @test */
    public function it_asserts_that_user_can_read_a_single_cities(){
        $city = factory('App\City', 5)->create();
        $randomCity = $city->random();

        $this->browse(function(Browser $browser) use($randomCity){
            $browser->loginAs('admin@admin.com')
                    ->visit(new citiesIndex)
                    ->pressViewButton($randomCity->id)
                    ->visit(new citiesShow($randomCity->id))
                    ->assertSeeCityDetails($randomCity);
        });
    }

    /** @test */
    public function it_asserts_that_user_can_add_a_new_city(){

        $cityName = $this->faker->city;

        $this->browse(function(Browser $browser) use ($cityName){
            $browser->loginAs('admin@admin.com')
                    ->visit(new citiesIndex)
                    ->pressAddCityButton()
                    ->on(new citiesCreate)
                    ->fillAndSubmitForm($cityName)
                    ->on(new citiesIndex)
                    ->assertSeeCity($cityName);
            
        });

        $this->assertDatabaseHas('cities', ['name' => $cityName]);
    }


     /** @test */
     public function it_asserts_that_user_can_edit_a_city(){

        $city = factory('App\City', 5)->create();
        $randomCity = $city->random();

        $this->browse(function(Browser $browser) use ($randomCity){
            $browser->loginAs('admin@admin.com')
                    ->visit(new citiesIndex)
                    ->pressEditButton($randomCity->id)
                    ->on(new citiesEdit($randomCity->id))
                    ->fillAndSubmitForm()
                    ->on(new citiesIndex)
                    ->assertSeeCity($randomCity->name.' Edited');
            
        });

        $this->assertDatabaseHas('cities', ['name' => $randomCity->name.' Edited']);
    }


    /** @test */
    public function it_asserts_that_user_can_delete_a_city(){

        $city = factory('App\City', 5)->create();
        $randomCity = $city->random();

        $this->browse(function(Browser $browser) use ($randomCity){
            $browser->loginAs('admin@admin.com')
                    ->visit(new citiesIndex)
                    ->pressDeleteButton($randomCity->id)
                    ->deleteCity()
                    ->assertDontSeeCity($randomCity->name);
            
        });

        $this->assertSoftDeleted('cities', ['name' => $randomCity->name]);
    }















    
 
}
