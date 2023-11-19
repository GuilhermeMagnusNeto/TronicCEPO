<?php
session_start();
// Conexão com o banco de dados
include('../conexao.php');

$usuario = $_POST['login'];
$senha = $_POST['senha'];

// Por algo assim:
$consulta = $conexao->prepare("SELECT * FROM tbUsuario WHERE nomeUsu = ?");
$consulta->bind_param("s", $usuario);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado && $resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    if (password_verify($senha, $row['senhaUsu'])) {
        $_SESSION['usuario'] = $row['pkCodUsu']; // Armazena o nome de usuário na sessão (pode ser usado para autenticação em páginas subsequentes)
        header("Location: ../../Paginas/PaginaPrincipal.php"); // Redireciona para a página principal
        exit();
    } else {
        // Senha incorreta
        header("Location: ../../Paginas/Login.html"); // Redireciona de volta para a página de login
        exit();
    }
}
?>
