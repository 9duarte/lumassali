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
            top: 10px;
            left: 10px;
            height: 100px;   /* <-- muda este número para ajustar o tamanho do carimbo */
            z-index: 1000;
        }
        .footnotes {
            padding: 0 10px;
            text-align: left;
            font-size: 19px;
            font-weight: 700;
        }
        .footnotes p { margin: .2rem 0; }
    </style>
</head>
<body>
    <img src="images/carimbo.jpg" class="carimbo" alt="Carimbo">
    <h1 style="text-align: center;">TABELA DE PREÇOS*</h1>
    <div class="container">
        <div class="column">
            <?php 
                for ($i=1; $i <= 4; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1 LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1 AND orderProduto = $j;";
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
                for ($i=5; $i <= 8; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1 LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1 AND orderProduto = $j;";
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
                for ($i=9; $i <= 14; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1 LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1 AND orderProduto = $j;";
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
                for ($i=15; $i <= 19; $i++) { 
                    $sql = "SELECT COUNT(nomeProduto) as numProdutos FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $numProdutos = $row['numProdutos'];
                    }
                    $sql = "SELECT nomeSecao FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1 LIMIT 1;";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class=\"category\">";
                        echo "<h2>". $row['nomeSecao'] . "</h2>";
                        for ($j=1; $j <= $numProdutos; $j++) { 
                            $sql2 = "SELECT nomeproduto, precoProduto FROM secoes_produtos WHERE orderSecao = $i AND ativo = 1 AND orderProduto = $j;";
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
    <div class="footnotes">
        <p>* Preços com Iva Incluído.</p>
        <p>** Vinhos à Garrafa vendidos ao Balcão.</p>
        <p>PS.: Aos produtos abrangidos pelo Sistema (Volta) acresce uma taxa de 0,10 €.</p>
    </div>
    <div id="balcao-wrapper">
        <div id="balcao-autocarros">
            <div class="ac-header">
                <div class="ac-pin">📍</div>
                <div class="ac-titulo">
                    <div class="ac-label">PARAGEM</div>
                    <h2>AGRINHA (CARREIRA)</h2>
                    <div class="ac-sub">Vila Nova de Famalicão</div>
                </div>
                <div class="ac-relogio">
                    <div class="ac-hora" id="ac-hora">--:--</div>
                    <div class="ac-dia" id="ac-dia">&nbsp;</div>
                    <div class="ac-data" id="ac-data">&nbsp;</div>
                </div>
            </div>
            
            <div id="autocarros-grid" class="ac-lista"></div>
            
            <div class="ac-footer">
                <span><span class="ac-dot"></span> Dados em tempo real · QMob</span>
                <span>Mobilidade para uma região melhor 🍃</span>
            </div>
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

        (function () {
            const CORES = ['#3b9dff', '#22c55e', '#f97316', '#a855f7'];
            const ENDPOINT = 'proximos_autocarros.php';
            const REFRESH_DATA_MS = 30000;
            
            const grid = document.getElementById('autocarros-grid');
            const elHora = document.getElementById('ac-hora');
            const elDia = document.getElementById('ac-dia');
            const elData = document.getElementById('ac-data');
            
            function el(tag, cls, texto) {
                const n = document.createElement(tag);
                if (cls) n.className = cls;
                if (texto !== undefined) n.textContent = texto;
                return n;
            }
            
            function atualizarRelogio() {
                const agora = new Date();
                elHora.textContent = agora.toLocaleTimeString('pt-PT', { hour: '2-digit', minute: '2-digit' });
                const dia = agora.toLocaleDateString('pt-PT', { weekday: 'long' });
                elDia.textContent = dia.charAt(0).toUpperCase() + dia.slice(1);
                elData.textContent = agora.toLocaleDateString('pt-PT', { day: 'numeric', month: 'long', year: 'numeric' });
            }
            
            async function atualizarAutocarros() {
                try {
                    const r = await fetch(ENDPOINT, { cache: 'no-store' });
                    const d = await r.json();
                    grid.replaceChildren();
                
                    if (!d.ok || d.departures.length === 0) {
                        grid.append(el('p', null, d.ok ? 'Sem passagens previstas nas próximas horas' : 'Informação indisponível de momento'));
                        return;
                    }
                
                    d.departures.forEach(function (p, i) {
                        const cor = CORES[i % CORES.length];
                
                        const item = el('div', 'ac-item');
                        item.style.setProperty('--cor', cor);
                
                        item.append(el('div', 'ac-icone', '🚌'));
                        item.append(el('div', 'ac-linha', p.line));
                
                        const tags = el('div', 'ac-tags');
                        if (p.agency) tags.append(el('div', 'ac-tag', p.agency));
                        if (p.operator) tags.append(el('div', 'ac-tag', p.operator));
                        item.append(tags);
                
                        // Junta o "via X" ao fim do destino, na mesma linha e mesmo
                        // tamanho, só se o destino ainda não o tiver (a API às vezes já
                        // traz "... VIA PEDOME" incluído no próprio destino).
                        let textoDestino = p.destination;
                        if (p.via && !/\bvia\b/i.test(textoDestino)) {
                        textoDestino += ' via ' + p.via;
                        }
                        const dest = el('div', 'ac-destino');
                        dest.append(el('div', 'principal', textoDestino));
                        item.append(dest);
                
                        const quando = el('div', 'ac-quando');
                        quando.append(el('div', 'ac-min', p.minutes + ' min'));
                        quando.append(el('div', 'ac-hh', p.time));
                        if (p.status) quando.append(el('div', 'ac-status', p.status));
                        item.append(quando);
                
                        grid.append(item);
                    });
                
                    if (d.stale) {
                        grid.append(el('p', null, '(informação possivelmente desatualizada)'));
                    }
                } catch (e) {
                    grid.replaceChildren();
                    grid.append(el('p', null, 'Informação indisponível de momento'));
                }
            }
            
            atualizarRelogio();
            setInterval(atualizarRelogio, 1000);
            atualizarAutocarros();
            setInterval(atualizarAutocarros, REFRESH_DATA_MS);
        })();
    </script>
</body>
</html>