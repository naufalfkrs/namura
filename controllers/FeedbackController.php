<?php
class FeedbackController extends Controller {
    protected $feedbackModel;

    public function __construct() {
        $this->init();
        $this->paginate('feedback');
        $this->feedbackModel = $this->loadModel("feedback");
    }

    public function index() {
        $this->check();
        $title = 'Feedback User';

        $result = $this->feedbackModel->getAll();

        $this->loadView(
            "feedback/index", [
                'title' => $title,
                'results' => $result,
            ],
            'main',
            'feedback'
        );
    }

    public function createFeedback() {
        $this->check();
        $result = $this->feedbackModel->getEvent();

        $this->loadView(
            "feedback/feedback_create", [
                'title' => 'Add Feedback',
                'events' => $result,
            ],
            'main'
        );
    }

    public function insertFeedback() {
        $this->check();
        $title = 'Add Feedback';
        $user_id = $_SESSION['user']['id'] ?? '';
        $event_id = $_POST['event_id'] ?? '';
        $rating = $_POST['rating'] ?? '';
        $comment = $_POST['comment'] ?? '';

        $result =  $this->feedbackModel->createFeedback($user_id, $event_id, $rating, $comment);

        if ($result["isSuccess"]) {
            header("Location:?c=feedback&m=index");
        } else {
            $results = $this->feedbackModel->getEvent();

            $this->loadView(
                "feedback/feedback_create", [
                    'title' => $title,
                    'error' => $result['info'],
                    'events' => $results,
                ],
                'main',
                'feedback'
            );
        }
    }

    public function editFeedback() {
        $this->check();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location:?c=feedback&m=index");
            exit;
        }

        $result = $this->feedbackModel->getById($id);

        if (!$result) {
            header("Location:?c=feedback&m=index");
            exit;
        }

        $results = $this->feedbackModel->getEvent();

        $this->loadView(
            "feedback/feedback_edit", [
                'title' => 'Edit Feedback',
                'results' => $result,
                'events' => $results,
            ],
            'main'
        );
    }

    public function updateFeedback() {
        $this->check();
        $title = 'Edit Feedback';

        $id = $_POST['id'] ?? null;
        $user_id = $_SESSION['user']['id'] ?? '';
        $event_id = $_POST['event_id'] ?? '';
        $rating = $_POST['rating'] ?? '';
        $comment = $_POST['comment'] ?? '';

        if (!$id) {
            header("Location:?c=feedback&m=index");
            exit;
        }

        $result = $this->feedbackModel->updateFeedback($id, $user_id, $event_id, $rating, $comment);

        if ($result["isSuccess"]) {
            header("Location:?c=feedback&m=index");
        } else {
            $results = $this->feedbackModel->getById($id);
            $events = $this->feedbackModel->getEvent();

            $this->loadView(
                "feedback/feedback_edit", [
                    'title' => $title,
                    'error' => $result['info'],
                    'results' => $results,
                    'events' => $events,
                ],
                'main'
            );
        }
    }

    public function deleteFeedback() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location:?c=feedback&m=index");
            exit;
        }

        $result = $this->feedbackModel->deleteFeedback($id);

        if ($result["isSuccess"]) {
            header("Location:?c=feedback&m=index");
        } else {
            $this->loadView(
                "feedback/index", [
                    'title' => 'Feedback User',
                    'error' => $result['info'],
                ],
                'main',
                'feedback'
            );
        }
    }
}
