<?php 

require_once("../../conexao.php");
$pagina = 'agenda';

$txtbuscar = @$_POST['txtbuscar'];
$cpf_adv	= $_SESSION['cpf_usuario'];
$agora  = date('Y-m-d');

if($txtbuscar == NULL or $txtbuscar == $agora){

	$res = $pdo->query("SELECT * from tarefas where advogado = '$cpf_adv' and data >= curDate() order by data,hora asc");
}else{
	$txtbuscar = @$_POST['txtbuscar'];
	$res = $pdo->query("SELECT * from tarefas where advogado = '$cpf_adv' and data = '$txtbuscar' order by hora asc");

}

$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$total_registros = count($dados);

if ($total_registros >0) {

echo '
<table class="table table-sm table-responsive-sm mt-3 tabelas">
	<thead class="thead-light">
		<tr>
			<th scope="col">Número Processo</th>
			<th scope="col">Cliente</th>
			<th scope="col">Nome</th>
			<th scope="col">Descrição</th>
			<th scope="col">Data</th>
			<th scope="col">Hora</th>

			<th scope="col">Ações</th>
		</tr>
	</thead>
	<tbody>';	
	
	for ($i=0; $i < count($dados); $i++) { 
			foreach ($dados[$i] as $key => $value) {
			}

			$id = $dados[$i]['id'];	
			$nome = $dados[$i]['nome'];
			
			$descricao 	  = $dados[$i]['descricao'];
			$data 		  = data($dados[$i]['data']);
			$hora 		  = $dados[$i]['hora'];
			$status 	  = $dados[$i]['status'];
			$num_processo = $dados[$i]['num_processo'];
			$cliente 	  = $dados[$i]['cliente'];

			$res_c 		  = $pdo->query("select * from clientes where cpf = '$cliente'");
			$dados_c 	  = $res_c->fetchAll(PDO::FETCH_ASSOC);
			$nome_cliente = @$dados_c[0]['nome'];

echo '
		<tr>

			<td>'.$num_processo.'</td>
			<td>'.$nome_cliente.'</td>
			<td>'.$nome.'</td>
			<td>'.$descricao.'</td>
			<td>'.$data.'</td>
			<td>'.$hora.'</td>
			
			<td>
				<a title="Editar Registro" href="index.php?acao='.$pagina.'&funcao=editar&id='.$id.'"><i class="fas fa-edit text-info mr-1"></i></a>
				<a title="Excluir Registro" href="index.php?acao='.$pagina.'&funcao=excluir&id='.$id.'"><i class="far fa-trash-alt text-danger"></i></a>';
				
				if ( $status == 'Agendada') {
					echo '
					<a title="Concluir Tarefa" href="index.php?acao='.$pagina.'&funcao=concluir&id='.$id.'">
					<i class="fas fa-circle ml-1 text-danger"></i></a>';
				} else {
					echo '
					<i class="fas fa-circle ml-1 text-success"></i>';
				}
				echo '
			</td>
		</tr>';

	}

echo  '
	</tbody>
</table> ';

} else {
	echo 'Não existem Registros Cadastrados!!';
}




function data($data){
    return date("d/m/Y", strtotime($data));
}

?>