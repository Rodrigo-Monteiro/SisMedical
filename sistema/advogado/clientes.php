<?php $pagina = 'clientes'; ?>


<div class="container">
	<div class="row botao-novo">
		<div class="col-md-12">
			
			<a id="btn-novo" data-toggle="modal" data-target="#modal"></a>
			<a href="index.php?acao=<?php echo $pagina ?>&funcao=novo"  type="button" class="btn btn-info">Novo Cliente</a>

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

					<input class="form-control form-control-sm mr-sm-2" type="search" placeholder="Nome ou CPF/CNPJ" aria-label="Search" name="txtbuscar" id="txtbuscar">
					
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
					<h5 class="modal-title" id="exampleModalLabel"><?php if(@$_GET['funcao'] == 'editar'){
						
						$nome_botao = 'Editar';
						$id_reg = $_GET['id'];

					//BUSCAR DADOS DO REGISTRO A SER EDITADO
						$res = $pdo->query("select * from clientes where id = '$id_reg'");
						$dados = $res->fetchAll(PDO::FETCH_ASSOC);
						$nome = $dados[0]['nome'];

						$cpf 			= $dados[0]['cpf'];
						$telefone 		= $dados[0]['telefone'];
						$email 			= $dados[0]['email'];
						$endereco 		= $dados[0]['endereco'];
						$obs 			= $dados[0]['obs'];
						$tipo_pessoa	= $dados[0]['tipo_pessoa'];
						$identidade	    = $dados[0]['identidade'];
						$nacionalidade	= $dados[0]['nacionalidade'];
						$estado_civil	= $dados[0]['estado_civil'];
						$profissao	    = $dados[0]['profissao'];

						if ($tipo_pessoa == 'F') {
							$pessoa_fisica 	 = 'selected';
							$pessoa_juridica = '';
						} else {
							$pessoa_fisica 	 = '';
							$pessoa_juridica = 'selected';	
						}

						if ($nacionalidade == 'brasileiro') {
							$nac_brasil  = 'selected';
							$nac_inter   = '';
						} else {
							$nac_brasil 	 = '';
							$nac_inter = 'selected';	
						}

						$ocultar = 'divcnpj2';

						echo 'Edição de Clientes';
					}else{
						
						$nome_botao 	= 'Salvar';
						$tipo_pessoa	= 'F';
						echo 'Cadastro de Clientes';
					} ?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">


				<form method="post">
					<div class="row">
						<div class="col-md-4 col-sm-12">
							<div class="form-group">

								<input type="hidden" id="id"  name="id" value="<?php echo @$id_reg ?>" required>

								<input type="hidden" id="cpf_antigo"  name="cpf_antigo" value="<?php echo @$cpf ?>" required>

								<label for="exampleFormControlInput1">Nome</label>
								<input type="text" class="form-control" id="nome" placeholder="Insira o Nome" name="nome" value="<?php echo @$nome ?>" required>
							</div>
						</div>

						<div class="col-md-4 col-sm-12" id="<?php echo $ocultar ?>">
							<div class="form-group">
								<label for="exampleFormControlInput1">Física / Jurídica</label>
								<select class="form-control" id="tipo_pessoa" name="tipo_pessoa"> 

									<option value="F" <?php echo @$pessoa_fisica ?>>Pessoa Física</option>
									<option value="J" <?php echo @$pessoa_juridica ?>>Pessoa Jurídica</option>
									
								</select>
							</div>
						</div>

						<?php if(@$tipo_pessoa == 'F'){ ?>
							<div class="col-md-4 col-sm-12" id="divcpf">
								<div class="form-group">
									<label for="exampleFormControlInput1">CPF</label>
									<?php if(@$_GET['funcao'] == 'editar'){ ?>
										<input type="hidden" class="form-control" name="cpf_oculto" value="<?php echo @$cpf ?>">
										<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Insira o CPF" value="<?php echo @$cpf ?>">
									<?php }else{ ?>
										<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Insira o CPF" required value="<?php echo @$cpf ?>">
									<?php } ?>
								</div>							
							</div>						
						<?php } elseif (@$tipo_pessoa == 'J') { ?>
							<div class="col-md-4 col-sm-12" id="divcnpj">
								<div class="form-group">
									<label for="exampleFormControlInput1">CNPJ2</label>
									<?php if(@$_GET['funcao'] == 'editar'){ ?>
										<input type="hidden" class="form-control" name="cpf_oculto" value="<?php echo @$cpf ?>">
										<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Insira o CNPJ" value="<?php echo @$cpf ?>">
									<?php }else{ ?>
										<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Insira o CNPJ" required value="<?php echo @$cpf ?>">
									<?php } ?>
								</div>							
							</div>	
						<?php } ?>

						<div class="col-md-4 col-sm-12" id="divcnpj2">
							<div class="form-group">
								<label for="exampleFormControlInput1">CNPJ1</label>
								<?php if(@$_GET['funcao'] == 'editar'){ ?>
									<input type="hidden" class="form-control" name="cpf_oculto" value="<?php echo @$cpf ?>">
									<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Insira o CNPJ" value="<?php echo @$cpf ?>">
								<?php }else{ ?>
									<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Insira o CNPJ" required value="<?php echo @$cpf ?>">
								<?php } ?>
							</div>							
						</div>	
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								
								<label for="exampleFormControlInput1">Identidade</label>
								<input type="text" class="form-control" id="identidade"  name="identidade" maxlength="12" value="<?php echo @$identidade ?>" placeholder="Insira a identidade" required>
							</div>
						</div>

						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								
								<label for="exampleFormControlInput1">Estado Civil</label>
								<select class="form-control" id="estado_civil" name="estado_civil">
									<?php 
											//SE EXISTIR EDIÇÃO DOS DADOS, TRAZER COMO PRIMEIRO REGISTRO O CARGO DO FUNCIONARIO
										if(@$_GET['funcao'] == 'editar'){

											$res_estado   = $pdo->query("SELECT * from estado_civil where id = '$estado_civil'");
											$dados_estado = $res_estado->fetchAll(PDO::FETCH_ASSOC);

											for ($i=0; $i < count($dados_estado); $i++) { 
												foreach ($dados_estado[$i] as $key => $value) {
												}

												$id_estado   = $dados_estado[$i]['id'];	
												$nome_estado = $dados_estado[$i]['nome'];

											}


											echo '<option value="'.$id_estado.'">'.$nome_estado.'</option>';
										}

										//TRAZER TODOS OS REGISTROS DE CARGOS
										$res   = $pdo->query("SELECT * from estado_civil order by nome asc");
										$dados = $res->fetchAll(PDO::FETCH_ASSOC);

										for ($i=0; $i < count($dados); $i++) { 
											foreach ($dados[$i] as $key => $value) {
											}

											$id   = $dados[$i]['id'];	
											$nome_combo = $dados[$i]['nome'];

											if($nome_estado != $nome_combo){
												echo '<option value="'.$id.'">'.$nome_combo.'</option>';
											}


										}
									?>						
								</select>
							</div>
						</div>

						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								
								<label for="exampleFormControlInput1">Nacionalidade</label>
								<select class="form-control" id="nacionalidade" name="nacionalidade"> 

									<option value="brasileiro" <?php echo @$nac_brasil ?>>Brasileiro(a)</option>
									<option value="estrangeiro" <?php echo @$nac_inter ?>>Estrangeiro(a)</option>
									
								</select>
							</div>
						</div>
						

					</div>

					<div class="row">

						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Insira o Telefone" value="<?php echo @$telefone ?>">
							</div>
						</div>

						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Email</label>							
								<input type="text" class="form-control" id="email" name="email" placeholder="Insira o Email" required value="<?php echo @$email ?>">						
							</div>
						</div>						
						
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								
								<label for="exampleFormControlInput1">Profissão</label>
								<input type="text" class="form-control" id="profissao" name="profissao" value="<?php echo @$profissao ?>" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Endereço</label>
								<input type="text" class="form-control" name="endereco" id="endereco" placeholder="Insira o Endereço" value="<?php echo @$endereco ?>">
							</div>
						</div>						
					</div>	

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Observações</label>
								<textarea class="form-control" name="obs" id="obs" maxlength="350"><?php echo @$obs ?></textarea> 
							</div>
						</div>
					</div>	





					<div id="mensagem" class="">

					</div>

				</div>
				<div class="modal-footer">
					<button id="btn-fechar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

					<button name="<?php echo $nome_botao ?>" id="<?php echo $nome_botao ?>" class="btn btn-primary"><?php echo $nome_botao ?></button>

				</div>
			</form>
		</div>
	</div>
