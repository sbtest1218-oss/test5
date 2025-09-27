<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API テスト</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px 0;
        }
        button:hover {
            background-color: #45a049;
        }
        #loading {
            display: none;
            color: #666;
            font-style: italic;
        }
        #result {
            margin-top: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            min-height: 100px;
        }
        .task-item {
            padding: 10px;
            margin: 10px 0;
            background-color: #f9f9f9;
            border-left: 3px solid #4CAF50;
            border-radius: 3px;
        }
        .task-title {
            font-weight: bold;
            color: #333;
        }
        .task-description {
            color: #666;
            margin-top: 5px;
        }
        .task-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            margin-top: 5px;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .error {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 10px;
            border-radius: 3px;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
        .form-section {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .btn-save {
            background-color: #2196F3;
        }
        .btn-save:hover {
            background-color: #1976D2;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 3px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>API テストページ</h1>
    
    <div class="form-section">
        <h2>新規タスク作成</h2>
        <div class="form-group">
            <label for="task-title">タイトル（必須）</label>
            <input type="text" id="task-title" placeholder="タスクのタイトルを入力">
        </div>
        <div class="form-group">
            <label for="task-description">説明（任意）</label>
            <textarea id="task-description" placeholder="タスクの説明を入力"></textarea>
        </div>
        <button class="btn-save" onclick="saveTask()">タスクを保存</button>
        <div id="save-result"></div>
    </div>
    
    <div>
        <button onclick="fetchTasks()">タスクデータを取得</button>
        <button onclick="clearResult()">クリア</button>
    </div>
    
    <div id="loading">読み込み中...</div>
    <div id="result">ここに取得したデータが表示されます</div>

    <script>
        function fetchTasks() {
            const resultDiv = document.getElementById('result');
            const loadingDiv = document.getElementById('loading');
            
            // ローディング表示
            loadingDiv.style.display = 'block';
            resultDiv.innerHTML = '';
            
            // APIを呼び出し
            fetch('/api/tasks')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('取得したデータ:', data);
                    
                    // ローディング非表示
                    loadingDiv.style.display = 'none';
                    
                    // 結果表示
                    if (data.status === 'success') {
                        displayTasks(data.data);
                    } else {
                        resultDiv.innerHTML = '<div class="error">データの取得に失敗しました</div>';
                    }
                })
                .catch(error => {
                    console.error('エラー:', error);
                    loadingDiv.style.display = 'none';
                    resultDiv.innerHTML = `<div class="error">エラーが発生しました: ${error.message}</div>`;
                });
        }
        
        function displayTasks(tasks) {
            const resultDiv = document.getElementById('result');
            
            if (tasks.length === 0) {
                resultDiv.innerHTML = '<p>タスクがありません</p>';
                return;
            }
            
            let html = `<h3>取得したタスク一覧 (${tasks.length}件)</h3>`;
            
            tasks.forEach(task => {
                const statusClass = task.is_completed ? 'status-completed' : 'status-pending';
                const statusText = task.is_completed ? '完了' : '未完了';
                
                html += `
                    <div class="task-item">
                        <div class="task-title">タスク ID: ${task.id} - ${task.title}</div>
                        ${task.description ? `<div class="task-description">${task.description}</div>` : ''}
                        <span class="task-status ${statusClass}">${statusText}</span>
                    </div>
                `;
            });
            
            html += '<h4>生のJSONデータ:</h4>';
            html += `<pre>${JSON.stringify(tasks, null, 2)}</pre>`;
            
            resultDiv.innerHTML = html;
        }
        
        function clearResult() {
            document.getElementById('result').innerHTML = 'ここに取得したデータが表示されます';
        }
        
        function saveTask() {
            const titleInput = document.getElementById('task-title');
            const descriptionInput = document.getElementById('task-description');
            const saveResultDiv = document.getElementById('save-result');
            const loadingDiv = document.getElementById('loading');
            
            // バリデーション
            if (!titleInput.value.trim()) {
                saveResultDiv.innerHTML = '<div class="error">タイトルは必須です</div>';
                return;
            }
            
            // 送信データの準備
            const taskData = {
                title: titleInput.value.trim(),
                description: descriptionInput.value.trim() || null
            };
            
            // ローディング表示
            loadingDiv.style.display = 'block';
            saveResultDiv.innerHTML = '';
            
            // APIに送信
            fetch('/api/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(taskData)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('保存したデータ:', data);
                
                // ローディング非表示
                loadingDiv.style.display = 'none';
                
                // 成功メッセージ表示
                if (data.status === 'success') {
                    saveResultDiv.innerHTML = `<div class="success">タスクが正常に保存されました (ID: ${data.data.id})</div>`;
                    
                    // フォームをクリア
                    titleInput.value = '';
                    descriptionInput.value = '';
                    
                    // 自動的にタスク一覧を更新
                    setTimeout(() => {
                        fetchTasks();
                    }, 1000);
                } else {
                    saveResultDiv.innerHTML = '<div class="error">タスクの保存に失敗しました</div>';
                }
            })
            .catch(error => {
                console.error('エラー:', error);
                loadingDiv.style.display = 'none';
                saveResultDiv.innerHTML = `<div class="error">エラーが発生しました: ${error.message}</div>`;
            });
        }
    </script>
</body>
</html>