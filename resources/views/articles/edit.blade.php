<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container" style="padding:15px">
            <h1 class="text-xl">글 수정하기</h1>
            <form action="{{ route('articles.update', ['article' => $article->id]) }}" method="POST" style="margin-top:3px">
                @csrf
                @method('PUT') <!--메서드 스푸핑-->
                <input type="text" name="body" style="margin-bottom:2px" class="block w-full mb-2 rounded" value="{{ old('body') ?? $article->body }}">
                @error('body')
                    <p class="text-xs" style="color:red;margin-bottom:3px"> {{ $message }} </p>
                @enderror
                <button class="py-1 px-3 rounded" style="background-color:black;color:white;font-size:small;">저장하기</botton>
            </form>
        </div>
    </body>
</html>