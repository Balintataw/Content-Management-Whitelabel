@extends('layouts.admin')

@section('content')

    @if(Session::has('deleted_user')) 
        <p class="bg-danger alert alert-success" style="position:absolute; top:20px;">{{ session('deleted_user') }}</p>
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
                            <img src="{{ $user->photo ? $user->photo->image_url : 'none' }}" height="30px" width="30px" style="border-radius:50%;" />
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

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