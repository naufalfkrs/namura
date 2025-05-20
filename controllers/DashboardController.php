<?php
class DashboardController extends Controller {
  public function __construct() {
    session_start();
    if (!isset($_SESSION['user'])) {
      header("Location:?c=auth&m=login");
      exit();
    }
  }
  
  public function index() { 
    $title = 'Dashboard';

    $this->loadView(
      "dashboard/index",
      [
        'title' => $title,
        'username' => $_SESSION['user']
      ],
      'main'
    );
  }
}