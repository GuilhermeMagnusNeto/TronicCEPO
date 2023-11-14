<?php
// // Conexão com o banco de dados
include('../conexao.php');

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Dados do novo arquivo
$nomeArquivo = $_POST['nomeArquivo'];  // Nome do Arquivo

// Verifica se o arquivo foi enviado com sucesso
if ($_FILES['uploadArquivo']['error'] !== UPLOAD_ERR_OK) {
    die("Erro no upload do arquivo: " . $_FILES['uploadArquivo']['error']);
}

// Caminho temporário do arquivo no servidor
$caminho_temporario = $_FILES['uploadArquivo']['tmp_name'];

// Lê o conteúdo da imagem em uma variável
$imagemArquivo = file_get_contents($caminho_temporario);

// Prepara e executa a consulta SQL usando prepared statements
$consulta = $conexao->prepare("INSERT INTO tbArquivos (nomeArquivo, imagemArquivo) VALUES ( ?, ?)");
$consulta->bind_param("ss", $nomeArquivo, $imagemArquivo);

if ($consulta->execute()) {
    echo "Arquivo cadastrado com sucesso!!!";
} else {
    echo "Erro na consulta: " . $consulta->error;
}

// Fecha a conexão após o uso
$conexao->close();
?>
