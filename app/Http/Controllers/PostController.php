<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return redirect('login');
        }

        // ->withTrashed() buat balikin data yang sudah dihapus dengan method softdeletes
        $posts = Post::active()->withTrashed()->get();
        $view_data = [
            'posts' => $posts,
        ];

        return view('posts.index', $view_data);
    }

    public function create()
    {
        if(!Auth::check()) {
            return redirect('login');
        }

        return view('posts.create');
    }

    public function store(Request $request)
    {
        if(!Auth::check()) {
            return redirect('login');
        }

        $title = $request->post('title');
        $content = $request->post('content');

        Post::create([
            'title' => $title,
            'content' => $content,
        ]);

        return redirect('posts');
    }

    public function show($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        }

         //first untuk mendapatkan query single data
        $post = Post::where('id', '=', $id)->first();
        $comments = $post->comments()->limit(2)->get();
        $total_comments = $post->total_comments();

        $view_data = [
            'post' => $post,
            'comments' => $comments,
            'total_comments' => $total_comments
        ];
        return view('posts.show', $view_data);
    }

    public function edit($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        }

        $post = Post::where('id', '=', $id)
            //first untuk mendapatkan query single data
            ->first();

        $view_data = [
            'post' => $post
        ];

        return view('posts.edit', $view_data);
    }

    public function update(Request $request, $id)
    {
        if(!Auth::check()) {
            return redirect('login');
        }
        
        $title = $request->post('title');
        $content = $request->post('content');

        Post::where('id', '=', $id)
            ->update([
                'title' => $title,
                'content' => $content,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        
        return redirect("posts/{$id}");
    }

    public function destroy($id)
    {   // bisa ga pake '='
        Post::where('id', $id)
            ->delete();

        return redirect('posts');
    }
}
