<?php 

require_once("../../conexao.php");

$id = $_POST['id'];

$res = $pdo->query("DELETE from parte_contraria where id = '$id' ");


?>