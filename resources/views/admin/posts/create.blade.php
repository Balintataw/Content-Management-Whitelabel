@extends('layouts.admin') 

@section('content')

    <h1>Create Post</h1>

    {!! Form::open(['method'=>'POST', 'action'=>'AdminPostsController@store', 'files'=>true]) !!}
        <div>
            <div class="form-group">
                <img src="/images/post_default.jpg" id="post-img-tag" width="150px" height="150px" style="border-radius:10px; border:1px solid grey; margin-bottom:10px;" />
                <div class="form-group" style="width:25%;">
                    {!! Form::label('photo_id', 'Attach Photo:') !!}
                    {!! Form::file('photo_id', ['class'=>'form-control', 'id'=>'post-img']) !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                {!! Form::label('category_id', 'Category:') !!}
                {!! Form::select('category_id', [''=>'Choose Category'] + $categories, null, ['class'=>'form-control']) !!}
                @if($errors->has('category_id'))
                    {{ $errors->first('category_id') }}
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
            @if($errors->has('title'))
                {{ $errors->first('title') }}
            @endif
        </div>

        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
            {!! Form::label('content', 'Content:') !!}
            {!! Form::textarea('content', null, ['class'=>'form-control', 'rows'=>7]) !!}
            @if($errors->has('content'))
                {{ $errors->first('content') }}
            @endif
        </div>

        <div class="form-group">
            {!! Form::submit('Create Post', ['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#post-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#post-img").change(function(){
            readURL(this);
        });
    </script>
@stop