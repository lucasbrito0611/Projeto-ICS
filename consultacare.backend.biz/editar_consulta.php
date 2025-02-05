<?php
require 'db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $consulta_id = $_POST['consulta_id'] ?? null;
    $data_hora = $_POST['data_hora'] ?? null;
    $especialidade = $_POST['especialidade'] ?? null;
    $paciente_id = $_POST['paciente_id'] ?? null;

    if (!$consulta_id || !$data_hora || !$especialidade || !$paciente_id) {
        echo json_encode(["success" => false, "message" => "Dados incompletos"]);
        exit;
    }

    $query = "UPDATE Consulta SET data_hora=?, especialidade=?, paciente_id=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssii", $data_hora, $especialidade, $paciente_id, $consulta_id);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo json_encode(["success" => true, "message" => "Consulta atualizada"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar"]);
    }
}
?>
