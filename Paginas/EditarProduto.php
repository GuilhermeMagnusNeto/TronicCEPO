<?php
session_start();
include('../Back-End/conexao.php');

// Verifique se o usuário está logado
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    // Realize uma consulta para verificar se o usuário ainda existe no banco de dados
    $consulta = "SELECT * FROM tbUsuario WHERE pkCodUsu = '$usuario'";
    $resultado = $conexao->query($consulta);
    
    if (!$resultado || $resultado->num_rows === 0) {
        // Usuário não encontrado no banco de dados, destrua a sessão
        session_destroy();
        header("Location: ../Paginas/Login.html");
        exit();
    }
} else {
    // Se a sessão não existe, redirecione para a página de login
    header("Location: ../Paginas/Login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tronic</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>

<!-- CABEÇALHO -->
<div class="container mt-3 my-2">
    <header class="d-flex flex-wrap justify-content-center py-3 mb- border-bottom pt-0">
        <a href="/Paginas/PaginaPrincipal.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href=""/></svg>
            <img src="../Imagens/LogoTronic.png" alt="Logo da loja Tronic" id="LogoTronic" height="35">
        </a>
    
        <ul class="nav nav-pills mx-auto">
            <li class="nav-item"><a href="/Paginas/PaginaPrincipal.php" class="nav-link" aria-current="page">Principal</a></li>
            <li class="nav-item"><a href="/Paginas/ListaDeProdutos.php" class="nav-link">Produtos</a></li>
            <li class="nav-item"><a href="/Paginas/CadastroDeProdutos.php" class="nav-link active">Cadastro</a></li>
        </ul>
        <div class="dropdown text-end my-auto mx-auto">
            <a href="" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../Imagens/DIGITAL.png" alt="icone de uma digital" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small">
                <li><a class="dropdown-item" href="../Paginas/Funcionarios.php">Funcionários</a></li>
                <li><a class="dropdown-item" href="../Paginas/PDF.php">PDF</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="">Sign out</a></li>
            </ul>
        </div>
    </header>
</div>

<!-- CORPO -->
<body class="mx-auto mt-0 px-0 pt-0">
    <img src="../Imagens/BannerHeader.jpeg" class="d-flex align-items-center mb-3 w-100">
    <form class="mx-5" action="../Back-End/Produtos/editarProduto.php" method="post">
        <?php
            if (isset($_GET['pkCodProd'])) {
                $pkCodProd = $_GET['pkCodProd'];

                $consultaProdutos = "SELECT * FROM tbProdutos where pkCodProd = $pkCodProd";
                $consultaProdutos = $conexao->query($consultaProdutos);
                $linha = $consultaProdutos->fetch_assoc();

                if ($linha > 0) {
                    echo "<div class='form-group mb-3'>";
                        echo "<input type='hidden' name='pkCodProd' value=' ". $linha["pkCodProd"] . "'>";
                        echo "<label for='formGroupExampleInput'>Marca</label>";
                        //SELECIONAR MARCA COM selected
                        echo "<select class='form-control' name='marca' required>";
                        if($linha["marcaProd"] == "Apple"){
                            echo "<option selected>Apple</option>";
                        }
                        else{
                            echo "<option>Apple</option>";
                        }
                        if($linha["marcaProd"] == "Samsung"){
                            echo "<option selected>Samsung</option>";
                        }
                        else{
                            echo "<option>Samsung</option>";
                        }
                        if($linha["marcaProd"] == "Xiaomi"){
                            echo "<option selected>Xiaomi</option>";
                        }
                        else{
                            echo "<option>Xiaomi</option>";
                        }
                        if($linha["marcaProd"] == "Motorola"){
                            echo "<option selected>Motorola</option>";
                        }
                        else{
                            echo "<option>Motorola</option>";
                        }
                        if($linha["marcaProd"] == "LG"){
                            echo "<option selected>LG</option>";
                        }
                        else{
                            echo "<option>LG</option>";
                        }
                        if($linha["marcaProd"] == "Outra"){
                            echo "<option selected>Outra</option>";
                        }
                        else{
                            echo "<option>Outra</option>";
                        }
                        echo "</select>";
                    echo "</div>";
                    //LISTAR MODELO
                    echo "<div class='form-group'>";
                        echo "<label for='formGroupExampleInput2'>Modelo</label>";
                        echo "<input type='text' class='form-control' id='formGroupExampleInput2' placeholder='iPhone 14' name='modelo'  value = '". $linha["modeloProd"] ."' required>";
                    echo "</div>";
                    //LISTAR COR
                    echo "<div class='row'>";
                        echo "<div class='form-group col-md mt-3'>";
                            echo "<label for='formGroupExampleInput2'>Cor</label>";
                            echo "<input type='text' class='form-control' id='formGroupExampleInput2' placeholder='Preto' name='cor' value = '". $linha["corProd"] ."' required>";
                        echo "</div>";
                        //SELECIONAR ARMAZENAMENTO COM selected
                        echo "<div class='form-group col-md mt-3'>";
                            echo "<label for='formGroupExampleInput2'>Armazenamento</label>";
                            echo "<select class='form-control' name='armazenamento' required>";
                            if($linha["armazenamentoProd"] == "0"){
                                echo "<option selected>0</option>";
                            }
                            else{
                                echo "<option>0</option>";
                            }
                            if($linha["armazenamentoProd"] == "32"){
                                echo "<option selected>32</option>";
                            }
                            else{
                                echo "<option>32</option>";
                            }
                            if($linha["armazenamentoProd"] == "64"){
                                echo "<option selected>64</option>";
                            }
                            else{
                                echo "<option>64</option>";
                            }
                            if($linha["armazenamentoProd"] == "128"){
                                echo "<option selected>128</option>";
                            }
                            else{
                                echo "<option>128</option>";
                            }
                            if($linha["armazenamentoProd"] == "256"){
                                echo "<option selected>256</option>";
                            }
                            else{
                                echo "<option>256</option>";
                            }
                            if($linha["armazenamentoProd"] == "512"){
                                echo "<option selected>512</option>";
                            }
                            else{
                                echo "<option>512</option>";
                            }
                            if($linha["armazenamentoProd"] == "1"){
                                echo "<option selected>1</option>";
                            }
                            else{
                                echo "<option>1</option>";
                            }
                            echo "</select>";
                        echo "</div>";
                    echo "</div>";
                    echo "<div class='row mb-3'>";
                        //LISTAR BATERIA
                        echo "<div class='form-group col-md mt-3'>";
                            echo "<label for='formGroupExampleInput2'>Procentagem da Bateria</label>";
                            echo "<input type='number' min='0' max='100' class='form-control' id='formGroupExampleInput2' placeholder='100' name='bateria' value = '". $linha["bateriaProd"] ."'>";
                        echo "</div>";
                        //LISTAR MEMORIA RAM
                        echo "<div class='form-group col-md mt-3'>";
                            echo "<label for='formGroupExampleInput2'>Memória RAM</label>";
                            echo "<input type='number' min='0' class='form-control' id='formGroupExampleInput2' placeholder='8' name='memoriaRam' value = '". $linha["memoriaRamProd"] ."'>";
                        echo "</div>";
                    echo "</div>";
                    //LISTAR OBSERVAÇÃO
                    echo "<div class='form-group mb-3'>";
                        echo "<label for='formGroupExampleInput2'>Observação</label>";
                        echo "<input type='text' maxlength='200' class='form-control' id='formGroupExampleInput2' placeholder='Bateria trocada' name='observacao' value = '". $linha["observacaoProd"] ."'>";
                    echo "</div>";
                    echo "<div class='row mb-3 d-flex justify-content-evenly mx-auto'>";
                        echo "<button type='submit' class='btn btn-primary btn-sm col-md-2 py-3 mt-3'>Editar Celular</button>";
                        echo "<a href='../Paginas/ListaDeProdutos.php' class='btn btn-secondary btn-sm col-md-2 py-3 mt-3'>Cancelar</a>";
                        echo "<a href='../Back-End/Produtos/DeletarProduto.php?pkCodProd=" . $linha["pkCodProd"] . "' class='btn btn-danger btn-sm col-md-2 py-3 mt-3'>Deletar Celular</a>";
                    echo "</div>";
                }
                else {
                    echo "Erro na pesquisa do produto!";
                }
            }
        ?>
    </form>
</body>

<!-- RODAPE -->
<div class="mx-0 px-0">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top px-5">
        <p class="col-md-4 mb-0 text-body-secondary">© 2023 Tronic, Inc</p>
        
        <a href="/Paginas/PaginaPrincipal.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <img src="../Imagens/LogoTronic.png" class="bi mx-auto" width="100"></img>
        </a>
        
        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="/Paginas/PaginaPrincipal.php" class="nav-link px-2 text-body-secondary">Principal</a></li>
            <li class="nav-item"><a href="/Paginas/ListaDeProdutos.php" class="nav-link px-2 text-body-secondary">Produtos</a></li>
            <li class="nav-item"><a href="/Paginas/CadastroDeProdutos.php" class="nav-link px-2 text-body-secondary">Cadastro</a></li>
        </ul>
    </footer>
</div>

</html>