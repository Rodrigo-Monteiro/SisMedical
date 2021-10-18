<?php 

require_once("../../conexao.php");

$nome 			= $_POST['nome'];
$cpf 			= $_POST['cpf_oculto'];
$telefone 		= $_POST['telefone'];
$email 			= $_POST['email'];
$id 			= $_POST['id'];
$cpf_antigo 	= $_POST['cpf_antigo'];
$endereco 		= @$_POST['endereco'];
$obs 			= @$_POST['obs'];
$identidade 	= $_POST['identidade'];
$nacionalidade 	= $_POST['nacionalidade'];
$estado_civil 	= $_POST['estado_civil'];
$profissao 	    = @$_POST['profissao'];

$cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);
$cpf_cript = md5($cpf_limpo);

if ($nome == '' or $cpf == '' or $obs == '' or $identidade == ''){
	echo "Dados obrigatórios não preenchidos!!";
	exit();
}

if($cpf_antigo != $cpf){

		//VERIFICAR SE O REGISTRO JÁ ESTÁ CADASTRADO
	$res_c = $pdo->query("select * from clientes where cpf = '$cpf'");
	$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
	$linhas = count($dados_c);

	if($linhas != 0){

		echo "Este Cliente já está cadastrado!!";
		exit();
	}

}





$res = $pdo->prepare(" UPDATE clientes 
						  SET nome 		  	= :nome
						    , cpf           = :cpf
						    , telefone    	= :telefone
						    , email 	  	= :email
						    , endereco    	= :endereco 
						    , obs 		  	= :obs
						    , tipo_pessoa   = :tipo_pessoa 
						    , identidade 	= :identidade
							, nacionalidade = :nacionalidade
							, estado_civil 	= :estado_civil
							, profissao 	= :profissao
						    where id = :id ");

$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":endereco", $endereco);
$res->bindValue(":obs", $obs);
$res->bindValue(":tipo_pessoa", $tipo_pessoa);
$res->bindValue(":identidade", $identidade);
$res->bindValue(":nacionalidade", $nacionalidade);
$res->bindValue(":estado_civil", $estado_civil);
$res->bindValue(":profissao", $profissao);

$res->bindValue(":id", $id);


$res->execute();


$res = $pdo->prepare("UPDATE usuarios set nome = :nome,  usuario = :usuario where cpf = :cpf ");

	$res->bindValue(":nome", $nome);
	$res->bindValue(":usuario", $email);
	$res->bindValue(":cpf", $cpf);

	$res->execute();

echo "Editado com Sucesso!!";

?>