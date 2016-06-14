<?php

namespace App\Http\Controllers;

use App\Libraries\FileManager;
use App\NewsArticle;
use App\Repositories\ArticlesRepository;
use App\Repositories\Criteria\UserArticles;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class NewsArticleController extends Controller
{
    public function index(Request $request, ArticlesRepository $repository){
        $articles = $repository->getByCriteria(new UserArticles($request->user()))->paginate(10);
        return view('news.index', compact('articles'));
    }

    public function create(){
        return view('news.create');
    }

    public function store(Request $request, ArticlesRepository $repository, FileManager $fileManager){
        $this->validate($request, [
           'title' => 'required|max:255|min:10',
            'text' => 'required|max:1000|min:100',
            'photo' => 'required|image'
        ]);
        $data = $request->only('title','text');
        $data['reporter_email'] = $request->user()->email;
        $response = $fileManager->uploadImage($request->file('photo'));
        switch ($response['status']){
            case $fileManager->SAVED_SUCCESSFULLY:
                $data['photo'] = $fileManager->getFileNameFromResponse($response);
                if($repository->create($data)){
                    Session::push('message', [
                        'type' => 'success',
                        'content' => 'Article Created Successfully!'
                    ]);
                    return redirect()->route('home.articles.index');
                } else{
                    Session::push('message', [
                        'type' => 'danger',
                        'content' => 'There was a problem saving the record!'
                    ]);
                    $fileManager->deleteImage($data['photo']);
                    return back()->withInput($request->input());
                }
            case $fileManager->INVALID_FILE:
            case $fileManager->ERROR_OCCURRED_SAVING:
            case $fileManager->INVALID_FILE_TYPE:
                Session::push('message', [
                    'type' => 'warning',
                    'content' => 'Problem uploading the file!'
                ]);
                $fileManager->deleteImage($data['photo']);
                return back()->withInput($request->input());

        }
    }

    public function destroy(ArticlesRepository $repository, $articles, FileManager $fileManager){
        $article = $repository->find($articles);
        if(Gate::denies('delete-article',$article)){
            abort(403);
        }
        Session::push('message', [
            'type' => 'warning',
            'content' => 'Successfully removed ' . $article->title . '!'
        ]);
        $fileManager->deleteImage($article->photo);
        $article->delete();
        return back();
    }
}
