<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;



class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()//authorize()は、ログインしているかどうかをチェックするもの
    {
        return true;
    }

      /**
     * Merge the birth date fields into a single date field.
     *
     * @return array
     */
    public function all($keys = null)//all()メソッドのオーバーライド:ユーザーの入力したold_year, old_month, old_dayをbirth_dayという単一のフィールドに統合しています。
    {
        $data = parent::all($keys);//$keysは呼び出し元から渡される引数であり、親クラスのallメソッドの振る舞いをカスタマイズするために使われます。

        // 'old_year', 'old_month', 'old_day' の全てのフィールドが入力されているかチェック
            if($this->filled(['old_year', 'old_month', 'old_day'])) {

        // 'old_year', 'old_month', 'old_day' を 'YYYY-MM-DD' 形式の 'birth_day' フィールドに統合
            $data['birth_day'] = sprintf('%04d-%02d-%02d', $this->input('old_year'), $this->input('old_month'), $this->input('old_day'));
        }
        // 統合後のデータを返す
        return $data;

        //親クラスのallメソッドを呼び出し、リクエストデータを取得。old_year、old_month、およびold_dayのフィールドが全て存在するかをチェック。存在する場合、それらを統合してbirth_dayフィールドを作成。統合後のデータを返す。
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // 今日の日付を取得
        $today = now()->toDateString();

        return [
            'over_name' => 'required|string|max:10',
        'under_name' => 'required|string|max:10',
        'over_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:255',
        'under_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:255',
        'mail_address' => 'required|string|email|max:255|unique:users',
        'sex' => 'required|in:0,1,2',
        'old_year' => 'required|min:1900|max:' . date('Y'),
        'old_month' => 'required|min:1|max:12',
        'old_day' => 'required|min:1|max:31',
        'birth_day' => 'required|date|after_or_equal:2000-01-01',
        'role' => 'required|in:1,2,3,4',
        'password' => 'required|string|min:8|confirmed',
        'subject' => 'required|array',
        'subject.*' => 'integer|exists:subjects,id'
        ];
    }

    public function messages()
    {
        return [
        'over_name.required' => '姓を入力してください。',
        'under_name.required' => '名を入力してください。',
        'over_name.max' => '姓は10文字以内で入力してください。',
        'under_name.max' => '名は10文字以内で入力してください。',
        'over_name_kana.required' => '姓のフリガナを入力してください。',
        'under_name_kana.required' => '名のフリガナを入力してください。',
        'over_name_kana.regex' => '姓（カナ）の形式が無効です。',
        'under_name_kana.regex' => '名（カナ）の形式が無効です。',
        'mail_address.required' => 'メールアドレスを入力してください。',
        'mail_address.email' => '有効なメールアドレスを入力してください。',
        'mail_address.unique' => 'このメールアドレスは既に使用されています。',
        'sex.required' => '性別を選択してください。',
        'old_year.required' => '生年を入力してください。',
        'old_month.required' => '生月を入力してください。',
        'old_month.integer' => '生月は整数で入力してください。',
        'old_month.min' => '生月は1以上である必要があります。',
        'old_month.max' => '生月は12以下である必要があります。',
        'old_year.min' => '生年は2000年以降である必要があります。',
        'old_day.required' => '生日を入力してください。',
        'old_day.integer' => '生日は整数で入力してください。',
        'old_day.min' => '生日は1以上である必要があります。',
        'old_day.max' => '生日は31以下である必要があります。',
        'birth_day.required' => '誕生日を入力してください。',
        'birth_day.date' => '有効な日付を入力してください。',
        'birth_day.after_or_equal' => '誕生日は2000-01-01以降の日付にしてください。',
        'role.required' => '役割を選択してください。',
        'role.integer' => '役割は整数で入力してください。',
        'role.in' => '選択された役割は無効です。',
        'password.required' => 'パスワードを入力してください。',
        'password.min' => 'パスワードは8文字以上で入力してください。',
        'password.confirmed' => 'パスワード確認が一致しません。',
        'subject.required' => '少なくとも一つの科目を選択してください。',

        ];
    }





    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $oldYear = $this->input('old_year');
            $oldMonth = $this->input('old_month');
            $oldDay = $this->input('old_day'); //ユーザーからの入力値を取得しています。$this->input() メソッドは、リクエストから指定されたフィールドの値を取得します。


             // 日付が正しいかをチェック
            if (!checkdate($oldMonth, $oldDay, $oldYear)) {
                $validator->errors()->add('old_day', '正しい日付を入力してください。');//checkdate 関数を使用して、入力された日付が有効な日付であるかを確認しています。無効な日付（例えば、2月30日など）の場合は、エラーメッセージを追加します。
            }
            // 日付の範囲をチェック
            $birthDate = Carbon::createFromDate($oldYear, $oldMonth, $oldDay);
            $today = now();//Carbon ライブラリを使用して、入力された日付が2000年1月1日から今日までの範囲内にあるかを確認しています。範囲外の場合は、エラーメッセージを追加します。

            if ($birthDate->isBefore('2000-01-01') || $birthDate->isAfter($today)) {
                $validator->errors()->add('old_year', '生年月日は2000年1月1日から今日までの間である必要があります。');
            }
        });
    }

    /**
     * カスタム属性名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'over_name'      => '姓',
            'under_name'     => '名',
            'over_name_kana' => '姓（カナ）',
            'under_name_kana'=> '名（カナ）',
            'mail_address'   => 'メールアドレス',
            'sex'            => '性別',
            'old_year'       => '生年',
            'old_month'      => '生月',
            'old_day'        => '生日',
            'role'           => '役割',
            'password'       => 'パスワード',
        ];
    }
}
