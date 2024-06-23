<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Subjects;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
// レコードを作成
   Subjects::insert([
            ['subject' => '国語'],
            ['subject' => '数学'],
            ['subject' => '英語']
        ]);
    }
}
