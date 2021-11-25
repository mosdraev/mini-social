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
      * @param UploadImageRequest $request
      * @param Profile $profile
      * @param string $type profile|post
      *
      * @return App\Models\Image|boolean
      */
    public function upload(UploadImageRequest $request, Profile $profile, $type)
    {
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $name = date('Ymd_His').'_'.time() . '.' . $file->extension();
            $path = $file->storePubliclyAs('public/images', $name);

            if ($path)
            {
                return Image::create([
                    'path' => $path, // holds the path of the image after successful upload
                    'type' => $type,
                    'user_id' => $profile->user_id
                ]);
            }
        }

        return false;
    }
}