<?php 

require_once("../../conexao.php");

$id 			 = $_POST['id_reg'];
$descricao 		 = $_POST['descricao'];
$data  			 = $_POST['data'];
$observacao  	 = $_POST['observacao'];

$res = $pdo->prepare("UPDATE historico
			            SET descricao 	   = :descricao
			              , data 	  	   = :data
			              , observacao 	   = :observacao
			          WHERE id = :id ");

$res->bindValue(":descricao", $descricao);
$res->bindValue(":data", $data);
$res->bindValue(":observacao", $observacao);
$res->bindValue(":id", $id);

$res->execute();	


echo "Editado com Sucesso!!";

?>