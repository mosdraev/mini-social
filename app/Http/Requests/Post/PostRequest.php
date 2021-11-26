<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\UploadImageRequest;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required',
            'image' => array_merge((new UploadImageRequest)->rules()['image'], ['sometimes', 'nullable'])
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            'image' => 'Image must be of the following file type (jpeg,png,jpg)'
        ];
    }
}
