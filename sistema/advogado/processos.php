<?php 
$pagina = 'processos'; 
$agora  = date('Y-m-d');
$data  = date('Y-m-d');
?>


<div class="container">
	<div class="row botao-novo">
		<div class="col-md-12">
			<a id="btn-novo" data-toggle="modal" data-target="#modal"></a>
		</div>
	</div>



	<div class="row mt-4">
		<div class="col-md-6 col-sm-12">
			<div class="float-left">
				<form method="post">
					<select id="itens-pagina" onChange="submit();" class="form-control-sm" id="exampleFormControlSelect1" name="itens-pagina">

						<?php 

						if(isset($_POST['itens-pagina'])){
							$item_paginado = $_POST['itens-pagina'];
						}elseif(isset($_GET['itens'])){
							$item_paginado = $_GET['itens'];
						} 

						?>

						<option value="<?php echo @$item_paginado ?>"><?php echo @$item_paginado ?> Registros</option>

						<?php if(@$item_paginado != $opcao1){ ?> 
							<option value="<?php echo $opcao1 ?>"><?php echo $opcao1 ?> Registros</option>
						<?php } ?>

						<?php if(@$item_paginado != $opcao2){ ?> 
							<option value="<?php echo $opcao2 ?>"><?php echo $opcao2 ?> Registros</option>
						<?php } ?>

						<?php if(@$item_paginado != $opcao3){ ?> 
							<option value="<?php echo $opcao3 ?>"><?php echo $opcao3 ?> Registros</option>
						<?php } ?>

						
						

					</select>

				</form>
			</div>

		</div>


		<?php 

	//DEFINIR O NUMERO DE ITENS POR PÁGINA
		if(isset($_POST['itens-pagina'])){
			$itens_por_pagina = $_POST['itens-pagina'];
			@$_GET['pagina'] = 0;
		}elseif(isset($_GET['itens'])){
			$itens_por_pagina = $_GET['itens'];
		}
		else{
			$itens_por_pagina = $opcao1;

		}

		?>




		<div class="col-md-6 col-sm-12">

			<div class="float-right mr-4">
				<form id="frm" class="form-inline my-2 my-lg-0" method="post">

					<input type="hidden" id="pag"  name="pag" value="<?php echo @$_GET['pagina'] ?>">

					<input type="hidden" id="itens"  name="itens" value="<?php echo @$itens_por_pagina; ?>">

					
					<select id="status_proc" class="form-control-sm mr-sm-2" name="status_proc">

						<?php   
							if(isset($_POST['status_proc'])){
								$ind_status = $_POST['status_proc'];
							}elseif(isset($_GET['ind_status'])){
								$ind_status = $_GET['ind_status'];
							} else {
								$ind_status = $status1;
							}							

							if (@$ind_status == null){
								$ind_status = 'Total';
							}
						?>

						<option value="<?php echo @$ind_status ?>">Processo <?php echo @$ind_status ?></option>

						<?php if(@$ind_status != $status1){ ?> 
							<option value="<?php echo $status1 ?>">Processo <?php echo $status1 ?></option>
						<?php } ?>

						<?php if(@$ind_status != $status2){ ?> 
							<option value="<?php echo $status2 ?>">Processo <?php echo $status2 ?></option>
						<?php } ?>

						<?php if(@$ind_status != $status3){ ?> 
							<option value="<?php echo $status3 ?>">Processo <?php echo $status3 ?></option>
						<?php } ?>

					</select>

					<input class="form-control form-control-sm mr-sm-2" type="text" name="txtbuscar" id="txtbuscar" placeholder="Processo ou CPF/CNPJ">
					<button class="btn btn-outline-secondary btn-sm my-2 my-sm-0" name="btn-buscar" id="btn-buscar"><i class="fas fa-search"></i></button>
				</form>
			</div>

		</div>


	</div>


	<div id="listar" class="mt-4">

	</div>

