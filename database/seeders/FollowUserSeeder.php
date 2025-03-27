<?php
 
 namespace Database\Seeders;
 
 use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;
 
 class FollowUserSeeder extends Seeder
 {
     public function run(): void
     {
         DB::table('follow_users')->updateOrInsert(
             ['following_user_id' => 1, 'followed_user_id' => 2], // 条件
             ['created_at' => now(), 'updated_at' => now()] // 更新または挿入
         );
         
         DB::table('follow_users')->updateOrInsert(
             ['following_user_id' => 2, 'followed_user_id' => 1],
             ['created_at' => now(), 'updated_at' => now()]
         );
     }
 }