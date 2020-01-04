<?php

namespace Tests\Browser;

use App\Company;
use App\Category;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\QAPDuskTestCase;
use Tests\Browser\Pages\search;
use Tests\Browser\Components\AdvancedSearch;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchTest extends QAPDuskTestCase
{

    protected $cities;
    protected $categories;


    public function setUp(): void{
        parent::setUp();

        $this->cities = factory('App\City', 3)->create();
        $this->categories = factory('App\Category', 3)
                            ->create()
                            ->each(function($category){
                                $category->companies()->createMany(factory('App\Company', 10)->make()->toArray());
                            });
    }

    /** @test */
    public function it_asserts_that_user_can_search_all_companies_within_a_city_and_category()
    {

        $randomCategoryId = $this->categories->random()->id;
        $randomCityId = $this->cities->random()->id;

        $companies = Category::find($randomCategoryId)->companies()->where('city_id', $randomCityId)->get();

        $this->browse(function (Browser $browser) use($randomCategoryId, $randomCityId, $companies)  {
            $browser->visit('/')
                    ->within(new AdvancedSearch, function(Browser $browser) use($randomCategoryId,$randomCityId){
                            $browser->search('',$randomCategoryId, $randomCityId);
                    })
                    ->on(new search)
                    ->assertSearchResultCount(count($companies))
                    ->assertSearchResults($companies);
        });
    }

    /** @test */
    public function it_asserts_that_user_can_search_specific_comapny(){

        $searchForCompany = Company::all()->random();

        $this->browse(function (Browser $browser) use($searchForCompany)  {
            $browser->visit('/')
                    ->within(new AdvancedSearch, function(Browser $browser) use($searchForCompany){
                            $browser->search($searchForCompany->name, $searchForCompany->categories->first()->id, $searchForCompany->city->id);
                    })
                    ->on(new search)
                    ->assertSearchResultCount(1)
                    ->assertSearchResult($searchForCompany);
        });
    }
}
