<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Exercícios - FitCrud</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div id="navbar"></div>

  <main class="container mt-5">
    <h2 class="mb-4">Cadastrar Exercício</h2>
    <form class="row g-3" action="./database/exercise/insert-exercise.php" method="POST">
      <div class="col-md-6">
        <label for="exercise_name" class="form-label">Nome do Exercício:</label>
        <input type="text" class="form-control" id="exercise_name" name="exercise_name" required>
      </div>
      <div class="col-md-6">
        <label for="exercise_type" class="form-label">Tipo de Exercício:</label>
        <input type="text" class="form-control" id="exercise_type" name="exercise_type" required>
      </div>
      <div class="col-md-6">
        <label for="description" class="form-label">Descrição:</label>
        <input type="text" class="form-control" id="description" name="description" required>
      </div>
      <div class="col-md-6">
        <label for="muscle_group" class="form-label">Grupo Muscular:</label>
        <select name="muscle_group" id="muscle_group" class="form-control" required>
          <option value="">Selecione um grupo muscular</option>
          <option value="1">Peito</option>
          <option value="3">Costas</option>
          <option value="4">Bíceps</option>
          <option value="5">Tríceps</option>
          <option value="6">Ombros</option>
          <option value="7">Abdômen</option>
          <option value="8">Quadríceps</option>
          <option value="9">Posterior de coxa</option>
          <option value="10">Panturrilhas</option>
          <option value="11">Glúteos</option>
        </select>
      </div>

      <div class="col-md-6">
        <label for="difficulty" class="form-label">Dificuldade</label>
        <select class="form-select" id="difficulty" name="difficulty">
          <option value="beginner">Iniciante</option>
          <option value="intermediate">Intermediário</option>
          <option value="advanced">Avançado</option>
        </select>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-dark">Cadastrar</button>
      </div>
    </form>

    <hr class="my-5" />

    <?php

    ob_start();

    include_once "./database/connection.php";


    ob_end_clean();


    $query = "SELECT * FROM exercises";
    $stmt = $connection->prepare($query);
    $stmt->execute();

    $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>

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
        // Verifica se existem exercícios cadastrados
        if ($exercises) {
          foreach ($exercises as $exercise) {
            // Para cada exercício, exibe os dados
            echo "<tr>";
            echo "<td>" . htmlspecialchars($exercise['name']) . "</td>";
            echo "<td>" . htmlspecialchars($exercise['exercise_type']) . "</td>";

            // Carrega o nome do grupo muscular
            $muscleGroupQuery = "SELECT name FROM muscle_groups WHERE id = :muscle_group_id";
            $muscleStmt = $connection->prepare($muscleGroupQuery);
            $muscleStmt->execute([':muscle_group_id' => $exercise['muscle_group_id']]);
            $muscleGroup = $muscleStmt->fetch(PDO::FETCH_ASSOC);
            echo "<td>" . htmlspecialchars($muscleGroup['name']) . "</td>";
            if ($exercise['difficulty'] == "beginner") {
              $difficultyText = "Iniciante";
            } elseif ($exercise['difficulty'] == "intermediate") {
              $difficultyText = "Intermediário";
            } else {
              $difficultyText = "Avançado";
            }
            echo "<td>" . htmlspecialchars($difficultyText) . "</td>";
            echo "<td>" . htmlspecialchars($exercise['description']) . "</td>";
            echo "<td><a href='edit-exercise.php?id=" . $exercise['id'] . "'>Editar</a> | <a href='delete-exercise.php?id=" . $exercise['id'] . "'>Excluir</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='6'>Nenhum exercício cadastrado</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </main>

  <div id="footer"></div>
  <script src="js/navbar.js"></script>
  <script src="js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>