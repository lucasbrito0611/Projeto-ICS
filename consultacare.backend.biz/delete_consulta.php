<?php
require 'db.php';

if (isset($_POST['consulta_id'])) {
    $consulta_id = $_POST['consulta_id'];

  
    $sql = "DELETE FROM Consulta WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $consulta_id);

    if ($stmt->execute()) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'message' => "Erro ao excluir consulta: " . $stmt->error);
    }

    $stmt->close();
} else {
    $response = array('success' => false, 'message' => 'ID da consulta não fornecido.');
}

$conn->close();
echo json_encode($response);