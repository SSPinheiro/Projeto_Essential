document.getElementById('form-cadastro-usuario').addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio do formulário

    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;
    const mensagemEmail = document.getElementById('mensagemEmail');
    const mensagemSenha = document.getElementById('mensagemSenha');

    mensagemEmail.textContent = ''; // Limpa a mensagem anterior
    mensagemSenha.textContent = ''; // Limpa a mensagem anterior

    // Validação do email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        mensagemEmail.textContent += 'Email inválido. ';
    }

    // Validação da senha
    if (senha.length < 6) {
        mensagemSenha.textContent += 'A senha deve ter pelo menos 6 caracteres. ';
    }

    // Se não houver mensagens de erro, o formulário pode ser enviado
    if (mensagemEmail.textContent === '' && mensagemSenha.textContent === '') {
        // Submissão do formulário
        this.submit(); // Envia o formulário
    }
});
