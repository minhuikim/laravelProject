<div class="flex flex-row mt-2">
    @can('update', $article)
    <p class="mr-1"><a href="{{ route('articles.edit', ['article' => $article->id]) }}"
        class="button rounded bg-blue-500 px-2 py-1 text-xs text-white">
        수정</a>
    </p>
    @endcan
    @can('delete', $article)
    <form action={{ route('articles.destroy', ['article' => $article->id]) }} method='POST'>
        @csrf
        @method('DELETE')
        <button class="rounded bg-red-500 px-2 py-1 text-white text-xs">삭제</botton>
    </form>
    @endcan
</div>