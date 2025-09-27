<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $tasks,
            'message' => 'タスク一覧を取得しました'
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable'
        ]);
        
        $task = Task::create($validated);
        
        return response()->json([
            'status' => 'success',
            'data' => $task,
            'message' => 'タスクが作成されました'
        ], 201);
    }
}