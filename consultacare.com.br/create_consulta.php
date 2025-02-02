<?php
require 'db.php';

header('Content-Type: application/json'); 

if (!isset($_POST['data_hora']) || !isset($_POST['especialidade']) || !isset($_POST['paciente_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Dados incompletos enviados.'
    ]);
    exit;
}

$data_hora = $_POST['data_hora'];
$especialidade = $_POST['especialidade'];
$paciente_id = $_POST['paciente_id'];

$data_hora_formatada = date("Y-m-d H:i:s", strtotime($data_hora));

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro na conexão com o banco de dados: ' . $conn->connect_error
    ]);
    exit;
}

$sql = "INSERT INTO Consulta (data_hora, especialidade, paciente_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro na preparação da query: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("ssi", $data_hora_formatada, $especialidade, $paciente_id);

if ($stmt->execute()) {
    $query_paciente = "SELECT nome FROM Paciente WHERE id = ?";
    $stmt_paciente = $conn->prepare($query_paciente);
    $stmt_paciente->bind_param("i", $paciente_id);
    $stmt_paciente->execute();
    $resultado_paciente = $stmt_paciente->get_result();
    $paciente = $resultado_paciente->fetch_assoc();
    $paciente_nome = $paciente['nome'];

    $response = [
        'success' => true,
        'consulta_id' => $stmt->insert_id,
        'data_hora' => date("d/m/Y H:i", strtotime($data_hora_formatada)),
        'especialidade' => $especialidade,
        'paciente_id' => $paciente_id,
        'paciente_nome' => $paciente_nome 
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'Erro ao inserir consulta: ' . $stmt->error
    ];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