</div>



<!--CHAMADA DA MODAL NOVO -->
<?php 
if(@$_GET['funcao'] == 'novo' && @$item_paginado == ''){ 
	
	?>
	<script>$('#btn-novo').click();</script>
<?php } ?>


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
					<h5 class="modal-title">Excluir Registro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<p>Deseja realmente Excluir este Registro?</p>
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











<!--MASCARAS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="../js/mascaras.js"></script>

<!--AJAX PARA INSERÇÃO DOS DADOS -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#Salvar').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/inserir.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#mensagem').removeClass()

					if(mensagem == 'Cadastrado com Sucesso!!'){
						
						$('#mensagem').addClass('mensagem-sucesso')

						$('#nome').val('')
						$('#cpf').val('')
						$('#telefone').val('')
						
						$('#email').val('')
						$('#obs').val('')
						$('#endereco').val('')

						$('#txtbuscar').val('')
						$('#btn-buscar').click();

						//$('#btn-fechar').click();




					}else{
						
						$('#mensagem').addClass('mensagem-erro')
					}
					
					$('#mensagem').text(mensagem)

				},
				
			})
		})
	})
</script>




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



<!--AJAX PARA BUSCAR OS DADOS PELA TXT -->
<script type="text/javascript">
	$('#txtbuscar').keyup(function(){
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

						$('#nome').val('')
						$('#cpf').val('')
						$('#telefone').val('')
						
						$('#email').val('')

						$('#txtbuscar').val('')
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

					$('#txtbuscar').val('')
					$('#btn-buscar').click();
					$('#btn-cancelar-excluir').click();

				},
				
			})
		})
	})
