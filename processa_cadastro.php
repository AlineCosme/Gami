<?php
// Desativa a exibição de erros no navegador em produção (apenas para depuração)
// ini_set('display_errors', 0);
// error_reporting(E_ALL);

// Configurações do banco de dados (ajuste conforme o seu ambiente)
$host = "localhost";
$usuario = "root";
$senha = "usbw";
$banco = "sistema_gami";

// Cria a conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    // Redireciona para uma página de erro ou exibe uma mensagem genérica
    // die("Erro na conexão com o banco de dados: " . $conn->connect_error); // Para depuração
    header("Location: erro_conexao.html"); // Página de erro genérica
    exit();
}

// Garante que o método da requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e limpa os dados do POST
    // Usar trim() para remover espaços em branco e htmlspecialchars() para evitar XSS
    $nome = trim(htmlspecialchars($_POST['nomeColaborador'] ?? ''));
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));

    // Validação básica (adicione mais validações conforme necessário)
    if (empty($nome) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redireciona de volta para o formulário com uma mensagem de erro ou parâmetro na URL
        header("Location: cadastro-colaborador.html?status=erro_validacao");
        exit();
    }

    // Usar Prepared Statements para segurança contra SQL Injection
    $sql = "INSERT INTO Colaborador (nomeColaborador, email) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Erro ao preparar a query
        // die("Erro ao preparar a query: " . $conn->error); // Para depuração
        header("Location: erro_banco.html"); // Página de erro genérica
        exit();
    }

    // 'ss' significa que os dois parâmetros são strings
    $stmt->bind_param("ss", $nome, $email);

    if ($stmt->execute()) {
        // Cadastro realizado com sucesso! Redireciona para a página 'cadastrado.php'
        // Você pode passar dados via GET se precisar, como o nome do cadastrado
        header("Location: cadastrado.php?nome=" . urlencode($nome) . "&email=" . urlencode($email));
        exit(); // IMPORTANTE: Termina o script após o redirecionamento
    } else {
        // Erro ao executar a inserção
        // die("Erro ao cadastrar: " . $stmt->error); // Para depuração
        header("Location: cadastro-colaborador.html?status=erro_cadastro");
        exit();
    }

    $stmt->close(); // Fecha o statement
} else {
    // Se a requisição não for POST, redireciona para a página do formulário
    header("Location: cadastro-colaborador.html");
    exit();
}

$conn->close(); // Fecha a conexão com o banco de dados
?>