<div class="card" style="margin-bottom: 15px;">
    <div class="card-header">
        <a href="#">
            {{ $reply->owner->name }}
        </a> said {{ __($reply->created_at->diffForHumans() ) }}...
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
