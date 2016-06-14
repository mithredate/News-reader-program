<?php

namespace App\Http\Controllers;

use App\Repositories\ArticlesRepository;
use Illuminate\Http\Request;
use \PDF;
use App\Http\Requests;

class NewsController extends Controller
{
    public function show(ArticlesRepository $repository, $slug){
        $article = $repository->findBy('slug',$slug);
        return view('article.view', compact('article'));
    }

    public function pdf(ArticlesRepository $repository, $slug){
        $article = $repository->findBy('slug',$slug);
        $pdf = PDF::loadView('article.pdf', compact('article'));
        return $pdf->download($article->title . '.pdf');
    }
}
