<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userRequest extends FormRequest
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
            'full_name'             => 'required',
            'username'              => 'required|max:255',
            'email'                 => 'required|email|max:255|unique:users',
            'password'              => 'required|min:4',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function messages() {
        return [
            'full_name.required' => 'Enter full_name',
            'username.required'  => 'Enter username',
            'email.required'     => 'Enter email address',
            'email.unique'       => 'The email has aready exists!',
            'password.required'  => 'Enter password',
            'password_confirmation.required' => 'Enter confirm password',
            'password_confirmation.same'=>'Confirm password not match'
        ];
    }
}
