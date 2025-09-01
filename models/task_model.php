<?php
class TaskModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllTasks($filter = 'all')
    {
        $currentDateTime = date('Y-m-d H:i:s');

        switch ($filter) {
            case 'current':

                $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                        FROM tasks t 
                        JOIN task_types tt ON t.type_id = tt.id 
                        JOIN task_statuses ts ON t.status_id = ts.id 
                        WHERE t.status_id = 1
                        ORDER BY t.date_time DESC";
                return $this->db->safeGet($sql, [], []);

            case 'overdue':

                $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                        FROM tasks t 
                        JOIN task_types tt ON t.type_id = tt.id 
                        JOIN task_statuses ts ON t.status_id = ts.id 
                        WHERE t.status_id = 1 AND t.date_time < :current_time
                        ORDER BY t.date_time DESC";
                return $this->db->safeGet($sql, ['current_time' => $currentDateTime], []);

            case 'completed':

                $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                        FROM tasks t 
                        JOIN task_types tt ON t.type_id = tt.id 
                        JOIN task_statuses ts ON t.status_id = ts.id 
                        WHERE t.status_id = 3
                        ORDER BY t.date_time DESC";
                return $this->db->safeGet($sql, [], []);

            case 'all':
            default:

                $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                        FROM tasks t 
                        JOIN task_types tt ON t.type_id = tt.id 
                        JOIN task_statuses ts ON t.status_id = ts.id 
                        ORDER BY t.date_time DESC";
                return $this->db->safeGet($sql, [], []);
        }
    }

    public function getTasksByDate($date)
    {
        $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                FROM tasks t 
                JOIN task_types tt ON t.type_id = tt.id 
                JOIN task_statuses ts ON t.status_id = ts.id 
                WHERE DATE(t.date_time) = :date
                ORDER BY t.date_time DESC";
        return $this->db->safeGet($sql, ['date' => $date], []);
    }

    public function getTasksByDateRange($startDate, $endDate, $filter = 'all')
    {
        $baseWhereClause = "DATE(t.date_time) >= :start_date AND DATE(t.date_time) <= :end_date";
        $params = ['start_date' => $startDate, 'end_date' => $endDate];
        $currentDateTime = date('Y-m-d H:i:s');

        switch ($filter) {
            case 'current':

                $whereClause = $baseWhereClause . " AND t.status_id = 1";
                break;

            case 'overdue':

                $whereClause = $baseWhereClause . " AND t.status_id = 1 AND t.date_time < :current_time";
                $params['current_time'] = $currentDateTime;
                break;

            case 'completed':

                $whereClause = $baseWhereClause . " AND t.status_id = 3";
                break;

            case 'all':
            default:

                $whereClause = $baseWhereClause;
                break;
        }

        $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                FROM tasks t 
                JOIN task_types tt ON t.type_id = tt.id 
                JOIN task_statuses ts ON t.status_id = ts.id 
                WHERE {$whereClause}
                ORDER BY t.date_time DESC";

        return $this->db->safeGet($sql, $params, []);
    }

    public function getTaskById($id)
    {
        if (!$this->db->isConnected()) {
            return null;
        }

        $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                FROM tasks t 
                JOIN task_types tt ON t.type_id = tt.id 
                JOIN task_statuses ts ON t.status_id = ts.id 
                WHERE t.id = :id";
        return $this->db->fetch($sql, ['id' => $id]);
    }

    public function addTask($data)
    {

        if (!$this->db->isConnected()) {
            return ['success' => false, 'errors' => ['Не удается сохранить задачу. Попробуйте позже.']];
        }


        $errors = $this->validateTaskData($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $sql = "INSERT INTO tasks (subject, type_id, location, date_time, duration, comment) 
                VALUES (:subject, :type_id, :location, :date_time, :duration, :comment)";

        $params = [
            'subject' => trim($data['subject']),
            'type_id' => intval($data['type_id']),
            'location' => !empty(trim($data['location'] ?? '')) ? trim($data['location']) : null,
            'date_time' => $data['date'] . ' ' . $data['time'],
            'duration' => intval($data['duration']),
            'comment' => !empty(trim($data['comment'] ?? '')) ? trim($data['comment']) : null
        ];

        $result = $this->db->execute($sql, $params);

        if ($result > 0) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        } else {
            return ['success' => false, 'errors' => ['Ошибка при добавлении задачи. Попробуйте позже.']];
        }
    }

    public function updateTask($id, $data)
    {

        if (!$this->db->isConnected()) {
            return ['success' => false, 'errors' => ['Не удается обновить задачу. Попробуйте позже.']];
        }


        $errors = $this->validateTaskData($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $sql = "UPDATE tasks 
                SET subject = :subject, 
                    type_id = :type_id, 
                    location = :location, 
                    date_time = :date_time, 
                    duration = :duration, 
                    comment = :comment,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

        $params = [
            'id' => intval($id),
            'subject' => trim($data['subject']),
            'type_id' => intval($data['type_id']),
            'location' => !empty(trim($data['location'] ?? '')) ? trim($data['location']) : null,
            'date_time' => $data['date'] . ' ' . $data['time'],
            'duration' => intval($data['duration']),
            'comment' => !empty(trim($data['comment'] ?? '')) ? trim($data['comment']) : null
        ];

        $result = $this->db->execute($sql, $params);

        if ($result > 0) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => ['Ошибка при обновлении задачи. Попробуйте позже.']];
        }
    }

    public function deleteTask($id)
    {

        if (!$this->db->isConnected()) {
            return ['success' => false, 'errors' => ['Не удается удалить задачу. Попробуйте позже.']];
        }

        $sql = "DELETE FROM tasks WHERE id = :id";
        $result = $this->db->execute($sql, ['id' => intval($id)]);

        if ($result > 0) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => ['Ошибка при удалении задачи. Попробуйте позже.']];
        }
    }

    public function completeTask($id)
    {

        if (!$this->db->isConnected()) {
            return ['success' => false, 'errors' => ['Не удается изменить статус задачи. Попробуйте позже.']];
        }

        $sql = "UPDATE tasks SET status_id = 3, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $result = $this->db->execute($sql, ['id' => intval($id)]);

        if ($result > 0) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => ['Ошибка при обновлении статуса. Попробуйте позже.']];
        }
    }

    public function undoTask($id)
    {

        if (!$this->db->isConnected()) {
            return ['success' => false, 'errors' => ['Не удается изменить статус задачи. Попробуйте позже.']];
        }


        $sql = "UPDATE tasks SET status_id = 1, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $result = $this->db->execute($sql, ['id' => intval($id)]);

        if ($result > 0) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => ['Ошибка при восстановлении задачи. Попробуйте позже.']];
        }
    }

    public function getTaskTypes()
    {

        $defaultTypes = [
            ['id' => 1, 'name' => 'Встреча'],
            ['id' => 2, 'name' => 'Задача'],
            ['id' => 3, 'name' => 'Звонок'],
            ['id' => 4, 'name' => 'Событие']
        ];


        if (!$this->db->isConnected()) {
            return $defaultTypes;
        }

        $sql = "SELECT * FROM task_types ORDER BY name";
        return $this->db->safeGet($sql, [], $defaultTypes);
    }

    public function getTaskStatistics()
    {
        if (!$this->db->isConnected()) {
            return [
                'total' => 0,
                'active' => 0,
                'overdue' => 0,
                'completed' => 0
            ];
        }

        $currentDateTime = date('Y-m-d H:i:s');

        $totalSql = "SELECT COUNT(*) as count FROM tasks";
        $activeSql = "SELECT COUNT(*) as count FROM tasks WHERE status_id = 1 AND date_time >= :current_time";
        $overdueSql = "SELECT COUNT(*) as count FROM tasks WHERE status_id = 1 AND date_time < :current_time";
        $completedSql = "SELECT COUNT(*) as count FROM tasks WHERE status_id = 3";

        $total = $this->db->fetch($totalSql);
        $active = $this->db->fetch($activeSql, ['current_time' => $currentDateTime]);
        $overdue = $this->db->fetch($overdueSql, ['current_time' => $currentDateTime]);
        $completed = $this->db->fetch($completedSql);

        return [
            'total' => $total['count'] ?? 0,
            'active' => $active['count'] ?? 0,
            'overdue' => $overdue['count'] ?? 0,
            'completed' => $completed['count'] ?? 0
        ];
    }

    public function getRecentTasks($limit = 5)
    {
        if (!$this->db->isConnected()) {
            return [];
        }

        $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                FROM tasks t 
                JOIN task_types tt ON t.type_id = tt.id 
                JOIN task_statuses ts ON t.status_id = ts.id 
                WHERE t.status_id IN (1, 3)
                ORDER BY t.updated_at DESC, t.created_at DESC
                LIMIT :limit";

        return $this->db->safeGet($sql, ['limit' => intval($limit)], []);
    }

    public function getUpcomingTasks($limit = 5)
    {
        if (!$this->db->isConnected()) {
            return [];
        }

        $currentDateTime = date('Y-m-d H:i:s');

        $sql = "SELECT t.*, tt.name as type_name, ts.name as status_name 
                FROM tasks t 
                JOIN task_types tt ON t.type_id = tt.id 
                JOIN task_statuses ts ON t.status_id = ts.id 
                WHERE t.status_id = 1 AND t.date_time >= :current_time
                ORDER BY t.date_time ASC
                LIMIT :limit";

        return $this->db->safeGet($sql, [
            'current_time' => $currentDateTime,
            'limit' => intval($limit)
        ], []);
    }

    private function validateTaskData($data)
    {
        $errors = [];


        if (empty(trim($data['subject'] ?? ''))) {
            $errors[] = "Тема обязательна для заполнения";
        } elseif (strlen(trim($data['subject'])) > 255) {
            $errors[] = "Тема не должна превышать 255 символов";
        }


        if (empty($data['type_id']) || !is_numeric($data['type_id'])) {
            $errors[] = "Необходимо выбрать тип задачи";
        }


        if (empty($data['date'])) {
            $errors[] = "Дата обязательна для заполнения";
        } elseif (!$this->isValidDate($data['date'])) {
            $errors[] = "Неверный формат даты";
        }


        if (empty($data['time'])) {
            $errors[] = "Время обязательно для заполнения";
        } elseif (!$this->isValidTime($data['time'])) {
            $errors[] = "Неверный формат времени";
        }


        if (empty($data['duration']) || !is_numeric($data['duration']) || intval($data['duration']) <= 0) {
            $errors[] = "Необходимо указать корректную длительность";
        }


        if (!empty($data['comment']) && strlen(trim($data['comment'])) > 1000) {
            $errors[] = "Комментарий не должен превышать 1000 символов";
        }


        if (!empty($data['location']) && strlen(trim($data['location'])) > 255) {
            $errors[] = "Место не должно превышать 255 символов";
        }


        if (!empty($data['date']) && !empty($data['time']) && $this->isValidDate($data['date']) && $this->isValidTime($data['time'])) {
            $taskDateTime = $data['date'] . ' ' . $data['time'];
            if (strtotime($taskDateTime) < time()) {


            }
        }

        return $errors;
    }

    private function isValidDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    private function isValidTime($time)
    {
        $t = DateTime::createFromFormat('H:i', $time);
        return $t && $t->format('H:i') === $time;
    }
}
?>