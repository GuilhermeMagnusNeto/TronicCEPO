<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Dados do novo arquivo
$nomeArquivo = "NOME DO ARQUIVO";  // Nome do Arquivo
// Caminho para a imagem
$caminho_da_imagem = '/Users/guilhermemagnus/Desktop/ProjetosVScode/TronicCEPO/Imagens/35432.png';
// Lê o conteúdo da imagem em uma variável
$imagemArquivo = file_get_contents($caminho_da_imagem);

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
