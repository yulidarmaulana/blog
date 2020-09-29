@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between bg-light">
        <div>
            @isset(($category))
                <h4>Category : {{ $category->name }}</h4>                
            @endisset

            @isset(($tag))
                <h4>Tag : {{ $tag->name }}</h4>
            @endisset

            @if(!isset($tag) && !isset($category))
                    <h4>All Post</h4>
            @endif

            <hr>
        </div>
        <div>
            @if(Auth::check())
                <a href="{{ route('posts.create') }}" class="btn btn-primary">New Posts</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login to create new post</a>
            @endif
        </div>
    </div>
        <div class="row">
            
            @forelse($posts as $post)
            <div class="col-md-4">
                <div class="card card mb-5">
                    
                    @if($post->thumbnail)
                        <img style="height: 300px; object-fit: cover; object-position: center;" class="card-img-top" src="{{ asset($post->takeImage())}}">
                    @endif

                    <div class="card-body">
                        <div class="card-title">
                            {{ $post->title }}
                        </div>        
                        <div>
                            {{ Str::limit($post->body, 100, '') }}
                        </div>

                    <a href="/posts/{{ $post->slug }}">Read more</a>
                    </div>

                    <div class="card-footer d-flex justify-content-between text-light bg-primary">
                        Published on {{ $post->created_at->diffForHumans()}}
                        @if(auth()->user()->is($post->author))
                        {{-- @can('update', $post) --}}
                            <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-success">Edit</a>
                        {{-- @endcan --}}
                        @endif
                    </div>
                </div>
            </div>
            @empty
                <div class="col-md-6">
                    <div class="alert alert-info">
                        There's no Posts.
                    </div>
                </div>
            @endforelse

        </div>
        <div class="d-flex justify-content-center">
            <div>
                {{ $posts->links() }}
            </div>
        </div>
</div>
@endsection