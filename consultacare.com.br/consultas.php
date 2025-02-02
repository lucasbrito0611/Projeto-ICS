<?php
require 'db.php';

$query_pacientes = "SELECT id, nome FROM Paciente";
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
    <link rel="stylesheet" href="./css/backend.css">
    <title>Consulta Care - Backend</title>
</head>
<body class="d-flex justify-content-center align-items-start">
    <div class="container">
        <div>
            <!-- Menu de Navegação -->
            <ul class="nav nav-tabs mt-3">
                <li class="nav-item">
                    <a class="nav-link" href="pacientes.php">Pacientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="consultas.php">Consultas</a>
                </li>
            </ul>
            
            <h2 class="mb-4 mt-3">Gerenciar Consultas</h2>
    
            <!-- Formulário para adicionar consulta -->
            <form id="consultaForm">
                <div class="form-row">
                    <input type="datetime-local" id="data_hora" name="data_hora" class="form-control" required>
                    <input type="text" id="especialidade" name="especialidade" class="form-control" placeholder="Especialidade" required>
    
                    <!-- Select para escolher o paciente -->
                    <select name="paciente_id" class="form-control" required>
                        <option value="">Selecione o Paciente</option>
                        <?php foreach ($pacientes as $paciente): ?>
                            <option value="<?php echo $paciente['id']; ?>"><?php echo $paciente['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary mt-3 mb-3">Adicionar Consulta</button>
                </div>
            </form>
    
            <!-- Formulário para editar consulta -->
            <div id="editarConsultaForm" style="display: none;">
                <h2>Editar Consulta</h2>
                <form id="editarForm" method="POST">
                    <div class="form-row ">
                        <input type="datetime-local" name="data_hora" class="form-control" placeholder="Data e Hora" required>
                        <input type="text" name="especialidade" class="form-control" placeholder="Especialidade" required>
                        <select name="paciente_id" class="form-control" required>
                            <option value="">Selecione o Paciente</option>
                            <?php foreach ($pacientes as $paciente): ?>
                                <option value="<?php echo $paciente['id']; ?>"><?php echo $paciente['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="consulta_id" value="">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 mb-3">Salvar Alterações</button>
                    <button type="button" id="cancelarEdicao" class="btn btn-secondary mt-2 mb-3" style="">Cancelar</button>
                </form>
            </div>
    
            <!-- Tabela de consultas -->
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>ID</th>
                        <th>Data e Hora</th>
                        <th>Especialidade</th>
                        <th>Paciente</th>
                        <th>Ações</th>
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
                                <td>
                                    <button class='btn btn-warning btn-sm edit-button' data-consulta-id="<?php echo $consulta['id']; ?>" data-data-hora='<?php echo $consulta['data_hora']; ?>' data-especialidade="<?php echo $consulta['especialidade']; ?>" data-paciente-nome="<?php echo $consulta['paciente_nome']; ?>">Editar</button>
                                    <button class="btn btn-danger btn-sm delete-button" data-consulta-id="<?php echo $consulta['id']; ?>">Excluir</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">Nenhuma consulta encontrada.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/consultas.js"></script>
</body>
</html>
