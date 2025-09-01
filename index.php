<?php


session_start();

require_once 'config.php';
require_once 'database.php';
require_once 'models/task_model.php';

class TaskController
{
    private $taskModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }

    public function handleRequest()
    {
        $action = $_GET['action'] ?? 'index';
        $id = $_GET['id'] ?? 0;

        switch ($action) {
            case 'add':
                $this->addTask();
                break;
            case 'edit':
                $this->editTask($id);
                break;
            case 'update':
                $this->updateTask($id);
                break;
            case 'delete':
                $this->deleteTask($id);
                break;
            case 'complete':
                $this->completeTask($id);
                break;
            case 'undo':
                $this->undoTask($id);
                break;
            default:
                $this->showTaskList();
        }
    }

    private function addTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'subject' => $_POST['subject'] ?? '',
                'type_id' => $_POST['type_id'] ?? 1,
                'location' => $_POST['location'] ?? '',
                'date' => $_POST['date'] ?? date('Y-m-d'),
                'time' => $_POST['time'] ?? '12:00',
                'duration' => $_POST['duration'] ?? 60,
                'comment' => $_POST['comment'] ?? ''
            ];

            $result = $this->taskModel->addTask($data);

            if ($result['success']) {
                $_SESSION['success'] = "Задача успешно добавлена";
            } else {
                $_SESSION['errors'] = $result['errors'];
            }
        }

        $this->redirectToIndex();
    }

    private function editTask($id)
    {
        $task = $this->taskModel->getTaskById($id);

        if (!$task) {
            $_SESSION['errors'] = ['Задача не найдена'];
            $this->redirectToIndex();
            return;
        }


        $taskTypes = $this->taskModel->getTaskTypes();


        $dateTime = new DateTime($task['date_time']);
        $taskDate = $dateTime->format('Y-m-d');
        $taskTime = $dateTime->format('H:i');


        $pageTitle = 'Редактирование: ' . $task['subject'];


        include 'views/task_edit.php';
    }

    private function updateTask($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->editTask($id);
            return;
        }

        $data = [
            'subject' => $_POST['subject'] ?? '',
            'type_id' => $_POST['type_id'] ?? 1,
            'location' => $_POST['location'] ?? '',
            'date' => $_POST['date'] ?? date('Y-m-d'),
            'time' => $_POST['time'] ?? '12:00',
            'duration' => $_POST['duration'] ?? 60,
            'comment' => $_POST['comment'] ?? ''
        ];

        $result = $this->taskModel->updateTask($id, $data);

        if ($result['success']) {
            $_SESSION['success'] = "Задача успешно обновлена";
            $this->redirectToIndex();
        } else {
            $_SESSION['errors'] = $result['errors'];
            $this->editTask($id);
        }
    }

    private function deleteTask($id)
    {
        $result = $this->taskModel->deleteTask($id);

        if ($result['success']) {
            $_SESSION['success'] = "Задача успешно удалена";
        } else {
            $_SESSION['errors'] = $result['errors'] ?? ["Ошибка при удалении задачи"];
        }

        $this->redirectToIndex();
    }

    private function completeTask($id)
    {
        $result = $this->taskModel->completeTask($id);

        if ($result['success']) {
            $_SESSION['success'] = "Задача отмечена как выполненная";
        } else {
            $_SESSION['errors'] = $result['errors'] ?? ["Ошибка при обновлении статуса задачи"];
        }

        $this->redirectToIndex();
    }

    private function undoTask($id)
    {
        $result = $this->taskModel->undoTask($id);

        if ($result['success']) {
            $_SESSION['success'] = "Задача возвращена в активные";
        } else {
            $_SESSION['errors'] = $result['errors'] ?? ["Ошибка при восстановлении задачи"];
        }

        $this->redirectToIndex();
    }

    private function setDatabaseStatus()
    {
        $db = Database::getInstance();
        $dbConnected = $db->isConnected();

        if ($db->hasError()) {
            $dbError = $db->getErrorMessage();
            $_SESSION['db_error'] = $dbError;
        }

        return $dbConnected;
    }

    private function showTaskList()
    {



        $filter = $_GET['filter'] ?? 'current';
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;
        $date = $_GET['date'] ?? null;


        if ($date) {
            $tasks = $this->taskModel->getTasksByDate($date);
        } elseif ($startDate && $endDate) {
            $tasks = $this->taskModel->getTasksByDateRange($startDate, $endDate, $filter);
        } else {
            $tasks = $this->taskModel->getAllTasks($filter);
        }

        $taskTypes = $this->taskModel->getTaskTypes();
        $dbConnected = $this->setDatabaseStatus();


        $taskCount = count($tasks);
        $hasDateRange = !empty($startDate) && !empty($endDate);
        $currentDate = $date;
        $currentStartDate = $startDate;
        $currentEndDate = $endDate;



        include 'views/task_list.php';
    }

    private function redirectToIndex()
    {

        $params = [];
        if (isset($_GET['filter']))
            $params['filter'] = $_GET['filter'];
        if (isset($_GET['start_date']))
            $params['start_date'] = $_GET['start_date'];
        if (isset($_GET['end_date']))
            $params['end_date'] = $_GET['end_date'];

        $query = !empty($params) ? '?' . http_build_query($params) : '';
        header('Location: index.php' . $query);
        exit;
    }
}

$controller = new TaskController();
$controller->handleRequest();