<?php $user_role = $_SESSION['user_role'] ?? 'client'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Exercícios - PhPeso</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/css/style.css">
</head>

<body>
  <?php include_once __DIR__ . '/../templates/navbar.php'; ?>
  <main class="container mt-5">
    <?php if (isset($_SESSION['success_message'])) {
      echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
      unset($_SESSION['success_message']);
    } ?>
    <?php if (isset($_SESSION['error_message'])) {
      echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
      unset($_SESSION['error_message']);
    } ?>

    <h2 class="mb-4"><?= $editing ? 'Editando Exercício' : "Cadastrar Exercício" ?></h2>

    <form class="register-form"
      action="<?= $editing ? BASE_URL . "index.php?controller=exercise&action=update&id=" . $exercise_form_data['id'] : BASE_URL . "index.php?controller=exercise&action=insert" ?>"
      method="POST">
      <div class="mb-3"><label class="form-label">Nome:</label><input type="text" class="form-control"
          name="exercise_name" value="<?= htmlspecialchars($exercise_form_data['name'] ?? '') ?>" required></div>
      <div class="mb-3"><label class="form-label">Tipo:</label><input type="text" class="form-control"
          name="exercise_type" value="<?= htmlspecialchars($exercise_form_data['exercise_type'] ?? '') ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">Grupo Muscular:</label><select name="muscle_group"
          class="form-control" required>
          <option value="">Selecione...</option><?php foreach ($muscleGroups as $group): ?>
            <option value="<?= $group['id'] ?>" <?= ($group['id'] ?? '') == ($exercise_form_data['muscle_group_id'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($group['name']) ?></option><?php endforeach; ?>
        </select></div>
      <div class="mb-3"><label class="form-label">Dificuldade</label><select class="form-select" name="difficulty">
          <option value="beginner" <?= ($exercise_form_data['difficulty'] ?? '') == 'beginner' ? 'selected' : '' ?>>
            Iniciante</option>
          <option value="intermediate" <?= ($exercise_form_data['difficulty'] ?? '') == 'intermediate' ? 'selected' : '' ?>>Intermediário</option>
          <option value="advanced" <?= ($exercise_form_data['difficulty'] ?? '') == 'advanced' ? 'selected' : '' ?>>
            Avançado</option>
        </select></div>
      <div class="mb-3" style="grid-column: 1 / -1;"><label class="form-label">Descrição:</label><textarea
          class="form-control" name="description"
          required><?= htmlspecialchars($exercise_form_data['description'] ?? '') ?></textarea></div>
      <div class="d-flex gap-2" style="grid-column: 1 / -1;">
        <button type="submit"
          class="btn btn-dark w-100"><?= $editing ? 'Salvar Alterações' : 'Cadastrar Exercício' ?></button>
        <?php if ($editing): ?><a href="<?= BASE_URL ?>index.php?controller=exercise&action=list"
            class="btn btn-secondary w-100">Cancelar</a><?php endif; ?>
      </div>
    </form>
    <hr class="my-5" />

    <h3>Exercícios Cadastrados</h3>
    <table class="table table-hover mt-3">
      <thead class="table-dark">
        <tr>
          <th>Nome</th>
          <th>Grupo Muscular</th><?php if ($user_role === 'admin'): ?>
            <th>Criado por</th><?php endif; ?>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($exercises)):
          foreach ($exercises as $ex): ?>
            <tr>
              <td><?= htmlspecialchars($ex['name']) ?></td>
              <td>
                <?= htmlspecialchars(array_values(array_filter($muscleGroups, fn($g) => $g['id'] == $ex['muscle_group_id']))[0]['name'] ?? 'N/A') ?>
              </td>
              <?php if ($user_role === 'admin'): ?>
                <td><?= htmlspecialchars($ex['trainerFirstName'] ?? 'Admin') ?></td><?php endif; ?>
              <td>
                <a href="<?= BASE_URL ?>index.php?controller=exercise&action=list&id=<?= $ex['id'] ?>"
                  class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                <a href="<?= BASE_URL ?>index.php?controller=exercise&action=delete&id=<?= $ex['id'] ?>"
                  class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?');"><i
                    class="fas fa-trash-alt"></i></a>
              </td>
            </tr>
          <?php endforeach; else: ?>
          <tr>
            <td colspan="<?= $user_role === 'admin' ? '4' : '3' ?>" class="text-center">Nenhum exercício cadastrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>
  <?php include_once __DIR__ . '/../templates/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>