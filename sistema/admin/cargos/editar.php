<?php 

require_once("../../conexao.php");

$nome = $_POST['nome'];

$antigo = $_POST['antigo'];
$id = $_POST['id'];

if ($nome == ''){
	echo "Cargo não preenchidos!!";
	exit();
}

if($antigo != $nome){

		//VERIFICAR SE O FUNCIONÁRIO JÁ ESTÁ CADASTRADO
	$res_c = $pdo->query("select * from cargos where nome = '$nome'");
	$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
	$linhas = count($dados_c);

	if($linhas != 0){

		echo "Este Registro já está cadastrado!!";
		exit();
	}

}





$res = $pdo->prepare("UPDATE cargos set nome = :nome where id = :id ");

$res->bindValue(":nome", $nome);

$res->bindValue(":id", $id);


$res->execute();



echo "Editado com Sucesso!!";





?>