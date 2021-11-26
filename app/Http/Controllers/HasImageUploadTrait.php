<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HasImageUploadTrait
{
     /**
      * Uploads a `profile` or `post` image that will be connected to an
      * existing user in the Database
      *
      * @param Request $request
      * @param Profile $profile
      * @param string $type profile|post
      *
      * @return \App\Models\Image
      */
    public function upload(Request $request, $type)
    {
        $curren_user = Auth::user();

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
                    'user_id' => $curren_user->id
                ]);
            }
        }

        return false;
    }
}