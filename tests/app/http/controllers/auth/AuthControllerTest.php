<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\DB;
use Laracasts\TestDummy\Factory;

class AuthControllerTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegistrationWithNoEmail()
    {
        $this->visit('register')
            ->press('Register')
            ->see('The email field is required.')
            ->seePageIs('register');
    }

    public function testRegisterationWithEmail(){

        factory(\App\User::class, 'authenticated_user', 10)->create();

        factory(\App\User::class, 'verified_user', 10)->create();

        factory(\App\User::class, 10)->create()
        ->each(function($u){
            DB::table('password_resets')->insert(['token' => 'test', 'email' => $u->email]);
        });

        factory(\App\User::class)->create([
            'email' => 'test@test.com'
        ])
            ->each(function($u){
                DB::table('password_resets')->insert(['token' => 'test', 'email' => $u->email]);
            });

        $this->visit('register')
            ->type('ak47@thisis.test','email')
            ->press('Register')
            ->see('Verification email sent successfully. Please verify you\'re email to continue')
            ->seeInDatabase('users',['email' => 'ak47@thisis.test', 'status' => '0', 'password' => ''])
            ->seeInDatabase('password_resets',['email' => 'ak47@thisis.test'])
            ->seePageIs('register');

        $firstToken = DB::table('password_resets')->where('email','ak47@thisis.test')->value('token');

        $this->visit('register')
            ->type('ak47@thisis.test','email')
            ->press('Register')
            ->see('The email has already been taken.')
            ->seePageIs('register');

        $secondToken = DB::table('password_resets')->where('email','ak47@thisis.test')->value('token');

        $this->assertEquals($firstToken, $secondToken);

        $this->visit('verify/'.$firstToken.'?email='.urlencode('ak47@thisis.test'))
            ->see('Thank you for verifying your email address');

        $this->visit('verify/'.$firstToken.'?email='.urlencode('ak47@thisis.test'))
            ->see('You have already verified your email address!')
            ->see('You have to set a password to be able to access your account!')
            ->type('ak47@thisis.test','email')
            ->type('123123','password')
            ->type('12312','password_confirmation')
            ->press('Set Password')
            ->see('The password confirmation does not match.');

        $this->visit('verify/'.$firstToken.'?email='.urlencode('ak47@thisis.test'))
            ->see('You have already verified your email address!')
            ->see('You have to set a password to be able to access your account!')
            ->type('','email')
            ->press('Set Password')
            ->see('The email field is required.')
            ->see('The password field is required.');

        $this->visit('verify/'.$firstToken.'?email='.urlencode('ak47@thisis.test'))
            ->see('You have already verified your email address!')
            ->see('You have to set a password to be able to access your account!')
            ->type('ak47@thisis.test','email')
            ->type('123123','password')
            ->type('123123','password_confirmation')
            ->press('Set Password')
            ->see('Thank you for setting your password')
            ->see('Your registration is now complete. You can start using our services!')
            ->seePageIs('home');


        $this->click('ak47@thisis.test')
            ->click('Logout')
            ->seePageIs('/');

    }

    public function testLogin(){
        $user = factory(\App\User::class, 'authenticated_user')->create([
            'password' => bcrypt('123123')
        ]);

        $this->visit('/')
            ->click('Login')
            ->seePageIs('login')
            ->type($user->email, 'email')
            ->type('123123','password')
            ->press('Login')
            ->seePageIs('home');
    }
}
