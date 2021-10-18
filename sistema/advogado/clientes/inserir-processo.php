<?php 

require_once("../../conexao.php");

$num_processo 		  = $_POST['num_processo'];
$vara 	 			  = $_POST['vara'];
$tipo_acao 		      = $_POST['tipo_acao'];
$tipo_pessoa_processo = $_POST['tipo_pessoa_processo'];
$cpf_cliente 		  = $_POST['cpf_cliente'];
$setor			      = $_POST['setor'];
$nome_parte_contratia = $_POST['nome_parte_contraria'];
$endereco			  = $_POST['endereco'];
$cpf_adv			  = $_SESSION['cpf_usuario'];

if ($setor == 1) {
	$tipo_entidade = $_POST['entidade_pub'];
} else {
	$tipo_entidade = $_POST['entidade_pri'];
}	



if ($tipo_pessoa_processo == 'F') {
	$cpf_parte_contraria = $_POST['cpf'];
} else {
	$cpf_parte_contraria = $_POST['cnpj'];
}

//VERIFICAR SE O REGISTRO JÁ ESTÁ CADASTRADO
$res_c = $pdo->query("select * from processos where num_processo = '$num_processo'");
$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados_c);
if($linhas == 0){
	$res = $pdo->prepare("INSERT into processos ( num_processo
												, vara
												, tipo_acao
												, advogado
												, cliente
												, parte_contraria
												, data_abertura
												, status
												, tipo_pessoa
												) 
										 values ( :num_processo
												, :vara
												, :tipo_acao
												, :advogado
												, :cliente
												, :parte_contraria
												, curDate()
												, :status
												, :tipo_pessoa) ");

	$res->bindValue(":num_processo", $num_processo);
	$res->bindValue(":vara", $vara);
	$res->bindValue(":tipo_acao", $tipo_acao);
	$res->bindValue(":advogado", $cpf_adv);
	$res->bindValue(":cliente", $cpf_cliente);
	$res->bindValue(":parte_contraria", $cpf_parte_contraria);
	$res->bindValue(":status", 'Ativo');
	$res->bindValue(":tipo_pessoa", $tipo_pessoa_processo);

	$res->execute();	

	//VERIFICAR SE O RÉU JÁ ESTÁ CADASTRADO SENÃO CADASTRAR
	$res_reu    = $pdo->query(" SELECT * FROM parte_contraria where cpf = '$cpf_parte_contraria'");
	$dados_reu  = $res_reu->fetchAll(PDO::FETCH_ASSOC);
	$linhas_reu = count($dados_reu);

	if($linhas_reu == 0){
		$res_r = $pdo->prepare ("INSERT into parte_contraria  ( nome
														, cpf
														, setor
														, tipo_entidade
														, endereco
														, advogado
														, data
														, tipo_pessoa
														) 
												 values ( :nome
														, :cpf
														, :setor
														, :tipo_entidade
														, :endereco
														, :advogado
														, curDate()
														, :tipo_pessoa) 
								");

		$res_r->bindValue(":nome", $nome_parte_contratia);
		$res_r->bindValue(":cpf", $cpf_parte_contraria);
		$res_r->bindValue(":setor", $setor);
		$res_r->bindValue(":tipo_entidade", $tipo_entidade);
		$res_r->bindValue(":endereco", $endereco);
		$res_r->bindValue(":advogado", $cpf_adv);
		$res_r->bindValue(":tipo_pessoa", $tipo_pessoa_processo);

		$res_r->execute();	
	}
	echo "Cadastrado com Sucesso!!";

}else{
	echo "Este Registro já está cadastrado!!";
}

?>