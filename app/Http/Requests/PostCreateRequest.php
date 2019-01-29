<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostCreateRequest extends Request
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
            'title' => 'bail|required|max:100',
            'content' => 'bail|required',
            'category_id' => 'bail|required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Post Title is required',
            'category_id.required'  => 'Post Category is required',
            'content.required'  => 'Post Description is required',
        ];
    }
}
