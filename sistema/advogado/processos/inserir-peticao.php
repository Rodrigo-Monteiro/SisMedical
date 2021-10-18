<?php 

	require_once("../../conexao.php");

	$titulo 	  	= $_POST['titulo'];
	$tipo_acao  	= $_POST['tipo_acao'];
	$agravado   	= $_POST['agravado'];
	$agravante 		= $_POST['agravante'];
	$num_processo   = $_POST['num_processo'];
	$texto 			= $_POST['txt_peticao'];
	$editar 		= $_POST['editar'];

	if ($editar == 'S') {

		$res = $pdo->prepare("UPDATE peticoes
		                         SET titulo		= :titulo
								   , tipo_acao	= :tipo_acao
								   , agravado	= :agravado
								   , agravante	= :agravante
								   , texto 		= :texto
								   , data 		= curDate()
						       WHERE num_processo = :num_processo
						    ");


	} else {
		
		$res_p      = $pdo->query("SELECT * from peticoes where num_processo = '$num_processo'");
		$dados_p    = $res_p->fetchAll(PDO::FETCH_ASSOC);
		$linhas 	= count($dados_p);

		if ($linhas == 0){

			$res = $pdo->prepare("INSERT into peticoes ( titulo		
													    , tipo_acao	
													    , agravado	
													    , agravante	
													    , texto 		
													    , data 	
											            , num_processo 
													    ) 
											     values ( :titulo		
													    , :tipo_acao
													    , :agravado
													    , :agravante
													    , :texto		
													    , curDate() 	
											            , :num_processo 
													    )  
							");
		} else {
			exit();
		}
	}
	

	
		$res->bindValue(":titulo", $titulo);
		$res->bindValue(":tipo_acao", $tipo_acao);
		$res->bindValue(":agravado", $agravado);
		$res->bindValue(":agravante", $agravante);
		$res->bindValue(":texto", $texto);
		$res->bindValue(":num_processo", $num_processo);

		$res->execute();	

		echo "Cadastrado com Sucesso!!";


	//ATUALIZAR A DATA DA PETIÇÃO DA TABELA DE PROCESSOS
	$res = $pdo->query(" UPDATE processos SET data_peticao	= curDate() WHERE num_processo = '$num_processo'");

?>