<?php 

require_once("../conexao.php");

$cpf_adv	= $_SESSION['cpf_usuario'];

//TOTALIZAR PROCESSOS ATIVOS
$res_c    		 	= $pdo->query("SELECT * FROM processos where advogado = '$cpf_adv' and status = 'Ativo'");
$dados_c  		 	= $res_c->fetchAll(PDO::FETCH_ASSOC); 
$total_processo_ati = count($dados_c);

//TOTALIZAR PROCESSOS ARQUIVADOS
$res_arq    		= $pdo->query("SELECT * FROM processos where advogado = '$cpf_adv' and status = 'Arquivado'");
$dados_arq  		= $res_arq->fetchAll(PDO::FETCH_ASSOC); 
$total_processo_arq = count($dados_arq);

//TOTALIZAR PROCESSOS DO ADVOGADO
$res_p    		 = $pdo->query("SELECT * FROM processos where advogado = '$cpf_adv'");
$dados_p  		 = $res_p->fetchAll(PDO::FETCH_ASSOC); 
$total_processos = count($dados_p);

//TOTALIZAR PROCESSOS DO ADVOGADO
$res_a    		 = $pdo->query("SELECT * FROM audiencias where advogado = '$cpf_adv' and data_audiencia >= curDate()");
$dados_a  		 = $res_a->fetchAll(PDO::FETCH_ASSOC); 
$total_audiencia = count($dados_a);

//TOTALIZAR PROCESSOS DO ADVOGADO
$res_t    		 = $pdo->query("SELECT * FROM tarefas where advogado = '$cpf_adv' and data >= curDate() ");
$dados_t  		 = $res_t->fetchAll(PDO::FETCH_ASSOC); 
$total_tarefas 	 = count($dados_t);
?>

<div class="container-fluid">

	<div class="area_cards">
		<div class="row">

			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col-5 col-md-4">
								<div class="icone-card text-center text-info">
									<a class="text-info" href="index.php?acao=processos"><i class="fas fa-folder-open"></i></a>
								</div>							
							</div>

							<div class="col-7 col-md-8">
								<div class="numbers">
									<p class="titulo-card">Carteira</p>
									<p class="subtitulo-card"><?php echo $total_processos ?></p>
								</div>
							</div>

						</div>
					</div>

					<div class="card-footer rodape-card">
						Total de Processos
					</div>
				</div>			
			</div>

			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col-5 col-md-4">
								<div class="icone-card text-center text-success">
									<a class="text-success" href="index.php?acao=processos&ind_status=Ativo"><i class="fas fa-file-upload"></i></a>
								</div>							
							</div>

							<div class="col-7 col-md-8">
								<div class="numbers">
									<p class="titulo-card">Processos Ativos</p>
									<p class="subtitulo-card"><?php echo $total_processo_ati ?></p>							
								</div>							
							</div>
						</div>					
					</div>

					<div class="card-footer rodape-card">
						Total de Processos Ativos
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col-5 col-md-4">
								<div class="icone-card text-center text-secondary">
									<a class="text-secondary" href="index.php?acao=processos&ind_status=Arquivado"><i class="fas fa-file-download"></i></a>
								</div>							
							</div>

							<div class="col-7 col-md-8">
								<div class="numbers">
									<p class="titulo-card">Processos Arquivados</p>
									<p class="subtitulo-card"><?php echo $total_processo_arq ?></p>							
								</div>							
							</div>
						</div>					
					</div>

					<div class="card-footer rodape-card">
						Total de Processos Arquivados
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col-5 col-md-4">
								<div class="icone-card text-center text-danger">
									<a class="text-danger" href="index.php?acao=agenda"><i class="far fa-calendar-alt"></i></a>
								</div>							
							</div>

							<div class="col-7 col-md-8">
								<div class="numbers">
									<p class="titulo-card">Tarefas Agendadas</p>
									<p class="subtitulo-card"><?php echo $total_tarefas ?></p>							
								</div>							
							</div>
						</div>					
					</div>

					<div class="card-footer rodape-card">
						Tarefas para Hoje
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="mt-4">
		<i class="far fa-calendar-check ml-4 text-danger"></i>
		<span class="text-muted ml-1">PRÓXIMAS AUDIÊNCIAS</span>
		<hr>

		<div class="row">


			<?php  
			$res = $pdo->query("SELECT * from audiencias where advogado = '$cpf_adv' and data_audiencia >= curDate() order by data_audiencia,hora_audiencia asc limit 4");

			$dados_aud = $res->fetchAll(PDO::FETCH_ASSOC);

			for ($i=0; $i < count($dados_aud); $i++) { 
				foreach ($dados_aud[$i] as $key => $value) {
				}

				$id_aud  	  	= $dados_aud[$i]['id'];	
				$num_processo 	= $dados_aud[$i]['num_processo'];
				$descricao 		= $dados_aud[$i]['descricao'];
				$data_audiencia = $dados_aud[$i]['data_audiencia'];
				$hora_audiencia = $dados_aud[$i]['hora_audiencia'];
				$local 			= $dados_aud[$i]['local'];

				$cliente   	    = $dados_aud[$i]['cliente'];

				$res_cliente   = $pdo->query("SELECT * from clientes where cpf = '$cliente' ");
				$dados_cliente = $res_cliente->fetchAll(PDO::FETCH_ASSOC);
				$nome_cliente  = $dados_cliente[0]['nome'];
				?>

				<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
					<div class="card card-stats bg-light mb-3">
						
						<?php 
							echo ' <a href="index.php?acao=audiencias&funcao=editar&id='.$id_aud.'">';
						?>
						<div class="card-header bg-dark text-white"><?php echo "Data: ".data($data_audiencia). "  -  " .$hora_audiencia."  -  ".$local ?></div>
						<div class="card-body">
							<span class="card-title text-secondary"><?php echo "<b>Processo:</b> <br>".$num_processo ?></span>
							<span class="card-title text-secondary"><?php echo "<br><b>Cliente:</b> <br>".$nome_cliente ?></span>
							<hr>
							<span class="card-title text-dark"><b><?php echo $descricao ?></b></span>
						</div>
						<?php 
							echo ' </a>';
						?>
					</div>	
				</div>
			<?php } ?> 

		</div>	
	</div>
</div>
<?php 
function data($data){
	return date("d/m/Y", strtotime($data));
}
?>