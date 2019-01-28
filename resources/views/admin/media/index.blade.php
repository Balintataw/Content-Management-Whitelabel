@extends('layouts.admin')

@section('content')

@if(Session::has('deleted_photo')) 
    <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('deleted_photo') }}</div>
@endif

<h1>Media Page</h1>

<form action="/delete/media" method="post" class="form-inline">
    <div class="form-group">
        <select name="checkboxArray" id="" class="form-control">
            <option value="delete">Delete</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" name="delete_all" class="btn btn-primary">
    </div>

    <table class="table table-striped table-hover">    
        <thead>
            <tr>
                <th><input type="checkbox" id="options"></th>
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
                        <td style="vertical-align: middle;">
                        <!-- some serious bs right here -->
                            @if($photo->id != 1)
                            @if($photo->id != 2)
                                <input class="check-boxes" type="checkbox" name="checkboxArray[]" value="{{ $photo->id }}">
                            @endif
                            @endif
                        </td>
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
</form>

@stop

@section('scripts')
<script>
    $(document).ready(function() {
        //flash message
        $('div.alert').delay(3000).slideUp(300);

        $('#options').click(function() {
            if(this.checked) {
                $('.check-boxes').each(function() {
                    this.checked = true;
                })
            } else {
                $('.check-boxes').each(function() {
                    this.checked = false;
                })
            }
        })
    })
</script>
@stop