@extends('layouts.admin')

@section('content')

@if(Session::has('deleted_photo')) 
    <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('deleted_photo') }}</div>
@endif
@if(Session::has('deletion_error')) 
    <div class="bg-danger alert alert-danger" style="position:absolute; top:60px; right:20px;">{{ session('deletion_error') }}</div>
@endif

<h1>Media Page</h1>

<form action="delete/media" method="post" class="form-inline">
    {{csrf_field()}}
    {{method_field('delete')}}
    <div class="form-group">
        <!-- made a select in case some other action was to be performed instead of delete -->
        <select name="checkboxArray" id="" class="form-control" style="display:none;">
            <option value="">Delete</option>
        </select>
    </div>
    <div class="form-group" style="height:40px;">
        <input type="submit" id="delete_all_btn" value="Delete Selected" name="delete_all" class="btn btn-primary" style="display:block;">
    </div>

    <table class="table table-striped table-hover">    
        <thead>
            <tr>
                <th><input type="checkbox" id="options"></th>
                <th>Id</th>
                <th>Image</th>
                <th>Name</th>
                <th>Created At</th>
                <!-- <th>Action</th> -->
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
                        <!-- redundant delete button -->
                        <!-- <td style="vertical-align: middle;">
                            <div class="form-group">
                                <input type="hidden" name="photoid" value="{{ $photo->id }}">
                                <input type="submit" name="delete_single" value="Delete" class="btn btn-danger">
                            </div>
                        </td> -->
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</form>
<div class="row">
    <div class="col-sm-6 col-sm-offset-5">
        {{$photos->links()}}
    </div>
</div>

@stop

@section('scripts')
<script>
    $(document).ready(function() {
        //flash message
        $('div.alert').delay(3000).slideUp(300);

        $('#options').click(function() {
            if(this.checked) {
                // $('#delete_all_btn').css('display', 'block');
                $('.check-boxes').each(function() {
                    this.checked = true;
                })
            } else {
                // $('#delete_all_btn').css('display', 'none');
                $('.check-boxes').each(function() {
                    this.checked = false;
                })
            }
        })
    })
</script>
@stop