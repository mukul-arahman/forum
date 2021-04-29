<div id="reply-{{ $reply->id }}" class="card" style="margin-bottom: 15px;">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5>
                <a href="{{ route('profile', $reply->owner) }}">
                    {{ $reply->owner->name }}
                </a> said {{ __($reply->created_at->diffForHumans() ) }}...
            </h5>

            <div>
                <form method="POSt" action="/replies/{{ $reply->id }}/favorites">
                    @csrf

                    <button type="submit" class="btn btn-dark" {{ $reply->isFavorited() ? 'disabled' : ''}}>
                        {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div><!-- /.d-flex -->
    </div><!-- /.card-header -->

    <div class="card-body">
        {{ $reply->body }}
    </div>

    @can ('update', $reply)
        <div class="card-footer">
            <form method="POST" action="/replies/{{ $reply->id }}">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    @endcan
</div>
