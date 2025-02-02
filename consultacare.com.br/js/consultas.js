// FUNÇÃO PARA ADICIONAR CONSULTA
document.getElementById('consultaForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('create_consulta.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Consulta adicionada com sucesso!');
            
            var tableBody = document.getElementById('consultaTableBody');
            var newRow = document.createElement('tr');
            newRow.id = 'consulta_' + data.consulta_id;
            newRow.innerHTML = `
                <td>${data.consulta_id}</td>
                <td>${data.data_hora}</td>
                <td>${data.especialidade}</td>
                <td>${data.paciente_nome}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-button" data-consulta-id="${data.consulta_id}" data-data-hora="${data.data_hora}" data-especialidade="${data.especialidade}" data-paciente-nome="${data.paciente_nome}">Editar</button>
                    <button class="btn btn-danger btn-sm delete-button" data-consulta-id="${data.consulta_id}">Excluir</button>
                </td>
            `;
            tableBody.appendChild(newRow);
            location.reload();
            document.getElementById('consultaForm').reset();
        } else {
            alert('Erro ao adicionar consulta: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro na requisição: ' + error);
    });
});

// FUNÇÃO PARA EXCLUIR CONSULTA
function excluirConsulta(consultaId) {
    if (confirm("Tem certeza que deseja excluir essa consulta?")) {
        var formData = new FormData();
        formData.append("consulta_id", consultaId);

        fetch('delete_consulta.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Consulta excluída com sucesso!");
                var row = document.getElementById('consulta_' + consultaId);
                if (row) {
                    row.remove();
                } else {
                    console.error('Linha não encontrada para exclusão');
                }
            } else {
                alert("Erro ao excluir consulta: " + data.message);
            }
        })
        .catch(error => {
            alert("Erro na requisição: " + error);
        });
    }
}


document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', function() {
        var consultaId = this.dataset.consultaId;
        excluirConsulta(consultaId);
    });
});

// FUNÇÃO PARA ABRIR O FORM DE EDIÇÃO
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-button');
    const editarForm = document.getElementById('editarConsultaForm');
    const editarFormInputs = editarForm.querySelectorAll('input');
    const cancelarEdicaoButton = document.getElementById('cancelarEdicao');
    
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const consultaId = button.getAttribute('data-consulta-id');
            const dataHora = button.getAttribute('data-data-hora');
            const especialidade = button.getAttribute('data-especialidade');
            const pacienteNome = button.getAttribute('data-paciente-nome');

            const form = document.getElementById('editarForm');
            form.querySelector('input[name="data_hora"]').value = dataHora;
            form.querySelector('input[name="especialidade"]').value = especialidade;
            form.querySelector('input[name="consulta_id"]').value = consultaId;

            const selectPaciente = form.querySelector('select[name="paciente_id"]');
            for (let option of selectPaciente.options) {
                if (option.textContent.trim() === pacienteNome.trim()) {
                    option.selected = true;
                    break;
                }
            }

            document.getElementById('editarConsultaForm').style.display = 'block';
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

    fetch('editar_consulta.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Consulta atualizada com sucesso!');
            location.reload(); 
        } else {
            alert('Erro ao atualizar consulta: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro na requisição: ' + error);
    });
});