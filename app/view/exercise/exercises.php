<?php

$id = $_GET['id'] ?? null;
$editing = false;
$exercise = [
  'name' => '',
  'exercise_type' => '',
  'description' => '',
  'muscle_group_id' => '',
  'difficulty' => 'beginner'
];

if ($id) {
  $connection = Connection::getInstance()->getConnection(); // Temporário para edição
  $stmt = $connection->prepare("SELECT * FROM exercises WHERE id = :id");
  $stmt->execute([':id' => $id]);
  $exerciseData = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($exerciseData) {
    $exercise = $exerciseData;
    $editing = true;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Exercícios - PhPeso</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
</head>

<body>
  <?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
  <?php include_once __DIR__ . '/../templates/navbar.php'; ?>

  <main class="container mt-5">
    <h2 class="mb-4">
      <?= $editing ? 'Editando exercício "' . htmlspecialchars($exercise['name']) . '"' : "Cadastrar Exercício" ?>
    </h2>

    <form id="exerciseForm" class="register-form" action=<?= $editing ? "/phpeso/index.php?controller=exercise&action=update&id=$id" : "/phpeso/index.php?controller=exercise&action=insert" ?> method="POST">

      <div class="mb-3">
        <label for="exercise_name" class="form-label">Nome do Exercício:</label>
        <input type="text" class="form-control" id="exercise_name" name="exercise_name"
          value="<?= htmlspecialchars($exercise['name']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="exercise_type" class="form-label">Tipo de Exercício:</label>
        <input type="text" class="form-control" id="exercise_type" name="exercise_type"
          value="<?= htmlspecialchars($exercise['exercise_type']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Descrição:</label>
        <input type="text" class="form-control" id="description" name="description"
          value="<?= htmlspecialchars($exercise['description']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="muscle_group" class="form-label">Grupo Muscular:</label>
        <select name="muscle_group" id="muscle_group" class="form-control" required>
          <option value="">Selecione um grupo muscular</option>
          <?php foreach ($muscleGroups as $group): ?>
            <option value="<?= $group['id'] ?>" <?= $group['id'] == $exercise['muscle_group_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($group['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="difficulty" class="form-label">Dificuldade</label>
        <select class="form-select" id="difficulty" name="difficulty">
          <option value="beginner" <?= $exercise['difficulty'] == 'beginner' ? 'selected' : '' ?>>Iniciante</option>
          <option value="intermediate" <?= $exercise['difficulty'] == 'intermediate' ? 'selected' : '' ?>>Intermediário
          </option>
          <option value="advanced" <?= $exercise['difficulty'] == 'advanced' ? 'selected' : '' ?>>Avançado</option>
        </select>
      </div>

      <button type="submit" class="exercise-btn btn btn-dark"><?= $editing ? 'Salvar' : 'Cadastrar' ?></button>
    </form>

    <hr class="my-5" />

    <h3>Exercícios Cadastrados</h3>

    <table class="table table-hover mt-3">
      <thead class="table-dark">
        <tr>
          <th>Nome</th>
          <th>Tipo</th>
          <th>Grupo Muscular</th>
          <th>Dificuldade</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($exercises) {
          foreach ($exercises as $exercise_item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($exercise_item['name']) . "</td>";
            echo "<td>" . htmlspecialchars($exercise_item['exercise_type']) . "</td>";

            // Acha o nome do grupo muscular correspondente
            $muscleGroupName = 'Não encontrado';
            foreach ($muscleGroups as $group) {
              if ($group['id'] == $exercise_item['muscle_group_id']) {
                $muscleGroupName = $group['name'];
                break;
              }
            }
            echo "<td>" . htmlspecialchars($muscleGroupName) . "</td>";

            if ($exercise_item['difficulty'] == "beginner") {
              $difficultyText = "Iniciante";
            } elseif ($exercise_item['difficulty'] == "intermediate") {
              $difficultyText = "Intermediário";
            } else {
              $difficultyText = "Avançado";
            }
            echo "<td>" . htmlspecialchars($difficultyText) . "</td>";
            echo "<td>" . htmlspecialchars($exercise_item['description']) . "</td>";
            echo "<td><a href='/phpeso/index.php?controller=exercise&action=list&id=" . $exercise_item['id'] . "'>Editar</a> | <a href='/phpeso/index.php?controller=exercise&action=delete&method=delete&id=" . $exercise_item['id'] . "'>Excluir</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='6'>Nenhum exercício cadastrado</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </main>

  <?php include_once __DIR__ . '/../templates/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../public/js/exercise-validator.js"></script>

</body>

</html>