<?php
class FeedbackController extends Controller
{
    protected $username;
    protected $role;
    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location:?c=dashboard&m=index");
            exit();
        }
    }

    public function index()
    {
        $title = 'Feedback User';

        $model = $this->loadModel("feedback");
        $result = $model->getAll();
        // die(var_dump($result));


        $this->loadView(
            "feedback/index",
            [
                'title' => $title,
                'results' => $result,
                'username' => $_SESSION['user']['name'],
                'role' => $_SESSION['user']['role'],
            ],
            'main'
        );
    }

    public function createFeedback()
    {
        $eventModel = $this->loadModel("feedback");  // nanti diganti ya nawa
        $result = $eventModel->getEvent();
        // die(var_dump($result));

        $this->loadView(
            "feedback/feedback_create",
            [
                'title' => 'Add Feedback',
                'username' => $_SESSION['user']['name'],
                'role' => $_SESSION['user']['role'],
                'events' => $result,
            ],
            'main'
        );
    }

    public function insertFeedback()
    {
        $title = 'Add Feedback';
        $user_id = $_SESSION['user']['id'] ?? '';
        $event_id = $_POST['event_id'] ?? '';
        $rating = $_POST['rating'] ?? '';
        $comment = $_POST['comment'] ?? '';

        $model = $this->loadModel("feedback");
        $result = $model->createFeedback($user_id, $event_id, $rating, $comment);

        if ($result["isSuccess"]) {
            header("Location:?c=feedback&m=index");
        } else {
            $eventModel = $this->loadModel("feedback");  // nanti diganti ya nawa
            $results = $eventModel->getEvent();

            $this->loadView(
                "feedback/feedback_create",
                [
                    'title' => $title,
                    'error' => $result['info'],
                    'events' => $results,
                    'username' => $_SESSION['user']['name'],
                    'role' => $_SESSION['user']['role'],
                ],
                'main'
            );
        }
    }

    public function editFeedback()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location:?c=feedback&m=index");
            exit;
        }

        $model = $this->loadModel("feedback");
        $result = $model->getById($id);

        if (!$result) {
            header("Location:?c=feedback&m=index");
            exit;
        }

        $eventModel = $this->loadModel("feedback");  // nanti diganti ya nawa
        $results = $eventModel->getEvent();

        $this->loadView(
            "feedback/feedback_edit",
            [
                'title' => 'Edit Feedback',
                'results' => $result,
                'events' => $results,
                'username' => $_SESSION['user']['name'],
                'role' => $_SESSION['user']['role'],
            ],
            'main'
        );
    }

    public function updateFeedback()
    {
        $title = 'Edit Feedback';

        $id = $_POST['id'] ?? null;
        $user_id = $_SESSION['user']['id'] ?? '';
        $event_id = $_POST['event_id'] ?? '';
        $rating = $_POST['rating'] ?? '';
        $comment = $_POST['comment'] ?? '';
        // die(var_dump($id));

        if (!$id) {
            header("Location:?c=feedback&m=index");
            exit;
        }

        $model = $this->loadModel("feedback");
        $result = $model->updateFeedback($id, $user_id, $event_id, $rating, $comment);

        if ($result["isSuccess"]) {
            header("Location:?c=feedback&m=index");
        } else {
            $model = $this->loadModel("feedback");
            $results = $model->getById($id);
            // die(var_dump($results));
            $events = $model->getEvent();

            $this->loadView(
                "feedback/feedback_edit",
                [
                    'title' => $title,
                    'error' => $result['info'],
                    'results' => $results,
                    'events' => $events,
                    'username' => $_SESSION['user']['name'],
                    'role' => $_SESSION['user']['role'],
                ],
                'main'
            );
        }
    }

    public function deleteFeedback()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location:?c=feedback&m=index");
            exit;
        }

        $model = $this->loadModel("feedback");
        $result = $model->deleteFeedback($id);

        if ($result["isSuccess"]) {
            header("Location:?c=feedback&m=index");
        } else {
            $this->loadView(
                "feedback/index",
                [
                    'title' => 'Feedback User',
                    'error' => $result['info'],
                    'username' => $_SESSION['user']['name'],
                    'role' => $_SESSION['user']['role'],
                ],
                'main'
            );
        }
    }
}
