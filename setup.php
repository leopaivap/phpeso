// Description: Script para configurar o ambiente do PHPeso

<?php

echo "<h1>Iniciando configuração do ambiente...</h1>";

try {
    // A Railway já cria o banco
    // echo "<p>1. Criando banco de dados 'db_phpeso'...</p>";
    // require_once __DIR__ . '/app/repository/create-database.php';
    // echo "<p style='color:green;'>Banco de dados criado com sucesso (ou já existia).</p>";

    echo "<p>2. Criando tabelas...</p>";
    require_once './app/repository/create-table.php';
    echo "<p style='color:green;'>Tabelas criadas com sucesso (ou já existiam).</p>";

    echo "<p>3. Populando tabela 'muscle_groups'...</p>";
    require_once './app/repository/muscle-group/populate-muscle-groups.php';
    echo "<p style='color:green;'>Grupos musculares inseridos com sucesso (ou já existiam).</p>";

    echo "<hr><h2>Ambiente configurado!</h2>";
    echo "<p>Você já pode acessar a <a href='/phpeso/index.php'>página inicial da aplicação</a>.</p>";

} catch (Exception $e) {
    echo "<h2 style='color:red;'>Ocorreu um erro durante a configuração:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}

?>