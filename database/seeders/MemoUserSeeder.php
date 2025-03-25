<?php
 
 namespace Database\Seeders;
 
 use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;
 use App\Models\Memo;
 
 class MemoUserSeeder extends Seeder
 {
     public function run(): void
     {
         DB::table('memo_user')->insert([
             ['user_id' => 1, 'memo_id' => 1], // Admin User がメモ 1 に関連
             ['user_id' => 2, 'memo_id' => 2], // General User がメモ 2 に関連
         ]);
     }
 }