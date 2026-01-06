<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(9);
        return view('artikel.index', compact('articles'));
    }

    public function create()
    {
        return view('artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string',
            'content'         => 'required',
            'cover'           => 'required|image|max:2048',
            'content_images.*'=> 'image|max:2048'
        ]);

        $article = Article::create($request->only('title', 'content'));

        if ($request->hasFile('content_images')) {
            
        }

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil dibuat');
    }

    public function show(Article $article)
    {
        return view('artikel.show', compact('article'));
    }
}
