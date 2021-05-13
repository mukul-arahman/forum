<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Notifications\YouWereMentioned;
use App\Http\Requests\CreatePostRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }

    /**
     * Persist a new reply.
     *
     * @param  $channelId
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ])->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        request()->validate([
            'body' => ["required", new SpamFree()]
        ]);

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted.']);
        }

        return back();
    }
}
