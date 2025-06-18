<?php
if (isset($_GET['controller']) && isset($_GET['action'])) {
  require_once "./app/controller/user/UserController.php";
  require_once "./app/controller/exercise/ExerciseController.php";
  require_once "./app/controller/workout/WorkoutController.php";

  $controllerName = $_GET['controller'];
  $action = $_GET['action'];
  $id = $_GET['id'] ?? null;

  // Pegando o método do GET para o delete
  $method = $_GET['method'] ?? $_SERVER['REQUEST_METHOD'];

  // Sanitiza os dados do POST
  $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];
  switch ($controllerName) {
    case 'user':
      $controller = new UserController();
      break;
    case 'exercise':
      $controller = new ExerciseController();
      break;
    case 'workout':
      $controller = new WorkoutController();
      break;
    default:
      http_response_code(404);
      echo "Controlador não encontrado.";
      exit;
  }

  // Chama a ação correspondente no controller
  if (method_exists($controller, $action)) {
    if ($id) {
      $controller->$action($id, $data, $method);
    } else {
      $controller->$action($data);
    }
  } else {
    http_response_code(404);
    echo "Ação '$action' não encontrada.";
  }

  exit;
}

require_once './app/view/home.php';
?>