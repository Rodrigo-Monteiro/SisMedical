<?php 

require_once("../../conexao.php");

$id = $_POST['id_reg'];
$descricao 		 = $_POST['descricao'];
$data_audiencia  = $_POST['data_audiencia'];
$hora_audiencia  = $_POST['hora_audiencia'];
$local   	 	 = $_POST['local'];


$res = $pdo->prepare("UPDATE audiencias
			            SET descricao 	   = :descricao
			              , local 	  	   = :local
			              , data_audiencia = :data_audiencia
			              , hora_audiencia = :hora_audiencia
			          WHERE id = :id ");

$res->bindValue(":descricao", $descricao);
$res->bindValue(":local", $local);
$res->bindValue(":data_audiencia", $data_audiencia);
$res->bindValue(":hora_audiencia", $hora_audiencia);
$res->bindValue(":id", $id);

$res->execute();	


echo "Editado com Sucesso!!";


//ATUALIZAR A TABELA DE PROCESSO

//BUSCAR O NUMERO DO PROCESSO
$res_proc = $pdo->query("select * from audiencias where id = '$id'");
$dados_proc  = $res_proc ->fetchAll(PDO::FETCH_ASSOC);
$processo = $dados_proc [0]['num_processo'];

$res_p = $pdo->prepare("UPDATE processos 
					       SET data_audiencia = :data_audiencia
					         , hora_audiencia = :hora_audiencia
					     WHERE num_processo   = :num_processo
					  ");

$res_p->bindValue(":data_audiencia", $data_audiencia);
$res_p->bindValue(":hora_audiencia", $hora_audiencia);
$res_p->bindValue(":num_processo", $processo);

$res_p->execute();

?>