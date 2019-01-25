<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

use App\Http\Requests;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Role;
use App\Photo;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('type', 'id')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        // validation being done in UsersRequest
        $request->merge([
            'password' => bcrypt($request->password),
        ]);
        $userInput = $request->all();
        if($file = $request->file('photo_id')) {
            $name = $file->getClientOriginalName();
            $size = $file->getClientSize();
            $file->move('images', $name); // creates avatars folder in public directory
            $photo = Photo::create( ['image_url'=>$name, 'size'=>$size] );

            $userInput['photo_id'] = $photo['id'];
        }
        // $userInput['password'] = bcrypt($request->password);
        User::create($userInput);

        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('type', 'id')->all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        if(trim($request->password) == '') {
            // if we want to allow for password changing from admin users panel
            $userInput = $request->except('password');
        } else {
            $userInput = $request->all();
            $userInput['password'] = bcrypt($request->password);
        }
        $user = User::findOrFail($id);
        if($file = $request->file('photo_id')) {
            $name = $file->getClientOriginalName();
            $size = $file->getClientSize();
            $file->move('images', $name); // creates avatars folder in public directory
            $photo = Photo::create(['image_url'=>$name, 'size'=>$size ]);

            $userInput['photo_id'] = $photo['id'];
        }
        $user->update($userInput);
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // cheese way to not delete my placeholder avatar image
        if($user->photo->image_url != '/images/avatar_default.svg') {
            unlink(public_path() . $user->photo->image_url);
        }
        $user->delete();
        Session::flash('deleted_user', 'User Deleted');

        // return redirect('/admin/users');
    }
}