</div>


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					<?php if(@$_GET['funcao'] == 'editar'){

						$nome_botao = 'Editar';
						$id_reg = $_GET['id'];

							//BUSCAR DADOS DO REGISTRO A SER EDITADO
						$res = $pdo->query("select * from processos where id = '$id_reg'");
						$dados = $res->fetchAll(PDO::FETCH_ASSOC);

						$num_processo 	= $dados[0]['num_processo'];
						$vara 			= $dados[0]['vara'];
						$tipo_acao 	    = $dados[0]['tipo_acao'];
						$data_peticao 	= $dados[0]['data_peticao'];
						$status 		= $dados[0]['status'];

						if ($data == '') {
							$data = date('Y-m-d');
						}

						echo 'Edição do Processo';
					} ?>
				</h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		
			<div class="modal-body">

				<form method="post">

					<input type="hidden" class="form-control" id="antigo" name="antigo" value="<?php echo $num_processo ?>">

					<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id_reg ?>">

					<div class="row">
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Número Processo</label>
								<input type="text" class="form-control" id="num_processo" name="num_processo" placeholder="Número do Processo" value="<?php echo $num_processo ?>">
							</div>
						</div>

						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Vara</label>
								<select class="form-control" id="" name="vara">
									<?php 
											//SE EXISTIR EDIÇÃO DOS DADOS, TRAZER COMO PRIMEIRO REGISTRO O CARGO DO FUNCIONARIO
										if(@$_GET['funcao'] == 'editar'){

											$res_vara   = $pdo->query("SELECT * from varas where id = '$vara'");
											$dados_vara = $res_vara->fetchAll(PDO::FETCH_ASSOC);

											for ($i=0; $i < count($dados_vara); $i++) { 
												foreach ($dados_vara[$i] as $key => $value) {
												}

												$id_vara   = $dados_vara[$i]['id'];	
												$nome_vara = $dados_vara[$i]['nome'];

											}


											echo '<option value="'.$id_vara.'">'.$nome_vara.'</option>';
										}

										//TRAZER TODOS OS REGISTROS DE CARGOS
										$res   = $pdo->query("SELECT * from varas order by nome asc");
										$dados = $res->fetchAll(PDO::FETCH_ASSOC);

										for ($i=0; $i < count($dados); $i++) { 
											foreach ($dados[$i] as $key => $value) {
											}

											$id   = $dados[$i]['id'];	
											$nome = $dados[$i]['nome'];

											if($nome_vara != $nome){
												echo '<option value="'.$id.'">'.$nome.'</option>';
											}


										}
									?>						
								</select>
							</div>
						</div>

						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Tipo Ação</label>
								<select class="form-control" id="" name="tipo_acao">
									<?php 
										//SE EXISTIR EDIÇÃO DOS DADOS, TRAZER COMO PRIMEIRO REGISTRO O CARGO DO FUNCIONARIO
										if(@$_GET['funcao'] == 'editar'){

											$res_espec  = $pdo->query("SELECT * from especialidades where id = '$tipo_acao'");
											$dados_espec = $res_espec->fetchAll(PDO::FETCH_ASSOC);

											for ($i=0; $i < count($dados_espec); $i++) { 
												foreach ($dados_espec[$i] as $key => $value) {
												}

												$id_espec   = $dados_espec[$i]['id'];	
												$nome_espec = $dados_espec[$i]['nome'];

											}

											echo '<option value="'.$id_espec.'">'.$nome_espec.'</option>';
										}

										$res   = $pdo->query("SELECT * from especialidades order by nome asc");
										$dados = $res->fetchAll(PDO::FETCH_ASSOC);

										for ($i=0; $i < count($dados); $i++) { 
											foreach ($dados[$i] as $key => $value) {
											}

											$id   = $dados[$i]['id'];	
											$nome = $dados[$i]['nome'];

											if($nome_espec != $nome){
												echo '<option value="'.$id.'">'.$nome.'</option>';
											}
										}
									?>						
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Data Petição</label>
								<input class="form-control form-control-sm mr-sm-2" type="date" name="data_peticao" id="data_peticao" value="<?php echo @$data_peticao ?>">
							</div>
						</div>

						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Status Processo</label>
								<select class="form-control" id="" name="status">
									<?php 
									
									echo '<option value="'.$status.'">'.$status.'</option>';

									if($status != 'Ativo'){
										echo '<option value="Aberto">Aberto</option>';
									}
									
									if($status != 'Arquivado'){
										echo '<option value="Arquivado">Arquivado</option>';
									}									
									
									?>						
								</select>
							</div>
						</div>
					</div>

					<div id="mensagem" class="">

					</div>
				</form>
			</div>
			


			<div class="modal-footer">
				<button id="btn-fechar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

				<button name="<?php echo $nome_botao ?>" id="<?php echo $nome_botao ?>" class="btn btn-primary"><?php echo $nome_botao ?></button>

			</div>
		
		</div>
	</div>
