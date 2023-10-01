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
            <form action="/articles" method="POST" style="margin-top:3px">
                <!-- <input type="hidden" name="_token" value="<?=csrf_token();?>" /> -->
                <!-- old(body) : 유효성 검사에 실패해도 입력한 내용이 삭제되지 않게 해줌 -->
                <!-- 419(csrf)에러 방지 -->
                @csrf
                <input type="text" name="body" style="margin-bottom:2px" class="block w-full mb-2 rounded" value="{{ old('body') }}">
                <!--                 
                    body 에러 출력
                -->
                @error('body')
                    <p class="text-xs" style="color:red;margin-bottom:3px"> {{ $message }} </p>
                @enderror
                <button class="py-1 px-3 rounded" style="background-color:black;color:white;font-size:small;">저장하기</botton>
            </form>
            <!-- dd 메소드는 컬렉션의 아이템을 덤프하여 표시하고 스크립트를 종료 
            error : https://laravel.com/docs/10.x/blade#validation-errors 
            - all : 전체 에러 출력
            - any : 에러 유무 확인
            - first : 첫번째 에러만 출력-->
            <!-- {{ dd(old('body')) }} -->
            <!-- {{ dd(request()->old('body')) }} -->
            <!-- {{ dd(request()->session()) }} -->
            <!-- {{ dd($errors->all()) }} -->
        </div>
    </body>
</html>