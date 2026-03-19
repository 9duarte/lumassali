<?php 
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: login.php');
        exit();
    }

    include('./db/conexao.php');

    $sql = "SELECT * FROM administrator WHERE id = " . $_SESSION['id'] . " AND pass = '" . $_SESSION['password'] . "';";
    $result = $con->query($sql);
    if ($result->num_rows == 0) {
        header('Location: login.php');
        exit();
    }

    if (!isset($_FILES['ficheiro_excel']) || $_FILES['ficheiro_excel']['error'] !== 0) {
        die('Erro no upload do ficheiro.');
    }

    $ext = pathinfo($_FILES['ficheiro_excel']['name'], PATHINFO_EXTENSION);
    if (!in_array($ext, ['xlsx', 'xls'])) {
        die('Formato inválido. Apenas Excel.');
    }

    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;

    $tmpFile = $_FILES['ficheiro_excel']['tmp_name'];

    $spreadsheet = IOFactory::load($tmpFile);
    $sheet = $spreadsheet->getActiveSheet();

    $ultimaLinha = $sheet->getHighestRow();

    for ($linha = 2; $linha <= $ultimaLinha; $linha++) {
        $codigo = trim($sheet->getCell("A$linha")->getValue());
        $preco  = $sheet->getCell("F$linha")->getValue();

        $sql = "UPDATE secoes_produtos SET precoProduto = $preco WHERE codigo = $codigo;";
        $result = $con->prepare($sql);
        $result->execute();
    }
    
    novaVersao();
    header('Location: admin.php');
?>