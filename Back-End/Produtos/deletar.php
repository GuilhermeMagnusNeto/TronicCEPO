<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Defina as informações de exclusão
$pkCodProd = 1; // codigo do produto que deseja excluir

// Prepara e executa a consulta SQL para excluir o produto usando prepared statement
$consulta = "DELETE FROM tbProdutos WHERE pkCodProd = ?";
$stmt = $conexao->prepare($consulta);
$stmt->bind_param("i", $pkCodProd);

if ($stmt->execute()) {
    echo "Registro excluído com sucesso.";
} else {
    echo "Erro na exclusão: " . $stmt->error;
}

// Fecha o statement e a conexão após o uso
$stmt->close();
$conexao->close();
?>
