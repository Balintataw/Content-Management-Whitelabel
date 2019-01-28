@extends('layouts.admin')

@section('content')

@if(Session::has('deleted_post')) 
    <div class="bg-danger alert alert-success" style="position:absolute; top:20px;">{{ session('deleted_post') }}</div>
@endif

<h1>Posts Page</h1>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>User</th>
                <th>Title</th>
                <!-- <th>Content</th> -->
                <th>Category</th>
                <th>Created Date</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @if($posts)
                @foreach($posts as $post)
                    <tr class="clickable-row" style="cursor:pointer;" data-url="{{ route('admin.posts.edit', $post->id) }}">
                        <td style="vertical-align: middle;">{{ $post->id }}</td>
                        <td style="vertical-align: middle;">
                            <img src="{{ $post->photo ? $post->photo->image_url : 'None' }}" height="50px" width="50" alt="post image"/>
                        </td>
                        <td style="vertical-align: middle;">{{ $post->user->name }}</td>
                        <td style="vertical-align: middle;">{{ $post->title }}</td>
                        <!-- <td style="vertical-align: middle;">{{ str_limit($post->content, 25) }}</td> -->
                        <td style="vertical-align: middle;">{{ $post->category ? $post->category->name : 'None' }}</td>
                        <td style="vertical-align: middle;">{{ $post->created_at->diffForHumans() }}</td>
                        <td style="vertical-align: middle;">{{ $post->updated_at->diffForHumans() }}</td>
                        <td style="vertical-align: middle;"><a href="{{ route('home.post', $post->slug) }}">View Post</a></td>
                        <!-- <td style="vertical-align: middle;"><a href="{{ route('home.post', $post->id) }}">View Post</a></td> -->
                        <td style="vertical-align: middle;"><a href="{{ route('admin.comments.show', $post->id) }}">View Comments</a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-5">
            {{$posts->render()}}
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="text/javascript">
        $('div.alert').delay(3000).slideUp(300);

        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("url");
            });
        });
    </script>
@stop