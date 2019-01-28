<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Request;
use App\User;

class UsersEditRequest extends Request
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
        $user = User::find($this->user);
        return [
            'name' => 'bail|required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // 'email' => 'required|email|max:255|unique:users,email',
            'role_id' => 'required',
        ];
    }
}
