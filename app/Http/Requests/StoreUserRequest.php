<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);

        if ($this->filled(['old_year', 'old_month', 'old_day'])) {
            $data['birth_day'] = sprintf('%04d-%02d-%02d', $this->input('old_year'), $this->input('old_month'), $this->input('old_day'));
        }

        return $data;
    }

public function rules()
{
    return [
        'over_name' => 'required|string|max:10',
        'under_name' => 'required|string|max:10',
        'over_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
        'under_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
        'mail_address' => 'required|string|email|max:100|unique:users',
        'old_year' => 'required|integer|min:2000|max:' . date('Y'),
        'old_month' => 'required|min:1|max:12',
        'old_day' => 'required|min:1|max:31',
        'birth_day' => 'required|date|after_or_equal:2000-01-01',
        'role' => 'required|in:1,2,3,4',
        'password' => 'required|string|min:8|max:30|confirmed',
        'subject.*' => 'integer|exists:subjects,id',
    ];
}

public function messages()
{
    return [
        'over_name.required' => '姓を入力してください。',
        'under_name.required' => '名を入力してください。',
        'over_name.max' => '姓は10文字以内です。',
        'under_name.max' => '名は10文字以内です。',
        'over_name_kana.required' => '姓のフリガナを入力してください。',
        'under_name_kana.required' => '名のフリガナを入力してください。',
        'over_name_kana.regex' => 'セイはカタカナのみです。',
        'over_name_kana.max' => 'セイは30文字以下です。',
        'under_name_kana.regex' => 'メイはカタカナのみです。',
        'under_name_kana.max' => 'メイは30文字以下です。',
        'mail_address.required' => 'メールアドレスを入力してください。',
        'mail_address.email' => '有効なメールアドレスを入力してください。',
        'mail_address.unique' => 'このメールアドレスは既に使用されています。',
        'mail_address.max' => 'メールアドレスは100文字以下で入力してください。',
        'sex.required' => '性別を選択してください。',
        'old_year.required' => '生年を入力してください。',
        'old_year.min' => '生年は2000年以降である必要があります。',
        'old_month.required' => '生月を入力してください。',
        'old_month.min' => '生月は1以上にしてください。',
        'old_month.max' => '生月は12以下にしてください。',
        'old_day.required' => '生日を入力してください。',
        'old_day.min' => '生日は1以上にしてください。',
        'old_day.max' => '生日は31以下である必要があります。',
        'birth_day.required' => '誕生日を入力してください。',
        'birth_day.date' => '有効な日付を入力してください。',
        'birth_day.after_or_equal' => '誕生日は2000-01-01以降の日付にしてください。',
        'role.required' => '役割を選択してください。',
        'role.in' => '選択された役割は無効です。',
        'password.required' => 'パスワードを入力してください。',
        'password.min' => 'パスワードは8文字以上で入力してください。',
        'password.max' => 'パスワードは30文字以下で入力してください。',
        'password.confirmed' => 'パスワード確認が一致しません。',
    ];
}

protected function withValidator(Validator $validator)
{
    $validator->after(function ($validator) {
        $oldYear = $this->input('old_year');
        $oldMonth = $this->input('old_month');
        $oldDay = $this->input('old_day');

        if (!checkdate($oldMonth, $oldDay, $oldYear)) {
            $validator->errors()->add('old_day', '正しい日付を入力してください。');
        }

        $birthDate = Carbon::createFromDate($oldYear, $oldMonth, $oldDay);
        $today = now();

        if ($birthDate->isBefore('2000-01-01') || $birthDate->isAfter($today)) {
            $validator->errors()->add('birth_day', '生年月日は2000年1月1日から今日までの間である必要があります。');
        }
    });
}

    public function attributes()
    {
        return [
            'over_name' => '姓',
            'under_name' => '名',
            'over_name_kana' => '姓（カナ）',
            'under_name_kana' => '名（カナ）',
            'mail_address' => 'メールアドレス',
            'sex' => '性別',
            'old_year' => '生年',
            'old_month' => '生月',
            'old_day' => '生日',
            'role' => '役割',
            'password' => 'パスワード',
        ];
    }
}
