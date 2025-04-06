<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'post' => 'required|max:8|regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'post.required' => '郵便番号を入力してください',
            'post.max' => '郵便番号は7桁の数字とハイフンで入力してください',
            'post.regex' => '郵便番号は7桁の数字とハイフンで入力してください',
            'address.required' => '住所を入力してください',
            
        ];
    }
}
