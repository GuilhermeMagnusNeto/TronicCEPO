<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Defina as informações de atualização
$pkCodArquivos = 2; // Codigo arquivo 
$nomeArquivo = "TESTE"; // Atributo a ser atualizado

// Prepara e executa a consulta SQL para atualizar o arquivo
$consulta = "UPDATE tbArquivos SET nomeArquivo = ? WHERE pkCodArquivos >= ?";
$stmt = $conexao->prepare($consulta);
$stmt->bind_param("si", $nomeArquivo, $pkCodArquivos);

if ($stmt->execute()) {
    echo "Registro atualizado com sucesso.";
} else {
    echo "Erro na atualização: " . $stmt->error;
}

// Fecha o statement e a conexão após o uso
$stmt->close();
$conexao->close();
?>
