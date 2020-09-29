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
        $request->validate([
            'thumbnail' => 'image|mimes:jpg,png,jpeg,img,svg|max:2048'
        ]);

        $val = request()->all();

        $slug = \Str::slug(request('title'));
        $val['slug'] = $slug;

        $thumbnail = request()->file('thumbnail') ? request()->file('thumbnail')->store("images/posts") : null;

        $val['category_id'] = request('category');
        $val['thumbnail'] = $thumbnail;
        
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
        $request->validate([
            'thumbnail' => 'image|mimes:jpg,png,jpeg,img,svg|max:2048'
        ]);

        if (request()->file('thumbnail')) {
            \Storage::delete($post->thumbnail);
            $thumbnail = request()->file('thumbnail')->store("images/posts");
        } else {
            $thumbnail = $post->thumbnail;
        }

        $val = request()->all();
        $val['category_id'] = request('category');
        $val['thumbnail'] = $thumbnail;

        $post->update($val);
        $post->tags()->sync(request('tags'));

        
        session()->flash('success', 'The post was updated');
        // session()->flash('error', 'The post was created');

        return redirect('posts');

    }

    public function destroy(Post $post)
    {	
        \Storage::delete($post->thumbnail);

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
