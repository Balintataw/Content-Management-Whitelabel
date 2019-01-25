<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UsersRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // faking authorization temporarily
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // currently not being used
        return [
            'name' => 'bail|required|max:255',
            'email' => 'bail|required|email|max:255|unique:users',
            'password' => 'bail|required|min:6',
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required'  => 'Email is required',
            'password.required'  => 'Password is required',
            'role_id.required'  => 'User role is required',
        ];
    }
}
