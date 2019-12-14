<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class citiesCreate extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/cities/create';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
                ->assertSee('Create City');
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
    
    public function fillAndSubmitForm(Browser $browser, $cityName){
        $browser->type('name', $cityName)
                     ->press('Save');
    }
}
