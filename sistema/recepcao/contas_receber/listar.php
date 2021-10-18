<?php 

require_once("../../conexao.php");
$pagina = 'contas_receber';

$txtbuscar  = @$_POST['txtbuscar'];
$txtbuscar2 = @$_POST['txtbuscar2'];
$cpf_adv	= $_SESSION['cpf_usuario'];

if($txtbuscar == NULL and $txtbuscar2 == NULL){

	$res = $pdo->query("  SELECT r.id
			                   , r.descricao
			                   , r.valor
			                   , r.advogado
			                   , r.cliente
			                   , r.data
			                   , r.ind_pagamento
			                   , r.id_processo 
			                   , c.nome as nome_cliente
			                   , a.nome as nome_advogado
			                FROM contas_receber r INNER JOIN clientes c  ON r.cliente = c.cpf
			                                      INNER JOIN advogados a ON r.advogado = a.cpf
		                   WHERE r.data >= curDate()
		               ");
}else{
	$txtbuscar2 = '%'.$txtbuscar2.'%';
	$res = $pdo->query("    SELECT r.id
			                     , r.descricao
			                     , r.valor
			                     , r.advogado
			                     , r.cliente
			                     , r.data
			                     , r.ind_pagamento
			                     , r.id_processo 
			                     , c.nome as nome_cliente
			                     , a.nome as nome_advogado
			                  FROM contas_receber r INNER JOIN clientes c  ON r.cliente = c.cpf
			                                        INNER JOIN advogados a ON r.advogado = a.cpf
			                 WHERE r.data = '$txtbuscar' 
			                   OR (r.cliente LIKE '$txtbuscar2' OR c.nome LIKE '$txtbuscar2')
			           ");

}

$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$total_registros = count($dados);

if ($total_registros >0) {

echo '
<table class="table table-responsive-sm table-sm mt-3 tabelas">
	<thead class="thead-light">
		<tr>
			<th scope="col">Descrição</th>
			<th scope="col">Valor</th>
			<th scope="col">Advogado</th>
			<th scope="col">Cliente</th>

			<th scope="col">Ações</th>
		</tr>
	</thead>
	<tbody>';	
	
	for ($i=0; $i < count($dados); $i++) { 
			foreach ($dados[$i] as $key => $value) {
			}

			$id = $dados[$i]['id'];	
			$valor = $dados[$i]['valor'];
			
			$descricao = $dados[$i]['descricao'];
			$cliente   = $dados[$i]['nome_cliente'];
			$advogado  = $dados[$i]['nome_advogado'];
			$status    = $dados[$i]['ind_pagamento'];

echo '
		<tr>

			
			<td>'.$descricao.'</td>
			
			
			<td>R$ '.$valor.'</td>
			<td>'.$advogado.'</td>
			<td>'.$cliente.'</td>
			
			<td>';
				
				
				if ( $status == 'N') {
					echo '
					<a title="Excluir Registro" href="index.php?acao='.$pagina.'&funcao=excluir&id='.$id.'"><i class="far fa-trash-alt text-danger"></i></a>
					<a title="Baixar Pagamento" href="index.php?acao='.$pagina.'&funcao=concluir&id='.$id.'">
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