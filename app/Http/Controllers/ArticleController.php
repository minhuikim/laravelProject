<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\DeleteArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    public function create() {
        return view('articles/create');
    }

    public function store(CreateArticleRequest $request) {
        $input = $request->validated();
    
        Article::create([
            'body' => $input['body'],
            'user_id' => Auth::id()
        ]);
        return redirect()->route('articles.index');
    }

    public function index() { 
        $articles = Article::with('user')
            ->latest()
            ->paginate();

        return view('articles.index', 
        [
            'articles' => $articles,
        ]);
    }

    public function show(Article $article) {
        return view('articles.show', ['article' => $article]);
    }

    public function edit(EditArticleRequest $request, Article $article) {
        return view('articles.edit', ['article' => $article]);
    }

    public function update(UpdateArticleRequest $request, Article $article) {

        $input = $request->validated();

        $article->body = $input['body'];
        $article->save();

        return redirect()->route('articles.index');
    }

    public function destroy(DeleteArticleRequest $request, Article $article) {
        $article->delete();

        return redirect()->route('articles.index');
    }
}
