<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UploadImageRequest;

use App\Models\Image;
use App\Models\Profile;

trait HasImageUpload
{
    /**
     * Uploads a `profile` or `post` image that will be connected to an
     * existing user in the Database
     *
     * @return boolean
     */
    public function upload(UploadImageRequest $request, Profile $profile, $type)
    {
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $imageName = date('Ymd_His').'_'.time() . '.' . $file->extension();
            $imagePath = $file->storePubliclyAs('public/images', $imageName);

            if ($imagePath)
            {
                Image::create([
                    'path' => $imagePath, // holds the path of the image after successful upload
                    'type' => $type,
                    'user_id' => $profile->user_id
                ]);

                $profile->update(['photo' => $imagePath]);

                return true;
            }
        }

        return false;
    }
}