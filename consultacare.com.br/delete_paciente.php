<?php
require 'db.php';

header('Content-Type: application/json');

if (isset($_POST['paciente_id'])) {
    $paciente_id = $_POST['paciente_id'];

    $sql = "DELETE FROM Paciente WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Erro na preparação da query: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $paciente_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir paciente: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID do paciente não foi fornecido.']);
}

$conn->close();
exit;
