<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::Auth();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

Route::group(['middleware'=>'admin'], function() {
    //active admin/superuser only routes
    Route::get('/admin', function() {
        return view('admin.index');
    });
    Route::resource('admin/users', 'AdminUsersController', ['names'=>[
        'index'=>'admin.users.index',
        'create'=>'admin.users.create',
        'store'=>'admin.users.store',
        'edit'=>'admin.users.edit',
    ]]);
    Route::resource('admin/posts', 'AdminPostsController', ['names'=>[
        'index'=>'admin.posts.index',
        'create'=>'admin.posts.create',
        'store'=>'admin.posts.store',
        'edit'=>'admin.posts.edit',
    ]]);
    Route::resource('admin/categories', 'AdminCategoriesController',['names'=>[
        'index'=>'admin.categories.index',
        'create'=>'admin.categories.create',
        'store'=>'admin.categories.store',
        'edit'=>'admin.categories.edit',
    ]]);
    Route::resource('admin/media', 'AdminMediasController',['names'=>[
        'index'=>'admin.media.index',
        'create'=>'admin.media.create',
        'store'=>'admin.media.store',
        'edit'=>'admin.media.edit',
    ]]);
    Route::resource('admin/comments', 'PostCommentsController',['names'=>[
        'index'=>'admin.comments.index',
        'create'=>'admin.comments.create',
        'show'=>'admin.comments.show',
        'edit'=>'admin.comments.edit',
    ]]);
    Route::resource('admin/comment/replies', 'CommentRepliesController',['names'=>[
        'index'=>'admin.comment.replies.index',
        'show'=>'admin.comment.replies.show',
        'create'=>'admin.comment.show',
        'edit'=>'admin.comment.edit',
    ]]);
    Route::any('admin/posts/{id}', 'AdminPostsController@destroy');
    Route::any('admin/users/{id}', 'AdminUsersController@destroy');
});

Route::group(['middleware'=>'auth'], function() {
    // requires logged in
    Route::post('comment/reply', 'CommentRepliesController@createReply');
    Route::get('/post/{id}', ['as'=>'home.post', 'uses'=>'AdminPostsController@post']); 
});