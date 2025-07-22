<?php $user_role = $_SESSION['user_role'] ?? 'client'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Treinos - PhPeso</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
  <style>
    .checkbox-list {
      max-height: 150px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
    }

    .exercise-detail {
      margin-bottom: 0.25rem;
      font-size: 0.9rem;
    }

    .exercise-detail strong {
      display: inline-block;
      width: 140px;
      color: #555;
    }
  </style>
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

    <?php if (in_array($user_role, ['admin', 'trainer'])): ?>
      <h2 class="mb-4"><?= $editing ? 'Editando Treino' : "Cadastrar Treino" ?></h2>
      <form class="register-form"
        action="<?= $editing ? BASE_URL . "index.php?controller=workout&action=update&id=" . ($workout_form_data['id'] ?? '') : BASE_URL . "index.php?controller=workout&action=insert" ?>"
        method="POST">
        <div class="mb-3"><label class="form-label">Nome:</label><input type="text" class="form-control" name="name"
            value="<?= htmlspecialchars($workout_form_data['name'] ?? '') ?>" required></div>
        <div class="mb-3"><label class="form-label">Descrição:</label><input type="text" class="form-control"
            name="description" value="<?= htmlspecialchars($workout_form_data['description'] ?? '') ?>" required></div>
        <div class="mb-3"><label class="form-label">Atribuir aos Alunos:</label>
          <div class="checkbox-list"><?php if (!empty($clients)):
            foreach ($clients as $client): ?>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="client_ids[]"
                    value="<?= $client['id'] ?>" id="client_<?= $client['id'] ?>" <?= in_array($client['id'], $workout_form_data['client_ids'] ?? []) ? 'checked' : '' ?>><label class="form-check-label"
                    for="client_<?= $client['id'] ?>"><?= htmlspecialchars($client['firstName'] . ' ' . $client['lastName']) ?></label>
                </div><?php endforeach; else: ?>
              <p class="text-muted small m-0">Nenhum aluno cadastrado.</p><?php endif; ?>
          </div>
        </div>
        <div class="mb-3"><label class="form-label">Incluir Exercícios:</label>
          <div class="checkbox-list">
            <?php if (!empty($available_exercises)):
              foreach ($available_exercises as $exercise): ?>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="exercise_ids[]"
                    value="<?= $exercise['id'] ?>" id="ex_<?= $exercise['id'] ?>" <?= in_array($exercise['id'], $workout_form_data['exercise_ids'] ?? []) ? 'checked' : '' ?>><label class="form-check-label"
                    for="ex_<?= $exercise['id'] ?>"><?= htmlspecialchars($exercise['name']) ?></label></div>
              <?php endforeach; else: ?>
              <p class="text-muted small m-0">Nenhum exercício cadastrado.</p><?php endif; ?>
          </div>
        </div>
        <div class="d-flex gap-2" style="grid-column: 1 / -1;">
          <button type="submit"
            class="btn btn-dark w-100"><?= $editing ? 'Salvar Alterações' : 'Cadastrar Treino' ?></button>
          <?php if ($editing): ?><a href="<?= BASE_URL ?>index.php?controller=workout&action=list"
              class="btn btn-secondary w-100">Cancelar</a><?php endif; ?>
        </div>
      </form>
      <hr class="my-5" />
    <?php endif; ?>

    <h3><?= $user_role === 'client' ? 'Meus Treinos' : 'Treinos Cadastrados' ?></h3>
    <table class="table table-hover mt-3 align-middle">
      <thead class="table-dark">
        <tr>
          <th>Nome</th>
          <th>Treinador</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($workouts)):
          foreach ($workouts as $workout): ?>
            <tr>
              <td><?= htmlspecialchars($workout['name']) ?></td>
              <td><?= htmlspecialchars($workout['trainerFirstName'] ?? 'Admin') ?></td>
              <td>
                <?php if ($user_role === 'client'): ?>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#workoutModal"
                    data-workout-id="<?= $workout['id'] ?>" data-workout-name="<?= htmlspecialchars($workout['name']) ?>"><i
                      class="fas fa-eye"></i> Ver Treino</button>
                <?php else: ?>
                  <a href="<?= BASE_URL ?>index.php?controller=workout&action=list&id=<?= $workout['id'] ?>"
                    class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                  <a href="<?= BASE_URL ?>index.php?controller=workout&action=delete&id=<?= $workout['id'] ?>"
                    class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?');"><i
                      class="fas fa-trash-alt"></i></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; else: ?>
          <tr>
            <td colspan="3" class="text-center">Nenhum treino encontrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

  <div class="modal fade" id="workoutModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background: #333333; color: #fefefe">
          <h5 class="modal-title">Detalhes do Treino</h5><button type="button" class="btn-close bg-white"
            data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="modal-spinner" class="text-center">
            <div class="spinner-border"></div>
          </div>
          <div id="modal-content-target"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">Fechar</button></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function translateDifficulty(level) {
      const levels = { 'beginner': 'Iniciante', 'intermediate': 'Intermediário', 'advanced': 'Avançado' };
      return levels[level] || level;
    }

    function escapeHTML(str) {
      const p = document.createElement("p");
      p.textContent = str;
      return p.innerHTML;
    }

    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.getElementById('workoutModal');
      if (modal) {
        modal.addEventListener('show.bs.modal', event => {
          const button = event.relatedTarget;
          const workoutId = button.getAttribute('data-workout-id');
          const workoutName = button.getAttribute('data-workout-name');
          const modalTitle = modal.querySelector('.modal-title');
          const contentTarget = document.getElementById('modal-content-target');
          const spinner = document.getElementById('modal-spinner');

          modalTitle.textContent = 'Treino: ' + workoutName;
          contentTarget.innerHTML = '';
          spinner.style.display = 'block';

          fetch(`<?= BASE_URL ?>index.php?controller=workout&action=getDetails&id=${workoutId}`)
            .then(res => res.json())
            .then(data => {
              spinner.style.display = 'none';
              let html = '';
              if (data && data.length > 0) {
                html = '<ul class="list-group list-group-flush">';
                data.forEach(ex => {
                  html += `<li class="list-group-item">
                                        <h4>${escapeHTML(ex.name)}</h4>
                                        <div class="exercise-detail"><strong>Tipo:</strong> <span>${escapeHTML(ex.exercise_type)}</span></div>
                                        <div class="exercise-detail"><strong>Dificuldade:</strong> <span>${escapeHTML(translateDifficulty(ex.difficulty))}</span></div>
                                        <div class="exercise-detail"><strong>Grupo Muscular:</strong> <span>${escapeHTML(ex.muscle_group_name || 'N/A')}</span></div>
                                        <div class="exercise-detail"><strong>Descrição:</strong> <span>${escapeHTML(ex.description)}</span></div>
                                    </li>`;
                });
                html += '</ul>';
              } else {
                html = '<p>Nenhum exercício encontrado para este treino.</p>';
              }
              contentTarget.innerHTML = html;
            }).catch(err => {
              spinner.style.display = 'none';
              contentTarget.innerHTML = '<p class="text-danger">Erro ao carregar os detalhes do treino.</p>';
            });
        });
      }
    });
  </script>
</body>

</html>
