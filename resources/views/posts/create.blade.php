@extends('layouts.app', ['title'=> 'New Post'])

@section('content')
<div class="container">
    <div class="col-md-6">
    
        <div class="card-header">New Post</div>
        <div class="card-body">
            <form action="/posts/store" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @include('posts.partials.form-control', ['submite' => 'Create'])
            </form>
        </div>
    </div>
</div>
@endsection