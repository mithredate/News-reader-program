<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsArticleControllerTest extends TestCase
{
    use DatabaseTransactions;




    public function testIndex(){
        $user = factory(\App\User::class,'authenticated_user')->create();

        $this->actingAs($user)
            ->visit('home/articles')
            ->see('You have not published any news yet!');
        $articles = factory(\App\NewsArticle::class)->times(4)->create(['reporter_email' => $user->email]);
        $this->visit('home/articles')
            ->dontSee('You have not published any news yet!');
        $articles->each(function($article){
           $this->see($article->title);
        });
    }

    public function testCreate(){
        $user = factory(\App\User::class,'authenticated_user')->create();
        //TODO: have to check again
//        $this->actingAs($user)
//            ->visit('home/articles/create')
//            ->type('This is another test article','title')
//            ->type('Veniam vocibus voluptaria mel ne, id modo similique elaboraret eam. Quo cu cibo sale mutat, his at vivendo concludaturque, quo et quando accusata efficiendi. Has ea timeam euismod antiopam, nam vidisse tibique consectetuer an. Pri posse affert ponderum ea. Tale eros ignota in vel, diam saepe causae cu mea, ea accusam principes sed. Mel eligendi voluptatum theophrastus in. Ei posse etiam viris nec.','text')
//            ->attach('C:\Users\mithredate\Desktop\desktop\images\test.jpg','photo')
//            ->press('Save')
//            ->seeInDatabase('news_articles',['title' => 'This is another test article', 'reporter_email' => $user->email])
//            ->seePageIs('home/articles')
//            ->see('This is another test article');
    }


    public function testDestroy(){
        $user = factory(\App\User::class,'authenticated_user')->create();
        factory(\App\NewsArticle::class)->times(4)->create(['reporter_email' => $user->email]);
        $toDelete = $user->articles()->first();
        $this->actingAs($user)
            ->visit('home/articles')
            ->press('delete-article-' . $toDelete->id . '-button')
            ->assertCount(3, $user->articles()->get());
        $this->visit('home/articles')
            ->dontSee($toDelete->title);
        $accessDeniedOnDelete = $user->articles()->first();
        $anotherUser = factory(\App\User::class,'authenticated_user')->create();
        $this->actingAs($anotherUser)
            ->post('home/articles/' . $accessDeniedOnDelete->id,[
            '_token' => csrf_token(),
            '_method' => 'DELETE'
        ])->assertResponseStatus(403);
    }

}
