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
            <li class="nav-item"><a href="/Paginas/CadastroDeProdutos.php" class="nav-link">Cadastro</a></li>
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
<body class="mx-0 mt-0 px-0 pt-0">
    <form class="mx-5" action="../Back-End/Arquivos/inserirArquivos.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="formGroupExampleInput2">Nome do Arquivo</label>
            <input type="text" class="form-control" placeholder="Nome do Arquivo" name="nomeArquivo" required>
        </div>
        <div class="form-group mb-3 mt-3">
            <label for="exampleFormControlFile1">Upload do Arquivo</label>
            <input type="file" class="form-control p-1" name="uploadArquivo">
        </div>
        <div class="row mb-3 d-flex justify-content-evenly mx-auto">
            <button type="submit" class="btn btn-primary btn-sm col-md-2 py-3 mt-3">Cadastrar PDF</button>
            <a href="../Paginas/PDF.php" class="btn btn-secondary btn-sm col-md-2 py-3 mt-3">Cancelar</a>
        </div>
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