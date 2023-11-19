<?php
// Conexão com o banco de dados
include("../conexao.php");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}


$pkCodProd = $_POST['pkCodProd'];
$marcaProd = $_POST['marca']; 
$modeloProd = $_POST['modelo'];
$corProd = $_POST['cor']; 
$armazenamentoProd = $_POST['armazenamento'];
$bateriaProd = $_POST['bateria'];
$memoriaRamProd = $_POST['memoriaRam'];
$observacaoProd = $_POST['observacao'];

// Prepara e executa a consulta SQL para atualizar o produto
$consulta = "UPDATE tbProdutos SET marcaProd = ?, modeloProd = ?, corProd = ?, armazenamentoProd = ?, bateriaProd = ?, memoriaRamProd = ?, observacaoProd = ? WHERE pkCodProd >= ?";
$stmt = $conexao->prepare($consulta);
$stmt->bind_param("sssiiisi", $marcaProd, $modeloProd, $corProd, $armazenamentoProd, $bateriaProd, $memoriaRamProd, $observacaoProd, $pkCodProd);

if ($stmt->execute()) {
    echo "Registro atualizado com sucesso.";
    header("Location: ../../Paginas/ListaDeProdutos.php");
} else {
    echo "Erro na atualização: " . $stmt->error;
}

// Fecha o statement e a conexão após o uso
$stmt->close();
$conexao->close();
?>
