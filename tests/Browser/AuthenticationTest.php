<?php

namespace Tests\Browser;

use Tests\QAPDuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends QAPDuskTestCase
{
    protected $user;
    protected $adminUser;
    protected $nonAdminUser;

    public function setUp(): void{
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->adminUser = factory('App\User')->state('admin_user')->create();
        $this->nonAdminUser = factory('App\User')->state('non_admin_user')->create();

    }

    /** @test */
    public function it_asserts_that_user_can_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Classifieds')
                    ->type('email', 'admin@admin.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/admin/companies')
                    ->assertSee('Company List')
                    ->assertAuthenticated();
        });
    }

    /** @test */
    public function it_asserts_that_user_can_logout()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                    ->visit('/admin')
                    ->clickLink('Logout')
                    ->assertGuest();
        });
    }

    /** @test */
    public function it_asserts_that_incorrect_login_fails()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Classifieds')
                    ->type('email', 'admin@admin.com')
                    ->type('password', '12345')
                    ->press('Login')
                    ->assertPathIs('/login')
                    ->assertSee('These credentials do not match our records')
                    ->assertElementHasClass('input[name="email"]', 'is-invalid');

            
        });
    }

    /** @test */
    public function it_asserts_that_admin_user_can_access_user_management_section()
    {
        $adminUser = $this->adminUser;
        $this->browse(function (Browser $browser) use($adminUser) {
           $browser->loginAs($adminUser)
                    ->visit('/admin')
                    ->assertSee('User management')
                    ->visit('/admin/users')
                    ->assertSee('User List');
           
        });
    }


    /** @test */
    public function it_asserts_that_nonadmin_user_cannon_access_user_management_section()
    {
        $nonAdminUser = $this->nonAdminUser;
        $this->browse(function (Browser $browser) use($nonAdminUser) {
           $browser->loginAs($nonAdminUser)
                    ->visit('/admin')
                    ->assertDontSee('User management')
                    ->visit('/admin/users')
                    ->assertSee('Forbidden'); 
        });
    }


}
