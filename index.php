<?php 
    include('./db/conexao.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumassali | Tabela de Preços</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .carimbo {
            position: fixed;
            bottom: 10px;
            left: 10px;
            height: 325px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">TABELA DE PREÇOS*</h1>
    <div class="container">
        <div class="column">
            <?php 
                for ($i=1; $i <= 2; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND orderProduto = $j;";
                            $result2 = $con->query($sql2);
                            if ($result2->num_rows > 0) {
                                $row2 = $result2->fetch_assoc();
                                echo "<div class=\"item\"><span>". $row2['nomeproduto'] . "</span><span>". $row2['precoProduto'] . "€</span></div>";
                            }
                        }
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <div class="column">
            <?php 
                for ($i=3; $i <= 5; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND orderProduto = $j;";
                            $result2 = $con->query($sql2);
                            if ($result2->num_rows > 0) {
                                $row2 = $result2->fetch_assoc();
                                echo "<div class=\"item\"><span>". $row2['nomeproduto'] . "</span><span>". $row2['precoProduto'] . "€</span></div>";
                            }
                        }
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <div class="column">
            <?php 
                for ($i=6; $i <= 9; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND orderProduto = $j;";
                            $result2 = $con->query($sql2);
                            if ($result2->num_rows > 0) {
                                $row2 = $result2->fetch_assoc();
                                echo "<div class=\"item\"><span>". $row2['nomeproduto'] . "</span><span>". $row2['precoProduto'] . "€</span></div>";
                            }
                        }
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <div class="column">
            <?php 
                for ($i=10; $i <= 14; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND orderProduto = $j;";
                            $result2 = $con->query($sql2);
                            if ($result2->num_rows > 0) {
                                $row2 = $result2->fetch_assoc();
                                echo "<div class=\"item\"><span>". $row2['nomeproduto'] . "</span><span>". $row2['precoProduto'] . "€</span></div>";
                            }
                        }
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>
    <h2 style="text-align: center;">VENDA AO BALCÃO</h2>
    <div class="container2">
        <div class="column">
            <?php 
                for ($i=15; $i <= 16; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND orderProduto = $j;";
                            $result2 = $con->query($sql2);
                            if ($result2->num_rows > 0) {
                                $row2 = $result2->fetch_assoc();
                                echo "<div class=\"item\"><span>". $row2['nomeproduto'] . "</span><span>". $row2['precoProduto'] . "€</span></div>";
                            }
                        }
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <img src="images/carimbo.jpg" class="carimbo" alt="Carimbo">
        <div class="column">
            <?php 
                for ($i=17; $i <= 19; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND orderProduto = $j;";
                            $result2 = $con->query($sql2);
                            if ($result2->num_rows > 0) {
                                $row2 = $result2->fetch_assoc();
                                echo "<div class=\"item\"><span>". $row2['nomeproduto'] . "</span><span>". $row2['precoProduto'] . "€</span></div>";
                            }
                        }
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>
    <script>
        let versaoAtual = null;

        async function checkUpdate() {
        try {
            const res = await fetch("/lumassali/versao.json?cache=" + Date.now());
            const data = await res.json();

            if (versaoAtual === null) {
            versaoAtual = data.versao;
            return;
            }

            if (data.versao !== versaoAtual) {
            console.log("Atualização detetada → reload");
            location.reload();
            }
        } catch (err) {
            console.error("Erro ao verificar versão", err);
        }
        }

        // verifica a cada 5 segundos
        setInterval(checkUpdate, 5000);
    </script>
</body>
</html>