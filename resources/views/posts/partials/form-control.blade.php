<div class="form-group">
    <input type="file" name="thumbnail" id="thumbnail">
    @error('thumbnail')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror    
</div>
<div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" value="{{ old('title') ?? $post->title }}" id="title" class="form-control">
    @error('title')
    <div class="mt-2-text-">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group">
        <label for="category">Category</label>
        <select name="category" id="category" class="form-control">
            <option disabled selected>Choose one!</option>
            @foreach($categories as $category)
            <option {{ $category->id == $post->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    @error('category')
    <div class="mt-2-text-">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group">
    <label for="tags">Tag</label>
    <select name="tags[]" id="tags" class="form-control select2" multiple>
        {{-- <option disabled selected>Choose one!</option> --}}
        @foreach($post->tags as $tag)
            <option selected value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
    @error('tags')
        <div class="mt-2-text-">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="body">Description</label>
    <textarea type="text" name="body" id="body" class="form-control">{{ old('body') ?? $post->body }}</textarea>
    @error('title')
        <div class="mt-2-text-">
            {{ $message }}
        </div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">{{ $submite ?? 'Update' }}</button>