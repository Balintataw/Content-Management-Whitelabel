@extends('layouts.admin')

@section('content')

@if(Session::has('deleted_photo')) 
    <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('deleted_photo') }}</div>
@endif

<h1>Media Page</h1>

<table class="table table-striped table-hover">    
    <thead>
        <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Name</th>
            <th>Created At</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($photos)
            @foreach($photos as $photo)
                <tr>
                    <td style="vertical-align: middle;">{{ $photo->id }}</td>
                    <td style="vertical-align: middle;"><img height="50px" width="50px" src="{{ $photo->image_url }}" alt="image"></td>
                    <td style="vertical-align: middle;">{{ $photo->image_url }}</td>
                    <td style="vertical-align: middle;">{{ $photo->created_at ? $photo->created_at->diffForHumans() : 'None' }}</td>
                    <td style="vertical-align: middle;">
                    {!! Form::open(['method'=>'DELETE', 'action'=>['AdminMediasController@destroy', $photo->id]]) !!}
                        {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}  
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
        $('div.alert').delay(3000).slideUp(300);
</script>

@stop
