<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;

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
    public function store($channelId, Thread $thread)
    {
        try {
            request()->validate([
                'body' => ["required", new SpamFree()]
            ]);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id(),
            ]);
        } catch(\Exception $e) {
            return response(
                'Your reply could not be saved at this time.', 422
            );
            //throw new \Exception('Spam detected.');
        }

        return $reply->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            request()->validate([
                'body' => ["required", new SpamFree()]
            ]);

            $reply->update(request(['body']));
        } catch(\Exception $e) {
            return response(
                'Your reply could not be saved at this time.', 422
            );
        }
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
