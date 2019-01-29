<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\Photo;

class AdminMediasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::paginate(5);
        // $photos = Photo::all();
        return view('admin.media.index', compact('photos'));
    }

    public function upload() {

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $size = $file->getClientSize();
        $file->move('images', $name); // creates avatars folder in public directory
        Photo::create( ['image_url'=>$name, 'size'=>$size ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        unlink(public_path() . $photo->image_url);
        $photo->delete();
    }

    public function deleteMulti(Request $request) {
        // if(isset($request->delete_single)) {
        //     $this->destroy($request->photoid);
        // } else 
        if(isset($request->delete_all) && !empty($request->checkboxArray)) {
            $photos = Photo::findOrFail($request->checkboxArray);
            foreach($photos as $photo) {
                $photo->delete();
            }
        } else {
            Session::flash('deletion_error', 'No images selected');
            return redirect('admin/media');
        }
        Session::flash('deleted_photo', 'Photos Deleted');
        return redirect('admin/media');
    }
}
