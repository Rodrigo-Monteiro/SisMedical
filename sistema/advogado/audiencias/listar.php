<?php 

require_once("../../conexao.php");
$pagina 	= 'audiencias';
$agora 		= date('Y-m-d');
$txtbuscar 	= @$_POST['txtbuscar'];
$txtbuscar2	= '%'.@$_POST['txtbuscar2'].'%';


echo '
<table class="table table-sm mt-3 tabelas">
<thead class="thead-light">
<tr>
<th scope="col">Número do Processo</th>
<th scope="col">Descrição</th>
<th scope="col">Tipo da Audiência</th>
<th scope="col">Local</th>
<th scope="col">Data da Audiência</th>
<th scope="col">Hora da Audiência</th>
<th scope="col">Prazo</th>
<th scope="col">Cliente</th>
<th scope="col">Réu</th>

<th scope="col">Ações</th>
</tr>
</thead>
<tbody>';


if(($txtbuscar == '' or $agora == $txtbuscar) and $txtbuscar2 == '%%' ){
	$res = $pdo->query("SELECT * from audiencias where data_audiencia >= curDate() order by data_audiencia asc");
}else{
	if ($txtbuscar2 == '%%') {
		$res = $pdo->query("SELECT * from audiencias where data_audiencia >= '$txtbuscar' order by data_audiencia asc");
	} else {
		$res = $pdo->query("SELECT * from audiencias where num_processo like '$txtbuscar2' order by data_audiencia asc");
	}

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
	$tipo_audiencia	= $dados[$i]['tipo_audiencia'];

	$data2 = implode('/',array_reverse(explode('-',$data_audiencia)));

	//CALCULAR DIAS ENTRE DATAS
	$diferenca = strtotime($data_audiencia) - strtotime($agora);
    $prazo 	   = floor($diferenca / (60*60*24));

	//BUSCAR O NOME DO ADVOGADO
	$res_adv 	   = $pdo->query("select * from advogados where cpf = '$advogado'");	
	$dados_adv 	   = $res_adv->fetchAll(PDO::FETCH_ASSOC);
	$nome_advogado = @$dados_adv[0]['nome'];

	//BUSCAR O NOMES DO ADVOGADOS
	$res_cli 	  = $pdo->query("select * from clientes where cpf = '$cliente'");	
	$dados_cli 	  = $res_cli->fetchAll(PDO::FETCH_ASSOC);
	$nome_cliente = @$dados_cli[0]['nome'];

	//BUSCAR O NOMES DO RÉU
	$res_reu 	  = $pdo->query("SELECT pc.nome 
		                           FROM parte_contraria pc
		                              , processos 		p  
		                          WHERE p.parte_contraria = pc.cpf
		                            AND p.num_processo    = '$num_processo' 
		                        ");	
	$dados_reu 	  = $res_reu->fetchAll(PDO::FETCH_ASSOC);
	$nome_reu 	  = @$dados_reu[0]['nome'];
	
	echo '
	<tr>

		<td>'.$num_processo.'</td>
		<td>'.$descricao.'</td>
		<td>'.$tipo_audiencia.'</td>
		<td>'.$local.'</td>
		<td>'.$data2.'</td>
		<td>'.$hora_audiencia.'</td>
		<td>'.$prazo.' dias</td>
		<td>'.$nome_cliente.'</td>
		<td>'.$nome_reu.'</td>
		
		<td>

			<a title="Observação" href="index.php?acao='.$pagina.'&funcao=obs&id='.$id.'"><i class="fas fa-comment text-warning"></i></a>

			<a title="Editar Audiência" href="index.php?acao='.$pagina.'&funcao=editar&id='.$id.'"><i class="fas fa-edit text-info"></i></a>

	 		<a title="Excluir Audiência" href="index.php?acao='.$pagina.'&funcao=excluir&id='.$id.'"><i class="far fa-trash-alt text-danger"></i></a>
		</td>
	</tr>';


	

}

echo  '
</tbody>
</table> ';


?>