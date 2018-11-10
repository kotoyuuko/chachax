<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root(Request $request)
    {
        if ($request->user()) {
            return redirect()->route('home');
        }

        return view('pages.root');
    }

    public function home()
    {
        $posts = Post::where('priority', '>', -1)
            ->orderBy('priority', 'desc')
            ->paginate(6);

        return view('pages.home')
            ->with('posts', $posts);
    }

    public function tos()
    {
        $tos = Post::where('slug', 'tos')->first();

        return view('pages.post')
            ->with('post', $tos);
    }
}
