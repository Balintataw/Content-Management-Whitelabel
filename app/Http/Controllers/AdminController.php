<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Category;
use App\Comment;

class AdminController extends Controller
{
    public function index() {
        $userCount = User::count();
        $postCount = Post::count();
        $categoryCount = Category::count();
        $commentCount = Comment::count();
        return view('admin/index', compact('userCount', 'postCount', 'categoryCount', 'commentCount'));
    }
}
