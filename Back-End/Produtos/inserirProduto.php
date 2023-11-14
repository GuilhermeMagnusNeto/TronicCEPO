<?php
// Conexão com o banco de dados
include('../conexao.php');

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Recupere os valores do formulário
$marcaProd = $_POST['marca']; // Nome dos campos deve corresponder aos atributos 'name' do formulário
$modeloProd = $_POST['modelo'];
$corProd = $_POST['cor'];
$armazenamentoProd = (int)$_POST['armazenamento'];
$bateriaProd = (int)$_POST['bateria'];
$imeiProd = $_POST['imei'];
$memoriaRamProd = (int)$_POST['memoriaRam'];
$nomeAntigoDono = $_POST['nomeAntigoDono'];
$telefoneAntigoDono = $_POST['telefoneAntigoDono'];
$cpfAntigoDono = $_POST['cpfAntigoDono'];
$valorCompraProd = (float)$_POST['valorCompra'];
$observacaoProd = $_POST['observacao'];
$aquisicaoProd = $_POST['aquisicao'];
$dataProd = $_POST['data'];
if($dataProd == null){
    $dataProd = date('Y-m-d');
}
$nomeAntigoDono = $_POST['nomeAntigoDono'];
$telefoneAntigoDono = $_POST['telefoneAntigoDono'];
$cpfAntigoDono = $_POST['cpfAntigoDono'];

// Verifica se o arquivo foi enviado com sucesso
if ($_FILES['uploadArquivo']['error'] !== UPLOAD_ERR_OK) {
    $arquivo = null;
}
else{
    // Caminho temporário do arquivo no servidor
    $caminhoArquivo = $_FILES['uploadArquivo']['tmp_name'];
    // Lê o conteúdo da imagem em uma variável
    $arquivo = file_get_contents($caminhoArquivo);
}

if($aquisicaoProd == "option1"){
    $aquisicaoProd = 1;
}
elseif($aquisicaoProd == "option2"){
    $aquisicaoProd = 2;
}
elseif($aquisicaoProd == "option3"){
    $aquisicaoProd = 3;
}

