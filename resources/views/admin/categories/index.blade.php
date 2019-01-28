@extends('layouts.admin')

@section('content')

@if(Session::has('category_added')) 
    <p class="bg-danger alert alert-success" style="position:absolute; top:20px;">{{ session('category_added') }}</p>
@endif

<h1>Categories Page</h1>
<div class="col-sm-5">
    {!! Form::open(['method'=>'POST', 'action'=>'AdminCategoriesController@store']) !!}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">            
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
            @if($errors->has('name'))
                {{ $errors->first('name') }}
            @endif
        </div>
        <div class="form-group">
            {!! Form::submit('Create Category', ['class'=>'btn btn-primary']) !!}
        </div>
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
                    <tr class="clickable-row" style="cursor:pointer;" data-url="{{ route('admin.categories.edit', $category->id) }}"> 
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