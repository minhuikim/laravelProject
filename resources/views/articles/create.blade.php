<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container" style="padding:15px">
            <h1 class="text-xl">글쓰기</h1>
            <form action="{{ route('articles.store') }}" method="POST" style="margin-top:3px">
                @csrf
                <input type="text" name="body" style="margin-bottom:2px" class="block w-full mb-2 rounded" value="{{ old('body') }}">
                @error('body')
                    <p class="text-xs" style="color:red;margin-bottom:3px"> {{ $message }} </p>
                @enderror
                <button class="py-1 px-3 rounded" style="background-color:black;color:white;font-size:small;">저장하기</botton>
            </form>
        </div>
    </body>
</html>