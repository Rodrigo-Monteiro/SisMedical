<?php 

require_once("../../conexao.php");
$pagina = 'processos';

$txtbuscar  = @$_POST['txtbuscar'];
$cpf_adv	  = $_SESSION['cpf_usuario'];

$ind_status = @$_POST['status_proc'];

if ($ind_status == 'Total'){
	$ind_status = null;
}


echo '
<table class="table table-responsive-sm table-sm mt-3 tabelas">
	<thead class="thead-light">
		<tr>
			<th scope="col">Número do Processo</th>
			<th scope="col">Vara</th>
			<th scope="col">Tipo de Ação</th>
			<th scope="col">Cliente</th>
			<th scope="col">Status</th>			

			<th scope="col">Ações</th>
		</tr>
	</thead>
	<tbody>';

	
	$itens_por_pagina = $_POST['itens'];

	//PEGAR A PÁGINA ATUAL
		$pagina_pag = intval(@$_POST['pag']);
		
		$limite = $pagina_pag * $itens_por_pagina;

		//CAMINHO DA PAGINAÇÃO
		$caminho_pag = 'index.php?acao='.$pagina.'&';

	if($txtbuscar == ''){
		$res = $pdo->query("SELECT * 
													FROM processos 
												 WHERE advogado = '$cpf_adv' 
												   AND CASE '$ind_status' 
												          WHEN 'Arquivado' THEN status = 'Arquivado'
												          WHEN 'Ativo'     THEN status = 'Ativo'
												          ELSE 1 = 1 END
										  ORDER BY id desc LIMIT $limite, $itens_por_pagina");
	}else{
		$txtbuscar = '%'.@$_POST['txtbuscar'].'%';
		$res = $pdo->query("SELECT * 
			                    FROM processos 
			                   WHERE advogado = '$cpf_adv' 
			                     AND CASE '$ind_status' 
												          WHEN 'Arquivado' THEN status = 'Arquivado'
												          WHEN 'Ativo'     THEN status = 'Ativo'
												          ELSE 1 = 1 END 
			                     AND (num_processo LIKE '$txtbuscar' or cliente LIKE '$txtbuscar') 
			                ORDER BY id desc");

	}
	
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);


	//TOTALIZAR OS REGISTROS PARA PAGINAÇÃO
		$res_todos = $pdo->query("SELECT * from processos");
		$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
		$num_total = count($dados_total);

		//DEFINIR O TOTAL DE PAGINAS
		$num_paginas = ceil($num_total/$itens_por_pagina);


	for ($i=0; $i < count($dados); $i++) { 
			foreach ($dados[$i] as $key => $value) {
			}

			$id 			= $dados[$i]['id'];	
			$num_processo 	= $dados[$i]['num_processo'];			
			$vara 			= $dados[$i]['vara'];
			$tipo_acao	 	= $dados[$i]['tipo_acao'];
			$cliente 		= $dados[$i]['cliente'];
			$status 		= $dados[$i]['status'];	

			$res_vara 	 = $pdo->query("SELECT * FROM varas WHERE id = '$vara' ");
			$dados_vara  = $res_vara->fetchAll(PDO::FETCH_ASSOC);
			$linhas_vara = count($dados_vara);
			$nome_vara   = $dados_vara[0]['nome'];

			$res_tipo 	 = $pdo->query("SELECT * FROM especialidades WHERE id = '$tipo_acao' ");
			$dados_tipo  = $res_tipo->fetchAll(PDO::FETCH_ASSOC);
			$linhas_tipo = count($dados_tipo);
			$nome_tipo   = $dados_tipo[0]['nome'];

			$res_cliente 	= $pdo->query("SELECT * FROM clientes WHERE cpf = '$cliente' ");
			$dados_cliente  = $res_cliente->fetchAll(PDO::FETCH_ASSOC);
			$linhas_cliente = count($dados_cliente);
			$nome_cliente   = $dados_cliente[0]['nome'];


			//VERIFICAR SE O PROCESSO TEM PAGAMENTO PENDENTE
			$res_receber 	   = $pdo->query("SELECT * FROM contas_receber WHERE id_processo = '$id' and ind_pagamento != 'S' ");
			$dados_receber   = $res_receber->fetchAll(PDO::FETCH_ASSOC);
			$linhas_receber  = count($dados_receber);
			
			if ($linhas_receber > 0) {
				$cor_square = 'text-danger';
				$title 			= 'Pagamento a Receber';
			}else{
				$cor_square = 'text-success';
				$title 			= 'Sem Pagamento a Receber';
			}

echo '
		<tr>

			
			<td title="'.$title.'"><i class="fas fa-square mr-1 '.$cor_square.'"></i><a class="text-dark" title="Lançar Observação" href="index.php?acao='.$pagina.'&funcao=obs&id='.$id.'">'.$num_processo.'</td>
			<td>'.$nome_vara.'</td>
			<td>'.$nome_tipo.'</td>
			<td>'.$nome_cliente.'</td>
			<td>';
					
					if ( $status == 'Ativo') {
						echo '
						<a title="Concluir Processo" href="index.php?acao='.$pagina.'&funcao=concluir&id='.$id.'">
						<i class="fas fa-circle ml-1 text-success"></i>';
					} 

					if ( $status == 'Arquivado') {
						echo '
						<i class="fas fa-circle ml-1 text-danger"></i>';
					} 

					
			echo '<span class="ml-1">'.$status.'</span>	</a></td>

			<td>

				<big>
					<a title="Editar Processo" href="index.php?acao='.$pagina.'&funcao=editar&id='.$id.'"><i class="fas fa-edit text-info"></i></a>';

					if ( $status != 'Arquivado') {
						echo '
							<a  href="index.php?acao='.$pagina.'&funcao=excluir&id='.$id.'"><i class="far fa-trash-alt text-danger"></i></a>';
					} else {
						echo '<i class="far fa-trash-alt ml-1 text-danger"></i>';
					}
					

					echo'
						<a title="Gerar Cobrança" href="index.php?acao='.$pagina.'&funcao=cobranca&id='.$id.'">
						<i class="fas fa-money-bill-alt ml-1 text-success"></i></a>

						<a title="Marcar Audiência" href="index.php?acao='.$pagina.'&funcao=audiencia&num='.$num_processo.'"><i class="fas fa-folder-open text-warning ml-1"></i></a>	

						<a title="Marcar Tarefa" href="index.php?acao='.$pagina.'&funcao=tarefa&num='.$num_processo.'&cliente='.$cliente.'"><i class="fas fas fa-tasks text-success ml-1"></i></a>	

						<a title="Movimentação do Processo" href="index.php?acao='.$pagina.'&funcao=hist&num='.$num_processo.'">
						<i class="far fa-file-alt ml-1 text-info"></i></a>

						<a title="Gerar Petição" href="index.php?acao='.$pagina.'&funcao=peticao&num_processo='.$num_processo.'"><i class="fab fa-product-hunt text-info ml-1"></i></a>
					</big>
			</td>
		</tr>';

	}

echo  '
	</tbody>
</table> ';


if($txtbuscar == ''){


echo '
<!--ÁREA DA PÁGINAÇÃO -->
<nav class="paginacao" aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item">
              <a class="btn btn-outline-dark btn-sm mr-1" href="'.$caminho_pag.'pagina=0&itens='.$itens_por_pagina.'" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>';
            
            for($i=0;$i<$num_paginas;$i++){
            $estilo = "";
            if($pagina_pag == $i)
              $estilo = "active";

          echo '
             <li class="page-item"><a class="btn btn-outline-dark btn-sm mr-1 '.$estilo.'" href="'.$caminho_pag.'pagina='.$i.'&itens='.$itens_por_pagina.'">'.($i+1).'</a></li>';
           } 
            
           echo '<li class="page-item">
              <a class="btn btn-outline-dark btn-sm" href="'.$caminho_pag.'pagina='.($num_paginas-1).'&itens='.$itens_por_pagina.'" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
</nav>

';

}


?>