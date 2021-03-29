@extends('layouts.master')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.update') }}" method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input 
                            type="text" 
                            class="form-control" 
                            id="title" 
                            name="title"
                            placeholder="{{ $post->title }}">
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <input 
                            type="text" 
                            class="form-control" 
                            id="content" 
                            name="content"
                            value="{{ $post->content }}">
                </div>

                @foreach($tags as $tag)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach

                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $postId }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

<!-- placeholder lægger et hint ind = grå text, som man skriver oveni
     value lægger selve teksten ind, som der så kan rettes i eller slettes -->

     <!-- 
         TOKEN for CSRF Protection:
         <input type="hidden" name="_token" value=" {{csrf_token()}}">
      -->