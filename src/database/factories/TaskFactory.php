<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * テスト用のダミーデータを定義
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3), // ランダムな3語のタイトル
            'description' => fake()->paragraph(), // ランダムな段落
            'is_completed' => false,
        ];
    }
}