</script>

<!--AJAX PARA OCULTAR DIV QUANDO TROCAR TIPO PESSOA -->
<script type="text/javascript">
	$('#tipo_pessoa').change(function(){
		var select = document.getElementById('tipo_pessoa');
		var value  = select.options[select.selectedIndex].value;
		
		console.log(value);
		if (value == 'J') {
			$("#divcpf").hide();
			document.getElementById("divcnpj2").style.display = 'block';
		} else {
			$("#divcpf").show();
			document.getElementById("divcnpj2").style.display = 'none';
		}
	})
</script>

<!--CHAMADA DA MODAL ABRIR PROCESSO -->
<?php 
if(@$_GET['funcao'] == 'processo' && @$item_paginado == ''){ 
	$cpf   = $_GET['cpf'];
	$setor = 1; 
	?>

	<div class="modal" id="modal-processo" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Abrir Processo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<form method="post">
						<input type="hidden" class="form-control" name="cpf_cliente" value="<?php echo $cpf ?>">

						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Número Processo</label>
									<input type="text" class="form-control" id="num_processo" name="num_processo" placeholder="Número do Processo">
								</div>
							</div>

							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Vara</label>
									<select class="form-control" id="vara" name="vara">
										<?php 
											//TRAZER TODOS OS REGISTROS DE CARGOS
											$res_vara   = $pdo->query("SELECT * from varas order by nome asc");
											$dados_vara = $res_vara->fetchAll(PDO::FETCH_ASSOC);

											for ($i=0; $i < count($dados_vara); $i++) { 
												foreach ($dados_vara[$i] as $key => $value) {
												}

												$id_vara = $dados_vara[$i]['id'];	
												$nome_vara = $dados_vara[$i]['nome'];

												echo '<option value="'.$id_vara.'">'.$nome_vara.'</option>';
											}	
										 ?>
									</select>
								</div>
							</div>

							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Tipo de Processo</label>
									<select class="form-control" id="tipo_acao" name="tipo_acao">
										<?php 
											//TRAZER TODOS OS REGISTROS DE CARGOS
											$res_espec = $pdo->query("SELECT * from especialidades order by nome asc");
											$dados_espec = $res_espec->fetchAll(PDO::FETCH_ASSOC);

											for ($i=0; $i < count($dados_espec); $i++) { 
												foreach ($dados_espec[$i] as $key => $value) {
												}

												$id_espec = $dados_espec[$i]['id'];	
												$nome_espec = $dados_espec[$i]['nome'];

												echo '<option value="'.$id_espec.'">'.$nome_espec.'</option>';
											}	
										 ?>
									</select>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-4 col-sm-12">
								<label for="exampleFormControlInput1">Física / Jurídica (Réu)</label>
								<select class="form-control" id="tipo_pessoa_processo" name="tipo_pessoa_processo"> 

									<option value="F">Pessoa Física</option>
									<option value="J">Pessoa Jurídica</option>
										
								</select>
							</div>

							<div class="col-md-4 col-sm-12" id="divcpfprocessado">
								<div class="form-group">
									<label for="exampleFormControlInput1">CPF (Réu)</label>
									<input type="text" class="form-control" id="cpf2" name="cpf" placeholder="Insira o CPF" required>							
								</div>							
							</div>

							<div class="col-md-4 col-sm-12" id="divcnpjprocessado">
								<div class="form-group">
									<label for="exampleFormControlInput1">CNPJ (Réu)</label>
									<input type="text" class="form-control" id="cnpj2" name="cnpj" placeholder="Insira o CNPJ" required>							
								</div>							
							</div>

							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Nome (Réu)</label>
									<input type="text" class="form-control" id="nome_parte_contraria" name="nome_parte_contraria">							
								</div>							
							</div>

						</div>

						<div class="row">

							<div class="col-md-6 col-sm-12" id="divSetor">
								<div class="form-group">
									<label for="exampleFormControlInput1">Setor</label>
									<select class="form-control" id="setor" name="setor">
										<?php 	

											//TRAZER TODOS OS REGISTROS DE CARGOS
											$res_setor   = $pdo->query("SELECT * from setor order by id asc");
											$dados_setor = $res_setor->fetchAll(PDO::FETCH_ASSOC);

											for ($i=0; $i < count($dados_setor); $i++) { 
												foreach ($dados_setor[$i] as $key => $value) {
												}

												$id_setor   = $dados_setor[$i]['id'];	
												$nome_setor = $dados_setor[$i]['nome'];

												echo '<option value="'.$id_setor.'">'.$nome_setor.'</option>';
											
											}
										?>						
									</select>
								</div>
							</div>

							<?php if(@$setor == 1){ ?>
								<div class="col-md-6 col-sm-12" id="divEntidadePub">
									<label for="exampleFormControlInput1">Tipo Entidade</label>
										<select class="form-control" id="entidade_pub" name="entidade_pub">
											<?php 	

												//TRAZER TODOS OS REGISTROS DE TIPO_ENTIDADE
												$res_entidade   = $pdo->query("SELECT * from tipo_entidade WHERE tipo_setor = 1 order by nome asc");
												$dados_entidade = $res_entidade->fetchAll(PDO::FETCH_ASSOC);

												for ($i=0; $i < count($dados_entidade); $i++) { 
													foreach ($dados_entidade[$i] as $key => $value) {
													}

													$id_entidade   = $dados_entidade[$i]['id'];	
													$nome_entidade = $dados_entidade[$i]['nome'];

													echo '<option value="'.$id_entidade.'">'.$nome_entidade.'</option>';
												}
											?>						
										</select>							
								</div>	
							<?php } elseif (@$setor == 2) { ?>
								<div class="col-md-6 col-sm-12" id="divEntidadePri">
									<label for="exampleFormControlInput1">Tipo Entidade</label>
										<select class="form-control" id="entidade_pri" name="entidade_pri">
											<?php 

												//TRAZER TODOS OS REGISTROS DE TIPO_ENTIDADE
												$res_entidade   = $pdo->query("SELECT * from tipo_entidade WHERE tipo_setor = 2 order by nome asc");
												$dados_entidade = $res_entidade->fetchAll(PDO::FETCH_ASSOC);

												for ($i=0; $i < count($dados_entidade); $i++) { 
													foreach ($dados_entidade[$i] as $key => $value) {
													}

													$id_entidade   = $dados_entidade[$i]['id'];	
													$nome_entidade = $dados_entidade[$i]['nome'];

													echo '<option value="'.$id_entidade.'">'.$nome_entidade.'</option>';
													
												}
											?>						
										</select>							
								</div>
							<?php } ?>

							<div class="col-md-6 col-sm-12" id="divEntidadePri2" dis>
									<label for="exampleFormControlInput1">Tipo Entidade</label>
										<select class="form-control" id="entidade_pri" name="entidade_pri">
											<?php 
												//TRAZER TODOS OS REGISTROS DE TIPO_ENTIDADE
												$res_entidade   = $pdo->query("SELECT * from tipo_entidade WHERE tipo_setor = 2 order by nome asc");
												$dados_entidade = $res_entidade->fetchAll(PDO::FETCH_ASSOC);

												for ($i=0; $i < count($dados_entidade); $i++) { 
													foreach ($dados_entidade[$i] as $key => $value) {
													}

													$id_entidade   = $dados_entidade[$i]['id'];	
													$nome_entidade = $dados_entidade[$i]['nome'];

													echo '<option value="'.$id_entidade.'">'.$nome_entidade.'</option>';

												}
											?>						
										</select>							
								</div>

						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Endereço</label>
									<input type="text" class="form-control" name="endereco" id="endereco" placeholder="Insira o Endereço">
								</div>
							</div>						
						</div>	
					
					<div id="mensagem-processo" class="">
						
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar">Cancelar</button>
					
						<input type="hidden" id="id"  name="id" value="<?php echo @$id ?>" required>

						<input type="hidden" id="btn-buscar-contraria" name="btn-buscar-contraria" >

						<button type="button" id="btn-processo" name="btn-processo" class="btn btn-info">Abrir</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	
<?php } ?>