</div>


<!--CHAMADA DA MODAL EDITAR -->
<?php 
if(@$_GET['funcao'] == 'editar' && @$item_paginado == ''){ 
	
	?>
	<script>$('#btn-novo').click();</script>
<?php } ?>



<!--CHAMADA DA MODAL DELETAR -->
<?php 
if(@$_GET['funcao'] == 'excluir' && @$item_paginado == ''){ 
	$id = $_GET['id'];
	?>

	<div class="modal" id="modal-deletar" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Cancelar Processo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<p>Deseja realmente cancelar este processo?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
					<form method="post">
						<input type="hidden" id="id"  name="id" value="<?php echo @$id ?>" required>

						<button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	
<?php } ?>

<script>$('#modal-deletar').modal("show");</script>


<!--CHAMADA DA MODAL CONCLUIR  -->
<?php 
if(@$_GET['funcao'] == 'concluir' && @$item_paginado == ''){ 
	$id = $_GET['id'];
	?>

	<div class="modal" id="modal-concluir" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Concluir Processo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<p>Deseja realmente finalizar o processo?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-tarefa">Cancelar</button>
					<form method="post">
						<input type="hidden" id="id"  name="id" value="<?php echo @$id ?>" required>

						<button type="button" id="btn-concluir" name="btn-concluir" class="btn btn-success">Concluir</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	
<?php } ?>

<script>$('#modal-concluir').modal("show");</script>



<!--CHAMADA DA MODAL OBS  -->
<?php 
if(@$_GET['funcao'] == 'obs' && @$item_paginado == ''){ 
	$id = $_GET['id'];
	?>

	<div class="modal" id="modal-obs" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Observação</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form method="post">

						<?php  
							$res 	= $pdo->query("select * from processos where id = '$id'");
							$dados  = $res->fetchAll(PDO::FETCH_ASSOC);
							$obs	= $dados[0]['observacao'];
						?>

						<div class="form-group">
							<label for="exampleFormControlInput1">Observação</label>
							<textarea type="text" class="form-control" name="obs" maxlength="350"><?php echo @$obs ?></textarea>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-obs">Cancelar</button>
					
						<input type="hidden" id="id"  name="id" value="<?php echo @$id ?>" required>

						<button type="button" id="btn-obs" name="btn-obs" class="btn btn-success">Gravar</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	
<?php } ?>

<script>$('#modal-obs').modal("show");</script>


<!--CHAMADA DA MODAL MOVIMENTAÇÃO  -->
<?php 
if(@$_GET['funcao'] == 'hist' && @$item_paginado == ''){ 
	$num_processo = $_GET['num'];
	?>

	<div class="modal" id="modal-historico" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Movimentação</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						
						<div class="form-group">
							<label for="exampleFormControlInput1">Descrição</label>
							<input type="text" class="form-control" name="descricao" placeholder="Descrição da Movimentação">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Observação</label>
							<textarea  class="form-control" name="observacao" maxlength="450"> </textarea>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Data</label>
							<input type="date" class="form-control form-control-sm mr-sm-2" name="data" id="data" value="<?php echo $agora ?>">
						</div>		
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-hist">Cancelar</button>
						
							<input type="hidden" id="num_processo"  name="num_processo" value="<?php echo @$num_processo ?>" required>

							<button type="button" id="btn-historico" name="btn-historico" class="btn btn-success">Lançar Nova Movimentação</button>
						
					</div>
				</form>
			</div>
		</div>
	</div>

	
<?php } ?>

