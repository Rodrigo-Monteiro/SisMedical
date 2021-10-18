<?php 

require_once("../../conexao.php");

$id  = $_POST['id'];
$obs = $_POST['obs'];

$res = $pdo->query("UPDATE processos
					   SET observacao = '$obs'
					 WHERE id = '$id' ");


?>