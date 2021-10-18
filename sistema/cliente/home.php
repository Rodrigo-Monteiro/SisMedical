<?php 

require_once("../conexao.php");

$cpf	= $_SESSION['cpf_usuario'];

//TOTALIZAR PROCESSOS DO CLIENTE
$res    		 = $pdo->query("SELECT * FROM processos where cliente = '$cpf'");
$dados  		 = $res->fetchAll(PDO::FETCH_ASSOC); 
$total_processos = count($dados);

//TOTALIZAR PROCESSOS CONCLUÍDOS DO CLIENTE
$res_c    		      = $pdo->query("SELECT * FROM processos where cliente = '$cpf' and status = 'Concluído'");
$dados_c  		 	  = $res_c->fetchAll(PDO::FETCH_ASSOC); 
$processos_concluidos = count($dados_c);

//TOTALIZAR PROCESSOS EM ANDAMENTOS DO CLIENTE
$res_a    		      = $pdo->query("SELECT * FROM processos where cliente = '$cpf' and status = 'Andamento'");
$dados_a  		 	  = $res_a->fetchAll(PDO::FETCH_ASSOC); 
$processos_andamento  = count($dados_a);

//TOTALIZAR CONTAS A PAGAR DO CLIENTE
$res_contas   = $pdo->query("SELECT * FROM contas_receber where cliente = '$cpf' and ind_pagamento = 'N'");
$dados_contas = $res_contas->fetchAll(PDO::FETCH_ASSOC); 
$contas  	  = count($dados_contas)
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
									<i class="far fa-file-alt"></i>							
								</div>							
							</div>

							<div class="col-7 col-md-8">
								<div class="numbers">
									<p class="titulo-card">Processos</p>
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
									<i class="fas fa-paste"></i>
								</div>							
							</div>

							<div class="col-7 col-md-8">
								<div class="numbers">
									<p class="titulo-card">Processos Concluídos</p>
									<p class="subtitulo-card"><?php echo $processos_concluidos ?></p>							
								</div>							
							</div>
						</div>					
					</div>

					<div class="card-footer rodape-card">
						Processos Concluídos
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col-5 col-md-4">
								<div class="icone-card text-center text-primary">
									<i class="fas fa-paste"></i>
								</div>							
							</div>

							<div class="col-7 col-md-8">
								<div class="numbers">
									<p class="titulo-card">Processos Andamento</p>
									<p class="subtitulo-card"><?php echo $processos_andamento ?></p>							
								</div>							
							</div>
						</div>					
					</div>

					<div class="card-footer rodape-card">
						Processos em Andamento
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col-5 col-md-4">
								<div class="icone-card text-center text-danger">
									<i class="fas fa-hand-holding-usd"></i>
								</div>							
							</div>

							<div class="col-7 col-md-8">
								<div class="numbers">
									<p class="titulo-card">Contas a Pagar</p>
									<p class="subtitulo-card"><?php echo $contas ?></p>							
								</div>							
							</div>
						</div>					
					</div>

					<div class="card-footer rodape-card">
						Contas a pagar Pendentes
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
			$res_aud = $pdo->query("SELECT * from audiencias where cliente = '$cpf' and data_audiencia >= curDate() order by data_audiencia,hora_audiencia asc limit 4");

			$dados_aud = $res_aud->fetchAll(PDO::FETCH_ASSOC);

			for ($i=0; $i < count($dados_aud); $i++) { 
				foreach ($dados_aud[$i] as $key => $value) {
				}

				$id 		  	= $dados_aud[$i]['id'];	
				$num_processo 	= $dados_aud[$i]['num_processo'];
				$descricao 		= $dados_aud[$i]['descricao'];
				$data_audiencia = $dados_aud[$i]['data_audiencia'];
				$hora_audiencia = $dados_aud[$i]['hora_audiencia'];
				$local 			= $dados_aud[$i]['local'];

				
				?>

				<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
					<div class="card card-stats bg-light mb-3">
						<div class="card-header bg-dark text-white"><?php echo "Data: ".data($data_audiencia). "  -  " .$hora_audiencia."  -  ".$local ?></div>
						<div class="card-body">
							<span class="card-title text-secondary"><big><?php echo "Processo: <br>".$num_processo ?></big></span>
							<hr>
							<span class="card-title text-dark"><b><?php echo $descricao ?></b></span>
						</div>
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