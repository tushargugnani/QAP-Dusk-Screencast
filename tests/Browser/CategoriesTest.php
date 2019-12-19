<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\QAPDuskTestCase;
use Tests\Browser\Pages\categoriesEdit;
use Tests\Browser\Pages\categoriesShow;
use Tests\Browser\Pages\categoriesIndex;
use Tests\Browser\Pages\categoriesCreate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoriesTest extends QAPDuskTestCase
{
    use WithFaker;

    /** @test */
    public function it_asserts_that_user_can_read_all_categories(){
        $categories = factory('App\Category', 10)->create();

        $this->browse(function(Browser $browser) use($categories){
            $browser->loginAs('admin@admin.com')
                    ->visit(new categoriesIndex)
                    ->assertSeeCategories($categories);
        });
    }

    /** @test */
    public function it_asserts_that_user_can_read_a_single_category(){
        $category = factory('App\Category', 5)->create();
        $randomCategory = $category->random();

        $this->browse(function(Browser $browser) use($randomCategory){
            $browser->loginAs('admin@admin.com')
                    ->visit(new categoriesIndex)
                    ->pressViewButton($randomCategory->id)
                    ->visit(new categoriesShow($randomCategory->id))
                    ->assertSeeCategoryDetails($randomCategory);
        });
    }

    /** @test */
    public function it_asserts_that_user_can_add_a_new_category(){

        $categoryName = $this->faker->word;

        $this->browse(function(Browser $browser) use ($categoryName){
            $browser->loginAs('admin@admin.com')
                    ->visit(new categoriesIndex)
                    ->pressAddCategoryButton()
                    ->on(new categoriesCreate)
                    ->fillAndSubmitForm($categoryName)
                    ->on(new categoriesIndex)
                    ->assertSeeCategory($categoryName);
            
        });

        $this->assertDatabaseHas('categories', ['name' => $categoryName]);
    }

    /** @test */
    public function it_asserts_that_user_can_edit_a_category(){

        $category = factory('App\Category', 5)->create();
        $randomCategory = $category->random();

        $this->browse(function(Browser $browser) use ($randomCategory){
            $browser->loginAs('admin@admin.com')
                    ->visit(new categoriesIndex)
                    ->pressEditButton($randomCategory->id)
                    ->on(new categoriesEdit($randomCategory->id))
                    ->fillAndSubmitForm()
                    ->on(new categoriesIndex)
                    ->assertSeeCategory($randomCategory->name.' Edited');
            
        });

        $this->assertDatabaseHas('categories', ['name' => $randomCategory->name.' Edited']);
    }

    /** @test */
    public function it_asserts_that_user_can_delete_a_category(){

        $category = factory('App\Category', 5)->create();
        $randomCategory = $category->random();

        $this->browse(function(Browser $browser) use ($randomCategory){
            $browser->loginAs('admin@admin.com')
                    ->visit(new categoriesIndex)
                    ->pressDeleteButton($randomCategory->id)
                    ->deleteCategory()
                    ->assertDontSeeCategory($randomCategory->name);            
        });

        $this->assertSoftDeleted('categories', ['name' => $randomCategory->name]);
    }

    /** @test */
    public function it_asserts_that_user_can_delete_multiple_category(){
        $category = factory('App\Category', 10)->create();
        $randomCategory = $category->random(3);

        $this->browse(function(Browser $browser) use ($randomCategory){
            $browser->loginAs('admin@admin.com')
                    ->visit(new categoriesIndex)
                    ->pause(2000)
                    ->selectCategories($randomCategory)
                    ->pressDeleteSelected()
                    ->deleteCategory()
                    ->pause(2000)
                    ->assertDontSeeCategories($randomCategory);
        });
    }
}
