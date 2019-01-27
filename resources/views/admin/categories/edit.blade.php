@extends('layouts.admin')

@section('content')

<h1>Categories Page</h1>
<div class="col-sm-5">
    {!! Form::model($category, ['method'=>'PATCH', 'action'=>['AdminCategoriesController@update', $category->id]]) !!}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">            
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
            @if($errors->has('name'))
                {{ $errors->first('name') }}
            @endif
        </div>
        <div class="form-group">
            {!! Form::submit('Update Category', ['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

    {!! Form::open(['method'=>'DELETE', 'action'=>['AdminCategoriesController@destroy', $category->id]]) !!}
        {!! Form::submit('Delete Category', ['class'=>'btn btn-danger']) !!}
    {!! Form::close() !!}
</div>
<div class="col-sm-7">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created Date</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @if($categories)
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at ? $category->created_at->diffForHumans() : 'None' }}</td>
                        <td>{{ $category->updated_at ? $category->updated_at->diffForHumans() : 'None' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("url");
        });
    });
</script>

@stop