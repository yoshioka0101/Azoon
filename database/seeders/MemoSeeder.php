<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Memo;

class MemoSeeder extends Seeder
{
    public function run(): void
    {
        // ダミーメモを作成
        DB::table('memos')->insert([
            [
                'content' => 'これはサンプルメモです。',
                'title' => 'サンプルメモ',
                'user_id' => 1, // 管理者ユーザーのメモ
                'image' => 'sample.jpg',
                'url' => "https://www.google.com",
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Laravel シーダーのテスト',
                'title' => 'Laravel Seeding',
                'user_id' => 2, // 一般ユーザーのメモ
                'image' => 'laravel.png',
                'url' => "https://www.google.com",
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // ダミーメモを10件作成
        Memo::factory(10)->create();
    }
}