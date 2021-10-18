<?php 

require_once("../../conexao.php");


$descricao = $_POST['descricao'];
$num_processo = $_POST['num_processo'];


//SCRIPT PARA FOTO NO BANCO
$caminho = '../../img/arquivos/' .$_FILES['foto']['name'];

if ($_FILES['foto']['name'] == ""){
  echo "Escolha um arquivo!!";
	exit();
}else{
   $imagem = $_FILES['foto']['name']; 
}
    
$imagem_temp = $_FILES['foto']['tmp_name']; 
move_uploaded_file($imagem_temp, $caminho);

if($descricao == ''){
	echo "Preencha a Descrição!!";
	exit();
}


	$res = $pdo->prepare("INSERT into documentos ( descricao
		 																					 , data
		 																					 , num_processo
		 																					 , arquivo
		 																					 ) 
		 																	  values ( :descricao
		 																					 , curDate()
		 																					 , :num_processo
		 																					 , :arquivo
		 																					 )
		 								  ");

	$res->bindValue(":descricao", $descricao);
	$res->bindValue(":num_processo", $num_processo);
	$res->bindValue(":arquivo", $imagem);

	$res->execute();	

	echo "Cadastrado com Sucesso!!";

?>