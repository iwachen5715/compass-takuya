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
            'post_title' => 'min:4|max:50',
            'post_body' => 'min:10|max:500',
             'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ];
    }

    public function messages(){
        return [
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は500文字です。',
            'main_category_name.required' => 'メインカテゴリー名は必須です。',
            'main_category_name.string' => 'メインカテゴリー名は文字列でなければなりません。',
            'main_category_name.max' => 'メインカテゴリー名は100文字以内でなければなりません。',
            'main_category_name.unique' => '同じ名前のメインカテゴリーは登録できません。',
        ];
    }
}
