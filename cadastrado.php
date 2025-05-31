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
        <h1>🎉 Cadastro Realizado com Sucesso!</h1>
        <?php
        // Exibe os dados passados via URL (opcional)
        if (isset($_GET['nome']) && isset($_GET['email'])) {
            $nome = htmlspecialchars($_GET['nome']);
            $email = htmlspecialchars($_GET['email']);
            echo "<p>Bem-vindo(a), <strong>$nome</strong>!</p>";
            echo "<p>Seu e-mail de cadastro é: <strong>$email</strong></p>";
        } else {
            echo "<p>Obrigado por se cadastrar!</p>";
        }
        ?>
        <p>Você já pode fechar esta janela ou:</p>
        <a href="index.html">Voltar para a página inicial</a>
    </div>
</body>
</html>