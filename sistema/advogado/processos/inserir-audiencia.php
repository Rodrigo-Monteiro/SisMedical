<?php 

require_once("../../conexao.php");

$descricao 		 = $_POST['descricao'];
$data_audiencia  = $_POST['data_audiencia'];
$hora_audiencia  = $_POST['hora_audiencia'];
$num_processo    = $_POST['num_processo'];
$local   	 	 = $_POST['local'];

//PROCESSOS
$res_p   = $pdo->query("SELECT * FROM processos WHERE num_processo = '$num_processo' ");
$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC); 

$cpf_cliente	 = $dados_p[0]['cliente'];
$cpf_adv     	 = $dados_p[0]['advogado'];
$total_audiencia = $dados_p[0]['qtd_audiencias'];
$total_audiencia = $total_audiencia  + 1;  

//VERIFICAR SE O REGISTRO JÁ ESTÁ CADASTRADO
$res_c = $pdo->query("SELECT * FROM audiencias WHERE data_audiencia = '$data_audiencia' and hora_audiencia = '$hora_audiencia' and advogado = '$cpf_adv' and num_processo = '$num_processo' ");
$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados_c);
if($linhas == 0){
	$res = $pdo->prepare("INSERT into audiencias( num_processo
												, descricao
												, data_audiencia
												, hora_audiencia
												, local
												, advogado
												, cliente
												) 
										 values ( :num_processo
												, :descricao
												, :data_audiencia
												, :hora_audiencia
												, :local
												, :advogado
												, :cliente
												) 
						");

	$res->bindValue(":num_processo", $num_processo);
	$res->bindValue(":descricao", $descricao);
	$res->bindValue(":data_audiencia", $data_audiencia);
	$res->bindValue(":hora_audiencia", $hora_audiencia);
	$res->bindValue(":local", $local);
	$res->bindValue(":advogado", $cpf_adv);
	$res->bindValue(":cliente", $cpf_cliente);

	$res->execute();	
	

	$res_processo = $pdo->prepare(" UPDATE processos 
		                               SET data_audiencia = :data_audiencia
		                                 , hora_audiencia = :hora_audiencia
		                                 , qtd_audiencias = :qtd_audiencias
		                             WHERE num_processo   = :num_processo
						          ");

	$res_processo->bindValue(":data_audiencia", $data_audiencia);
	$res_processo->bindValue(":hora_audiencia", $hora_audiencia);
	$res_processo->bindValue(":qtd_audiencias", $total_audiencia );
	$res_processo->bindValue(":num_processo", $num_processo);

	$res_processo->execute();	



	//TRAZER O EMAIL DO CLIENTE
	$res_cli     = $pdo->query("SELECT * FROM clientes WHERE cpf = '$cpf_cliente' ");
	$dados_cli   = $res_cli->fetchAll(PDO::FETCH_ASSOC); 
	$email_cli	 = $dados_cli[0]['email'];
	$data2 = implode('/',array_reverse(explode('-',$data_audiencia)));


	//CÓDIGO PARA DISPARAR EMAIL PARA O CLIENTE
	$url_painel_cli  = $url_sistema.'cliente';
	$to       		 = $email_cli;
	$subject         = "Marcação de Audiência dia $data2";

	$message = "

		<b>Descrição:</b> $descricao.
		<br>
		<b>Local da Audiência:</b><br>
		$local - $data2 - $hora_audiencia

			<br><br><br> <i> Ver no seu painel do Cliente - <a title='$url_painel_cli' href='$url_painel_cli' target='_blank'>$url_painel_cli</a></i>";

	$remet	  = $email_notif;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
	$headers .= "From: " .$remet;

	mail($to, $subject, $message, $headers);

	echo "Cadastrado com Sucesso!!";

}else{
	echo "Esta Audiência já está cadastrado!!";
}

?>