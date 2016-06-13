<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Times New Roman';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">

<div class="container">
    <div class="row">
        <img src="{{ url('gallery/' . $article->photo) }}?fit=contain" alt="{{ $article->title }}" class="img-responsive img-rounded">
        <div class="jumbotron">
            <h1>{{ $article->title }}</h1>
            <p>{!! $article->text !!}</p>
        </div>

        <ol class="breadcrumb">
            <li><a href="{{ route('articles.show',['slug' => $article->slug]) }}">Read Online</a></li>
        </ol>
        <div class="btn btn-primary btn-block"><span class="badge">by</span> <strong>{{$article->reporter->email}}</strong></div>
        <div class="btn btn-danger btn-block"><span class="badge">published at</span> <strong>{{$article->created_at->format('l F jS, Y')}}</strong></div>

    </div>
</div>

        <!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>