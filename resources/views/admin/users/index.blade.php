@extends('layouts.admin')

@section('content')

    @if(Session::has('deleted_user')) 
        <div class="bg-danger alert alert-success" style="position:absolute; top:60px; right:20px;">{{ session('deleted_user') }}</div>
    @endif
    <h1>Users</h1>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active Status</th>
                <th>Created Date</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @if($users)
                @foreach($users as $user)
                    <tr class="clickable-row" style="cursor:pointer;" data-url="{{ route('admin.users.edit', $user->id) }}">
                        <td style="vertical-align: middle;">{{ $user->id }}</td>
                        <td style="vertical-align: middle;">
                            <img src="/images/{{ $user->photo ? $user->photo->image_url : 'avatar_default.svg' }}" height="30px" width="30px" style="border-radius:50%;" />
                        </td>
                        <td style="vertical-align: middle;">{{ $user->name }}</td>
                        <td style="vertical-align: middle;">{{ $user->email }}</td>
                        <td style="vertical-align: middle;">{{ $user->role->type }}</td>
                        <td style="vertical-align: middle;">{{ $user->is_active == 1 ? 'Active' : 'Inactive' }}</td>
                        <td style="vertical-align: middle;">{{ $user->created_at->diffForHumans() }}</td>
                        <td style="vertical-align: middle;">{{ $user->updated_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-5">
            {{$users->render()}}
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        //flash message
        $('div.alert').delay(3000).slideUp(300);
        //table row click event
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("url");
            });
        });
    </script>
@stop