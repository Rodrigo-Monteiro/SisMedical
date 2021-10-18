<?php 

require_once("../../conexao.php");
@session_start();

$id = $_POST['id'];
$func = $_SESSION['cpf_usuario'];

$pdo->query("UPDATE contas_pagar 
	            SET data_pagamento = curDate()
	              , ind_pago = 'Sim'
	              , funcionario = '$func'  
	          WHERE id = '$id' ");

echo "Editado com Sucesso!!";


//LANÇAR NA TABELA DE MOVIMENTAÇÕES

//BUSCAR O VALOR DA CONSULTA FEITA
$res_valor = $pdo->query("select * from contas_pagar where id = '$id'");
$dados_valor  = $res_valor ->fetchAll(PDO::FETCH_ASSOC);
$valor = $dados_valor [0]['valor'];

$res = $pdo->prepare("INSERT into movimentacoes (tipo, movimento, valor, funcionario, data, id_movimento) values (:tipo, :movimento, :valor, :funcionario, curDate(), :id_movimento)");

$res->bindValue(":tipo", 'S');
$res->bindValue(":movimento", 'Pagamento Conta');
$res->bindValue(":valor", $valor);
$res->bindValue(":funcionario", $func);
$res->bindValue(":id_movimento", $id);

$res->execute();

?>