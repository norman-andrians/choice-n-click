<?php
$servername = "localhost";
$username = "drea";
$password = "kobayashi";
$dbname = "choice_n_click";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
    die("conneksi gagal. " . $connect->connect_error);
}
?>