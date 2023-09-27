<html>
    <head>
        <!--    
            public/build/assets 연결
            https://laravel.com/docs/10.x/vite#main-content
        -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container" style="padding:15px">
            <h1 class="text-xl">글쓰기</h1>
            <form action="/articles" method="POST" class="mt-3">
                <!-- 419(csrf)에러 방지 -->
                @csrf
                <!-- <input type="hidden" name="_token" value="<?=csrf_token();?>" /> -->
                <input type="text" name="body" style="margin-bottom:2px" class="block w-full mb-2 rounded">
                <button class="py-1 px-3 rounded" style="background-color:black;color:white;text-size:small;">저장하기</botton>
            </form>
        </div>
    </body>
</html>