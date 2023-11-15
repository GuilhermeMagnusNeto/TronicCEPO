<?php
// Conexão com o banco de dados
include("../conexao.php");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Deletar arquivo usando o parâmetro na URL
if (isset($_GET['pkCodArquivos'])) {
    $pkCodArquivos = $_GET['pkCodArquivos'];

    // Prepara e executa a consulta SQL para excluir o arquivo usando prepared statement
    $consulta = "DELETE FROM tbArquivos WHERE pkCodArquivos = ?";
    $stmt = $conexao->prepare($consulta);
    $stmt->bind_param("i", $pkCodArquivos);

    if ($stmt->execute()) {
        echo "Registro excluído com sucesso.";
        header("Location: ../../Paginas/PDF.php");
    } else {
        echo "Erro na exclusão: " . $stmt->error;
    }

    // Fecha o statement e a conexão após o uso
    $stmt->close();
    $conexao->close();
}

?>
