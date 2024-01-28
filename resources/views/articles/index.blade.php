<!DOCTYPE html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container" style="padding:15px">
            <h1 class="text-xl mb-5">글목록</h1> 
            @foreach($articles as $article)
                <div class="background-white border rounded mb-3 p-3">
                    <p><a href="{{ route('articles.show', ['article' => $article->id]) }}">{{ $article->body }}</a></p>
                    <p>{{ $article->user->name }}</p>
                    <p>{{ $article->created_at->diffForHumans() }}</p>
                    <div class="flex flex-row mt-2">
                        <p class="mr-1"><a href="{{ route('articles.edit', ['article' => $article->id]) }}"
                            class="button rounded bg-blue-500 px-2 py-1 text-xs text-white">
                            수정</a>
                        </p>
                        <form action={{ route('articles.destroy', ['article' => $article->id]) }} method='POST'>
                            @csrf
                            @method('DELETE')
                            <button class="rounded bg-red-500 px-2 py-1 text-white text-xs">삭제</botton>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="container p-5">
            {{ $articles->links() }}
        </div>
    </body>
</html>