<script>$('#modal-historico').modal("show");</script>



<!--CHAMADA DA MODAL PETIÇÃO  -->
<?php 
if(@$_GET['funcao'] == 'peticao' && @$item_paginado == ''){ 
	$num_processo = $_GET['num_processo'];
	?>
	<div class="modal fade" id="modal-peticao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">
	          Gerar Petição Inicial
	        </h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">

	        <form method="post" action="rel/rel_peticao_class.php" target="_blank" id="form-peticao" name="form-peticao">
	          
				<?php  
					$res 	= $pdo->query("SELECT * FROM peticoes WHERE num_processo = '$num_processo'");
					$dados  = $res->fetchAll(PDO::FETCH_ASSOC);

					$titulo		= @$dados[0]['titulo'];
					$tipo_acao	= @$dados[0]['tipo_acao'];
					$agravante	= @$dados[0]['agravante'];
					$agravado	= @$dados[0]['agravado'];
					$texto		= @$dados[0]['texto'];


					if($titulo != ''){
						$editar = 'S';
					} else {
						$editar = 'N';
					}
				?>

				<input type="hidden" class="form-control" id="num_processo" name="num_processo" value="<?php echo $num_processo ?>">
				<input type="hidden" class="form-control" id="editar" name="editar" value="<?php echo @$editar ?>">


				<div class="form-group">
	              <label for="exampleFormControlInput1">Titulo</label>
	              <input type="text" class="form-control" id="titulo" placeholder="Insira o Titulo" name="titulo" value="<?php echo @$titulo ?>">
	            </div>

	            <div class="form-group">
	              <label for="exampleFormControlInput1">Tipo Ação</label>
	              <input type="text" class="form-control" id="tipo_acao" placeholder="Insira o tipo de ação" name="tipo_acao" value="<?php echo @$tipo_acao ?>">
	            </div>
	           

	            <div class="form-group">
	              <label for="exampleFormControlInput1">Agravante</label>
	              <input type="text" class="form-control" id="agravante" placeholder="Nome do Agravante" name="agravante" value="<?php echo @$agravante ?>">
	            </div>

	            <div class="form-group">
	              <label for="exampleFormControlInput1">Agravado</label>
	              <input type="text" class="form-control" id="agravado" placeholder="Nome do Agravado" name="agravado" value="<?php echo @$agravado ?>">
	            </div>

	            <div class="form-group">
	              <label for="exampleFormControlInput1">Texto</label>
	              <textarea type="text" class="form-control" id="txt_peticao" name="txt_peticao" maxlength="1500"><?php echo @$texto ?></textarea>
	            </div>

	            <div id="mensagem_peticao" class="">
						
				</div>
	      </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	           <button type="submit" name="btn-peticao" id="btn-peticao" class="btn btn-success">Relatório</button>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>

<script>$('#modal-peticao').modal("show");</script>

<!--MASCARAS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="../js/mascaras.js"></script>


<!--AJAX PARA BUSCAR OS DADOS -->
<script type="text/javascript">
	$(document).ready(function(){

		var pag = "<?=$pagina?>";
		$('#btn-buscar').click(function(event){
			event.preventDefault();	
			
			$.ajax({
				url: pag + "/listar.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "html",
				success: function(result){
					$('#listar').html(result)
					
				},
				

			})

		})

		
	})
</script>

<!--AJAX PARA LISTAR OS DADOS -->
<script type="text/javascript">
	$(document).ready(function(){
		
		var pag = "<?=$pagina?>";

		$.ajax({
			url: pag + "/listar.php",
			method: "post",
			data: $('#frm').serialize(),
			dataType: "html",
			success: function(result){
				$('#listar').html(result)

			},

			
		})
	})
</script>



<!--AJAX PARA BUSCAR OS DADOS PELA TROCA NA DATA -->
<script type="text/javascript">
	$('#txtbuscar').keyup(function(){
		$('#btn-buscar').click();
	})
</script>

<!--AJAX PARA BUSCAR OS DADOS PELA TROCA NA DATA -->
<script type="text/javascript">
	$('#status_proc').change(function(){
		$('#btn-buscar').click();
	})
</script>





<!--AJAX PARA EDIÇÃO DOS DADOS -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#Editar').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/editar.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#mensagem').removeClass()

					if(mensagem == 'Editado com Sucesso!!'){
						
						$('#mensagem').addClass('mensagem-sucesso')

					
						$('#btn-buscar').click();

						$('#btn-fechar').click();




					}else{
						
						$('#mensagem').addClass('mensagem-erro')
					}
					
					$('#mensagem').text(mensagem)

				},
				
			})
		})
	})
