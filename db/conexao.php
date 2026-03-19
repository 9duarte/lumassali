<?php
    // Change this to your connection info.
    $DATABASE_HOST = '4x1.pt';
    $DATABASE_USER = 'xpt123_lumassali';
    $DATABASE_PASS = 'Lumassali2025';
    $DATABASE_NAME = 'xpt123_lumassali';
    // Try and connect using the info above.
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $con->set_charset("utf8");
    // if ( mysqli_connect_errno() ) {
    //     // If there is an error with the connection, stop the script and display the error.
    //     $error_message = 'Failed to connect to MySQL: ' . mysqli_connect_error();
    //     echo "<script>console.error(" . json_encode($error_message) . ");</script>";
    //     exit;
    // }
    // echo "<script>console.error(" . json_encode("aaaaaaa") . ");</script>";
    // exit;
    function novaVersao() {
        $file = 'versao.json';
        $data = json_decode(file_get_contents($file), true);

        $data['versao']++;

        file_put_contents($file, json_encode($data));
    }
?>  