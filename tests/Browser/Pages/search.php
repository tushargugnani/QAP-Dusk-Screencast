<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class search extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/search';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathBeginsWith($this->url());
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

    public function assertSearchResultCount(Browser $browser, $count){
        $browser->assertSeeIn('.search-result', $count.' Result');
    }

    public function assertSearchResults(Browser $browser, $comapnies){
        foreach($comapnies as $company){
            $browser->assertSeeIn('.product-grid-list', $company->name);
        }
        
    }

    public function assertSearchResult(Browser $browser, $company){
        $browser->assertSeeIn('.product-grid-list', $company->name);
    }


}
