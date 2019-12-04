<?php

namespace Tests;

class QAPDuskTestCase extends DuskTestCase{

    protected static $migrationRun = false;

    public function setUp(): void{
        parent::setUp();

        if(!static::$migrationRun){
            $this->artisan('migrate:refresh');
            $this->artisan('db:seed');
            static::$migrationRun = true;
        }
   }

}