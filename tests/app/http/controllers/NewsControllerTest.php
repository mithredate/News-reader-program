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

    public function testPDFDownload(){
        $article = factory(\App\NewsArticle::class)->create();
        $this->visit($article->slug)
            ->click('Download PDF')
            ->assertResponseStatus(200)
            ->seePageIs($article->slug . '/pdf');
    }
}
