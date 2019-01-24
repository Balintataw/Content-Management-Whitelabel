<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

use App\Http\Requests;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
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
            'user_id'=>Uuid::generate(), 
        ]);
        $userInput = $request->all();
        if($file = $request->file('avatar_id')) {
            $name = $file->getClientOriginalName();
            $size = $file->getClientSize();
            $file->move('images', $name); // creates avatars folder in public directory
            $photo = Photo::create( ['image_url'=>$name, 'size'=>$size, 'user_id'=>$userInput['user_id'] ]);

            $userInput['avatar_id'] = $photo['id'];
        }
        // $userInput['password'] = bcrypt($request->password);
        // $userInput['user_id'] = Uuid::generate();
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
        $user = User::findOrFail($id);
        $userInput = $request->all();
        if($file = $request->file('avatar_id')) {
            $name = $file->getClientOriginalName();
            $size = $file->getClientSize();
            $file->move('images', $name); // creates avatars folder in public directory
            $photo = Photo::create(['image_url'=>$name, 'size'=>$size, 'user_id'=>$user['user_id'] ]);

            $userInput['avatar_id'] = $photo['id'];
        }
        $user->update($userInput);
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
