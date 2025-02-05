// FUNÇÃO PARA ADICIONAR PACIENTE
document.getElementById('pacienteForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('create_paciente.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Paciente adicionado com sucesso!');
            
            var tableBody = document.getElementById('pacienteTableBody');
            var newRow = document.createElement('tr');
            newRow.id = 'paciente_' + data.paciente_id;
            newRow.innerHTML = `
                <td>${data.paciente_id}</td>
                <td>${data.nome}</td>
                <td>${data.endereco}</td>
                <td>${data.data_nasc}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-button" data-paciente-id="${data.paciente_id}" data-nome="${data.nome}" data-endereco="${data.endereco}" data-data="${data.data_nasc}">Editar</button>
                    <button class="btn btn-danger btn-sm delete-button" data-paciente-id="${data.paciente_id}">Excluir</button>
                </td>
            `;
            tableBody.appendChild(newRow);
            location.reload();
            document.getElementById('pacienteForm').reset();
        } else {
            alert('Erro ao adicionar paciente: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro na requisição: ' + error);
    });
});

// FUNÇÃO PARA ABRIR O FORM DE EDIÇÃO
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-button');
    const editarForm = document.getElementById('editarPacienteForm');
    const editarFormInputs = editarForm.querySelectorAll('input');
    const cancelarEdicaoButton = document.getElementById('cancelarEdicao');
    
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pacienteId = button.getAttribute('data-paciente-id');
            const nome = button.getAttribute('data-nome');
            const endereco = button.getAttribute('data-endereco');
            const dataNascimento = button.getAttribute('data-data');

            const form = document.getElementById('editarForm');
            form.querySelector('input[name="nome"]').value = nome;
            form.querySelector('input[name="endereco"]').value = endereco;
            form.querySelector('input[name="data_nasc"]').value = dataNascimento;
            form.querySelector('input[name="paciente_id"]').value = pacienteId;

            document.getElementById('editarPacienteForm').style.display = 'block';
        });
    });
    
    cancelarEdicaoButton.addEventListener('click', function() {
        editarForm.style.display = 'none'; 
    });
});

// FUNÇÃO PARA EDITAR CONSULTA
document.getElementById('editarForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    var formData = new FormData(this);

    fetch('editar_paciente.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())  
    .then(data => {
        if (data.success) {
            alert('Paciente atualizado com sucesso!');
            location.reload(); 
        } else {
            alert('Erro ao atualizar paciente: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro na requisição: ' + error);
    });
});

// FUNÇÃO PARA EXCLUIR PACIENTE
function excluirPaciente(pacienteId) {
    if (confirm("Tem certeza que deseja excluir esse paciente?")) {
        var formData = new FormData();
        formData.append("paciente_id", pacienteId);

        fetch('delete_paciente.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Paciente excluído com sucesso!");
                var row = document.getElementById('paciente_' + pacienteId);
                if (row) {
                    row.remove();
                } else {
                    console.error('Linha não encontrada para exclusão');
                }
            } else {
                alert("Erro ao excluir paciente: " + data.message);
            }
        })
        .catch(error => {
            alert("Erro na requisição: " + error);
        });

    }
}


document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', function() {
        var pacienteId = this.dataset.pacienteId;
        excluirPaciente(pacienteId);
    });
});