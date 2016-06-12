@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="thumbnail">
                    <img src="{{ url('gallery/' . $article->photo) }}?fit=contain" alt="{{ $article->title }}" class="img-responsive img-rounded">
                    <div class="caption">
                        <h3>{{ $article->title }}</h3>
                        <p>{!! $article->text !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 hidden-sm hidden-xs">
                <ol class="breadcrumb">
                    <li><a href="{{ url(Auth::check() ? '/home':'/') }}"><i class="fa fa-step-backward"></i> Back to home</a></li>
                </ol>
                <div class="btn btn-primary btn-block"><span class="badge">by</span> <strong>{{$article->reporter->email}}</strong></div>
                <div class="btn btn-danger btn-block"><span class="badge">published at</span> <strong>{{$article->created_at->format('l F jS, Y')}}</strong></div>

            </div>
        </div>
    </div>
@endsection
