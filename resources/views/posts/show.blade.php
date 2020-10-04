@extends('layouts.app')
@section('title', $post->title)
@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        
        <div class="text-secondary mb-3">
        <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a> 
        &middot; {{ $post->created_at->format("d F, Y") }}
        &middot;
        @foreach ($post->tags as $tag)
        <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
        @endforeach

        <div class="media my-3">
            {{-- Wrote by {{ $post->author->name }} --}}
            <img width="60" class="rounded-circle mr-3" src="{{ $post->author->gravatar() }}" alt="">
            <div class="media-body">
                <div>
                    {{ $post->author->name }}
                </div>
                    {{ '@' .$post->author->username }}
            </div>
        </div>
        
        </div>
        <p>{!! nl2br($post->body) !!}</p>
        <div>

            @if(auth()->user()->is($post->author))
            <div class="flex mt-3">
                <!-- Button trigger modal --> 
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Delete
                </button>

                <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-success">Edit</a>
            </div>
                        
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda yakin menghapusnya ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <div>{{ $post->title }}</div>
                            <div class="text-secondary">
                                <small>Publish : {{ $post->created_at->format("d F, Y") }} </small>
                            </div>
                        </div>

                        <form action="/posts/{{ $post->slug }}/delete" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex">
                                <button class="btn btn-danger mr-2" type="submit">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    </div>
                </div>
            </div>
            @endif

            </div> 
       
        </div>
    </div>
@endsection