<?php

use App\Http\Controllers\ProfileController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
});

Route::post('/articles', function (Request $request) {
    // 비어있지 않고, 문자열이고, 255자를 넘으면 안된다.
    // 라라벨 유효성 검사
    // https://laravel.com/docs/10.x/validation#main-content
    $input = $request->validate([
        'body' => 'required|string|max:255'
        // 'body' => [
        //     'required',
        //     'string',
        //     'max:255',
        // ],
    ]);
    // dd($input);

    ##### pdo를 통해 db 연결
    // // config/database.php
    // $host = config('database.connections.mysql.host');
    // $dbname = config('database.connections.mysql.database');
    // $username = config('database.connections.mysql.username');
    // $password = config('database.connections.mysql.password');

    // // pdo 객체 생성
    // $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // // 쿼리 준비
    // $stmt = $conn->prepare("INSERT INTO articles (body, user_id) VALUES (:body, :user_id)");

    // // dd($request->all());

    // // body
    // // $body = $request->input('body');
    // // dd($body);

    // // userid
    // // dd($request->user()->id);
    // // dd(Auth::user()->id);
    // // dd(Auth::id());

    // // 쿼리 값 설정 (바인딩)
    // $stmt->bindValue(':body', $input['body']);
    // $stmt->bindValue(':user_id', Auth::id());

    // // 실행
    // $stmt->execute();

    ##### 라라벨 DB class 사용
    // DB 파사드를 이용하는 방법
    // https://laravel.com/docs/10.x/database
    // statement : insert, update, delete가 아닐 경우 주로 사용
    // DB::statement("INSERT INTO articles (body, user_id) VALUES (:body, :user_id)", ['body' => $input['body'], 'user_id' => Auth::id()]);
    // DB::insert("INSERT INTO articles (body, user_id) VALUES (:body, :user_id)", ['body' => $input['body'], 'user_id' => Auth::id()]);

    // 쿼리 빌더를 사용하는 방법 (쿼리문을 작성하지 않아도 됨)
    // https://laravel.com/docs/10.x/queries
    // DB::table('articles')->insert([
    //     'body' => $input['body'],
    //     'user_id' => Auth::id()
    // ]);

    // 엘로퀀트 orm 사용
    // https://laravel.com/docs/10.x/eloquent
    // $article = new Article();
    // $article->body = $input['body'];
    // $article->user_id = Auth::id();
    // $article->save();

    // 쿼리빌더처럼 작성
    Article::create([
        'body' => $input['body'],
        'user_id' => Auth::id()
    ]);
    // -> sail tinker로 조회 시 쿼리빌더를 사용하는 경우 스탠다드 class가 조회되고, 엘로퀀트로 조회 시 article 모델 클래스가 반환

    // 대량할당 취약점 발생 가능
    // https://laravel.com/docs/10.x/eloquent#mass-assignment
    // Article::create($input); 

    return 'hello';
});

Route::get('articles', function() {
    $articles = Article::all();
    // ['articles' => $articles] : view페이지에 articles를 넘겨준다
    return view('articles.index', ['articles' => Article::all()]);
    // return view('articles.index')->with('articles', $articles);
});