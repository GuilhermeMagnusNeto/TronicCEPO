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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</head>

<!-- CABEÇALHO -->
<div class="container mt-3 my-2">
    <header class="d-flex flex-wrap justify-content-center py-3 mb- border-bottom pt-0">
        <a href="/Paginas/PaginaPrincipal.html"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="" />
            </svg>
            <img src="../Imagens/LogoTronic.png" alt="Logo da loja Tronic" id="LogoTronic" height="35">
        </a>

        <ul class="nav nav-pills mx-auto mb-">
            <li class="nav-item"><a href="/Paginas/PaginaPrincipal.html" class="nav-link"
                    aria-current="page">Principal</a></li>
            <li class="nav-item"><a href="/Paginas/ListaDeProdutos.html" class="nav-link">Produtos</a></li>
            <li class="nav-item"><a href="/Paginas/CadastroDeProdutos.html" class="nav-link">Cadastro</a></li>
        </ul>
        <div class="dropdown text-end my-auto mx-auto">
            <a href="" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="../Imagens/DIGITAL.png" alt="icone de uma digital" width="32" height="32"
                    class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small">
                <li><a class="dropdown-item" href="../Paginas/Funcionarios.html">Funcionários</a></li>
                <li><a class="dropdown-item" href="../Paginas/PDF.html">PDF</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="">Sign out</a></li>
            </ul>
        </div>
    </header>
</div>

<!-- CORPO -->

<body class="mx-auto mt-0 px-0 pt-0">
    <form class="mx-4" action="../Back-End/Usuario/editarFuncionario.php" method="post">
        <?php
            // Consulta SQL para obter todos os usuarios
            if (isset($_GET['pkCodUsu'])) {
                $pkCodUsu = $_GET['pkCodUsu'];

                $consultaUsuarios = "SELECT * FROM tbUsuario where pkCodUsu = $pkCodUsu";
                $consultaUsuarios = $conexao->query($consultaUsuarios);
                $linha = $consultaUsuarios->fetch_assoc();

                if ($linha > 0) {
                    echo "<input type='hidden' name='pkCodUsu' value=' ". $linha["pkCodUsu"] . "'>";
                    echo "<div class='form-group mb-3'>";
                    echo "<label for='exampleInputEmail1'>Nome</label>";
                    echo "<input type='text' name='nome' class='form-control' placeholder='Nome do Funcionário' value = '". $linha["nomeUsu"] ."'>";
                    echo "</div>";
                    echo "<div class='form-group mb-3'>";
                        echo "<label for='Cargo'>Cargo</label>";
                        echo "<input type='text' name='cargo' class='form-control' placeholder='Cargo do Funcionário' value = '". $linha["cargoUsu"] ."'>";
                    echo "</div>";
                    echo "<label>Acesso:</label>";
                    if($linha["nivelAcessoUsu"] == 3){
                        echo "<div class='form-check form-check-inline'>";
                        echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio1' value='simples'>";
                        echo "<label class='form-check-label' for='inlineRadio1'>Simples</label>";
                        echo "</div>";
                        echo "<div class='form-check form-check-inline'>";
                            echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio2' value='medio'>";
                            echo "<label class='form-check-label' for='inlineRadio2'>Medio</label>";
                        echo "</div>";
                        echo "<div class='form-check form-check-inline'>";
                            echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio3' value='completo' checked>";
                            echo "<label class='form-check-label' for='inlineRadio3'>Completo</label>";
                        echo "</div>";
                    }
                    elseif($linha["nivelAcessoUsu"] == 2){
                        echo "<div class='form-check form-check-inline'>";
                        echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio1' value='simples'>";
                        echo "<label class='form-check-label' for='inlineRadio1'>Simples</label>";
                        echo "</div>";
                        echo "<div class='form-check form-check-inline'>";
                            echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio2' value='medio' checked>";
                            echo "<label class='form-check-label' for='inlineRadio2'>Medio</label>";
                        echo "</div>";
                        echo "<div class='form-check form-check-inline'>";
                            echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio3' value='completo'>";
                            echo "<label class='form-check-label' for='inlineRadio3'>Completo</label>";
                        echo "</div>";
                    }
                    elseif($linha["nivelAcessoUsu"] == 1){
                        echo "<div class='form-check form-check-inline'>";
                        echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio1' value='simples' checked>";
                        echo "<label class='form-check-label' for='inlineRadio1'>Simples</label>";
                        echo "</div>";
                        echo "<div class='form-check form-check-inline'>";
                            echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio2' value='medio'>";
                            echo "<label class='form-check-label' for='inlineRadio2'>Medio</label>";
                        echo "</div>";
                        echo "<div class='form-check form-check-inline'>";
                            echo "<input class='form-check-input' type='radio' name='acesso' id='inlineRadio3' value='completo'>";
                            echo "<label class='form-check-label' for='inlineRadio3'>Completo</label>";
                        echo "</div>";
                    }
                    
                }
                else {
                    echo "Erro na pesquisa do funcionario!";
                }
            }
            else{
                echo "Nenhum Usuario selecionado!";
            }
        ?>
        <button type="submit" class="btn btn-primary my-3">Salvar</button>
    </form>
</body>

<!-- RODAPE -->
<div class="mx-0 px-0">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top px-5">
        <p class="col-md-4 mb-0 text-body-secondary">© 2023 Tronic, Inc</p>

        <a href="/Paginas/PaginaPrincipal.html"
            class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <img src="../Imagens/LogoTronic.png" class="bi mx-auto" width="100"></img>
        </a>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="/Paginas/PaginaPrincipal.html"
                    class="nav-link px-2 text-body-secondary">Principal</a></li>
            <li class="nav-item"><a href="/Paginas/ListaDeProdutos.html"
                    class="nav-link px-2 text-body-secondary">Produtos</a></li>
            <li class="nav-item"><a href="/Paginas/CadastroDeProdutos.html"
                    class="nav-link px-2 text-body-secondary">Cadastro</a></li>
        </ul>
    </footer>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var form = document.querySelector("form");

            form.addEventListener("submit", function (event) {
                var senha = form.querySelector("[name='senha']").value;
                var confirmarSenha = form.querySelector("[name='confirmarSenha']").value;
                var senhaError = document.getElementById("senhaError");

                if (senha !== confirmarSenha) {
                    senhaError.textContent = "Senhas diferentes!";
                    event.preventDefault(); // Impede o envio do formulário
                } else {
                    senhaError.textContent = ""; // Limpa a mensagem de erro
                }
            });
        });
    </script>

</html>