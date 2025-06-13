<?php
class Controller {
    protected $username;
    protected $role;
    protected $id;
    protected $foto;

    protected $model;
    protected $currentPage;
    protected $totalPages;
    protected $limit = 10;
    protected $offset;

    public function loadModel($modelName) {
        $modelClass = ucfirst($modelName);

        $modelFile = "models/{$modelName}.php";

        if (!file_exists($modelFile)) {
            throw new NotFoundException("Model file {$modelFile} not found.");
        }

        include_once "models/Model.php";
        include_once $modelFile;
        
        if (!class_exists($modelClass)) {
            throw new InternalServerErrorException("Model class {$modelName} not found.");
        }

        return new $modelClass();
    }

    public function loadView($viewName, $data = [], $layout = null, $model = null) {
        if ($model !== null) {
            $this->paginate($model);
            $data['currentPage'] = $this->currentPage;
            $data['totalPages'] = $this->totalPages;
        }

        $data['username'] = $this->username;
        $data['role'] = $this->role;
        $data['foto'] = $this->foto;

        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $viewFile = "views/{$viewName}.php";
        
        if (!file_exists($viewFile)) {
            throw new NotFoundException("View file {$viewFile} not found.");
        }

        if ($layout === null) {
            include_once $viewFile;
            return;
        }

        $layoutPath = "views/layouts/{$layout}.php";
        
        if (!file_exists($layoutPath)) {
            throw new NotFoundException("Layout {$layout} not found.");
        }

        include_once $layoutPath;
    }

    public function init() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }

        $this->username = $_SESSION['user']['name'];
        $this->role = $_SESSION['user']['role'];
        $this->foto = $_SESSION['user']['foto'];
        $this->id = $_SESSION['user']['id'];
    }

    public function check() {
        if ($this->role !== 'admin' && $this->role !== 'superadmin') {
            header("Location:?c=dashboard&m=index");
            exit();
        }
    }

    public function paginate($model) {
        $this->model = $this->loadModel($model);

        $this->currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $this->offset = ($this->currentPage - 1) * $this->limit;

        $totalUsers = $this->model->getTotalUsers();
        $this->totalPages = ceil($totalUsers / $this->limit);

    }

}