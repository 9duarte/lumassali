<?php 
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: login.php');
        exit();
    }

    include('./db/conexao.php');

    $sql = "SELECT * FROM administrator WHERE id = " . $_SESSION['id'] . " AND pass = '" . $_SESSION['password'] . "';";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        
    }
    else {
        header('Location: login.php');
        exit();
    }

    for ($i=1; $i <= 19; $i++) { 
        $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i;";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $numProdutos = $row['numProdutos'];
        }
        for ($j=1; $j <= $numProdutos; $j++) { 
            $input = $_POST['secao_' . $i . '_produto_' . $j];
            $sql = "UPDATE secoes_produtos SET precoProduto = $input WHERE orderSecao = $i AND orderProduto = $j;";
            $result = $con->prepare($sql);
            $result->execute();
        }
    }
    novaVersao();
    header('Location: admin.php');
?>