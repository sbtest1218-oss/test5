@extends('layouts.app')

@section('title', '新規タスク作成')

@section('content')
    <style>
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-control:focus {
            outline: none;
            border-color: #4a90e2;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>

    <h2>新規タスク作成</h2>

    <div class="form-container">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="title" class="form-label">タイトル *</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">説明</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">作成</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-danger">キャンセル</a>
            </div>
        </form>
    </div>
@endsection