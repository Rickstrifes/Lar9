@extends('layouts.app')

@section('title', "Judul: $post->title")

@section('content')
    <div class="container">
        <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1">{{ $post->title }}</h2>
            <p class="blog-post-meta">{{ $post->created_at }} by <a href="#"></a></p>

            <p>{{ $post->content }}</p>

            <small class="text-muted">{{ $total_comments }} Komentar</small>

            @foreach ($comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <p style="font-size: 8px">{{ $comment->comment }}</p>
                    </div>
                </div>
            @endforeach
        </article>
        <a href="{{ url('posts') }}">
            < kembali</a>
    </div>
@endsection
