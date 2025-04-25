<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function attributes()
{
    return [
        'product_name' => '商品名',
        'company_id' => 'メーカー名',
        'price' => '価格',
        'stock' => '在庫数',
        'comment' => 'コメント',
        'img_path' => '商品画像',
    ];
}

public function messages() {
    return [
        'product_name.required' => ':attributeは必須項目です。',
        'company_id.required' => ':attributeは必須項目です。',
        'price.required' => ':attributeは必須項目です。',
        'stock.required' => ':attributeは必須項目です。',
        'comment.max' => ':attributeは:max文字以内で入力してください',
        'img_path.image' => ':attributeは画像ファイルを指定してください。',
        'img_path.mimes' => ':attributeはjpeg,png,jpg,gifのいずれかの形式で指定してください。',
        'img_path.max' => ':attributeは:maxKB以内で指定してください。'
    ];
}
}
