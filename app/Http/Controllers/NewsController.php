<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class NewsController extends Controller
{
    public function show(ArticleRepository $repository, $slug){
        $article = $repository->getBySlug($slug);
        return view('article.view', compact('article'));
    }
}
