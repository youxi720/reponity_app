<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ここでfalseにすると認可されない
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'post.overview' => 'required|string|max:500', // 概要は必須、文字列、500文字まで
            'post.form_url' => 'required|url', // フォームURLは必須、有効なURL
            'post.target_ids' => 'required|array|min:1', // ターゲットIDは必須、配列で少なくとも1つ必要
            'post.target_ids.*' => 'integer|exists:targets,id', // 各ターゲットIDは整数で、ターゲットテーブルに存在する
            'post.spreadsheet_url' => 'nullable|url', // スプレッドシートURLは任意、有効なURL形式であればOK
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'post.overview.required' => '概要は必須です。',
            'post.overview.max' => '概要は500字以内に納めてください。',
            'post.form_url.required' => 'フォームリンクは必須です。',
            'post.form_url.url' => '有効なURLを入力してください。',
            'post.target_ids.required' => '対象者を少なくとも1つ選択してください。',
            'post.target_ids.*.exists' => '無効な対象者が含まれています。',
            'post.spreadsheet_url.url' => '有効なGoogleスプレッドシートのURLを入力してください。',
        ];
    }
}
