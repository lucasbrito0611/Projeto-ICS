<?php
require 'db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $paciente_id = $_POST['paciente_id'] ?? null;
    $nome = $_POST['nome'] ?? null;
    $endereco = $_POST['endereco'] ?? null;
    $dataNascimento = $_POST['data_nasc'] ?? null;

    if (!$paciente_id || !$nome || !$endereco || !$dataNascimento) {
        echo json_encode(["success" => false, "message" => "Dados incompletos"]);
        exit;
    }

    $query = "UPDATE Paciente SET nome=?, endereco=?, data_nasc=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $nome, $endereco, $dataNascimento, $paciente_id);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo json_encode(["success" => true, "message" => "Consulta atualizada"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar"]);
    }
}
?>
