<?php

namespace App;

use App\Reply;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    public function path()
    {
        return '/threads/' . $this->id;
    }

    public function replies()
    {
        // select * from replies where reply.thread_id = thread.id
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        // select * from user where user.id = thread.user_id
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
