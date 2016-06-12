<?php

namespace App\Http\Controllers;

use App\NewsArticle;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class NewsArticleController extends Controller
{
    public function index(Request $request, ArticleRepository $repository){
        $articles = $repository->getUserArticles($request->user());
        return view('news.index', compact('articles'));
    }

    public function create(){
        return view('news.create');
    }

    public function store(Request $request, ArticleRepository $repository){
        $this->validate($request, [
           'title' => 'required|max:255|min:10',
            'text' => 'required|max:1000|min:100',
            'photo' => 'required|image'
        ]);
        $response = $repository->store($request);
        switch ($response){
            case ArticleRepository::$SAVED_SUCCESSFULLY:
                return redirect()->route('home.articles.index');
            case ArticleRepository::$ERROR_OCCURRED_SAVING:
            default:
                return back()->withInput($request->input());
        }
    }

    public function destroy(ArticleRepository $repository, $articles){
        $repository->remove($articles);
        return back();
    }
}
