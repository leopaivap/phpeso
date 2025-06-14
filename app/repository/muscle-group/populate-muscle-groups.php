<?php
// apenas para teste, futuramente tera cadastro de grupos musculares
require_once "../Connection.php";

try {
    $connection = Connection::getInstance()->getConnection();
    $stmt = $connection->query("SELECT COUNT(*) FROM muscle_groups");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Lista de grupos musculares comuns
        $muscleGroups = [
            'Peito',
            'Costas',
            'Bíceps',
            'Tríceps',
            'Ombros',
            'Pernas',
            'Glúteos',
            'Panturrilhas',
            'Abdômen',
            'Antebraço',
            'Trapézio'
        ];

        $stmt = $connection->prepare("INSERT INTO muscle_groups (name) VALUES (:name)");
        foreach ($muscleGroups as $group) {
            $stmt->execute([':name' => $group]);
        }

        // echo "Grupos musculares inseridos com sucesso.";
    } else {
        // echo "Tabela 'muscle_groups' já possui dados.";
    }
} catch (PDOException $e) {
    // echo "Erro ao inserir grupos musculares: " . $e->getMessage();
}
?>