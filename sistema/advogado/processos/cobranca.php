<?php 

require_once("../../conexao.php");

$id 		= $_POST['id'];
$descricao  = $_POST['descricao'];
$valor 		= $_POST['valor'];

$cpf_adv	= $_SESSION['cpf_usuario'];

//RECUPERAR O CPF/CNPJ DO CLIENTE
$res_c 		 = $pdo->query("select * from processos where id = '$id'");
$dados_c 	 = $res_c->fetchAll(PDO::FETCH_ASSOC);
$cpf_cliente = $dados_c[0]['cliente'];

$res = $pdo->prepare("INSERT INTO contas_receber ( descricao
												 , valor
												 , advogado
												 , cliente
												 , data
												 , ind_pagamento
												 , id_processo)
	                         		      values ( :descricao
												 , :valor
												 , :advogado
												 , :cliente
												 , curDate()
												 , :ind_pagamento
												 , :id_processo)
	                ");

$res->bindValue(":descricao", $descricao);
$res->bindValue(":valor", $valor);
$res->bindValue(":advogado", $cpf_adv);
$res->bindValue(":cliente", $cpf_cliente);
$res->bindValue(":ind_pagamento", 'N');
$res->bindValue(":id_processo", $id);

$res->execute();

echo "Cadastrado com Sucesso!!";

?>