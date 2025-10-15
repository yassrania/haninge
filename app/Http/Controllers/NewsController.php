<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest('published_at')->paginate(12);
        return view('pages.nyheter.index', compact('news'));
    }

    public function show(string $slug)
    {
        $post = News::where('slug', $slug)->firstOrFail();
        return view('pages.nyheter.show', compact('post'));
    }
}
