<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_pae_conn = "localhost";
$database_pae_conn = "pma_pae";
$username_pae_conn = "pma_pae";
$password_pae_conn = "PM44P1";
/*
$pae_conn =  mysqli_connect($hostname_pae_conn, $username_pae_conn, $password_pae_conn, $database_pae_conn);
if ($pae_conn->connect_error) {
    die('Error de conexión: ' . $pae_conn->connect_error);
}
if (mysqli_connect_error()) {
    die('Error de Conexión (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}


echo 'Éxito... ' . $pae_conn->host_info . "\n";



*/



$pae_conn = mysqli_connect($hostname_pae_conn, $username_pae_conn, $password_pae_conn, $database_pae_conn);

if (!$pae_conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

?>
