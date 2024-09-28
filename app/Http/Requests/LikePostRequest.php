<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 認可が必要な場合は適宜設定
    }

    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id',
        ];
    }

    public function messages()
    {
        return [
            'post_id.required' => '投稿IDは必須です。',
            'post_id.exists' => '指定された投稿は存在しません。',
        ];
    }
}
