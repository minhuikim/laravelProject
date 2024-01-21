<?php

use App\Http\Controllers\ProfileController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/articles/create', function () {
    return view('articles/create');
})->name('articles.create');

Route::post('/articles', function (Request $request) {
    $input = $request->validate([
        'body' => 'required|string|max:255'
    ]);

    Article::create([
        'body' => $input['body'],
        'user_id' => Auth::id()
    ]);

    return 'hello';
})->name('articles.store');

Route::get('articles', function(Request $request) {
    $perPage = $request->input('per_page', 5); 

    $articles = Article::with('user')
        ->latest()
        ->paginate($perPage);

    return view('articles.index', 
        [
            'articles' => $articles,
        ]);
})->name('articles.index');

// Route 모델 바인딩
Route::get('articles/{article}', function(Article $article) {
    return view('articles.show', ['article' => $article]);
})->name('articles.show');