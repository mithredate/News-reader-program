<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex(){
        $this->visit('/')->assertViewHas('articles');
        $repository = new \App\Repositories\ArticleRepository();
        $repository->latest(10)->each(function($article){
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
        factory(\App\NewsArticle::class)->create(['title' => 'This is a test article']);
        $this->visit('/')
            ->see('This is a test article')
            ->dontSee('No recent news!');
        factory(\App\NewsArticle::class)->times(10)->create();
        $this->visit('/')
            ->dontSee('This is a test article');

        factory(\App\NewsArticle::class)->create(['title' => 'This is another test article']);
        $this->visit('/')
            ->see('This is another test article');
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

        factory(\App\NewsArticle::class)->create(['title' => 'This is a test article']);


        $this->seeInDatabase('news_articles',['title' => 'This is a test article'])
            ->visit('home')->see('This is a test article');

    }
}
