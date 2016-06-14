<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\NewsArticle;
use App\Repositories\ArticlesRepository;
use App\Repositories\Criteria\Latest;
use App\Repositories\Criteria\Limit;
use App\User;
use Bosnadev\Repositories\Eloquent\Repository;
use Faker\Generator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param ArticlesRepository $articles
     * @return \Illuminate\Http\Response
     * @internal param Articles $repository
     * @internal param Request $request
     */
    public function index(ArticlesRepository $articles)
    {
        $articles = $articles->pushCriteria(new Latest())->pushCriteria(new Limit(10))->all();
        return view('home', compact('articles'));
    }
}
