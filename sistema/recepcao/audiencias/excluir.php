<?php 

require_once("../../conexao.php");

$id = $_POST['id'];

//BUSCAR O NUMERO DO PROCESSO
$res_proc = $pdo->query("SELECT * FROM audiencias WHERE id = '$id'");
$dados_proc         = $res_proc ->fetchAll(PDO::FETCH_ASSOC);
$processo 			= $dados_proc [0]['num_processo'];

$res_valor = $pdo->query("SELECT * from processos WHERE num_processo = '$processo'");
$dados_valor        = $res_valor ->fetchAll(PDO::FETCH_ASSOC);
$total_audiencia	= $dados_valor [0]['qtd_audiencias'];

$total_audiencia    = $total_audiencia - 1;

$res_p = $pdo->query  ("UPDATE processos 
					       SET qtd_audiencias = '$total_audiencia'
					     WHERE num_processo   = '$processo'
					  ");


$res = $pdo->prepare("DELETE from audiencias where id = :id ");

$res->bindValue(":id", $id);

$res->execute();

?>