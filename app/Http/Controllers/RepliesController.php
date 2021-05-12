<?php

namespace App\Http\Controllers;

use App\User;
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
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        // Inspect the body of the reply for username mentioned
        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);
        // there are two arrays with @ and without @

        foreach ($matches[1] as $name) {
            $user = User::whereName($name)->first();

            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
        }

        // And then for each mentioned user, notify them

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
