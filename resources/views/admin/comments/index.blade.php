@extends('layouts.admin')

@section('content')

<!-- change session var -->
@if(Session::has('category_added')) 
    <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('category_added') }}</div>
@endif

<h1>Comments</h1>
<div>
    @if(count($comments) > 0)
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Photo</th>
                    <th>Post Id</th>
                    <th>Author</th>
                    <th>Email</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                <!-- change route data -->
                    <tr class="clickable-row" style="cursor:pointer;" data-url="{{ route('home.post', $comment->post->slug) }}"> 
                        <td style="vertical-align: middle;">{{ $comment->id }}</td>
                        <td style="vertical-align: middle;">
                            <img src="{{ $comment->user->photo ? $comment->user->photo->image_url : 'None' }}" height="40px" width="40" alt="author avatar"/>
                        </td>
                        <td style="vertical-align: middle;">{{ $comment->post_id }}</td>
                        <td style="vertical-align: middle;">{{ $comment->author }}</td>
                        <td style="vertical-align: middle;">{{ $comment->email }}</td>
                        <td style="vertical-align: middle;">{{ str_limit($comment->content, 25) }}</td>
                        @if($comment->is_active == 1)
                            <td style="vertical-align: middle;">
                                {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}
                                    <input type="hidden" name="is_active" value="0">
                                    {!! Form::submit('Deactivate', ['class'=>'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        @else
                            <td style="vertical-align: middle;">
                                {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}
                                    <input type="hidden" name="is_active" value="1">
                                    {!! Form::submit('Activate', ['class'=>'btn btn-success']) !!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                        <td style="vertical-align: middle;">{{ $comment->created_at ? $comment->created_at->diffForHumans() : 'None' }}</td>
                        <td style="vertical-align: middle;">{{ $comment->updated_at ? $comment->updated_at->diffForHumans() : 'None' }}</td>
                        <td style="vertical-align: middle;">
                            {!! Form::open(['method'=>'DELETE', 'action'=>['PostCommentsController@destroy', $comment->id]]) !!}
                                {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td style="vertical-align: middle;"><a href="{{ route('admin.comment.replies.show', $comment->id) }}">View replies</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h3 class="text-center">No comments</h3>
    @endif
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
    //flash message
    $('div.alert').delay(3000).slideUp(300);

    //click event on table row
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("url");
        });
    });
</script>

@stop