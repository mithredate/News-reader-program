@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Article</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('home.articles.store') }}" name="create-article" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('partials.inputs.text',['type' => 'text', 'name' => 'title', 'label' => 'News Title'])
                            @include('partials.inputs.text',['type' => 'file', 'name' => 'photo', 'label' => 'News Photo'])
                            @include('partials.inputs.textarea',['name' => 'text', 'label' => 'News Text'])
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
