@extends('layouts.admin')

@section('content')

    <h1>Create Users</h1>

<!-- <input type="file" name="file" id="profile-img"> -->

    {!! Form::open(['method'=>'POST', 'action'=>'AdminUsersController@store', 'files'=>true]) !!}
        <img src="/images/avatar_default.svg" id="profile-img-tag" width="150px" height="150px" style="border-radius:50%; border:1px solid grey; margin-bottom:10px;" />
        <div class="form-group" style="width:25%;">
            {!! Form::label('photo_id', 'Avatar:') !!}
            {!! Form::file('photo_id', ['class'=>'form-control', 'id'=>'profile-img']) !!}
        </div>

        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <!-- <div style="margin-top:15px;"> -->
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
            @if($errors->has('name'))
                {{ $errors->first('name') }}
            @endif
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::text('email', null, ['class'=>'form-control']) !!}
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            {!! Form::label('password', 'Password:') !!}
            {!! Form::password('password', ['class'=>'form-control']) !!}
            @if($errors->has('password'))
                {{ $errors->first('password') }}
            @endif
        </div>

        <div class="form-group {{ $errors->has('role_id') ? 'has-error' : '' }}">
            {!! Form::label('role_id', 'Role:') !!}
            {!! Form::select('role_id', [''=>'Choose Role'] + $roles, null, ['class'=>'form-control']) !!}
            @if($errors->has('role_id'))
                {{ $errors->first('role_id') }}
            @endif
        </div>

        <div class="form-group">
            {!! Form::label('is_active', 'Active Status:') !!}
            {!! Form::select('is_active', array(1 => 'Active', 0=>'Inactive'), 0, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create User', ['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@stop

@section('scripts')
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#profile-img").change(function(){
            readURL(this);
        });
    </script>
@stop
