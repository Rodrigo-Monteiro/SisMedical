<?php 

require_once("../../conexao.php");

$descricao 		 = $_POST['descricao'];
$data  			 = $_POST['data'];
$hora  			 = $_POST['hora'];
$num_processo    = $_POST['num_processo'];
$nome   	 	 = $_POST['nome'];
$cliente   	 	 = $_POST['cliente'];
$cpf_adv	  = $_SESSION['cpf_usuario'];

//VERIFICAR SE O REGISTRO JÁ ESTÁ CADASTRADO
$res_c = $pdo->query("SELECT * FROM tarefas WHERE data = '$data' and hora = '$hora' and advogado = '$cpf_adv' and num_processo = '$num_processo' ");
$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados_c);
if($linhas == 0){
	$res = $pdo->prepare("INSERT into tarefas   ( num_processo
												, descricao
												, data
												, hora
												, nome
												, advogado
												, cliente
												, status
												) 
										 values ( :num_processo
												, :descricao
												, :data
												, :hora
												, :nome
												, :advogado
												, :cliente
												, 'Agendada'
												) 
						");

	$res->bindValue(":num_processo", $num_processo);
	$res->bindValue(":descricao", $descricao);
	$res->bindValue(":data", $data);
	$res->bindValue(":hora", $hora);
	$res->bindValue(":nome", $nome);
	$res->bindValue(":advogado", $cpf_adv);
	$res->bindValue(":cliente", $cliente);

	$res->execute();	
	
	echo "Cadastrado com Sucesso!!";

}else{
	echo "Esta tarefa já está cadastrada!";
}

?>