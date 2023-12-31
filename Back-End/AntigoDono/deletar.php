<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Defina as informações de exclusão
$pkCodUsu = 1; // codigo do antigo dono que deseja excluir

// Prepara e executa a consulta SQL para excluir o antigo dono usando prepared statement
$consulta = "DELETE FROM tbAntigoDono WHERE pkCodAntigoDono = ?";
$stmt = $conexao->prepare($consulta);
$stmt->bind_param("i", $pkCodUsu);

if ($stmt->execute()) {
    echo "Registro excluído com sucesso.";
} else {
    echo "Erro na exclusão: " . $stmt->error;
}

// Fecha o statement e a conexão após o uso
$stmt->close();
$conexao->close();
?>
