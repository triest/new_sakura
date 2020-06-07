<?php

namespace Tests\Browser;

use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends DuskTestCase
{

    /**
     * Проверка регистрации в LK
     * @test
     */
    public function testNormalRegistration()
    {
        DB::table('users')->where('name', 'UserTest')->delete();
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('lk.register')
                ->assertSee('Регистрация')
                ->type('name', 'UserTest')
                ->type('surname', 'Surname')
                ->type('email', 'user-test@test.local')
                ->type('phone', '9998887766')
                ->type('password', '11111111')
                ->type('password_confirmation', '11111111')
                ->press('ЗАРЕГИСТРИРОВАТЬСЯ')
                ->assertSee('Проверка электронной почты');
        });
    }

    /**
     * Проверка регистрации в ADMIN
     * @test
     */
    public function testAdminRegistration()
    {
        DB::table('admins')->where('name', 'AdminTest')->delete();
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.register')
                ->assertSee('Регистрация персонала')
                ->type('name', 'AdminTest')
                ->type('surname', 'Surname')
                ->type('email', 'admin-test@test.local')
                ->type('password', '11111111')
                ->type('password_confirmation', '11111111')
                ->press('ЗАРЕГИСТРИРОВАТЬСЯ')
                ->assertSee('ADMIN');
        });
    }

}
