<?php

namespace App\Providers;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Support\ServiceProvider;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Browser::macro('assertElementHasClass', function ($element, $class) {
            
            PHPUnit::assertTrue(
                in_array($class, explode(" ",
                $this->attribute($element, 'class'))),
             "Did not see expected value [$class] within element [$element]"
            );

            return $this;
        });
    }
}
