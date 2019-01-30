@extends('layouts.blog-home')

@section('content')


<!DOCTYPE html>
<html lang="en">

@include('home.head_metadata')

<body>

    <!-- Navigation -->
    @include('home.home_nav')

    <!-- Page Content -->
    <div class="container">
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">
            @if(count($posts) > 0)
            @foreach($posts as $post)
                <!-- Blog Post -->
                  <!-- Flash message -->
                @if(Session::has('comment_added')) 
                    <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('comment_added') }}</div>
                @endif
                @if(Session::has('reply_added')) 
                    <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('reply_added') }}</div>
                @endif

                <!-- Blog Post -->

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
                <img class="img-responsive" style="min-height:200px" src="{{ $post->photo ? $post->photo->image_url : $post->photoPlaceholder() }}" alt="">

                <hr>

                <!-- Post Content -->
                <!-- <p class="lead">{{ str_limit($post->content, 50) }}</p> -->
                <p>{!! str_limit($post->content, 200) !!}</p>

                <a href="{{ route('home.post', $post->slug) }}">Read More 
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>

                <hr>

                @endforeach 
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-5">
                        {{$posts->render()}}
                    </div>
                </div>
            @endif
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

            @include('home.home_sidenav')

            </div>

        </div>
        <!-- /.row -->
        <hr>
    </div>
    <!-- /.container -->
</body>

</html>

@endsection
