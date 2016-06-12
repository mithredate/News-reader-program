<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\NewsArticle;
use App\Repositories\ArticleRepository;
use App\User;
use Faker\Generator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param ArticleRepository $repository
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->latest(10);
        return view('home', compact('articles'));
    }
}
