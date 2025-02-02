<?php
require 'db.php'; 

header('Content-Type: application/json');

if (!isset($_POST['nome']) || !isset($_POST['endereco']) || !isset($_POST['data_nasc'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Dados incompletos enviados.'
    ]);
    exit;
}

$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$data_nasc = $_POST['data_nasc'];

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro na conexão com o banco de dados: ' . $conn->connect_error
    ]);
    exit;
}

$sql = "INSERT INTO Paciente (nome, endereco, data_nasc) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro na preparação da query: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("sss", $nome, $endereco, $data_nasc);

if ($stmt->execute()) {
    $response = [
        'success' => true,
        'paciente_id' => $stmt->insert_id,
        'nome' => $nome,
        'endereco' => $endereco,
        'data_nasc' => $data_nasc,
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'Erro ao inserir paciente: ' . $stmt->error
    ];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
