<?php
require_once '../../repository/Connection.php';
require_once '../../controller/workout/WorkoutController.php';
require_once '../../controller/user/UserController.php';

$connection = Connection::getInstance()->getConnection();

$id = $_GET['id'] ?? null;
$editing = false;

$workout = [
  'name' => '',
  'description' => '',
  'student_id' => '',
  'trainer_id' => '',
];

$workoutController = new WorkoutController();
$userController = new UserController();
$getMethod = "GET";

if ($id) {
  $workoutData = $workoutController->findById($id, $getMethod);
  if ($workoutData && $workoutData != null) {
    $workout = $workoutData;
    $editing = true;
  }
}

$students = $userController->selectAllByRole("client", $getMethod);
$trainerList = $userController->selectAllByRole("trainer", $getMethod);
$workouts = $workoutController->selectAll($getMethod);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Treinos - PhPeso</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../public/css/style.css">
</head>

<body>
  <div id="navbar"></div>

  <main class="container mt-5">
    <h2 class="mb-4">
      <?= $editing ? 'Editando treino "' . htmlspecialchars($workout['name']) . '"' : "Cadastrar Treino" ?>
    </h2>

    <?php
    session_start();
    if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])) {
      echo '<div class="alert alert-danger" role="alert"><ul>';
      foreach ($_SESSION['errors'] as $error) {
        echo '<li>' . htmlspecialchars($error) . '</li>';
      }
      echo '</ul></div>';
      unset($_SESSION['errors']);
    }
    ?>

    <form id="workoutForm" class="register-form" action=<?= $editing ? "/phpeso/index.php?controller=workout&action=update&id=$id" : "/phpeso/index.php?controller=workout&action=insert" ?> method="POST">

      <div class="mb-3">
        <label for="name" class="form-label">Nome do Treino:</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Treino de Peito"
          value="<?= htmlspecialchars($workout['name']) ?>"
          required>
      </div>

      <div class="mb-3">
        <label for="student_id" class="form-label">Aluno</label>
        <select name="student_id" id="student_id" name="student_id" class="form-control" required>
          <option value="">Selecione um Aluno</option>
          <?php foreach ($students as $student): ?>
            <option value="<?= $student['id'] ?>" <?= $student['id'] === $workout['student_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($student['firstName'] . " " . $student['lastName']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Descrição do Treino:</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Ex: Treino de Peito"
          value="<?= htmlspecialchars($workout['description']) ?>"
          required>
      </div>

      <div class="mb-3">
        <label for="trainer_id" class="form-label">Treinador</label>
        <select name="trainer_id" id="trainer_id" name="trainer_id" class="form-control" required>
          <option value="">Selecione um Treinador</option>
          <?php foreach ($trainerList as $trainer): ?>
            <option value="<?= $trainer['id'] ?>" <?= $trainer['id'] == $workout['trainer_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($trainer['firstName'] . " " . $trainer['lastName']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="workout-btn btn btn-dark w-50"><?= $editing ? 'Salvar' : 'Cadastrar' ?></button>
    </form>

    <hr class="my-5" />

    <h3>Treinos Cadastrados</h3>
    <table class="table mt-3">
      <thead class="table-dark">
        <tr>
          <th>Nome do Treino</th>
          <th>Aluno</th>
          <th>Treinador</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($workouts) && $workout != null) {
          foreach ($workouts as $workout) {
            $currentStudent = $userController->findById($workout['student_id'], $getMethod);
            $currentTrainer = $userController->findById($workout['trainer_id'], $getMethod);
            if ($currentStudent && $currentTrainer) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($workout['name']) . "</td>";
              echo "<td>" . htmlspecialchars($currentStudent->getFirstName() . " " . $currentStudent->getLastName()) . "</td>";
              echo "<td>" . htmlspecialchars($currentTrainer->getFirstName() . " " . $currentTrainer->getLastName()) . "</td>";
              echo "<td>" . htmlspecialchars($workout['description']) . "</td>";
              echo "<td><a href='workouts.php?id=" . $workout['id'] . "'>Editar</a> | <a href='/phpeso/index.php?controller=workout&action=delete&method=delete&id=" . $workout['id'] . "'>Excluir</a></td>";
              echo "</tr>";
            } else {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($workout['name']) . "</td>";
              echo "<td>Erro ao carregar nome do aluno.</td>";
              echo "<td>Erro ao carregar nome do treinador.</td>";
              echo "<td>" . htmlspecialchars($workout['description']) . "</td>";
              echo "<td><a href='workouts.php?id=" . $workout['id'] . "'>Editar</a> | <a href='/phpeso/index.php?controller=workout&action=delete&method=delete&id=" . $workout['id'] . "'>Excluir</a></td>";
              echo "</tr>";
            }
          }
        } else {
          echo "<tr><td colspan='6'>Nenhum treino cadastrado</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </main>

  <div id="footer"></div>
  <script src="../../../public/js/navbar.js"></script>
  <script src="../../../public/js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>