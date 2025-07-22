<?php

echo "<h1>Iniciando configuração do ambiente na nuvem...</h1>";

try {
    // A Railway já cria o banco, então pulamos essa etapa.

    echo "<p>1. Criando tabelas...</p>";
    // Usando caminho absoluto para garantir que o arquivo seja encontrado
    require_once '/var/www/html/app/repository/create-table.php';
    echo "<p style='color:green;'>Tabelas criadas com sucesso.</p>";

    echo "<p>2. Populando tabela 'muscle_groups'...</p>";
    // Usando caminho absoluto
    require_once '/var/www/html/app/repository/muscle-group/populate-muscle-groups.php';
    echo "<p style='color:green;'>Grupos musculares inseridos com sucesso.</p>";

    echo "<hr><h2>Ambiente configurado!</h2>";

} catch (Exception $e) {
    echo "<h2 style='color:red;'>Ocorreu um erro durante a configuração:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}

?>