@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="assets/css/dropzone.css">
@stop
@section('content')
<h1>Create Media</h1>

    {!! Form::open(['method'=>'POST', 'action'=>'AdminMediasController@store', 'class'=>'dropzone']) !!}
        <!-- {!! Form::submit('Upload', ['class'=>'btn btn-primary']) !!} -->
    {!! Form::close() !!}

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="text/javascript">

    </script>

@stop

@section('scripts')

@stop