<?php
// Conexão com o banco de dados
include("../conexao.php");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}


if (isset($_GET['pkCodArquivos'])) {
    $pkCodArquivos = $_GET['pkCodArquivos'];
    // Prepara e executa a consulta SQL para atualizar o arquivo
    $consulta = "SELECT imagemArquivo, nomeArquivo FROM tbArquivos WHERE pkCodArquivos = ?";
    $stmt = $conexao->prepare($consulta);
    $stmt->bind_param("i", $pkCodArquivos);

    if ($stmt->execute()) {
        $stmt->bind_result($imagemArquivo, $nomeArquivo);
        $stmt->fetch();
        $stmt->close();

        // Configura os cabeçalhos para o download ou visualização no navegador
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $nomeArquivo . '.pdf"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');

        // Exibe o arquivo PDF no navegador ou faz o download
        echo $imagemArquivo;
        $conexao->close();
    } else {
        echo "Erro na atualização: " . $stmt->error;
    }
}
else{
    echo "Erro ao carregar arquivo!";
}
// Fecha o statement e a conexão após o uso
$stmt->close();
$conexao->close();

?>