</script>





<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-deletar').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/excluir.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#btn-buscar').click();
					$('#btn-cancelar-excluir').click();

				},
				
			})
		})
	})
</script>

<!--AJAX PARA CONCLUIR TAREFA -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-concluir').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/concluir.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#txtbuscar').val('')
					$('#btn-buscar').click();
					$('#btn-cancelar-tarefa').click();

				},
				
			})
		})
	})
</script>

<!--CHAMADA DA MODAL COBRANCA  -->
<?php 
if(@$_GET['funcao'] == 'cobranca' && @$item_paginado == ''){ 
	$id = $_GET['id'];
	?>

	<div class="modal" id="modal-cobranca" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Gerar Cobrança</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						

							<div class="form-group">
								<label for="exampleFormControlInput1">Descrição</label>
								<input type="text" class="form-control" name="descricao" placeholder="Descrição da Cobrança"">
							</div>

							<div class="form-group">
								<label for="exampleFormControlInput1">Valor</label>
								<input type="text" class="form-control" name="valor" placeholder="Valor da Cobrança"">
							</div>						
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-cobranca">Cancelar</button>
						
							<input type="hidden" id="id"  name="id" value="<?php echo @$id ?>" required>

							<button type="button" id="btn-cobranca" name="btn-cobranca" class="btn btn-success">Cobrar</button>
						
					</div>
				</form>
			</div>
		</div>
	</div>

	
<?php } ?>

<script>$('#modal-cobranca').modal("show");</script>


<!--CHAMADA DA MODAL MARCAR AUDIENCIA -->
<?php 
if(@$_GET['funcao'] == 'audiencia' && @$item_paginado == ''){ 
	$num_processo = $_GET['num'];
	?>

	<div class="modal" id="modal-audiencia" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Marcar Audiência</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<form method="post">				
						
						<div class="form-group">

							<label for="exampleFormControlInput1">Descrição</label>
							<input type="text" class="form-control" id="descricao" placeholder="Insira a Descrição " name="descricao" required>
						</div>

						<div class="form-group">

							<label for="exampleFormControlInput1">Local</label>
							<input type="text" class="form-control" id="local" placeholder="Insira o Local " name="local" required>
						</div>

						<div class="row">

							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Data da Audiência</label>
									<input class="form-control form-control-sm mr-sm-2" type="date" name="data_audiencia" id="data_audiencia" value="<?php echo $agora ?>">
								</div>
							</div>

							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Hora da Audiência</label>
									<input class="form-control form-control-sm mr-sm-2" type="time" name="hora_audiencia" id="hora_audiencia" ">
								</div>
							</div>

						</div>					
						
			
					
					<div id="mensagem" class="">
						
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar">Cancelar</button>
					
						<input type="hidden" id="num_processo"  name="num_processo" value="<?php echo @$num_processo ?>" required>

						<button type="button" id="btn-audiencia" name="btn-audiencia" class="btn btn-info">Marcar</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	
<?php } ?>

<script>$('#modal-audiencia').modal("show");</script>

