@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Recent News</div>

                    <div class="panel-body">
                        @if($articles->count() > 0)
                            @foreach($articles as $article)
                                <a href="{{ route('articles.show',['slug' => $article->slug]) }}">
                                    <div class="well media">
                                        <div class="media-left">
                                            <img class="media-object img-rounded" src="{{ url('gallery/' . $article->photo) }}?w=100&h=100&fit=crop" alt="{{ $article->title }}">
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                {{ $article->title }}
                                            </h4>
                                            {!! \Illuminate\Support\Str::limit($article->text) !!}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            @if(Auth::check())
                                <div class="alert alert-info">No recent news! Want to be the one to tell us what is going on? Publish your first news <a href="{{ route('home.articles.create') }}">here</a></div>
                            @else
                            <div class="alert alert-info">No recent news! Want to be the one to tell us what is going on? Start by registering
                                <a href="{{ url('/register') }}">here</a></div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
