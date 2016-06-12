@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Your Published News <a href="{{ route('home.articles.create') }}" class="pull-right"><i class="fa fa-newspaper-o"></i> Publish News</a></div>

                    <div class="panel-body">
                        @if($articles->count() > 0)
                        @foreach($articles as $article)
                            <div class="media">
                                <div class="media-left">
                                    <img class="media-object" src="{{ url('gallery/' . $article->photo) }}?w=100" alt="{{ $article->title }}">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        {{ $article->title }}
                                        <form action="{{ route('home.articles.destroy',['articles' => $article->id]) }}" method="POST" class="form-inline pull-right" name="delete-article-{{$article->id}}">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" name="delete-article-{{$article->id}}-button" class="btn btn-danger" title="Delete {{ $article->title }}"><i class="fa fa-remove"></i></button>
                                        </form>
                                    </h4>
                                    {!! \Illuminate\Support\Str::limit($article->text) !!}
                                </div>
                            </div>
                        @endforeach
                        @else
                            <div class="alert alert-info">You have not published any news yet! click <a href="{{ route('home.articles.create') }}">here</a> to start!</div>
                        @endif
                    </div>
                    <div class="panel-footer">
                        {!! $articles->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
