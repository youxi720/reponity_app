<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommunityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'creator_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024|dimensions:max_width=300,ratio=1/1'
        ];
    }
    
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは100文字以内で入力してください。',
            'description.max' => '説明は255文字以内で入力してください。',
            'creator_id.required' => '作成者IDは必須です。',
            'creator_id.exists' => '無効な作成者IDです。',
            'image.image' => 'アップロードされたファイルは画像である必要があります。',
            'image.mimes' => '画像はjpeg, png, jpg, gif形式である必要があります。',
            'image.max' => '画像サイズは1MB以下にしてください。',
            'image.dimensions' => '画像は最大幅300ピクセルで正方形にしてください。',
        ];
    }
}
