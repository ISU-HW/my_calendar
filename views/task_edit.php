<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование задачи - Мой календарь</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Стили остаются те же - копируйте из task_form.php */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #2563eb;
            --primary-light: #eff6ff;
            --primary-dark: #1d4ed8;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-muted: #9ca3af;
            --background: #ffffff;
            --background-secondary: #f9fafb;
            --border: #e5e7eb;
            --border-light: #f3f4f6;
            --success: #10b981;
            --success-light: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --error: #ef4444;
            --error-light: #fef2f2;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--background-secondary);
            color: var(--text-primary);
            line-height: 1.5;
        }

        .main-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 24px;
        }

        .header {
            background: var(--background);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            background: var(--background-secondary);
            color: var(--text-primary);
            border-color: var(--primary-color);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .card {
            background: var(--background);
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--background-secondary);
        }

        .card-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-content {
            padding: 24px;
        }

        /* Alert styles */
        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border: 1px solid;
        }

        .alert-success {
            color: var(--success);
            background-color: var(--success-light);
            border-color: var(--success);
        }

        .alert-error {
            color: var(--error);
            background-color: var(--error-light);
            border-color: var(--error);
        }

        .alert .material-icons {
            font-size: 20px;
            margin-top: 2px;
        }

        /* Task info styles */
        .task-info {
            background: var(--primary-light);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid var(--primary-color);
        }

        .task-info h2 {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-label {
            font-weight: 500;
            color: var(--text-secondary);
            min-width: 80px;
            font-size: 14px;
        }

        .info-value {
            color: var(--text-primary);
            font-size: 14px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: var(--success-light);
            color: var(--success);
        }

        .status-overdue {
            background: var(--error-light);
            color: var(--error);
        }

        .status-completed {
            background: var(--background-secondary);
            color: var(--text-muted);
        }

        /* Form styles */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            margin-bottom: 6px;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 14px;
        }

        .required {
            color: var(--error);
        }

        .form-input, .form-select, .form-textarea {
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: var(--background);
            color: var(--text-primary);
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
            font-family: inherit;
        }

        /* Button styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            min-height: 44px;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--text-secondary);
            color: white;
        }

        .btn-secondary:hover:not(:disabled) {
            background: var(--text-primary);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover:not(:disabled) {
            background: #059669;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover:not(:disabled) {
            background: #d97706;
        }

        .btn-danger {
            background: var(--error);
            color: white;
        }

        .btn-danger:hover:not(:disabled) {
            background: #dc2626;
        }

        .btn-outline {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-outline:hover:not(:disabled) {
            background: var(--background-secondary);
            color: var(--text-primary);
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                padding: 16px;
            }

            .header {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }

            .header-left {
                flex-direction: column;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <a href="index.php" class="back-btn">
                    <span class="material-icons">arrow_back</span>
                    К списку задач
                </a>
                <h1>Редактирование задачи</h1>
            </div>
        </div>

        <!-- Alerts -->
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <span class="material-icons">error</span>
                <div>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <?php echo htmlspecialchars($error); ?><br>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['errors']); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Task Info -->
        <div class="task-info">
            <h2>
                <span class="material-icons">info</span>
                Информация о задаче
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Статус:</span>
                    <?php
                    $statusClass = 'status-active';
                    $statusText = 'Активная';

                    if ($task['status_id'] == 3) {
                        $statusClass = 'status-completed';
                        $statusText = 'Выполнена';
                    } elseif (strtotime($task['date_time']) < time()) {
                        $statusClass = 'status-overdue';
                        $statusText = 'Просрочена';
                    }
                    ?>
                    <span class="status-badge <?php echo $statusClass; ?>">
                        <?php echo $statusText; ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Создана:</span>
                    <span class="info-value"><?php echo date('d.m.Y H:i', strtotime($task['created_at'])); ?></span>
                </div>
                <?php if ($task['updated_at'] != $task['created_at']): ?>
                    <div class="info-item">
                        <span class="info-label">Изменена:</span>
                        <span class="info-value"><?php echo date('d.m.Y H:i', strtotime($task['updated_at'])); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <span class="material-icons">edit</span>
                    Редактировать задачу
                </h2>
            </div>
            <div class="card-content">
                <form method="POST" action="?action=update&id=<?php echo $task['id']; ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="subject">
                                Тема <span class="required">*</span>
                            </label>
                            <input type="text" id="subject" name="subject" class="form-input"
                                   value="<?php echo htmlspecialchars($task['subject']); ?>" 
                                   placeholder="Название задачи" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="type_id">Тип</label>
                            <select id="type_id" name="type_id" class="form-select">
                                <?php foreach ($taskTypes as $type): ?>
                                    <option value="<?php echo $type['id']; ?>" 
                                            <?php echo ($type['id'] == $task['type_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($type['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="location">Место</label>
                            <input type="text" id="location" name="location" class="form-input"
                                   value="<?php echo htmlspecialchars($task['location'] ?? ''); ?>" 
                                   placeholder="Где будет проходить">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="duration">Длительность</label>
                            <select id="duration" name="duration" class="form-select">
                                <option value="15" <?php echo ($task['duration'] == 15) ? 'selected' : ''; ?>>15 минут</option>
                                <option value="30" <?php echo ($task['duration'] == 30) ? 'selected' : ''; ?>>30 минут</option>
                                <option value="60" <?php echo ($task['duration'] == 60) ? 'selected' : ''; ?>>1 час</option>
                                <option value="90" <?php echo ($task['duration'] == 90) ? 'selected' : ''; ?>>1.5 часа</option>
                                <option value="120" <?php echo ($task['duration'] == 120) ? 'selected' : ''; ?>>2 часа</option>
                                <option value="180" <?php echo ($task['duration'] == 180) ? 'selected' : ''; ?>>3 часа</option>
                                <option value="240" <?php echo ($task['duration'] == 240) ? 'selected' : ''; ?>>4 часа</option>
                                <option value="480" <?php echo ($task['duration'] == 480) ? 'selected' : ''; ?>>8 часов</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="date">Дата <span class="required">*</span></label>
                            <input type="date" id="date" name="date" class="form-input" 
                                   value="<?php echo $taskDate; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="time">Время <span class="required">*</span></label>
                            <input type="time" id="time" name="time" class="form-input" 
                                   value="<?php echo $taskTime; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="comment">Комментарий</label>
                        <textarea id="comment" name="comment" class="form-textarea" 
                                  placeholder="Дополнительные заметки..."><?php echo htmlspecialchars($task['comment'] ?? ''); ?></textarea>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary">
                            <span class="material-icons">save</span>
                            Сохранить изменения
                        </button>

                        <?php if ($task['status_id'] == 3): ?>
                            <a href="?action=undo&id=<?php echo $task['id']; ?>" 
                               class="btn btn-warning"
                               onclick="return confirm('Вернуть задачу в активное состояние?')">
                                <span class="material-icons">undo</span>
                                Вернуть в активные
                            </a>
                        <?php elseif ($task['status_id'] != 3): ?>
                            <a href="?action=complete&id=<?php echo $task['id']; ?>" 
                               class="btn btn-success"
                               onclick="return confirm('Отметить задачу как выполненную?')">
                                <span class="material-icons">check</span>
                                Выполнено
                            </a>
                        <?php endif; ?>

                        <a href="?action=delete&id=<?php echo $task['id']; ?>" 
                           class="btn btn-danger"
                           onclick="return confirm('Вы уверены, что хотите удалить эту задачу?')">
                            <span class="material-icons">delete</span>
                            Удалить
                        </a>

                        <a href="index.php" class="btn btn-outline">
                            <span class="material-icons">cancel</span>
                            Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        const textarea = document.getElementById('comment');
        if (textarea) {
            function adjustTextareaHeight() {
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            }
            
            textarea.addEventListener('input', adjustTextareaHeight);
            adjustTextareaHeight();
        }


        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const subject = document.getElementById('subject');
                const date = document.getElementById('date');
                const time = document.getElementById('time');

                if (!subject.value.trim()) {
                    e.preventDefault();
                    alert('Тема задачи обязательна для заполнения');
                    subject.focus();
                    return false;
                }

                if (!date.value || !time.value) {
                    e.preventDefault();
                    alert('Дата и время обязательны для заполнения');
                    (date.value ? time : date).focus();
                    return false;
                }
            });
        }


        let formDirty = false;
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            const initialValue = input.value;
            input.addEventListener('input', () => {
                formDirty = input.value !== initialValue;
            });
        });


        document.querySelectorAll('a[href]').forEach(link => {
            if (!link.onclick) {
                link.addEventListener('click', (e) => {
                    if (formDirty) {
                        const confirmLeave = confirm('У вас есть несохраненные изменения. Вы уверены, что хотите покинуть страницу?');
                        if (!confirmLeave) {
                            e.preventDefault();
                            return false;
                        }
                    }
                });
            }
        });

        window.addEventListener('beforeunload', (e) => {
            if (formDirty) {
                e.preventDefault();
                e.returnValue = 'У вас есть несохраненные изменения.';
            }
        });


        form.addEventListener('submit', () => {
            formDirty = false;
        });
    </script>
</body>

</html>