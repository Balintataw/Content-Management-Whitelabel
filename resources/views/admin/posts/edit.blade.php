@extends('layouts.admin') 

@section('content')

    @include('includes.tinyeditor')

    <h1>Edit Post</h1>

    {!! Form::model($post, ['method'=>'PATCH', 'action'=>['AdminPostsController@update', $post->id], 'files'=>true]) !!}
        <div>
            <div class="form-group">
                <img class="img-responsive" src="{{ $post->photo ? $post->photo->image_url : $post->photoPlaceholder() }}"id="post-img-tag" width="150px" height="150px" alt="post heading image">
                <!-- <img src="{{ $post->photo->image_url }}" id="post-img-tag" width="150px" height="150px" style="border-radius:10px; border:1px solid grey; margin-bottom:10px;" /> -->
                <div class="form-group" style="width:25%;">
                    {!! Form::label('photo_id', 'Post Header Image:') !!}
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
            {!! Form::submit('Edit Post', ['class'=>'btn btn-primary']) !!}
            {!! Form::button('Delete Post', ['class'=>'btn btn-danger', 'id'=>'delete-post', 'data-postid'=>$post->id]) !!}
        </div>
    {!! Form::close() !!}

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="text/javascript">
        // gets and sets image on input
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
        // handles delete of post without form
        $('#delete-post').click(function(e) {
            // e.preventDefault();
            var postId = $(this).data('postid')
            console.log('id', postId)
            $.ajax({
                type: "POST",
                url: "/admin/posts" + '/' + postId,
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "id": postId
                }),
                success: function(html){
                    window.location = '/admin/posts';
                    console.log('deleted post');
                }
            });
        })
    </script>
@stop