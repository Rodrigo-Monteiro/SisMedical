<?php 

require_once("../../conexao.php");

$nome 		 = $_POST['nome'];

$setor 	 	 = $_POST['setor'];
$endereco 	 = $_POST['endereco'];
$obs 		 = $_POST['obs'];
$tipo_pessoa = $_POST['tipo_pessoa'];

$cpf_adv	= $_SESSION['cpf_usuario'];

if ($tipo_pessoa == 'F') {
	$cpf = $_POST['cpf'];
} else {
	$cpf = $_POST['cnpj'];
}

if ($setor == 1) {
	$tipo_entidade = $_POST['entidade_pub'];
} else {
	$tipo_entidade = $_POST['entidade_pri'];
}

$cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);
$cpf_cript = md5($cpf_limpo);

if ($nome == '' or $cpf == ''){
	echo "Dados obrigatórios não preenchidos!!";
	exit();
}

//VERIFICAR SE O REGISTRO JÁ ESTÁ CADASTRADO
$res_c = $pdo->query("select * from parte_contraria where cpf = '$cpf'");
$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados_c);
if($linhas == 0){
	$res = $pdo->prepare("INSERT into parte_contraria ( nome
													  , cpf
													  , endereco
													  , setor
													  , tipo_entidade
													  , advogado
													  , data
													  , obs
													  , tipo_pessoa) 
											  values  ( :nome
											   		  , :cpf
											   		  , :endereco
											   		  , :setor
											   		  , :tipo_entidade
											   		  , :advogado
											   		  , curDate()
											   		  , :obs
											   		  , :tipo_pessoa ) 
						");

	$res->bindValue(":nome", $nome);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":endereco", $endereco);
	$res->bindValue(":setor", $setor);
	$res->bindValue(":tipo_entidade", $tipo_entidade);
	$res->bindValue(":advogado", $cpf_adv);
	$res->bindValue(":obs", $obs);
	$res->bindValue(":tipo_pessoa", $tipo_pessoa);

	$res->execute();	


	echo "Cadastrado com Sucesso!!";

}else{
	echo "Este Registro já está cadastrado!!";
}

?>