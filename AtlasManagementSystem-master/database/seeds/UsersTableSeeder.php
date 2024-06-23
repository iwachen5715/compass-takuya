<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
            'over_name' => '白井',
            'under_name' => '拓也',
            'over_name_kana' => 'シライ',
            'under_name_kana' => 'タクヤ',
            'mail_address' => 'iwa.taku.5715@gmail.com',
            'sex' => 1, // 1: 男性, 2: 女性, 3: その他
            'birth_day' => '1993-07-15',
            'role' => 4, // 1: 教師(国語), 2: 教師(数学), 3: 教師(英語), 4: 生徒
            'password' => bcrypt('password5715'), // パスワードはハッシュ化
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null, // 削除されていない場合
        ]);
    }
}
