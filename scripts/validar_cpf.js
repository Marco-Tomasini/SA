function validarCPF() {
    const cpf = document.getElementById('cpf').value;
    const nascimento = document.getElementById('nascimento').value;
    const resultado = document.getElementById('resultado');

    resultado.textContent = 'Validando...';

    fetch('createteste.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=validar_cpf&cpf=' + encodeURIComponent(cpf) + '&nascimento=' + encodeURIComponent(nascimento)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultado.textContent = '✅ CPF válido! Nome: ' + data.data.name + data.data.birthDate;
            resultado.style.color = 'green';
        } else {
            resultado.textContent = '❌ ' + data.message;
            resultado.style.color = 'red';
        }
    })
    .catch(() => {
        resultado.textContent = 'Erro ao comunicar com o servidor.';
        resultado.style.color = 'red';
    });
}
