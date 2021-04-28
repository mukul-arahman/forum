<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param \App\Profile $profile
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $this->getActivity($user)
        ]);
    }

    /**
     * @param User $user
     * @return mixed
     */
    protected function getActivity(User $user)
    {
        return $user->activity()
                    ->latest()
                    ->with('subject')
                    ->take(50)
                    ->get()
                    ->groupBy( function ($activity) {
                        return $activity->created_at->format('Y-m-d');
                    });
    }
}