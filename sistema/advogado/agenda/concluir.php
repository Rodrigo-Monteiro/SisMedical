<?php 

require_once("../../conexao.php");

$id = $_POST['id'];

$res = $pdo->query("UPDATE tarefas
 					   SET status = 'Concluida' 
 					 WHERE id = '$id' ");


?>