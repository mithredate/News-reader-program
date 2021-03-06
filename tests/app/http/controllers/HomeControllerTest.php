<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex(){
        $this->visit('/')->assertViewHas('articles');
        $articles = \App\NewsArticle::latest()->limit(10)->get();
        $articles->each(function($article){
            $this->see($article->title);
        });

    }

    public function testPublicNews(){
        \Illuminate\Support\Facades\DB::table('news_articles')->truncate();

        $this->assertCount(0,\App\NewsArticle::all());
        $this->visit('/')
            ->see('No recent news! Want to be the one to tell us what is going on?')
            ->see('Start by registering')
            ->dontSee('Publish your first news');
        $firstArticle = factory(\App\NewsArticle::class)->create();
        $this->visit('/')
            ->see($firstArticle->title)
            ->dontSee('No recent news!');
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

    public function testPublicNewsLoggedIn(){
        \Illuminate\Support\Facades\DB::table('news_articles')->truncate();

        $user = factory(\App\User::class,'authenticated_user')->create();

        $this->actingAs($user)
            ->visit('home')
            ->see('No recent news! Want to be the one to tell us what is going on?');
        factory(\App\User::class,'authenticated_user',5)->create()
            ->each(function($u){
                factory(\App\NewsArticle::class)->times(random_int(1,4))->create(['reporter_email' => $u->email]);
            });
        $this->visit('home')
            ->dontSee('No recent news! Want to be the one to tell us what is going on?');
    }
}
