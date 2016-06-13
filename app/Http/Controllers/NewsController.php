<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use \PDF;
use App\Http\Requests;

class NewsController extends Controller
{
    public function show(ArticleRepository $repository, $slug){
        $article = $repository->getBySlug($slug);
        return view('article.view', compact('article'));
    }

    public function pdf(ArticleRepository $repository, $slug){
        $article = $repository->getBySlug($slug);
        $pdf = PDF::loadView('article.pdf', compact('article'));
//        return $pdf->download($article->title . '.pdf');
        return $pdf->stream();
    }
}
