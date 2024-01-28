<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('글 수정하기') }}
        </h2>
    </x-slot>

    <div class="container" style="padding:15px">
        <form action="{{ route('articles.update', ['article' => $article->id]) }}" method="POST" style="margin-top:3px">
            @csrf
            @method('PATCH') <!--메서드 스푸핑-->
            <input type="text" name="body" style="margin-bottom:2px" class="block w-full mb-2 rounded" value="{{ old('body') ?? $article->body }}">
            @error('body')
                <p class="text-xs" style="color:red;margin-bottom:3px"> {{ $message }} </p>
            @enderror
            <button class="py-1 px-3 rounded" style="background-color:black;color:white;font-size:small;">저장하기</botton>
        </form>
    </div>
</x-app-layout>