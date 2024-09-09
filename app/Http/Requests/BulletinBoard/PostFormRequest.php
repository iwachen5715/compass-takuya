<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
             'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
            'post_category_id' => 'required|exists:sub_categories,id',
        ];
    }

    public function messages(){
        return [
            'post_title.required' => 'タイトルは必ず入力してください。',
            'post_title.string' => 'タイトルは文字列型である必要があります。',
            'post_title.max' => 'タイトルは最大100文字までです。',
            'post_body.required' => '投稿内容は必ず入力してください。',
            'post_body.string' => '投稿内容は文字列型である必要があります。',
            'post_body.max' => '投稿内容は最大5000文字までです。',
            'post_category_id.required' => 'カテゴリーは必ず入力してください。',
            'post_category_id.exists' => '選択したカテゴリーは存在しません。',
        ];
    }
}
