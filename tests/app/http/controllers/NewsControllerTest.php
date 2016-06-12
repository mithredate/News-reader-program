<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testRecentArticle(){
        $article = factory(\App\NewsArticle::class)->create();
        $this->get($article->slug)
            ->assertResponseStatus(200);
    }
}
