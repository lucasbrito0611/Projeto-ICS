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
        <!-- Menu de Navegação -->
        <ul class="nav nav-tabs mt-3">
            <li class="nav-item">
                <a class="nav-link active" href="pacientes.php">Pacientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="consultas.php">Consultas</a>
            </li>
        </ul>

        <h2 class="mb-4 mt-3">Gerenciar Pacientes</h2>

        <!-- Formulário para adicionar paciente -->
        <form id="pacienteForm">
            <div class="form-row">
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome" required>
                <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Endereço" required>
                <input type="date" id="data_nasc" name="data_nasc" class="form-control" required>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mt-3 mb-3">Adicionar Paciente</button>
            </div>
        </form>

        <!-- Formulário para editar paciente -->
        <div id="editarPacienteForm" style="display: none;">
            <h2>Editar Paciente</h2>
            <form id="editarForm" method="POST">
                <div class="form-row ">
                    <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                    <input type="text" name="endereco" class="form-control" placeholder="Endereço" required>
                    <input type="date" name="data_nasc" class="form-control" placeholder="Data de Nascimento" required>
                    <input type="hidden" name="paciente_id" value="">
                </div>
                <button type="submit" class="btn btn-primary mt-2 mb-3">Salvar Alterações</button>
                <button type="button" id="cancelarEdicao" class="btn btn-secondary mt-2 mb-3" style="">Cancelar</button>
            </form>
        </div>

        <!-- Tabela de pacientes -->
        <table class="table table-bordered">
            <thead class="table-info">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Data de Nascimento</th>
                    <th>Ações</th>
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
                            <td>
                                <button class='btn btn-warning btn-sm edit-button' data-paciente-id="<?php echo $paciente['id']; ?>" data-nome='<?php echo $paciente['nome']; ?>' data-endereco="<?php echo $paciente['endereco']; ?>" data-data="<?php echo $paciente['data_nasc']; ?>">Editar</button>
                                <button class="btn btn-danger btn-sm delete-button" data-paciente-id="<?php echo $paciente['id']; ?>">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">Nenhum paciente encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="js/pacientes.js"></script>
</body>
</html>
