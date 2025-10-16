<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase; // テスト後にデータベースをリセット

    /**
     * タスク一覧ページが表示されることをテスト
     */
    public function test_タスク一覧ページが表示される(): void
    {
        // タスクを3つ作成
        Task::factory()->count(3)->create();

        // /tasksにアクセス
        $response = $this->get('/tasks');

        // 200 OKが返ってくるか確認
        $response->assertStatus(200);
    }

    /**
     * 新しいタスクが作成できることをテスト
     */
    public function test_新しいタスクが作成できる(): void
    {
        // タスクのデータを準備
        $taskData = [
            'title' => 'テストタスク',
            'description' => 'これはテストです'
        ];

        // POSTリクエストでタスクを作成
        $response = $this->post('/tasks', $taskData);

        // タスク一覧にリダイレクトされるか確認
        $response->assertRedirect('/tasks');

        // データベースにタスクが保存されたか確認
        $this->assertDatabaseHas('tasks', [
            'title' => 'テストタスク',
            'description' => 'これはテストです'
        ]);
    }

    /**
     * タスクのタイトルが必須であることをテスト
     */
    public function test_タイトルなしではタスクを作成できない(): void
    {
        // タイトルなしのデータ
        $taskData = [
            'title' => '', // 空
            'description' => 'これはテストです'
        ];

        // POSTリクエストを送信
        $response = $this->post('/tasks', $taskData);

        // バリデーションエラーになるか確認
        $response->assertSessionHasErrors('title');

        // データベースに保存されていないことを確認
        $this->assertDatabaseCount('tasks', 0);
    }

    /**
     * タスクが削除できることをテスト
     */
    public function test_タスクが削除できる(): void
    {
        // タスクを1つ作成
        $task = Task::factory()->create();

        // DELETEリクエストで削除
        $response = $this->delete("/tasks/{$task->id}");

        // タスク一覧にリダイレクトされるか確認
        $response->assertRedirect('/tasks');

        // データベースから削除されたか確認
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }
}
