<?php

session_start();
define('BASE_URL', '/phpeso');

if (isset($_GET['controller']) && isset($_GET['action'])) {
  require_once "./app/controller/user/UserController.php";
  require_once "./app/controller/exercise/ExerciseController.php";
  require_once "./app/controller/workout/WorkoutController.php";

  $controllerName = $_GET['controller'];
  $action = $_GET['action'];


  $controllerClass = ucfirst($controllerName) . 'Controller';

  if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    if (method_exists($controller, $action)) {
      $id = $_GET['id'] ?? null;
      $method = $_GET['method'] ?? $_SERVER['REQUEST_METHOD'];
      $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];


      if (in_array($action, ['list', 'logout', 'showLogin', 'showRegister'])) {
        $controller->$action();
      } else if (in_array($action, ['insert', 'login'])) {
        $controller->$action($data);
      } else if ($id) {

        if ($action === 'delete') {
          $controller->$action($id, $data, $method);
        } else {

          $controller->$action($id, $data);
        }
      } else {
        http_response_code(400);
        echo "Parâmetros inválidos para a ação '$action'.";
      }

    } else {
      http_response_code(404);
      echo "Ação '$action' não encontrada no controlador '$controllerClass'.";
    }
  } else {
    http_response_code(404);
    echo "Controlador '$controllerClass' não encontrado.";
  }
  exit;
}

require_once './app/view/home.php';