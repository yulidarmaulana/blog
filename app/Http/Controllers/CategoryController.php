<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function show(Category $category)
    {	
        $posts = $category->posts()->latest()->paginate(6);
        return view('posts.index', compact('posts', 'category'));
    }
}
