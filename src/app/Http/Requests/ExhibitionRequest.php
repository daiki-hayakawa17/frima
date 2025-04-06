<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class SellRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required | max:255',
            'item__image' => 'required | mimes:png,jpeg',
            'categories' => 'required',
            'condition' => 'required',
            'price' => 'required | integer | min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明を255文字以内で入力してください',
            'item__image.required' => '商品画像を登録してください',
            'item__image.mimes:png,jpg' => '「.png」または「.jpeg」形式でアップロードしてください',
            'categories.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0以上の数値で入力してください',
        ];
    }
}