if ($nomeAntigoDono != null && $cpfAntigoDono != null) {
    $consulta = $conexao->prepare("SELECT * FROM tbAntigoDono WHERE cpfAntigoDono = ?");
    $consulta->bind_param("s", $cpfAntigoDono);

    // Executa a consulta
    if ($consulta->execute()) {
        // Verifica o número de linhas retornadas
        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {
            // Existem resultados, faça algo com os resultados aqui
            while ($linha = $resultado->fetch_assoc()) {
                $fkCodAntigoDono = $linha['pkCodAntigoDono'];
            }
            // Prepara e executa a consulta SQL usando prepared statements
            $consulta = $conexao->prepare("INSERT INTO tbProdutos (marcaProd, modeloProd, corProd, armazenamentoProd, bateriaProd, imeiProd, memoriaRamProd, valorCompraProd, observacaoProd, aquisicaoProd, dataProd, CompraVendaProd, fkCodAntigoDono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $consulta->bind_param("sssiisidssssi", $marcaProd, $modeloProd, $corProd, $armazenamentoProd, $bateriaProd, $imeiProd, $memoriaRamProd, $valorCompraProd, $observacaoProd, $aquisicaoProd, $dataProd, $arquivo, $fkCodAntigoDono);

            if ($consulta->execute()) {
                echo "Produto cadastrado com sucesso!!!";
                if ($_FILES['uploadImagem']['error'][0] !== UPLOAD_ERR_OK) {
                    header("Location: ../../Paginas/ListaDeProdutos.php");
                } else {
                    $fkCodProd = $consulta->insert_id;
                    if ($_FILES['uploadImagem']['error'][0] !== UPLOAD_ERR_OK) {
                        //não faz nada
                    } else {
                        //cadastra imagens no banco de dados

                        // Caminhos temporários dos arquivos no servidor
                        $caminhosImagens = $_FILES['uploadImagem']['tmp_name'];

                        // Nomes originais dos arquivos
                        $nomesImagens = $_FILES['uploadImagem']['name'];

                        // Itera sobre os caminhos temporários
                        for ($i = 0; $i < count($caminhosImagens); $i++) {
                            // Lê o conteúdo da imagem em uma variável
                            $conteudoImagem = file_get_contents($caminhosImagens[$i]);

                            // Nome da imagem original
                            $nomeImagem = $nomesImagens[$i];

                            // Insere no banco de dados
                            $consultaImagem = $conexao->prepare("INSERT INTO tbImagemProduto (nomeImagem, imagem, fkCodProd) VALUES (?, ?, ?)");
                            if (!$consultaImagem) {
                                die("Erro na preparação da consulta: " . $conexao->error);
                            }
                            
                            $consultaImagem->bind_param("sss", $nomeImagem, $conteudoImagem, $fkCodProd);

                            // Executa a consulta
                            if ($consultaImagem->execute()) {
                                echo "Imagem cadastrada com sucesso!";
                                header("Location: ../../Paginas/ListaDeProdutos.php"); // Redireciona
                            } else {
                                echo "Erro no cadastro da imagem: " . $consultaImagem->error;
                                header("Location: ../../Paginas/CadastroDeProdutos.php"); // Redireciona
                            }

                            // Fecha a consulta
                            $consultaImagem->close();
                        }
                    }
                }
            } else {
                echo "Erro no cadastro do produto: " . $consulta->error;
            }
            // Fecha a conexão após o uso
            $conexao->close();
        } else {
            // NÃO HÁ ANTIGOS DONOS NO BANCO DE DADOS
            $consulta = $conexao->prepare("INSERT INTO tbAntigoDono (nomeAntigoDono, telefoneAntigoDono, cpfAntigoDono) VALUES (?, ?, ?)");
            $consulta->bind_param("sss", $nomeAntigoDono, $telefoneAntigoDono, $cpfAntigoDono);

            if ($consulta->execute()) {
                // Obtém o resultado
                $fkCodAntigoDono = $consulta->insert_id;

                // Prepara e executa a consulta SQL usando prepared statements
                $consulta = $conexao->prepare("INSERT INTO tbProdutos (marcaProd, modeloProd, corProd, armazenamentoProd, bateriaProd, imeiProd, memoriaRamProd, valorCompraProd, observacaoProd, aquisicaoProd, dataProd, CompraVendaProd, fkCodAntigoDono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $consulta->bind_param("sssiisidssssi", $marcaProd, $modeloProd, $corProd, $armazenamentoProd, $bateriaProd, $imeiProd, $memoriaRamProd, $valorCompraProd, $observacaoProd, $aquisicaoProd, $dataProd, $arquivo, $fkCodAntigoDono);

                if ($consulta->execute()) {
                    echo "Produto cadastrado com sucesso!!!";
                    if ($_FILES['uploadImagem']['error'][0] !== UPLOAD_ERR_OK) {
                        header("Location: ../../Paginas/ListaDeProdutos.php");
                    } else {
                        $fkCodProd = $consulta->insert_id;
                        if ($_FILES['uploadImagem']['error'][0] !== UPLOAD_ERR_OK) {
                            //não faz nada
                        } else {
                            //cadastra imagens no banco de dados

                            // Caminhos temporários dos arquivos no servidor
                            $caminhosImagens = $_FILES['uploadImagem']['tmp_name'];

                            // Nomes originais dos arquivos
                            $nomesImagens = $_FILES['uploadImagem']['name'];

                            // Itera sobre os caminhos temporários
                            for ($i = 0; $i < count($caminhosImagens); $i++) {
                                // Lê o conteúdo da imagem em uma variável
                                $conteudoImagem = file_get_contents($caminhosImagens[$i]);

                                // Nome da imagem original
                                $nomeImagem = $nomesImagens[$i];

                                // Insere no banco de dados
                                $consultaImagem = $conexao->prepare("INSERT INTO tbImagemProduto (nomeImagem, imagem, fkCodProd) VALUES (?, ?, ?)");
                                if (!$consultaImagem) {
                                    die("Erro na preparação da consulta: " . $conexao->error);
                                }
                                
                                $consultaImagem->bind_param("sss", $nomeImagem, $conteudoImagem, $fkCodProd);

                                // Executa a consulta
                                if ($consultaImagem->execute()) {
                                    echo "Imagem cadastrada com sucesso!";
                                    header("Location: ../../Paginas/ListaDeProdutos.php"); // Redireciona
                                } else {
                                    echo "Erro no cadastro da imagem: " . $consultaImagem->error;
                                    header("Location: ../../Paginas/CadastroDeProdutos.php"); // Redireciona
                                }

                                // Fecha a consulta
                                $consultaImagem->close();
                            }
                        }
                    }
                } else {
                    echo "Erro no cadastro do produto: " . $consulta->error;
                }
                // Fecha a conexão após o uso
                $conexao->close();
            } else {
                // Erro na execução da consulta
                echo "Erro no cadastro do antigo dono: " . $consulta->error;
            }
        }
    } else {
        // Erro na execução da consulta
        echo "Erro na consulta: " . $consulta->error;
    }

    // Fecha a consulta
    $consulta->close();
}
else{
    //não tem antigo dono
    $fkCodAntigoDono = 1;
    // Prepara e executa a consulta SQL usando prepared statements
    $consulta = $conexao->prepare("INSERT INTO tbProdutos (marcaProd, modeloProd, corProd, armazenamentoProd, bateriaProd, imeiProd, memoriaRamProd, valorCompraProd, observacaoProd, aquisicaoProd, dataProd, CompraVendaProd, fkCodAntigoDono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $consulta->bind_param("sssiisidssssi", $marcaProd, $modeloProd, $corProd, $armazenamentoProd, $bateriaProd, $imeiProd, $memoriaRamProd, $valorCompraProd, $observacaoProd, $aquisicaoProd, $dataProd, $arquivo, $fkCodAntigoDono);

    if ($consulta->execute()) {
        $fkCodProd = $consulta->insert_id;
        if ($_FILES['uploadImagem']['error'][0] !== UPLOAD_ERR_OK) {
            header("Location: ../../Paginas/ListaDeProdutos.php");
        } else {
            //cadastra imagens no banco de dados

            // Caminhos temporários dos arquivos no servidor
            $caminhosImagens = $_FILES['uploadImagem']['tmp_name'];

            // Nomes originais dos arquivos
            $nomesImagens = $_FILES['uploadImagem']['name'];

            // Itera sobre os caminhos temporários
            for ($i = 0; $i < count($caminhosImagens); $i++) {
                // Lê o conteúdo da imagem em uma variável
                $conteudoImagem = file_get_contents($caminhosImagens[$i]);

                // Nome da imagem original
                $nomeImagem = $nomesImagens[$i];

                // Insere no banco de dados
                $consultaImagem = $conexao->prepare("INSERT INTO tbImagemProduto (nomeImagem, imagem, fkCodProd) VALUES (?, ?, ?)");
                if (!$consultaImagem) {
                    die("Erro na preparação da consulta: " . $conexao->error);
                }
                
                $consultaImagem->bind_param("sss", $nomeImagem, $conteudoImagem, $fkCodProd);

                // Executa a consulta
                if ($consultaImagem->execute()) {
                    echo "Imagem cadastrada com sucesso!";
                    header("Location: ../../Paginas/ListaDeProdutos.php"); // Redireciona
                } else {
                    echo "Erro no cadastro da imagem: " . $consultaImagem->error;
                    header("Location: ../../Paginas/CadastroDeProdutos.php"); // Redireciona
                }

                // Fecha a consulta
                $consultaImagem->close();
            }
        }
    } else {
        echo "Erro na consulta: " . $consulta->error;
    }

    // Fecha a conexão após o uso
    $conexao->close();
}
?>
