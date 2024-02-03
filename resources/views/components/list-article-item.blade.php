<div class="background-white border rounded mb-3 p-3">
    <p>
        <a href="{{ route('articles.show', ['article' => $article->id]) }}">
            {{ $article->body }}
        </a>
    </p>
    <p>
        <a href="{{ route('profile', ['user' => $article->user->id]) }}">
            {{ $article->user->name }}
        </a>
    </p>
    <p class="text-xs text-gray-500">
        <span>{{ $article->created_at->diffForHumans() }}</span>
        <span class="ml-1">
            <a href="{{ route('articles.show', ['article' => $article->id]) }}">
                댓글 {{ $article->comments_count }} @if($article->recent_comments_exists) (new) @endif
            </a>
        </span>
    </p>
    <x-article-button-group  :article=$article />
</div>