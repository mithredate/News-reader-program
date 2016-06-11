<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase
{
    public function testHomePage(){
        $this->visit('/')
            ->see('Your Application\'s Landing Page.');
    }

    public function testRegisterLink(){
        $this->visit('/')
            ->click('Register')
            ->seePageIs('register');
    }
    public function testClickHomeNotAuthenticated(){
        $this->visit('/')
            ->click('Home')
            ->seePageIs('login');
    }
}
