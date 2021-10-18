<?php 

require_once("../../conexao.php");
$pagina = 'contas_pagar';
$agora  = date('Y-m-d');

$txtbuscar  = @$_POST['txtbuscar'];
$cpf		= $_SESSION['cpf_usuario'];

if($txtbuscar == NULL or $txtbuscar == '' or $txtbuscar == $agora ){

	$res = $pdo->query("  SELECT *
			                FROM contas_receber 
		                   WHERE cliente = '$cpf' 
		                ORDER BY data desc
		               ");
}else{
	$res = $pdo->query("    SELECT *
			                  FROM contas_receber 
			                 WHERE cliente = '$cpf'
			                   AND data = '$txtbuscar' 
			              ORDER BY id asc
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
			<th scope="col">Data</th>
			<th scope="col">Pago</th>
		</tr>
	</thead>
	<tbody>';	
	
	for ($i=0; $i < count($dados); $i++) { 
			foreach ($dados[$i] as $key => $value) {
			}

			$id = $dados[$i]['id'];	
			$valor = $dados[$i]['valor'];
			
			$descricao = $dados[$i]['descricao'];
			$cpf_adv   = $dados[$i]['advogado'];
			$status    = $dados[$i]['ind_pagamento'];
			$data    = $dados[$i]['data'];
			$data2 = implode('/', array_reverse(explode('-', $data)));

			$res_adv   = $pdo->query(" SELECT * FROM advogados WHERE cpf = '$cpf_adv' ");
			$dados_adv = $res_adv->fetchAll(PDO::FETCH_ASSOC);
			$advogado  = $dados_adv[0]['nome'];

echo '
		<tr>

			
			<td>'.$descricao.'</td>
			
			
			<td>R$ '.$valor.'</td>
			<td>'.$advogado.'</td>
			<td>'.$data2.'</td>
			
			<td>';
				
				
				if ( $status == 'N') {
					echo '
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