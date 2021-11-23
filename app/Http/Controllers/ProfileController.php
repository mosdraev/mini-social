<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UploadImageRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    use HasImageUpload;

    /**
     * Upload the specified resource in storage.
     *
     * @param Request $request
     * @param Profile $profile
     */
    public function uploadPhoto(UploadImageRequest $request, Profile $profile)
    {
        $this->upload($request, $profile, 'profile');

        return redirect()->route('view.profile', $profile->user_id)
                ->with('type', 'alert-success')
                ->with('message', 'Successfully uploded photo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return Inertia::render('Profile/View', [
            'profileData' => $profile
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $data = $request->validated();

        $result = $profile->modify($data);

        if ($result === true)
        {
            return redirect()->route('view.profile', $profile->user_id)
                ->with('type', 'alert-success')
                ->with('message', 'Successfully updated profile!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
