<?php
// Conexão com o banco de dados
include('../conexao.php');

// Recupere os valores do formulário
$marcaProd = $_POST['marca']; // Nome dos campos deve corresponder aos atributos 'name' do formulário
$modeloProd = $_POST['modelo'];
$corProd = $_POST['cor'];
$armazenamentoProd = (int)$_POST['armazenamento']; // Converta para inteiro
$bateriaProd = (int)$_POST['bateria'];
$imeiProd = $_POST['imei'];
$memoriaRamProd = (int)$_POST['memoriaRam'];
$valorCompraProd = (float)$_POST['valorCompra']; // Converta para ponto flutuante
$observacaoProd = $_POST['observacao'];
$aquisicaoProd = $_POST['aquisicao'];
$dataProd = $_POST['data'];
$fkCodAntigoDono = (int)$_POST['fkCodAntigoDono'];

// Caminho para o arquivo de imagem (se estiver usando upload de imagem)
$caminhoImagem = $_FILES['imagem']['tmp_name']; // Deve corresponder ao atributo 'name' do input de imagem

// Lê o conteúdo do arquivo de imagem
$imagem = file_get_contents($caminhoImagem);

// Prepara e executa a consulta SQL usando prepared statements
$consulta = $conexao->prepare("INSERT INTO tbProdutos (marcaProd, modeloProd, corProd, armazenamentoProd, bateriaProd, imeiProd, memoriaRamProd, valorCompraProd, observacaoProd, aquisicaoProd, dataProd, CompraVendaProd, fkCodAntigoDono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$consulta->bind_param("sssiisidssssi", $marcaProd, $modeloProd, $corProd, $armazenamentoProd, $bateriaProd, $imeiProd, $memoriaRamProd, $valorCompraProd, $observacaoProd, $aquisicaoProd, $dataProd, $imagem, $fkCodAntigoDono);

if ($consulta->execute()) {
    echo "Produto cadastrado com sucesso!!!";
    header("Location: ../../Paginas/PaginaPrincipal.php"); // Redireciona para a página principal
} else {
    echo "Erro na consulta: " . $consulta->error;
    header("Location: ../../Paginas/Funcionarios.html"); // Redireciona
}

// Fecha a conexão após o uso
$conexao->close();
?>
