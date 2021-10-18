<?php 

require_once("../../conexao.php");
$pagina 	= 'historico';
$agora 		= date('Y-m-d');
$txtbuscar 	= @$_POST['txtbuscar'];
$txtbuscar2	= '%'.@$_POST['txtbuscar2'].'%';


echo '
<table class="table table-responsive-sm table-sm mt-3 tabelas">
<thead class="thead-light">
<tr>
	<th scope="col">Processo</th>
	<th scope="col">Descrição</th>
	<th scope="col">Observação</th>
	<th scope="col">Data</th>
	<th scope="col">Cliente</th>
	<th scope="col">Ações</th>
</tr>
</thead>
<tbody>';


if(($txtbuscar == '' or $agora == $txtbuscar) and $txtbuscar2 == '%%' ){
	$res = $pdo->query("SELECT * from historico where data >= curDate() order by id desc");
}else{
	if ($txtbuscar2 == '%%') {
		$res = $pdo->query("SELECT * from historico where data >= '$txtbuscar' order by data asc");
	} else {
		$res = $pdo->query("SELECT * from historico where num_processo like '$txtbuscar2' order by data asc");
	}

}

$dados = $res->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($dados); $i++) { 
	foreach ($dados[$i] as $key => $value) {
	}

	$id = $dados[$i]['id'];
	$num_processo	= $dados[$i]['num_processo'];	
	$descricao 		= $dados[$i]['descricao'];
	$observacao 	= $dados[$i]['observacao'];
	$data 			= $dados[$i]['data'];

	$data2 = implode('/',array_reverse(explode('-',$data)));	


	//BUSCAR O NOMES DO CLIENTE
	$res_cli 	  = $pdo->query("SELECT c.nome 
		                           FROM clientes  c 
		                              , processos p
		                          WHERE p.cliente      = c.cpf
		                            AND p.num_processo = '$num_processo'
		                       ");	
	$dados_cli 	  = $res_cli->fetchAll(PDO::FETCH_ASSOC);
	$nome_cliente = @$dados_cli[0]['nome'];
	
	echo '
	<tr>

		<td>'.$num_processo.'</td>
		<td>'.$descricao.'</td>
		<td>'.$observacao.'</td>
		<td>'.$data2.'</td>
		<td>'.$nome_cliente.'</td>
		
		<td>
			
			<a title="Editar Movimentação" href="index.php?acao='.$pagina.'&funcao=editar&id='.$id.'"><i class="fas fa-edit text-info"></i></a>

	 		<a title="Excluir Movimentação" href="index.php?acao='.$pagina.'&funcao=excluir&id='.$id.'"><i class="far fa-trash-alt text-danger"></i></a>
		</td>
	</tr>';


	

}

echo  '
</tbody>
</table> ';


?>