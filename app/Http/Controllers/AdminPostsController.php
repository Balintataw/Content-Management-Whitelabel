<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\Http\Requests\PostCreateRequest;
use App\Category;
use App\Photo;
use App\Post;

// hack for 'count(): Parameter must be an array or an object that implements Countable'
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

class AdminPostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(5);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        $postInput = $request->all();
        $user = Auth::user();
        if($file = $request->file('photo_id')) {
            $name = $file->getClientOriginalName();
            $size = $file->getClientSize();
            $file->move('images', $name); // creates avatars folder in public directory
            $photo = Photo::create( ['image_url'=>$name, 'size'=>$size ]);

            $postInput['photo_id'] = $photo['id'];
        }
        $user->posts()->create($postInput);
        return redirect('/admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.posts.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $postInput = $request->all();
        $user = Auth::user();
        if($file = $request->file('photo_id')) {
            $name = $file->getClientOriginalName();
            $size = $file->getClientSize();
            $file->move('images', $name); // creates avatars folder in public directory
            $photo = Photo::create( ['image_url'=>$name, 'size'=>$size ]);

            $postInput['photo_id'] = $photo['id'];
        }
        $post->update($postInput);
        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post->photo->image_url != '/images/post_default.jpg') {
            unlink(public_path() . $post->photo->image_url);
            $post->photo->delete();
        }
        $post->delete();
        Session::flash('deleted_post', 'Post Deleted');
    }

    public function post($slug) {
        $post = Post::findBySlugOrFail($slug);
        $categories = Category::all();
        $comments = $post->comments()->whereIsActive(1)->orderBy('created_at', 'DESC')->get();
        return view('post', compact('post', 'comments', 'categories'));
    }
}
