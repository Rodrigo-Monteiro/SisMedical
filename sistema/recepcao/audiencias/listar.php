<?php 

require_once("../../conexao.php");
$pagina 	= 'audiencias';
$agora 		= date('Y-m-d');
$txtbuscar 	= @$_POST['txtbuscar'];
$txtbuscar2	= '%'.@$_POST['txtbuscar2'].'%';


echo '
<table class="table table-responsive-sm table-sm mt-3 tabelas">
<thead class="thead-light">
<tr>
<th scope="col">Número do Processo</th>
<th scope="col">Descrição</th>
<th scope="col">Local</th>
<th scope="col">Data da Audiência</th>
<th scope="col">Hora da Audiência</th>
<th scope="col">Advogado</th>
<th scope="col">Cliente</th>

<th scope="col">Ações</th>
</tr>
</thead>
<tbody>';


if(($txtbuscar == '' or $agora == $txtbuscar) and $txtbuscar2 == '%%' ){
	$res = $pdo->query("SELECT * from audiencias where data_audiencia >= curDate() order by hora_audiencia asc");
}else{
	$res = $pdo->query("SELECT * from audiencias where data_audiencia >= '$txtbuscar' and num_processo like '$txtbuscar2' order by hora_audiencia asc");

}

$dados = $res->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($dados); $i++) { 
	foreach ($dados[$i] as $key => $value) {
	}

	$id = $dados[$i]['id'];
	$num_processo	= $dados[$i]['num_processo'];	
	$descricao 		= $dados[$i]['descricao'];
	$local 			= $dados[$i]['local'];
	$data_audiencia = $dados[$i]['data_audiencia'];
	$hora_audiencia = $dados[$i]['hora_audiencia'];
	$advogado 		= $dados[$i]['advogado'];
	$cliente 		= $dados[$i]['cliente'];

	$data2 = implode('/',array_reverse(explode('-',$data_audiencia)));

	//BUSCAR O NOME DO ADVOGADO
	$res_adv 	   = $pdo->query("select * from advogados where cpf = '$advogado'");	
	$dados_adv 	   = $res_adv->fetchAll(PDO::FETCH_ASSOC);
	$nome_advogado = @$dados_adv[0]['nome'];

	//BUSCAR O NOMES DO ADVOGADOS
	$res_cli 	  = $pdo->query("select * from clientes where cpf = '$cliente'");	
	$dados_cli 	  = $res_cli->fetchAll(PDO::FETCH_ASSOC);
	$nome_cliente = @$dados_cli[0]['nome'];
	
	echo '
	<tr>

		<td>'.$num_processo.'</td>
		<td>'.$descricao.'</td>
		<td>'.$local.'</td>
		<td>'.$data2.'</td>
		<td>'.$hora_audiencia.'</td>
		<td>'.$nome_advogado.'</td>
		<td>'.$nome_cliente.'</td>
		
		<td>
			<a title="Editar Audiência" href="index.php?acao='.$pagina.'&funcao=editar&id='.$id.'"><i class="fas fa-edit text-info"></i></a>

	 		<a title="Excluir Audiência" href="index.php?acao='.$pagina.'&funcao=excluir&id='.$id.'"><i class="far fa-trash-alt text-danger"></i></a>
		</td>
	</tr>';


	

}

echo  '
</tbody>
</table> ';


?>