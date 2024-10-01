<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserVioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 全てのユーザーがリクエストを行えるようにtrueを返す
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
            'faculty' => 'nullable|string|max:50',
            'hobby' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024|dimensions:max_width=600,ratio=1/1',
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'faculty.string' => '学部は文字列である必要があります。',
            'faculty.max' => '学部は50文字以内で入力してください。',
            'hobby.string' => '趣味は文字列である必要があります。',
            'hobby.max' => '趣味は50文字以内で入力してください。',
            'image.image' => 'アップロードされたファイルは画像である必要があります。',
            'image.mimes' => '画像はjpeg, png, jpg, gif形式である必要があります。',
            'image.max' => '画像サイズは1MB以下にしてください。',
            'image.dimensions' => '画像は最大幅600ピクセルで正方形にしてください。',
        ];
    }
}
