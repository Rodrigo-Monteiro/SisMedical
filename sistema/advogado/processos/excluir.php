<?php 

require_once("../../conexao.php");

$id = $_POST['id'];

$res = $pdo->query("UPDATE processos
					   SET status = 'Arquivado'
					 WHERE id = '$id' ");

?>