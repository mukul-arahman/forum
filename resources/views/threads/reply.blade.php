<div class="card" style="margin-bottom: 15px;">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5>
                <a href="#">
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
</div>
