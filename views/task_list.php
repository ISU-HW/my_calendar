<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой календарь</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
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
            max-width: 1200px;
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
        }

        .header h1 {
            font-size: 32px;
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

        .alert-warning {
            color: var(--warning);
            background-color: var(--warning-light);
            border-color: var(--warning);
        }

        .alert .material-icons {
            font-size: 20px;
            margin-top: 2px;
        }

        /* New Task Card */
        .new-task-card {
            background: var(--background);
            border: 2px dashed var(--border);
            border-radius: 12px;
            margin-bottom: 24px;
            transition: all 0.2s ease;
            cursor: pointer;
            overflow: hidden;
        }

        .new-task-card:hover {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        .new-task-prompt {
            padding: 32px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .new-task-prompt .material-icons {
            font-size: 48px;
            color: var(--text-muted);
            margin-bottom: 16px;
            transition: all 0.2s ease;
        }

        .new-task-card:hover .new-task-prompt .material-icons {
            color: var(--primary-color);
            transform: scale(1.1);
        }

        .new-task-prompt h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .new-task-prompt p {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .new-task-card:hover .new-task-prompt p {
            color: var(--primary-color);
        }

        .new-task-form {
            display: none;
            padding: 24px;
            background: var(--background);
            border-top: 1px solid var(--border);
        }

        .new-task-form.show {
            display: block;
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

        .form-input,
        .form-select,
        .form-textarea {
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: var(--background);
            color: var(--text-primary);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-input:disabled,
        .form-select:disabled,
        .form-textarea:disabled {
            background: var(--background-secondary);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        .form-textarea {
            min-height: 80px;
            resize: vertical;
            font-family: inherit;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        /* Button styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            min-height: 40px;
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
            background: var(--background-secondary);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover:not(:disabled) {
            background: var(--border);
            color: var(--text-primary);
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

        .btn-small {
            padding: 6px 12px;
            font-size: 13px;
            min-height: 32px;
        }

        .btn-icon {
            padding: 8px;
            min-width: 40px;
            border-radius: 50%;
        }

        /* Filter controls */
        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
            margin-bottom: 24px;
            padding: 20px;
            background: var(--background);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-label {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 14px;
        }

        .date-range-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* Date Range Picker */
        .date-range-picker {
            position: relative;
            display: inline-block;
            width: 280px;
        }

        .date-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--background);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .date-input:hover {
            border-color: var(--primary-color);
        }

        .date-input.active {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .date-text {
            flex: 1;
            color: var(--text-primary);
        }

        .date-text.placeholder {
            color: var(--text-muted);
        }

        .date-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--background);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            margin-top: 4px;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .date-dropdown.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: all;
        }

        .calendar-container {
            display: flex;
        }

        .calendar {
            flex: 1;
            padding: 16px;
            min-width: 260px;
        }

        .calendar+.calendar {
            border-left: 1px solid var(--border);
        }

        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .calendar-nav {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
        }

        .calendar-nav:hover {
            background: var(--background-secondary);
            color: var(--text-primary);
        }

        .calendar-nav:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .calendar-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
        }

        .calendar-day-header {
            padding: 8px 4px;
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
        }

        .calendar-day {
            padding: 8px 4px;
            text-align: center;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 13px;
            position: relative;
        }

        .calendar-day:hover:not(.disabled):not(.other-month) {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .calendar-day.disabled {
            color: var(--text-muted);
            cursor: not-allowed;
        }

        .calendar-day.other-month {
            color: var(--text-muted);
        }

        .calendar-day.selected {
            background: var(--primary-color);
            color: white;
        }

        .calendar-day.in-range {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .calendar-day.range-start {
            background: var(--primary-color);
            color: white;
            border-radius: 6px 0 0 6px;
        }

        .calendar-day.range-end {
            background: var(--primary-color);
            color: white;
            border-radius: 0 6px 6px 0;
        }

        .calendar-day.range-start.range-end {
            border-radius: 6px;
        }

        .calendar-actions {
            padding: 16px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .selected-range {
            font-size: 13px;
            color: var(--text-secondary);
        }

        /* Table styles */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-light);
        }

        th {
            background: var(--background-secondary);
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background: var(--background-secondary);
        }

        tbody tr.completed {
            opacity: 0.6;
        }

        tbody tr.completed:hover {
            opacity: 0.8;
        }

        .task-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .task-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        tr.completed .task-link {
            color: var(--text-secondary);
            text-decoration: line-through;
        }

        .actions {
            display: flex;
            gap: 4px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            color: var(--text-secondary);
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .action-btn.complete {
            background: var(--success-light);
            color: var(--success);
        }

        .action-btn.complete:hover {
            background: var(--success);
            color: white;
        }

        .action-btn.undo {
            background: var(--warning-light);
            color: var(--warning);
        }

        .action-btn.undo:hover {
            background: var(--warning);
            color: white;
        }

        .action-btn.edit {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .action-btn.edit:hover {
            background: var(--primary-color);
            color: white;
        }

        .action-btn.delete {
            background: var(--error-light);
            color: var(--error);
        }

        .action-btn.delete:hover {
            background: var(--error);
            color: white;
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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state .material-icons {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                padding: 16px;
            }

            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                justify-content: space-between;
            }

            .date-range-buttons {
                justify-content: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .calendar-container {
                flex-direction: column;
            }

            .calendar+.calendar {
                border-left: none;
                border-top: 1px solid var(--border);
            }

            .date-range-picker {
                width: 100%;
            }

            table {
                font-size: 13px;
            }

            th,
            td {
                padding: 12px 8px;
            }

            .actions {
                flex-direction: column;
                gap: 2px;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Header -->
        <div class="header">
            <h1>Мой календарь</h1>
        </div>

        <!-- Alerts -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <span class="material-icons">check_circle</span>
                <div><?php echo htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?></div>
            </div>
        <?php endif; ?>

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

        <!-- New Task Card -->
        <div class="new-task-card" id="newTaskCard">
            <div class="new-task-prompt" id="newTaskPrompt">
                <div class="material-icons">add_circle_outline</div>
                <h3>Добавить новую задачу</h3>
                <p>Нажмите здесь для создания новой задачи</p>
            </div>
            <div class="new-task-form" id="newTaskForm">
                <form action="index.php?action=add" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="subject">Тема <span class="required">*</span></label>
                            <input type="text" id="subject" name="subject" class="form-input" required
                                placeholder="Название задачи">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="type_id">Тип</label>
                            <select id="type_id" name="type_id" class="form-select">
                                <?php foreach ($taskTypes as $type): ?>
                                    <option value="<?php echo $type['id']; ?>">
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
                                placeholder="Где будет проходить">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="duration">Длительность</label>
                            <select id="duration" name="duration" class="form-select">
                                <option value="15">15 минут</option>
                                <option value="30">30 минут</option>
                                <option value="60" selected>1 час</option>
                                <option value="90">1.5 часа</option>
                                <option value="120">2 часа</option>
                                <option value="180">3 часа</option>
                                <option value="240">4 часа</option>
                                <option value="480">8 часов</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="date">Дата <span class="required">*</span></label>
                            <input type="date" id="date" name="date" class="form-input"
                                value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="time">Время <span class="required">*</span></label>
                            <input type="time" id="time" name="time" class="form-input" value="12:00" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="comment">Комментарий</label>
                        <textarea id="comment" name="comment" class="form-textarea"
                            placeholder="Дополнительные заметки..."></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" onclick="cancelNewTask()">
                            Отмена
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="material-icons">add</span>
                            Добавить задачу
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Task List Card -->
        <div class="card">
            <div class="card-header">
                <h2>Список задач</h2>
            </div>
            <div class="card-content">
                <!-- Filter Controls -->
                <div class="filter-controls">
                    <div class="filter-group">
                        <label class="filter-label">Показать:</label>
                        <select id="filter" class="form-select" style="width: 160px;" onchange="applyFilters()">
                            <option value="all" <?php echo ($filter == 'all') ? 'selected' : ''; ?>>Все задачи</option>
                            <option value="current" <?php echo ($filter == 'current') ? 'selected' : ''; ?>>Активные
                            </option>
                            <option value="overdue" <?php echo ($filter == 'overdue') ? 'selected' : ''; ?>>Просроченные
                            </option>
                            <option value="completed" <?php echo ($filter == 'completed') ? 'selected' : ''; ?>>
                                Выполненные</option>
                        </select>
                    </div>

                    <?php if ($filter != 'overdue'): ?>
                        <div class="filter-group">
                            <label class="filter-label">Период:</label>
                            <div class="date-range-picker" id="dateRangePicker">
                                <div class="date-input" id="dateInput">
                                    <span class="date-text placeholder" id="dateText">Выберите период</span>
                                    <span class="material-icons">date_range</span>
                                </div>

                                <div class="date-dropdown" id="dateDropdown">
                                    <div class="calendar-container">
                                        <div class="calendar" id="leftCalendar">
                                            <div class="calendar-header">
                                                <button type="button" class="calendar-nav" id="prevMonth">
                                                    <span class="material-icons">chevron_left</span>
                                                </button>
                                                <div class="calendar-title" id="leftTitle"></div>
                                                <div style="width: 32px;"></div>
                                            </div>
                                            <div class="calendar-grid" id="leftGrid"></div>
                                        </div>

                                        <div class="calendar" id="rightCalendar">
                                            <div class="calendar-header">
                                                <div style="width: 32px;"></div>
                                                <div class="calendar-title" id="rightTitle"></div>
                                                <button type="button" class="calendar-nav" id="nextMonth">
                                                    <span class="material-icons">chevron_right</span>
                                                </button>
                                            </div>
                                            <div class="calendar-grid" id="rightGrid"></div>
                                        </div>
                                    </div>

                                    <div class="calendar-actions">
                                        <div class="selected-range" id="selectedRange">Период не выбран</div>
                                        <div>
                                            <button type="button" class="btn btn-outline btn-small"
                                                id="clearBtn">Очистить</button>
                                            <button type="button" class="btn btn-primary btn-small"
                                                id="applyBtn">Применить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="date-range-buttons">
                            <button type="button" class="btn btn-outline btn-small"
                                onclick="setDateRange('today')">Сегодня</button>
                            <button type="button" class="btn btn-outline btn-small"
                                onclick="setDateRange('tomorrow')">Завтра</button>
                            <button type="button" class="btn btn-outline btn-small" onclick="setDateRange('thisWeek')">Эта
                                неделя</button>
                            <button type="button" class="btn btn-outline btn-small" onclick="setDateRange('nextWeek')">След
                                неделя</button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Table -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Тип</th>
                                <th>Задача</th>
                                <th>Место</th>
                                <th>Дата и время</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tasks)): ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="material-icons">event_busy</div>
                                            <p>Задач не найдено</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tasks as $task): ?>
                                    <tr class="<?php echo ($task['status_id'] == 3) ? 'completed' : ''; ?>">
                                        <td><?php echo htmlspecialchars($task['type_name']); ?></td>
                                        <td>
                                            <a href="?action=edit&id=<?php echo $task['id']; ?>" class="task-link">
                                                <?php echo htmlspecialchars($task['subject']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($task['location'] ?? '-'); ?></td>
                                        <td><?php echo date('d.m.Y H:i', strtotime($task['date_time'])); ?></td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <?php if ($task['status_id'] == 3): ?>
                                                    <button type="button" class="action-btn undo"
                                                        onclick="undoTask(<?php echo $task['id']; ?>)" title="Вернуть в активные">
                                                        <span class="material-icons">undo</span>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="action-btn complete"
                                                        onclick="completeTask(<?php echo $task['id']; ?>)" title="Выполнено">
                                                        <span class="material-icons">check</span>
                                                    </button>
                                                <?php endif; ?>
                                                <a href="?action=edit&id=<?php echo $task['id']; ?>" class="action-btn edit"
                                                    title="Редактировать">
                                                    <span class="material-icons">edit</span>
                                                </a>
                                                <button type="button" class="action-btn delete"
                                                    onclick="deleteTask(<?php echo $task['id']; ?>)" title="Удалить">
                                                    <span class="material-icons">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>

        function showNewTaskForm() {
            const prompt = document.getElementById('newTaskPrompt');
            const form = document.getElementById('newTaskForm');

            prompt.style.display = 'none';
            form.classList.add('show');


            document.getElementById('subject').focus();
        }

        function cancelNewTask() {
            const prompt = document.getElementById('newTaskPrompt');
            const form = document.getElementById('newTaskForm');

            form.classList.remove('show');
            prompt.style.display = 'block';


            document.querySelector('#newTaskForm form').reset();
        }


        document.getElementById('newTaskCard').addEventListener('click', function (e) {
            if (e.target.closest('.new-task-form')) return;
            showNewTaskForm();
        });


        class DateRangePicker {
            constructor(element, options = {}) {
                this.element = element;
                this.options = {
                    format: 'dd.mm.yyyy',
                    separator: ' - ',
                    minDate: null,
                    maxDate: null,
                    ...options
                };

                this.startDate = null;
                this.endDate = null;
                this.currentMonth = new Date();
                this.currentMonth.setDate(1);
                this.selectingStart = true;
                this.isOpen = false;

                this.init();
            }

            init() {
                this.setupElements();
                this.setupEventListeners();
                this.render();
            }

            setupElements() {
                this.input = this.element.querySelector('#dateInput');
                this.dropdown = this.element.querySelector('#dateDropdown');
                this.dateText = this.element.querySelector('#dateText');

                this.leftTitle = this.element.querySelector('#leftTitle');
                this.rightTitle = this.element.querySelector('#rightTitle');
                this.leftGrid = this.element.querySelector('#leftGrid');
                this.rightGrid = this.element.querySelector('#rightGrid');

                this.prevBtn = this.element.querySelector('#prevMonth');
                this.nextBtn = this.element.querySelector('#nextMonth');
                this.clearBtn = this.element.querySelector('#clearBtn');
                this.applyBtn = this.element.querySelector('#applyBtn');
                this.selectedRange = this.element.querySelector('#selectedRange');
            }

            setupEventListeners() {
                this.input.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggle();
                });

                this.dropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                });

                this.prevBtn.addEventListener('click', () => this.prevMonth());
                this.nextBtn.addEventListener('click', () => this.nextMonth());
                this.clearBtn.addEventListener('click', () => this.clear());
                this.applyBtn.addEventListener('click', () => this.apply());

                document.addEventListener('click', (e) => {
                    if (!this.element.contains(e.target)) {
                        this.close();
                    }
                });
            }

            toggle() {
                this.isOpen ? this.close() : this.open();
            }

            open() {
                this.isOpen = true;
                this.input.classList.add('active');
                this.dropdown.classList.add('show');
                this.render();
            }

            close() {
                this.isOpen = false;
                this.input.classList.remove('active');
                this.dropdown.classList.remove('show');
            }

            prevMonth() {
                this.currentMonth.setMonth(this.currentMonth.getMonth() - 1);
                this.render();
            }

            nextMonth() {
                this.currentMonth.setMonth(this.currentMonth.getMonth() + 1);
                this.render();
            }

            clear() {
                this.startDate = null;
                this.endDate = null;
                this.selectingStart = true;
                this.updateDisplay();
                this.render();
            }

            apply() {
                this.close();
                this.updateDisplay();
                this.triggerChange();
                applyFilters();
            }

            setPreset(preset) {
                const today = new Date();
                let start, end;

                switch (preset) {
                    case 'today':
                        start = end = new Date(today);
                        break;
                    case 'tomorrow':
                        start = end = new Date(today);
                        start.setDate(today.getDate() + 1);
                        end = new Date(start);
                        break;
                    case 'thisWeek':
                        start = new Date(today);
                        start.setDate(today.getDate() - today.getDay() + 1);
                        end = new Date(start);
                        end.setDate(start.getDate() + 6);
                        break;
                    case 'nextWeek':
                        start = new Date(today);
                        start.setDate(today.getDate() - today.getDay() + 8);
                        end = new Date(start);
                        end.setDate(start.getDate() + 6);
                        break;
                    case 'thisMonth':
                        start = new Date(today.getFullYear(), today.getMonth(), 1);
                        end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        break;
                    case 'nextMonth':
                        start = new Date(today.getFullYear(), today.getMonth() + 1, 1);
                        end = new Date(today.getFullYear(), today.getMonth() + 2, 0);
                        break;
                }

                this.startDate = start;
                this.endDate = end;
                this.selectingStart = true;
                this.render();
                this.updateSelectedRange();
            }

            selectDate(date) {
                if (this.selectingStart || !this.startDate || date < this.startDate) {
                    this.startDate = new Date(date);
                    this.endDate = null;
                    this.selectingStart = false;
                } else {
                    this.endDate = new Date(date);
                    this.selectingStart = true;
                }

                this.render();
                this.updateSelectedRange();
            }

            render() {
                this.renderCalendar(this.leftGrid, this.leftTitle, this.currentMonth);

                const nextMonth = new Date(this.currentMonth);
                nextMonth.setMonth(this.currentMonth.getMonth() + 1);
                this.renderCalendar(this.rightGrid, this.rightTitle, nextMonth);
            }

            renderCalendar(grid, titleEl, month) {
                const monthNames = [
                    'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
                    'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
                ];

                const dayNames = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];

                titleEl.textContent = `${monthNames[month.getMonth()]} ${month.getFullYear()}`;

                grid.innerHTML = '';

                dayNames.forEach(day => {
                    const dayEl = document.createElement('div');
                    dayEl.className = 'calendar-day-header';
                    dayEl.textContent = day;
                    grid.appendChild(dayEl);
                });

                const firstDay = new Date(month.getFullYear(), month.getMonth(), 1);
                const lastDay = new Date(month.getFullYear(), month.getMonth() + 1, 0);
                const startDate = new Date(firstDay);
                startDate.setDate(startDate.getDate() - firstDay.getDay());

                for (let i = 0; i < 42; i++) {
                    const currentDate = new Date(startDate);
                    currentDate.setDate(startDate.getDate() + i);

                    const dayEl = document.createElement('div');
                    dayEl.className = 'calendar-day';
                    dayEl.textContent = currentDate.getDate();

                    if (currentDate.getMonth() !== month.getMonth()) {
                        dayEl.classList.add('other-month');
                    }

                    if (this.isDateInRange(currentDate)) {
                        if (this.isDateEqual(currentDate, this.startDate)) {
                            dayEl.classList.add('range-start');
                        } else if (this.isDateEqual(currentDate, this.endDate)) {
                            dayEl.classList.add('range-end');
                        } else {
                            dayEl.classList.add('in-range');
                        }
                    }

                    dayEl.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (!dayEl.classList.contains('disabled')) {
                            this.selectDate(currentDate);
                        }
                    });

                    grid.appendChild(dayEl);
                }
            }

            isDateEqual(date1, date2) {
                if (!date1 || !date2) return false;
                return date1.toDateString() === date2.toDateString();
            }

            isDateInRange(date) {
                if (!this.startDate) return false;
                if (!this.endDate) return this.isDateEqual(date, this.startDate);
                return date >= this.startDate && date <= this.endDate;
            }

            updateSelectedRange() {
                if (this.startDate && this.endDate) {
                    const start = this.formatDate(this.startDate);
                    const end = this.formatDate(this.endDate);
                    const days = Math.ceil((this.endDate - this.startDate) / (1000 * 60 * 60 * 24)) + 1;
                    this.selectedRange.textContent = `${start} - ${end} (${days} дн.)`;
                } else if (this.startDate) {
                    this.selectedRange.textContent = `${this.formatDate(this.startDate)} - выберите конечную дату`;
                } else {
                    this.selectedRange.textContent = 'Период не выбран';
                }
            }

            updateDisplay() {
                if (this.startDate && this.endDate) {
                    const start = this.formatDate(this.startDate);
                    const end = this.formatDate(this.endDate);
                    this.dateText.textContent = `${start}${this.options.separator}${end}`;
                    this.dateText.classList.remove('placeholder');
                } else if (this.startDate) {
                    this.dateText.textContent = `${this.formatDate(this.startDate)} - ...`;
                    this.dateText.classList.remove('placeholder');
                } else {
                    this.dateText.textContent = 'Выберите период';
                    this.dateText.classList.add('placeholder');
                }
            }

            formatDate(date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}.${month}.${year}`;
            }

            triggerChange() {
                const event = new CustomEvent('dateRangeChange', {
                    detail: {
                        startDate: this.startDate,
                        endDate: this.endDate,
                        formattedStart: this.startDate ? this.formatDate(this.startDate) : null,
                        formattedEnd: this.endDate ? this.formatDate(this.endDate) : null
                    }
                });
                this.element.dispatchEvent(event);
            }

            getRange() {
                return {
                    startDate: this.startDate,
                    endDate: this.endDate
                };
            }

            setRange(startDate, endDate) {
                this.startDate = startDate ? new Date(startDate) : null;
                this.endDate = endDate ? new Date(endDate) : null;
                this.updateDisplay();
                this.render();
            }
        }


        let dateRangePicker;
        document.addEventListener('DOMContentLoaded', function () {
            const pickerElement = document.getElementById('dateRangePicker');
            if (pickerElement) {
                dateRangePicker = new DateRangePicker(pickerElement);


                const urlParams = new URLSearchParams(window.location.search);
                const startDate = urlParams.get('start_date');
                const endDate = urlParams.get('end_date');

                if (startDate && endDate) {
                    setTimeout(() => {
                        dateRangePicker.setRange(startDate, endDate);
                    }, 100);
                }
            }
        });


        function setDateRange(preset) {
            if (dateRangePicker) {
                dateRangePicker.setPreset(preset);
                dateRangePicker.updateDisplay();
                dateRangePicker.triggerChange();
                applyFilters();
            }
        }


        function applyFilters() {
            const filter = document.getElementById('filter').value;
            let url = 'index.php?filter=' + filter;

            if (dateRangePicker && filter !== 'overdue') {
                const range = dateRangePicker.getRange();
                if (range.startDate && range.endDate) {
                    const startDate = range.startDate.toISOString().split('T')[0];
                    const endDate = range.endDate.toISOString().split('T')[0];
                    url += '&start_date=' + startDate + '&end_date=' + endDate;
                }
            }

            window.location.href = url;
        }

        function completeTask(id) {
            if (confirm('Отметить задачу как выполненную?')) {
                window.location.href = '?action=complete&id=' + id + '&' + getCurrentFilters();
            }
        }

        function undoTask(id) {
            if (confirm('Вернуть задачу в активное состояние?')) {
                window.location.href = '?action=undo&id=' + id + '&' + getCurrentFilters();
            }
        }

        function deleteTask(id) {
            if (confirm('Удалить задачу?')) {
                window.location.href = '?action=delete&id=' + id + '&' + getCurrentFilters();
            }
        }

        function getCurrentFilters() {
            const params = new URLSearchParams();
            params.set('filter', document.getElementById('filter').value);

            if (dateRangePicker) {
                const range = dateRangePicker.getRange();
                if (range.startDate && range.endDate) {
                    params.set('start_date', range.startDate.toISOString().split('T')[0]);
                    params.set('end_date', range.endDate.toISOString().split('T')[0]);
                }
            }

            return params.toString();
        }
    </script>
</body>

</html>