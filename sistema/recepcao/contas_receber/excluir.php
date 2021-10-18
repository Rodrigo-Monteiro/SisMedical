<?php 

require_once("../../conexao.php");

$id = $_POST['id'];

$res = $pdo->query("DELETE from contas_receber where id = '$id' ");


?>