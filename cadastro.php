<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Realizado!</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #28a745; margin-bottom: 20px; }
        p { color: #555; margin-bottom: 10px; }
        a { color: #007bff; text-decoration: none; margin-top: 20px; display: inline-block; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
       
<?php
require 'db.php';

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$equipe = $_POST['equipe'] ?? '';

$erros = [];

if (empty($nome)) $erros[] = "Nome é obrigatório.";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = "E-mail inválido.";
if (empty($senha) || strlen($senha) < 6) $erros[] = "Senha deve ter ao menos 6 caracteres.";
if (empty($equipe)) $erros[] = "Selecione uma equipe.";

if (count($erros) > 0) {
  foreach ($erros as $erro) {
    echo "<p style='color:red;'>$erro</p>";
  }
  exit;
}

// Evita duplicidade de e-mail
$sqlCheck = "SELECT id FROM colaboradores WHERE email = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("s", $email);
$stmtCheck->execute();
$stmtCheck->store_result();

if ($stmtCheck->num_rows > 0) {
  echo "<p style='color:red;'>E-mail já cadastrado.</p>";
  exit;
}

// Hash da senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO colaboradores (nome, email, senha, equipe) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $senhaHash, $equipe);

if ($stmt->execute()) {
  echo  "<p style='color:green;'>Bem-vindo(a), <strong>$nome</strong>!</p>";
            echo "<p>Seu e-mail de cadastro é: <strong>$email</strong></p>";
} else {
  echo "<p style='color:red;'>Erro ao cadastrar: " . $conn->error . "</p>";
}
?>
<p>Você já pode fechar esta janela ou:</p>
        <a href="index.html">Voltar para a página inicial</a>
</div>
      </body>

</html>
    