@extends('layouts.blog-home')


@section('content')
    <!-- Flash message -->
    @if(Session::has('comment_added')) 
        <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('comment_added') }}</div>
    @endif
    @if(Session::has('reply_added')) 
        <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('reply_added') }}</div>
    @endif

    <!-- Blog Post -->
    <div class="container">
        <div class="row">
            <div class="col-sm-8">

                <!-- Title -->
                <h1>{{$post->title}}</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">{{$post->user->name}}</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->format('F j, Y \a\t h:i A')}}</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="{{ $post->photo ? $post->photo->image_url : $post->photoPlaceholder() }}" alt="">

                <hr>

                <!-- Post Content -->
                <!-- <p class="lead">{{ str_limit($post->content, 50) }}</p> -->
                <p>{!! $post->content !!}</p>
                <hr>

                <!-- Blog Comments -->
                @if(Auth::check())
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store' ])!!} 
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <div class="form-group">
                            {!! Form::textarea('content', null, ['class'=>'form-control', 'rows'=>5]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Create Comment', ['class'=>'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
                <hr>
                @endif

                <!-- Posted Comments -->

                @if(count($comments) > 0)
                    <p class="text-center">Show Comments</p>
                    @foreach($comments as $comment)
                    
                    <!-- Comment section -->
                    <div class="media" style="position:relative;">
                        <a class="pull-left" href="#">
                            <img height="40" class="media-object" src="{{$comment->user->photo ? $comment->user->photo->image_url : Auth::user()->gravatar}}" alt="commenters avatar">
                        </a>
                        <div class="media-body">
                            <div class="media-body">
                                <h4 class="media-heading">{{$comment->author}}
                                    <small>{{$comment->created_at->diffForHumans()}}</small>
                                </h4>
                                <p>{{$comment->content}}</p>
                            </div>
                            <div class="comment-reply-container" style="display:flex;">
                                <i class="fa fa-comment toggle-reply" style="position:absolute; top:0px; right:50px; cursor:pointer; font-size:20px;"></i>
                            <!-- replies section -->
                                <div class="comment-reply">
                                    {!! Form::open(['method'=>'POST', 'action'=> 'CommentRepliesController@createReply']) !!}
                                        <div class="form-group">

                                            <input type="hidden" name="comment_id" value="{{$comment->id}}">

                                            {!! Form::label('content', 'Reply:') !!}
                                            {!! Form::textarea('content', null, ['class'=>'form-control','rows'=>2])!!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::submit('submit', ['class'=>'btn btn-primary']) !!}
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                            @if(count($comment->replies) > 0)

                                @foreach($comment->replies as $reply)

                                    @if($reply->is_active == 1)

                                    <!-- Nested Comment -->
                                    <div id="nested-comment" class=" media" style="position:relative;">
                                        <a class="pull-left" href="#">
                                            <img height="40" class="media-object" src="{{$reply->user->photo->image_url}}" alt="">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">{{$reply->author}}
                                                <small>{{$reply->created_at->diffForHumans()}}</small>
                                            </h4>
                                            <p>{{$reply->content}}</p>
                                        </div>

                                        <div class="comment-reply-container">

                                            <!-- would require some recursion and db restructuring to continue nesting replies -->
                                            <!-- <i class="fa fa-comment toggle-reply" style="position:absolute; top:0px; right:50px; cursor:pointer; font-size:20px;"></i> -->

                                            <div class="comment-reply">

                                                {!! Form::open(['method'=>'POST', 'action'=> 'CommentRepliesController@createReply']) !!}
                                                        <div class="form-group">

                                                            <input type="hidden" name="comment_id" value="{{$comment->id}}">

                                                            {!! Form::label('content', 'Reply:') !!}
                                                            {!! Form::textarea('content', null, ['class'=>'form-control','rows'=>2])!!}
                                                        </div>

                                                        <div class="form-group">
                                                            {!! Form::submit('submit', ['class'=>'btn btn-primary']) !!}
                                                        </div>
                                                {!! Form::close() !!}

                                            </div>
                                        </div>
                                    <!-- End Nested Comment -->
                                    </div>
                                    @endif
                                @endforeach
                            @endif <!-- end replies section -->
                        </div>
                    </div> <!-- end comment section -->
                    @endforeach
                @endif
            </div> <!-- end col-sm-8 -->
            <div class="col-sm-4">
                @include('home.home_sidenav')
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
@stop


@section('scripts')

    <script>
        // toggle reply textarea
        $(".toggle-reply").click(function(){
            $(this).next().slideToggle("fast");
        });
        // flash message
        $('div.alert').delay(3000).slideUp(300);

    </script>

@stop

