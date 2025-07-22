<?php

session_start();
define('BASE_URL', '/');

if (isset($_GET['controller']) && isset($_GET['action'])) {
  $controllerName = $_GET['controller'];
  $action = $_GET['action'];
  $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

  $controllerFile = './app/controller/' . $controllerName . '/' . ucfirst($controllerName) . 'Controller.php';

  if (!file_exists($controllerFile)) {
    http_response_code(404);
    die("Erro Crítico: Controlador '$controllerName' não encontrado.");
  }
  require_once $controllerFile;

  $controllerClass = ucfirst($controllerName) . 'Controller';
  if (!class_exists($controllerClass) || !method_exists($controllerClass, $action)) {
    http_response_code(404);
    die("Erro Crítico: Ação '$action' ou Controlador '$controllerClass' não encontrado.");
  }

  $controller = new $controllerClass();
  $data = $_POST ?? [];

  // Roteamento que lida corretamente com ou sem ID
  $actions_with_id = ['update', 'delete', 'getDetails', 'updateRole', 'deleteUser'];

  if (in_array($action, $actions_with_id)) {
    if ($id === null) {
      die("Erro: Ação '$action' requer um ID.");
    }
    $controller->$action($id, $data);
  } else {
    // Ações como 'list', 'insert', 'login' que não usam ID na chamada do método
    $controller->$action($data);
  }
  exit;
}

require_once './app/view/home.php';