<script>$('#modal-processo').modal("show");</script>


<!--AJAX PARA OCULTAR DIV QUANDO TROCADO O SELECT DO PROCESSO-->
<script type="text/javascript">
	$('#tipo_pessoa_processo').change(function(){
		var select = document.getElementById('tipo_pessoa_processo');
		var value  = select.options[select.selectedIndex].value;
		
		console.log(value);
		if (value == 'J') {
			document.getElementById("divcpfprocessado").style.display = 'none';
			document.getElementById("divcnpjprocessado").style.display = 'block';
		} else {
			document.getElementById("divcpfprocessado").style.display = 'block';
			document.getElementById("divcnpjprocessado").style.display = 'none';
		}
	})
</script>

<!--AJAX PARA BUSCAR O NOME DA PARTE CONTRÁRIA -->
<script type="text/javascript">
	$('#cpf2').keyup(function(){
		$('#btn-buscar-contraria').click();
	})
</script>

<!--AJAX PARA BUSCAR O NOME DA PARTE CONTRÁRIA -->
<script type="text/javascript">
	$('#cnpj2').keyup(function(){
		$('#btn-buscar-contraria').click();
	})
</script>

<!--AJAX PARA BUSCAR OS DADOS -->
<script type="text/javascript">
	$(document).ready(function(){

		var pag = "<?=$pagina?>";
		$('#btn-buscar-contraria').click(function(event){
			event.preventDefault();	
			
			$.ajax({
				url: pag + "/buscar-nome.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "html",
				success: function(result){
					document.getElementById("nome_parte_contraria").value = result;
					
				},
				

			})

		})

		
	})
</script>

<!--AJAX PARA INSERÇÃO DOS DADOS -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-processo').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/inserir-processo.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){

					$('#mensagem-processo').removeClass()

					if(mensagem == 'Cadastrado com Sucesso!!'){
						
						$('#mensagem-processo').addClass('mensagem-sucesso')

						
						
						$('#btn-cancelar').click();




					}else{
						
						$('#mensagem-processo').addClass('mensagem-erro')
					}
					
					$('#mensagem-processo').text(mensagem)

				},
				
			})
		})
	})
</script>

<!--AJAX PARA OCULTAR DIV QUANDO TROCAR TIPO ENTIDADE -->
<script type="text/javascript">
	$('#setor').change(function(){
		var select = document.getElementById('setor');
		var value  = select.options[select.selectedIndex].value;
		
		console.log(value);
		if (value == 2) {
			$("#divEntidadePub").hide();
			document.getElementById("divEntidadePri2").style.display = 'block';
		} else {
			$("#divEntidadePub").show();
			document.getElementById("divEntidadePri2").style.display = 'none';
		}
	})
</script>