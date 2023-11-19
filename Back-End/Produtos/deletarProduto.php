<?php
// Conexão com o banco de dados
include("../conexao.php");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

if (isset($_GET['pkCodProd'])) {
    $pkCodProd = $_GET['pkCodProd'];

    // Prepara e executa a consulta SQL para excluir o produto usando prepared statement
    $consulta = "DELETE FROM tbProdutos WHERE pkCodProd = ?";
    $stmt = $conexao->prepare($consulta);
    $stmt->bind_param("i", $pkCodProd);

    if ($stmt->execute()) {
        echo "Registro excluído com sucesso.";
        header("Location: ../../Paginas/ListaDeProdutos.php");
    } else {
        echo "Erro na exclusão: " . $stmt->error;
    }

    // Fecha o statement e a conexão após o uso
    $stmt->close();
    $conexao->close();
} 
else {
    echo "Erro na exclusão!";
}
?>
