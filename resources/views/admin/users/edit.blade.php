@extends('layouts.admin')

@section('content')

    <h1>Edit User</h1>
        {!! Form::model($user, ['method'=>'PATCH', 'action'=>['AdminUsersController@update', $user->id], 'files'=>true]) !!}
        <div class="col-sm-8">

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

            <!-- <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password', ['class'=>'form-control']) !!}
                @if($errors->has('password'))
                    {{ $errors->first('password') }}
                @endif
            </div> -->

            <div class="form-group {{ $errors->has('role_id') ? 'has-error' : '' }}">
                {!! Form::label('role_id', 'Role:') !!}
                {!! Form::select('role_id', [''=>'Choose Role'] + $roles, null, ['class'=>'form-control']) !!}
                @if($errors->has('role_id'))
                    {{ $errors->first('role_id') }}
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('is_active', 'Active Status:') !!}
                {!! Form::select('is_active', array(1 => 'Active', 0=>'Inactive'), null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Save Changes', ['class'=>'btn btn-primary']) !!}
                {!! Form::button('Delete User', ['class'=>'btn btn-danger', 'id'=>'delete-user', 'data-userid'=>$user->id]) !!}
                <!-- {!! Form::open(['method'=>'DELETE', 'action'=>['AdminUsersController@destroy', $user->id], 'class'=>'pull-right']) !!}
                        {!! Form::submit('Delete User', ['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!} -->
            </div>
        </div>
        <div class="col-sm-3">
            <img src="{{ $user->photo->image_url }}" alt="user avatar" id="profile-img-tag" width="150px" height="150px" style="border-radius:50%; border:1px solid grey; margin-bottom:10px;" />
            <!-- <img src="{{ $user->photo->image_url }}" alt="user avatar" id="profile-img-tag" width="150px" height="150px" style="border-radius:50%;" /> -->
            <div class="form-group">
                {!! Form::label('photo_id', 'Avatar:') !!}
                {!! Form::file('photo_id', ['class'=>'form-control', 'id'=>'profile-img']) !!}
            </div>
        </div>
    {!! Form::close() !!}



    <!-- @include('includes.form_errors') -->

    <!-- TODO jquery should be available globally? -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="text/javascript">
        // gets and sets image as user selectes it
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#profile-img").change(function() {
            readURL(this);
        });
        // handles DELETE request without form
        $('#delete-user').click(function(e) {
            e.preventDefault();
            var userId = $(this).data('userid')
            console.log('ID', userId)
            $.ajax({
                type: "POST",
                url: "/admin/users" + "/" + userId,
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "id":userId
                }),
                success: function(html){
                    window.location = '/admin/users';
                    console.log('deleted user')
                }
            });
        })
    </script>
@stop