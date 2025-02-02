<?php
require 'db.php';

$query_pacientes = "SELECT id, nome, endereco, data_nasc FROM Paciente";
$resultado_pacientes = mysqli_query($conn, $query_pacientes);
$pacientes = [];
if ($resultado_pacientes) {
    while ($row = mysqli_fetch_assoc($resultado_pacientes)) {
        $pacientes[] = $row;
    }
}

$query_consultas = "
    SELECT c.id, c.data_hora, c.especialidade, p.nome AS paciente_nome 
    FROM Consulta c
    JOIN Paciente p ON c.paciente_id = p.id
    ORDER BY c.data_hora 
";
$resultado_consultas = mysqli_query($conn, $query_consultas);
$consultas = [];
if ($resultado_consultas) {
    while ($row = mysqli_fetch_assoc($resultado_consultas)) {
        $consultas[] = $row;
    }
} else {
    $consultas = [];
}

$query_pacientes = "
    SELECT id, nome, endereco, data_nasc
    FROM Paciente
";
$resultado_pacientes = mysqli_query($conn, $query_pacientes);
$pacientes = [];
if ($resultado_pacientes) {
    while ($row = mysqli_fetch_assoc($resultado_pacientes)) {
        $pacientes[] = $row;
    }
} else {
    $pacientes = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2dRzbdexmZjF3/NW8MbZgsZ3r8g2PVuIuGnDgM3vqHeZ9M5onVKpnIF57r4d" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rock+Salt&family=Courgette&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./backend.css">
    <title>ConsultaCare - Frontend</title>
</head>
<body class="d-flex justify-content-center align-items-start">
    <div class="container">
        <div class="mb-5">
            <h2 class="mb-4 mt-3">Lista de pacientes</h2>

            <!-- Tabela de pacientes -->
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Data de Nascimento</th>
                    </tr>
                </thead>
                <tbody id="pacienteTableBody">
                    <?php if (!empty($pacientes)): ?>
                        <?php foreach ($pacientes as $paciente): ?>
                            <?php $data_formatada = date("d/m/Y", strtotime($paciente['data_nasc'])); ?>
                            <tr id="paciente_<?php echo $paciente['id']; ?>">
                                <td><?php echo $paciente['id']; ?></td>
                                <td><?php echo $paciente['nome']; ?></td>
                                <td><?php echo $paciente['endereco']; ?></td>
                                <td><?php echo $data_formatada; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Nenhum paciente encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            <h2 class="mb-4 mt-3">Lista de consultas</h2>
    
            <!-- Tabela de consultas -->
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>ID</th>
                        <th>Data e Hora</th>
                        <th>Especialidade</th>
                        <th>Paciente</th>
                    </tr>
                </thead>
                <tbody id="consultaTableBody">
                    <?php if (!empty($consultas)): ?>
                        <?php foreach ($consultas as $consulta): ?>
                            <?php $data_formatada = date("d/m/Y H:i", strtotime($consulta['data_hora'])); ?>
                            <tr id="consulta_<?php echo $consulta['id']; ?>">
                                <td><?php echo $consulta['id']; ?></td>
                                <td><?php echo $data_formatada; ?></td>
                                <td><?php echo $consulta['especialidade']; ?></td>
                                <td><?php echo $consulta['paciente_nome']; ?></td> 
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Nenhuma consulta encontrada.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
