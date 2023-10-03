<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container" style="padding:15px">
            <h1 class="text-xl mb-5">글목록</h1> 
            @foreach($articles as $article)
                <!-- {{ $loop->index }} -->
                {{-- @if($loop->first)
                    @continue
                @endif --}}
                <div class="background-white border rounded mb-3 p-3">
                    <!-- echo + js xss공격 방지 -->
                    <p>{{ $article->body }}</p>
                    <p>{{ $article->created_at }}</p>
                </div>
            @endforeach

            {{-- @for($i=0; $i < $articles->count(); $i++)
                <?//로그인안한 사용자에게만 출력?>
                @guest
                <div class="background-white border rounded mb-3 p-3">
                    <p>{{ $articles[$i]->body }}</p>
                    <p>{{ $articles[$i]->created_at }}</p>
                </div>
                @endguest
            @endfor
            --}}
        </div>
    </body>
</html>