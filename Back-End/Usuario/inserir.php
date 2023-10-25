<?php
// Conexão com o banco de dados
$conexao = new mysqli("sql10.freesqldatabase.com", "sql10653561", "bibYa74ZeN", "sql10653561");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Dados do novo usuário
$nomeUsu = "Leonardo";  // Nome
$senhaUsu = "teste1234"; // Senha (deve ser tratada com hash)
$nivelAcessoUsu = 3; // Nível de acesso

// Hash da senha
$senhaHash = password_hash($senhaUsu, PASSWORD_DEFAULT);

// Prepara e executa a consulta SQL usando prepared statements
$consulta = $conexao->prepare("INSERT INTO tbUsuario(nomeUsu, senhaUsu, nivelAcessoUsu) VALUES(?, ?, ?)");
$consulta->bind_param("ssi", $nomeUsu, $senhaHash, $nivelAcessoUsu);

if ($consulta->execute()) {
    echo "Usuário cadastrado com sucesso!!!";
} else {
    echo "Erro na consulta: " . $consulta->error;
}

// Fecha a conexão após o uso
$conexao->close();
?>
