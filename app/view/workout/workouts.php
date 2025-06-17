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
  <?php include_once __DIR__ . '/../templates/navbar.php'; ?>

  <main class="container mt-5">
    <h2 class="mb-4">
      <?= $editing ? 'Editando treino "' . htmlspecialchars($workout_form_data['name']) . '"' : "Cadastrar Treino" ?>
    </h2>

    <form id="workoutForm" class="register-form"
      action="<?= $editing ? "/phpeso/index.php?controller=workout&action=update&id=" . $workout_form_data['id'] : "/phpeso/index.php?controller=workout&action=insert" ?>"
      method="POST">

      <div class="mb-3">
        <label for="name" class="form-label">Nome do Treino:</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Treino de Peito"
          value="<?= htmlspecialchars($workout_form_data['name']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="student_id" class="form-label">Aluno</label>
        <select name="student_id" id="student_id" class="form-control" required>
          <option value="">Selecione um Aluno</option>
          <?php if (!empty($students))
            foreach ($students as $student): ?>
              <option value="<?= $student['id'] ?>" <?= $student['id'] == $workout_form_data['student_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($student['firstName'] . " " . $student['lastName']) ?>
              </option>
            <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Descrição do Treino:</label>
        <input type="text" class="form-control" id="description" name="description"
          placeholder="Ex: Foco em hipertrofia" value="<?= htmlspecialchars($workout_form_data['description']) ?>"
          required>
      </div>

      <div class="mb-3">
        <label for="trainer_id" class="form-label">Treinador</label>
        <select name="trainer_id" id="trainer_id" class="form-control" required>
          <option value="">Selecione um Treinador</option>
          <?php if (!empty($trainerList))
            foreach ($trainerList as $trainer): ?>
              <option value="<?= $trainer['id'] ?>" <?= $trainer['id'] == $workout_form_data['trainer_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($trainer['firstName'] . " " . $trainer['lastName']) ?>
              </option>
            <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="workout-btn btn btn-dark w-50"><?= $editing ? 'Salvar' : 'Cadastrar' ?></button>
    </form>

    <hr class="my-5" />

    <h3>Treinos Cadastrados</h3>
    <table class="table table-hover mt-3">
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
        if (!empty($workouts)) {
          foreach ($workouts as $workout_item) {
            $studentName = "Não encontrado";
            if (!empty($students)) {
              foreach ($students as $student) {
                if ($student['id'] == $workout_item['student_id']) {
                  $studentName = $student['firstName'] . ' ' . $student['lastName'];
                  break;
                }
              }
            }

            $trainerName = "Não encontrado";
            if (!empty($trainerList)) {
              foreach ($trainerList as $trainer) {
                if ($trainer['id'] == $workout_item['trainer_id']) {
                  $trainerName = $trainer['firstName'] . ' ' . $trainer['lastName'];
                  break;
                }
              }
            }

            echo "<tr>";
            echo "<td>" . htmlspecialchars($workout_item['name']) . "</td>";
            echo "<td>" . htmlspecialchars($studentName) . "</td>";
            echo "<td>" . htmlspecialchars($trainerName) . "</td>";
            echo "<td>" . htmlspecialchars($workout_item['description']) . "</td>";
            echo "<td><a href='/phpeso/index.php?controller=workout&action=list&id=" . $workout_item['id'] . "'>Editar</a> | <a href='/phpeso/index.php?controller=workout&action=delete&method=delete&id=" . $workout_item['id'] . "'>Excluir</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5'>Nenhum treino cadastrado</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </main>

  <?php include_once __DIR__ . '/../templates/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>