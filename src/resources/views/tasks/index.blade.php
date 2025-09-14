@extends('layouts.app')

@section('title', 'タスク一覧')

@section('content')
    <style>
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .task-list {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .task-item {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .task-item:last-child {
            border-bottom: none;
        }
        .task-info {
            flex-grow: 1;
        }
        .task-title {
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }
        .task-completed {
            text-decoration: line-through;
            color: #999;
        }
        .task-description {
            color: #666;
            font-size: 14px;
        }
        .task-actions {
            display: flex;
            gap: 10px;
        }
        .task-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            margin-left: 10px;
        }
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
    </style>

    <div class="task-header">
        <h2>タスク一覧</h2>
        <a href="{{ route('tasks.create') }}" class="btn">新規タスク作成</a>
    </div>

    @if($tasks->count() > 0)
        <div class="task-list">
            @foreach($tasks as $task)
                <div class="task-item">
                    <div class="task-info">
                        <div class="task-title {{ $task->is_completed ? 'task-completed' : '' }}">
                            {{ $task->title }}
                            <span class="task-status {{ $task->is_completed ? 'status-completed' : 'status-pending' }}">
                                {{ $task->is_completed ? '完了' : '未完了' }}
                            </span>
                        </div>
                        @if($task->description)
                            <div class="task-description">{{ $task->description }}</div>
                        @endif
                    </div>
                    <div class="task-actions">
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-success">詳細</a>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn">編集</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="task-list">
            <div class="empty-state">
                <p>タスクがありません。</p>
                <p>新しいタスクを作成してください。</p>
            </div>
        </div>
    @endif
@endsection