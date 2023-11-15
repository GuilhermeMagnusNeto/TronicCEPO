<?php
// Conexão com o banco de dados
include("../conexao.php");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Deletar arquivo usando o parâmetro na URL
if (isset($_GET['pkCodUsu'])) {
    $pkCodUsu = $_GET['pkCodUsu'];

    // Prepara e executa a consulta SQL para excluir o usuário usando prepared statement
    $consulta = "DELETE FROM tbUsuario WHERE pkCodUsu = ?";
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
}
?>
