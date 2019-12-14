<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class citiesShow extends Page
{
    protected $city_id;

    public function __construct($city_id){
        $this->city_id = $city_id;
    }
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/cities/'.$this->city_id;
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

    public function assertSeeCityDetails(Browser $browser, $city){
        $browser->assertSee($city->id)
                ->assertSee($city->name);
    }
}
