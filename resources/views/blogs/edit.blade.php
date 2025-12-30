<div class="container">
    <h2>Edit blog</h2>
    <form action="{{ route('blogs.update', $blog->id) }}" method="POST">
        @csrf
        @method("PATCH")
        <div class="mb-3">
            <label for="title" class="form-label">title</label>
            <input type="text" class="form-control" name="title" value="{{old("title", $blog["title"])}}">
            @error("title")
                <p>{{$message}}</p>
            @enderror
        </div>
<div class="mb-3">
            <label for="content" class="form-label">content</label>
            <input type="text" class="form-control" name="content" value="{{old("content", $blog["content"])}}">
            @error("content")
                <p>{{$message}}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>