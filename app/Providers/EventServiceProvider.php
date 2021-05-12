<?php

namespace App\Providers;

use App\Events\ThreadHasNewReply;
use App\Listeners\NotifySubscribers;
use Illuminate\Support\Facades\Event;
use App\Events\ThreadRecievedNewReply;
use Illuminate\Auth\Events\Registered;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\NotifyThreadSubscribers;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ThreadRecievedNewReply::class => [
            NotifyMentionedUsers::class,
            NotifySubscribers::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
