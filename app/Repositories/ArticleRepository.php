<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-12
 * Time: 3:58 PM
 */

namespace App\Repositories;


use App\NewsArticle;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ArticleRepository
{

    public static $ERROR_OCCURRED_SAVING = 0;
    public static $SAVED_SUCCESSFULLY = 1;

    protected $photoDirectory;

    public function __construct()
    {
        $this->photoDirectory = app('filesystem')->disk('gallery')->getDriver()->getAdapter()->getPathPrefix();
    }


    public function store(Request $request){
        $data = $request->only(['title','text']);
        if ($request->file('photo')->isValid() ) {
            $filename = time(). '_' .$request->file('photo')->getClientOriginalName();
            $request->file('photo')->move($this->photoDirectory , $filename );
            $data['photo'] = $filename;
            $data['reporter_email'] = $request->user()->email;
            NewsArticle::create($data);
            Session::push('message', [
                'type' => 'success',
                'content' => 'Article Created Successfully!'
            ]);
            return self::$SAVED_SUCCESSFULLY;
        }
        Session::push('message', [
            'type' => 'danger',
            'content' => 'Problem occurred during the save process!'
        ]);
        return self::$ERROR_OCCURRED_SAVING;
    }

    public function getBySlug($slug)
    {
        return NewsArticle::where('slug',$slug)->firstOrFail();
    }

    public function latest($count)
    {
        return NewsArticle::latest()->limit($count)->get();
    }

    public function getUserArticles(User $user, $per_page = 10)
    {
       return $user->articles()->latest()->paginate($per_page);
    }

    public function remove($articles)
    {
        $article = NewsArticle::findOrFail($articles);
        if(Gate::denies('delete-article',$article)){
            abort(403);
        }
        Session::push('message', [
            'type' => 'warning',
            'content' => 'Successfully removed ' . $article->title . '!'
        ]);
        if(file_exists($this->photoDirectory . PATH_SEPARATOR . $article->photo)) {
            unlink($this->photoDirectory . PATH_SEPARATOR . $article->photo);
        }
        $article->delete();
    }
}