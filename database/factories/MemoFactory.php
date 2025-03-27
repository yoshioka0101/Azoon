<?php
 
 namespace Database\Factories;
 
 use Illuminate\Database\Eloquent\Factories\Factory;
 use App\Models\Memo;
 
 /**
  * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Memo>
  */
 class MemoFactory extends Factory
 {
     protected $model = Memo::class;
 
     public function definition(): array
     {
         return [
             'title' => $this->faker->sentence,
             'content' => $this->faker->paragraph,
             'url' => $this->faker->optional()->url,
             'image' => $this->faker->imageUrl(),
             'user_id' => 1,
             'status' => 1,
             'created_at' => now(),
             'updated_at' => now(),
         ];
     }
 }