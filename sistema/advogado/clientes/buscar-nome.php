<?php 

require_once("../../conexao.php");
$pagina = 'clientes';

$txtbuscar = @$_POST['cpf'];

if ($txtbuscar == ''){
		$txtbuscar = @$_POST['cnpj'];
}


$res 		= $pdo->query("SELECT * FROM parte_contraria WHERE cpf = '$txtbuscar' ");
$dados 	= $res->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados);

if ($linhas > 0){
	$nome 	=  $dados[0]['nome'];
	echo $nome;
} else {
	echo '';
}

?>