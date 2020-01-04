<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class AdvancedSearch extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '.advance-search';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@search-box' => 'input[name="search"]',
            '@category-select' => 'select[name="categories"]',
            '@city-select' => 'select[name="city_id"]',
            '@submit' => 'button[type="submit"]',
        ];
    }

    public function search(Browser $browser, $company, $category, $city){
        $browser->type('@search-box', $company)
                ->select('@category-select', $category)
                ->select('@city-select', $city)
                ->click('@submit');
    }
}
