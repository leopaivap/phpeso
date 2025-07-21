<?php

session_start();
define('BASE_URL', '/');

if (isset($_GET['controller']) && isset($_GET['action'])) {
  $controllerName = $_GET['controller'];
  $action = $_GET['action'];

  $controllerFile = './app/controller/' . $controllerName . '/' . ucfirst($controllerName) . 'Controller.php';

  // Verifica se o arquivo do controller existe antes de incluí-lo
  if (file_exists($controllerFile)) {
    require_once $controllerFile;
  } else {
    http_response_code(404);
    echo "Controlador '$controllerName' não encontrado.";
    exit;
  }

  $controllerClass = ucfirst($controllerName) . 'Controller';

  if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    if (method_exists($controller, $action)) {
      $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
      $method = $_SERVER['REQUEST_METHOD'];
      $data = $_POST ?? [];

      // Ações que não precisam de login ou parâmetros
      $publicActions = ['showLogin', 'showRegister', 'login', 'insert', 'logout'];
      if (in_array($action, $publicActions)) {
        // Para login e insert, passamos os dados do POST
        if ($action === 'login' || $action === 'insert') {
          $controller->$action($data);
        } else {
          $controller->$action();
        }
      } else {
        // Ações que precisam de login (BaseController cuida da verificação)
        if ($id !== null) {
          // Ações com ID
          if ($action === 'updateRole') {
            $controller->updateRole($id, $data);
          } elseif ($action === 'deleteUser') {
            $controller->deleteUser($id);
          } else {
            // Ações genéricas de update/delete de outros controllers
            $controller->$action($id, $data);
          }
        } else {
          // Ações sem ID (como 'list')
          $controller->$action();
        }
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