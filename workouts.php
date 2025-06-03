<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Treinos - FitCrud</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  include_once 'auth-guard.php';
  include_once 'templates/navbar.php';
  ?>

  <main class="container mt-5">
    <h2 class="mb-4">Cadastrar Novo Treino</h2>
    <form>
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="data" class="form-label">Data:</label>
          <input type="date" class="form-control" id="data" required>
        </div>
        <div class="col-md-6">
          <label for="descricao" class="form-label">Descrição do Treino:</label>
          <input type="text" class="form-control" id="descricao" placeholder="Ex: Treino de Peito" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Selecionar Exercícios:</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="supino" id="ex1">
          <label class="form-check-label" for="ex1">Supino Reto</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="crucifixo" id="ex2">
          <label class="form-check-label" for="ex2">Crucifixo</label>
        </div>
        <!-- Estes serão populados do backend futuramente -->
      </div>

      <button type="submit" class="btn btn-dark">Cadastrar Treino</button>
    </form>

    <hr class="my-5" />

    <h3>Treinos Cadastrados</h3>
    <table class="table mt-3">
      <thead class="table-dark">
        <tr>
          <th>Data</th>
          <th>Descrição</th>
          <th>Exercícios</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>10/04/2025</td>
          <td>Peito</td>
          <td>Supino, Crucifixo</td>
          <td><a href="#">Editar</a> | <a href="#">Remover</a></td>
        </tr>
      </tbody>
    </table>
  </main>

  <div id="footer"></div>
  <script src="js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>