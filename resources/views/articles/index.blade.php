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
                    <p>{{$article->user->name}}</p>
                    <p>{{ $article->created_at->diffForHumans() }}</p>
                    <!-- <p>{{ $article->created_at->format("Y년 m월 d일 H:i:s") }}</p> -->
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

        <!-- <ul>
            {{-- @for($i=0; $i < $totalCount/$perPage; $i++)
            <li><a href="/articles?page={{$i+1}}&per_page={{$perPage}}">{{$i+1}}</a></li>
            @endfor --}}    
        </ul> -->

        <div class="container p-5">
            {{ $articles->links() }}
        </div>
    </body>
</html>