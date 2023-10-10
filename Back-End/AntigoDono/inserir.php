<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Dados do novo usuário
$nomeAntigoDono = "Guilherme";  // Nome
$telefoneAntigoDono = "51983475050"; // Telefone
$cpfAntigoDono = "04055437005"; // CPF

// Prepara e executa a consulta SQL usando prepared statements
$consulta = $conexao->prepare("INSERT INTO tbAntigoDono (nomeAntigoDono, telefoneAntigoDono, cpfAntigoDono) VALUES (?, ?, ?)");
$consulta->bind_param("sss", $nomeAntigoDono, $telefoneAntigoDono, $cpfAntigoDono);

if ($consulta->execute()) {
    echo "Antigo Dono cadastrado com sucesso!!!";
} else {
    echo "Erro na consulta: " . $consulta->error;
}

// Fecha a conexão após o uso
$conexao->close();
?>
