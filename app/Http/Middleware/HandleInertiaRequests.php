<?php

namespace App\Http\Middleware;

use App\Models\Profile;
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
        $user = null;
        $profile = null;

        if (!is_null($request->user()))
        {
            $user = $request->user()->only('id', 'email');
            $profile = Profile::select('firstname', 'lastname')
                ->where('user_id', $user['id'])->first()->toArray();
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
                'profile' => $profile
            ],
        ]);
    }
}
