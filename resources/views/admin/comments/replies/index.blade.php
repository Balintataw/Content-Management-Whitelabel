@extends('layouts.admin')

@section('content')

<!-- change session var -->
@if(Session::has('category_added')) 
    <div class="bg-danger alert alert-success" style="position:absolute; top:20px;">{{ session('category_added') }}</div>
@endif

<h1>Replies</h1>
<div>
    @if(count($replies) > 0)
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
                @foreach($replies as $reply)
                <!-- change route data -->
                    <tr class="clickable-row" style="cursor:pointer;" data-url="{{ route('home.post', $reply->post->id) }}"> 
                        <td style="vertical-align: middle;">{{ $reply->id }}</td>
                        <td style="vertical-align: middle;">
                            <img src="{{ $reply->user->photo ? $reply->user->photo->image_url : 'None' }}" height="40px" width="40" alt="author avatar"/>
                        </td>
                        <td style="vertical-align: middle;">{{ $reply->post_id }}</td>
                        <td style="vertical-align: middle;">{{ $reply->author }}</td>
                        <td style="vertical-align: middle;">{{ $reply->email }}</td>
                        <td style="vertical-align: middle;">{{ str_limit($reply->content, 25) }}</td>
                        @if($reply->is_active == 1)
                            <td style="vertical-align: middle;">
                                {!! Form::open(['method'=>'PATCH', 'action'=>['CommentRepliesController@update', $reply->id]]) !!}
                                    <input type="hidden" name="is_active" value="0">
                                    {!! Form::submit('Deactivate', ['class'=>'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        @else
                            <td style="vertical-align: middle;">
                                {!! Form::open(['method'=>'PATCH', 'action'=>['CommentRepliesController@update', $reply->id]]) !!}
                                    <input type="hidden" name="is_active" value="1">
                                    {!! Form::submit('Activate', ['class'=>'btn btn-success']) !!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                        <td style="vertical-align: middle;">{{ $reply->created_at ? $reply->created_at->diffForHumans() : 'None' }}</td>
                        <td style="vertical-align: middle;">{{ $reply->updated_at ? $reply->updated_at->diffForHumans() : 'None' }}</td>
                        <td style="vertical-align: middle;">
                            {!! Form::open(['method'=>'DELETE', 'action'=>['CommentRepliesController@destroy', $reply->id]]) !!}
                                {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                        <!-- check this link -->
                        <td style="vertical-align: middle;"><a href="{{ route('home.comments.index', $comment->id) }}">View Post</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h3 class="text-center">No replies</h3>
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