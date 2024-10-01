<?php
session_start();
require_once 'classes/usuario.php';
$u = new Usuario("essentia", "localhost", "root", "Unida010!");
$perguntas = [
  "Qual é o nome do seu primeiro animal de estimação?",
  "Qual é a sua cidade natal?",
  "Qual é o nome da sua escola primária?",
  "Qual é o seu anime favorito?",
];

$generalMessage = ""; 
$emailMessage = ""; 
$senhaMessage = ""; 
$cpfMessage = ""; 
$campoVazioMessage = ""; 

function validarCPF($cpf)
{
  $cpf = preg_replace('/[^0-9]/', '', $cpf);
  if (strlen($cpf) != 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
    return false;
  }

  $soma = 0;
  for ($i = 0; $i < 9; $i++) {
    $soma += $cpf[$i] * (10 - $i);
  }
  $digito1 = ($soma * 10) % 11;
  if ($digito1 == 10) $digito1 = 0;

  $soma = 0;
  for ($i = 0; $i < 10; $i++) {
    $soma += $cpf[$i] * (11 - $i);
  }
  $digito2 = ($soma * 10) % 11;
  if ($digito2 == 10) $digito2 = 0;

  return $digito1 == $cpf[9] && $digito2 == $cpf[10];
}

if (isset($_POST['envio'])) {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $cpf = $_POST['cpf'];
  $telefone = $_POST['telefone'];
  $dataNascimento = $_POST['data-nascimento'];
  $senha = $_POST['senha'];
  $perguntaSecreta = $_POST['pergunta-secreta'];
  $respostaSecreta = $_POST['resposta-secreta'];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailMessage = "Email inválido!";
  }

  elseif (strlen($senha) < 6) {
    $senhaMessage = "A senha deve ter pelo menos 6 caracteres!";
  }

  elseif (!validarCPF($cpf)) {
    $cpfMessage = "CPF inválido! Verifique se está correto.";
  }

  elseif (empty($nome) || empty($email) || empty($cpf) || empty($telefone) || empty($dataNascimento) || empty($senha) || empty($perguntaSecreta) || empty($respostaSecreta)) {
    $campoVazioMessage = "Preencha todos os campos!";
  } else {
 
    $dataAtual = new DateTime();
    $dataNascimentoDate = new DateTime($dataNascimento);
    $idade = $dataAtual->diff($dataNascimentoDate)->y;

    if ($dataNascimentoDate > $dataAtual) {
      $generalMessage = "<div class='alert error'>Data de nascimento não pode ser no futuro!</div>";
    } elseif ($idade < 18 || $idade > 120) {
      $generalMessage = "<div class='alert error'>A idade deve ser entre 18 e 120 anos!</div>";
    } else {
      if ($u->cadastrar($nome, $email, $cpf, $telefone, $dataNascimento, $senha, $perguntaSecreta, $respostaSecreta)) {
        $generalMessage = "<div class='alert success'>Cadastrado com sucesso, acesse para entrar!</div>";
      } else {
        $generalMessage = "<div class='alert error'>" . $u->msgErro . "</div>";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de usuário</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#telefone').mask('(00) 00000-0000');
      $('#cpf').mask('000.000.000-00');

      
      $('.nome-input').on('keypress', function(e) {
        const charCode = (typeof e.which === "undefined") ? e.keyCode : e.which;
        if (charCode >= 48 && charCode <= 57) {
          e.preventDefault();
        }
      });

      $('#form-cadastro-usuario').on('submit', function(e) {
      
        const email = $('#email').val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
          alert("Email inválido!");
          e.preventDefault();
          return;
        }

      
        const cpf = $('#cpf').val().replace(/\D/g, ''); 
        if (!validarCPF(cpf)) {
          alert("CPF inválido!");
          e.preventDefault();
          return;
        }
      });

      function validarCPF(cpf) {
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
          return false;
        }
        let soma = 0;
        for (let i = 0; i < 9; i++) {
          soma += Number(cpf[i]) * (10 - i);
        }
        let digito1 = (soma * 10) % 11;
        if (digito1 === 10) digito1 = 0;

        soma = 0;
        for (let i = 0; i < 10; i++) {
          soma += Number(cpf[i]) * (11 - i);
        }
        let digito2 = (soma * 10) % 11;
        if (digito2 === 10) digito2 = 0;

        return digito1 === Number(cpf[9]) && digito2 === Number(cpf[10]);
      }
    });
  </script>
</head>

<body>
  <header>
    <div class="container">
      <a href="index.php" class="logo">
        <img src="assets/images/ho.svg" alt="" />
      </a>
    </div>
  </header>
  <section class="page-cadastro-usuario paddingBottom50">
    <div class="container">
      <div>
        <a href="cadastro-usuario.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Cadastro de usuário</span>
        </a>
      </div>
      <div class="container-small">
        <div>
          <?php echo $generalMessage; ?>
        </div>
        <form method="post" id="form-cadastro-usuario">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome" required maxlength="255">
            </div>
            <div>
              <label class="input-label">E-mail</label>
              <input type="text" class="email-input" id="email" name="email" required maxlength="255">
              <p class="error-message"><?php echo $emailMessage; ?></p>
            </div>
            <div>
              <label class="input-label">CPF</label>
              <input type="text" class="cpf-input" id="cpf" name="cpf" required maxlength="14">
              <p class="error-message"><?php echo $cpfMessage; ?></p>
            </div>
            <div>
              <label class="input-label">Telefone</label>
              <input type="tel" class="telefone-input" id="telefone" name="telefone" required maxlength="15">
            </div>
            <div>
              <label class="input-label">Data de Nascimento</label>
              <input type="date" class="date-nascimento" name="data-nascimento" required>
            </div>
            <div>
              <label class="input-label">Senha</label>
              <input type="password" class="senha-input" id="senha" name="senha" required maxlength="40">
              <p class="error-message"><?php echo $senhaMessage; ?></p>
            </div>
            <div>
              <label class="input-label" for="pergunta-secreta">Pergunta Secreta</label>
              <select id="pergunta-secreta" name="pergunta-secreta" required>
                <?php foreach ($perguntas as $pergunta): ?>
                  <option value="<?php echo htmlspecialchars($pergunta); ?>"><?php echo htmlspecialchars($pergunta); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label for="resposta-secreta">Resposta</label>
              <input type="text" id="resposta-secreta" name="resposta-secreta" required>
            </div>
          </div>
          <button type="submit" name="envio" class="button-default">Salvar novo usuário</button>
        </form>
      </div>
    </div>
  </section>
</body>

</html>