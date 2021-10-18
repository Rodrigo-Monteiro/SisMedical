<?php 

	require_once("../../conexao.php");

	$descricao 	  = $_POST['descricao'];
	$data  		  = $_POST['data'];
	$observacao   = $_POST['observacao'];
	$num_processo = $_POST['num_processo'];

	$res = $pdo->prepare("INSERT into historico ( num_processo
												, descricao
												, data
												, observacao
												) 
										 values ( :num_processo
												, :descricao
												, :data
												, :observacao
												) 
						");

	$res->bindValue(":num_processo", $num_processo);
	$res->bindValue(":descricao", $descricao);
	$res->bindValue(":data", $data);
	$res->bindValue(":observacao", $observacao);

	$res->execute();	

	echo "Cadastrado com Sucesso!!";


	//TRAZER O EMAIL DO CLIENTE
	$res_cli     = $pdo->query(" SELECT c.*
		                           FROM clientes  c 
		                              , processos p
		                          WHERE c.cpf      	   = p.cliente
		                            AND p.num_processo = '$num_processo' 
		                       ");
	
	$dados_cli   = $res_cli->fetchAll(PDO::FETCH_ASSOC); 
	$email_cli	 = $dados_cli[0]['email'];

	//CÓDIGO PARA DISPARAR EMAIL PARA O CLIENTE
	$url_painel_cli  = $url_sistema.'cliente';
	$to       		 = $email_cli;
	$subject  = "Movimentação do Processo: $num_processo";

	$message = "
		<b>$descricao</b> <br><br>
		
		$observacao<br><br>

			<br><br><br> <i> Ver no seu painel do Cliente - <a title='$url_painel_cli' href='$url_painel_cli' target='_blank'>$url_painel_cli</a></i>";

	$remet	  = $email_notif;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
	$headers .= "From: " .$remet;

	mail($to, $subject, $message, $headers);

?>