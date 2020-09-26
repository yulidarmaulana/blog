<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\{Post, Category, Tag};
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function index()
    {
        
        return view('posts.index', [
            'posts' => Post::latest()->paginate(6),
            
        ]);
    }

    public function show(Post $post)
    {

        // $post = Post::where('slug', $slug)->firstOrFail();

        return view('posts.show', compact('post'));
        // return $slug;
    }

    public function create()
    {	
        return view('posts.create', [
                'post'=> new Post(),
                'categories'=> Category::get(),
                'tags'=> Tag::get()
            ]);
    }

    public function store(PostRequest $request)
    {	
       
        // $val = $this->validateRequest();

        $val = request()->all();

        // Assign title to  the slug
        $val['slug'] = \Str::slug(request('title'));
        $val['category_id'] = request('category');
        
        // create new post
        $post = auth()->user()->posts()->create($val);  

        $post->tags()->attach(request('tags'));

        session()->flash('success', 'The post was created');
        // session()->flash('error', 'The post was created');

        return redirect('posts');

        // return back();
    }

    public function edit(Post $post)
    {	
        return view('posts.edit', [
            'post'=> $post,
            'categories'=> Category::get(),
            'tags'=> Tag::get()
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {	
        
        $val = request()->all();
        $val['category_id'] = request('category');
        $post->update($val);
        $post->tags()->sync(request('tags'));

        
        session()->flash('success', 'The post was updated');
        // session()->flash('error', 'The post was created');

        return redirect('posts');

    }

    public function destroy(Post $post)
    {	
        if (auth()->user()->is($post->author)) {
            $post->tags()->detach();
            $post->delete();
            session()->flash('success', 'The post was destroyed');
            return redirect('posts');            
        }else {
            // $this->authorize('delete', $post);
            session()->flash('error', "It wasnt your");
            return redirect('posts');            
        }
   }
}
