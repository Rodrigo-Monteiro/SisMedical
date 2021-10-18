<?php 

require_once("../../conexao.php");

$id = $_POST['id'];


//BUSCAR AS INFORMAÇOES DE CONTAS A RECEBER PARA LANÇAR NAS MOVIMENTAÇÕES
$res_c 	 = $pdo->query("SELECT * FROM contas_receber WHERE id = '$id'");
$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
$valor	 = $dados_c[0]['valor'];
$funcionario	= $_SESSION['cpf_usuario'];


$res = $pdo->query("UPDATE contas_receber
 					   SET ind_pagamento = 'S' 
 					 WHERE id = '$id' ");

//LANÇAR O VALOR NA TABELA DE MOVIMENTAÇÕES
$res_m = $pdo->prepare("INSERT INTO movimentacoes ( tipo
									     , movimento 
									     , valor 
									     , funcionario
									     , data
									     , id_movimento
									     )
	                              VALUES ( :tipo
									     , :movimento 
									     , :valor 
									     , :funcionario
									     , curDate()
									     , :id_movimento)
	        ");

$res_m->bindValue(":tipo", 'Entrada');
$res_m->bindValue(":movimento", 'Processo');
$res_m->bindValue(":valor", $valor);
$res_m->bindValue(":funcionario", $funcionario);
$res_m->bindValue(":id_movimento", $id);

$res_m->execute();

?>