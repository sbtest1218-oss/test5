@extends('layouts.app')

@section('title', 'タスク詳細')

@section('content')
    <style>
        .task-detail {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .detail-row {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
            margin-bottom: 8px;
        }
        .detail-value {
            color: #333;
            font-size: 16px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
        }
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .task-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
    </style>

    <h2>タスク詳細</h2>

    <div class="task-detail">
        <div class="detail-row">
            <div class="detail-label">タイトル</div>
            <div class="detail-value">{{ $task->title }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">説明</div>
            <div class="detail-value">{{ $task->description ?: '説明なし' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">ステータス</div>
            <div class="detail-value">
                <span class="status-badge {{ $task->is_completed ? 'status-completed' : 'status-pending' }}">
                    {{ $task->is_completed ? '完了' : '未完了' }}
                </span>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">作成日時</div>
            <div class="detail-value">{{ $task->created_at->format('Y年m月d日 H:i') }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">更新日時</div>
            <div class="detail-value">{{ $task->updated_at->format('Y年m月d日 H:i') }}</div>
        </div>

        <div class="task-actions">
            <a href="{{ route('tasks.edit', $task) }}" class="btn">編集</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
            </form>
            <a href="{{ route('tasks.index') }}" class="btn btn-success">一覧に戻る</a>
        </div>
    </div>
@endsection