<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class citiesIndex extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/cities';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    public function assertSeeCity(Browser $browser, $cityName){
        $browser->assertSee($cityName);
    }

    public function assertDontSeeCity(Browser $browser, $cityName){
        $browser->assertDontSee($cityName);
    }

    public function assertSeeCities(Browser $browser, $cities){
        foreach($cities as $city){
            $browser->assertSee($city->name);
        }
    }

    public function pressViewButton(Browser $browser, $cityId){
        $browser->click('@viewButton'.$cityId);
    }

    public function pressEditButton(Browser $browser, $cityId){
        $browser->click('@editButton'.$cityId);
    }

    public function pressDeleteButton(Browser $browser, $cityId){
        $browser->click('@deleteButton'.$cityId);
    }

    public function pressAddCityButton(Browser $browser){
        $browser->clickLink('Add City');
    }

    public function deleteCity(Browser $browser){
        $browser->assertDialogOpened('Are you sure?')
            ->acceptDialog()
            ->assertPathIs('/admin/cities');
    }

}
