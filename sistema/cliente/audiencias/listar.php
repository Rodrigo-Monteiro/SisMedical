<?php 

require_once("../../conexao.php");
$pagina 	= 'audiencias';
$agora 		= date('Y-m-d');
$txtbuscar 	= @$_POST['txtbuscar'];
$txtbuscar2	= '%'.@$_POST['txtbuscar2'].'%';
$cpf        = $_SESSION['cpf_usuario'];


echo '
<table class="table table-responsive-sm table-sm mt-3 tabelas">
<thead class="thead-light">
<tr>
<th scope="col">Número do Processo</th>
<th scope="col">Descrição</th>
<th scope="col">Local</th>
<th scope="col">Data da Audiência</th>
<th scope="col">Hora da Audiência</th>
<th scope="col">Prazo</th>
<th scope="col">Advogado</th>

<th scope="col">Ações</th>
</tr>
</thead>
<tbody>';


if(($txtbuscar == '' or $agora == $txtbuscar) and $txtbuscar2 == '%%' ){
	$res = $pdo->query("SELECT * from audiencias where data_audiencia >= curDate() and cliente = '$cpf' order by data_audiencia desc limit 20");
}else{
	if ($txtbuscar2 == '%%') {
		$res = $pdo->query("SELECT * from audiencias where data_audiencia = '$txtbuscar' and cliente = '$cpf' order by hora_audiencia asc");
	} else {
		$res = $pdo->query("SELECT * from audiencias where num_processo like '$txtbuscar2' and cliente = '$cpf' order by hora_audiencia asc");
	}

}

$dados = $res->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($dados); $i++) { 
	foreach ($dados[$i] as $key => $value) {
	}

	$id 			= $dados[$i]['id'];
	$num_processo	= $dados[$i]['num_processo'];	
	$descricao 		= $dados[$i]['descricao'];
	$local 			= $dados[$i]['local'];
	$data_audiencia = $dados[$i]['data_audiencia'];
	$hora_audiencia = $dados[$i]['hora_audiencia'];
	$advogado 		= $dados[$i]['advogado'];
	$cliente 		= $dados[$i]['cliente'];

	$data2 = implode('/',array_reverse(explode('-',$data_audiencia)));

	//CALCULAR DIAS ENTRE DATAS
	$diferenca = strtotime($data_audiencia) - strtotime($agora);
    $prazo 	   = floor($diferenca / (60*60*24));

	//BUSCAR O NOME DO ADVOGADO
	$res_adv 	   = $pdo->query("select * from advogados where cpf = '$advogado'");	
	$dados_adv 	   = $res_adv->fetchAll(PDO::FETCH_ASSOC);
	$nome_advogado = @$dados_adv[0]['nome'];	
	
	echo '
	<tr>

		<td>'.$num_processo.'</td>
		<td>'.$descricao.'</td>
		<td>'.$local.'</td>
		<td>'.$data2.'</td>
		<td>'.$hora_audiencia.'</td>
		<td>'.$prazo.' dias</td>
		<td>'.$nome_advogado.'</td>
		
		<td>

			<a title="Observação" href="index.php?acao='.$pagina.'&funcao=obs&id='.$id.'"><i class="fas fa-comment text-info"></i></a>

		</td>
	</tr>';


	

}

echo  '
</tbody>
</table> ';


?>