<!--CHAMADA DA MODAL MARCAR TAREFA -->
<?php 
if(@$_GET['funcao'] == 'tarefa' && @$item_paginado == ''){ 
	$num_processo = $_GET['num'];
	$cliente 	  = $_GET['cliente'];
	?>

	<div class="modal" id="modal-tarefa" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Marcar Tarefa</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<form method="post">				
						
						<div class="form-group">

							<label for="exampleFormControlInput1">Nome</label>
							<input type="text" class="form-control" id="nome" placeholder="Insira o Nome da Tarefa" name="nome" required>
						</div>

						<div class="form-group">

							<label for="exampleFormControlInput1">Descrição</label>
							<input type="text" class="form-control" id="descricao" placeholder="Insira a Descrição " name="descricao" required>
						</div>
						

						<div class="row">

							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Data</label>
									<input class="form-control form-control-sm mr-sm-2" type="date" name="data" id="data" value="<?php echo $agora ?>">
								</div>
							</div>

							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Hora</label>
									<input class="form-control form-control-sm mr-sm-2" type="time" name="hora" id="hora">
								</div>
							</div>

						</div>					
						
			
					
					<div id="mensagem-tarefa" class="">
						
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-tarefa">Cancelar</button>
					
						<input type="hidden" id="num_processo"  name="num_processo" value="<?php echo @$num_processo ?>" required>

						<input type="hidden" id="cliente"  name="cliente" value="<?php echo @$cliente ?>" required>

						<button type="button" id="btn-tarefa" name="btn-tarefa" class="btn btn-info">Marcar</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	
<?php } ?>

<script>$('#modal-tarefa').modal("show");</script>

<!--AJAX PARA CONCLUIR COBRANCA -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-cobranca').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/cobranca.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#btn-buscar').click();
					$('#btn-cancelar-cobranca').click();

				},
				
			})
		})
	})
</script>

<!--AJAX PARA LANÇAR OBSERVACAO -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-obs').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/observacao.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#txtbuscar').val('')
					$('#btn-buscar').click();
					$('#btn-cancelar').click();

				},
				
			})
		})
	})
</script>

<!--AJAX PARA INSERÇÃO DA AUDIENCIA -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-audiencia').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/inserir-audiencia.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#mensagem').removeClass()

					if(mensagem == 'Cadastrado com Sucesso!!'){
						
						$('#mensagem').addClass('mensagem-sucesso')				
						
						$('#btn-cancelar').click();
						

					}else{
						
						$('#mensagem').addClass('mensagem-erro')
					}
					
					$('#mensagem').text(mensagem)

				},
				
			})
		})
	})
</script>

<!--AJAX PARA INSERÇÃO DA TAREFA -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-tarefa').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/inserir-tarefa.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#mensagem-tarefa').removeClass()

					if(mensagem == 'Cadastrado com Sucesso!!'){
						
						$('#mensagem-tarefa').addClass('mensagem-sucesso')				
						
						$('#btn-cancelar-tarefa').click();
						

					}else{
						
						$('#mensagem-tarefa').addClass('mensagem-erro')
					}
					
					$('#mensagem-tarefa').text(mensagem)

				},
				
			})
		})
	})
</script>

<!--AJAX PARA INSERÇÃO DO HISTORICO -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-historico').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/inserir-historico.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#mensagem').removeClass()

					if(mensagem == 'Cadastrado com Sucesso!!'){
						
						$('#mensagem').addClass('mensagem-sucesso');	
						$('#btn-cancelar-hist').click();

					}else{
						
						$('#mensagem').addClass('mensagem-erro');
					}
					
					$('#mensagem').text(mensagem);

				},
				
			})
		})
	})
</script>

<!--AJAX PARA INSERÇÃO DA PETIÇÃO -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-peticao').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/inserir-peticao.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#mensagem_peticao').removeClass()

					if(mensagem == 'Cadastrado com Sucesso!!'){
						
						$('#mensagem_peticao').addClass('mensagem-sucesso');
						document.forms['form-peticao'].submit();	
						
					}else{
						
						$('#mensagem_peticao').addClass('mensagem-erro');
					}
					
					$('#mensagem_peticao').text(mensagem);

				},
				
			})
		})
	})
</script>