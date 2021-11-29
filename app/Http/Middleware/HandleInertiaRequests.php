<?php

namespace App\Http\Middleware;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $authenticated_user = null;
        $user_notifications = 0;

        if ($request->user())
        {
            $user = $request->user()->only('id', 'email');
            $profile = $request->user()->profile->only('firstname', 'lastname');

            $authenticated_user = array_merge($user, $profile);
            $user_notifications = $request->user()->notification;
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $authenticated_user,
            ],
            'notifications' => $user_notifications->count(),
            'flash' => [
                'content' => [
                    'message' => fn () => $request->session()->get('message'),
                    'type' => fn () => $request->session()->get('type'),
                ]
            ],
        ]);
    }
}
