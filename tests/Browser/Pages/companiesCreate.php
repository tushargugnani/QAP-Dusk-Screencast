<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class companiesCreate extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/companies/create';
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

    public function fillFormDataAndSubmit(Browser $browser, $fakeCompanyData){
            $browser->pause(4000)
                    ->type('name', $fakeCompanyData['name'])
                    ->type('address', $fakeCompanyData['address'])
                    ->type('description', $fakeCompanyData['description'])
                    ->select('city_id')
                    ->select('categories[]')
                    ->attach('logo', storage_path('app/public/images/'.$fakeCompanyData['image']))
                    ->press('Save');
    }

   
}
