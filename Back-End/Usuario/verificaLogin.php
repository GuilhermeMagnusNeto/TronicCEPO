<?php
session_start();
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Receba os dados do formulário
$usuario = $_POST['login'];
$senha = $_POST['senha'];

// Consulta SQL para verificar o usuário e senha no banco de dados
$consulta = "SELECT * FROM tbUsuario WHERE nomeUsu = '$usuario' AND senhaUsu = '$senha'";
$resultado = $conexao->query($consulta);

// Verifica se a consulta foi executada com sucesso e se encontrou um registro correspondente
if ($resultado && $resultado->num_rows > 0) {
    // Autenticação bem-sucedida
    $_SESSION['usuario'] = $usuario; // Armazena o nome de usuário na sessão (pode ser usado para autenticação em páginas subsequentes)
    header("Location: ../Paginas/PaginaPrincipal.html"); // Redireciona para a página principal
    exit();
} else {
    // Autenticação falhou
    header("Location: ../Paginas/login.html"); // Redireciona de volta para a página de login
    exit();
}

// Fecha a conexão após o uso
$conexao->close();
?>
