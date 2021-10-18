<?php 

require_once("../conexao.php");

$pagina 	  = 'pasta_processo'; 
$cpf_adv	  = $_SESSION['cpf_usuario'];
$num_processo = '1111111-11.1111.111.1111';//$_GET['num_processo'];

//DADOS DO PROCESSO
$res_p    		 = $pdo->query("SELECT * FROM processos where num_processo = '$num_processo'");
$dados_p  		 = $res_p->fetchAll(PDO::FETCH_ASSOC); 
$cliente 		 = $dados_p[0]['cliente'];
$parte_contraria = $dados_p[0]['parte_contraria'];
$data_abertura   = $dados_p[0]['data_abertura'];
$status 		 = $dados_p[0]['status'];
$obs_processo    = $dados_p[0]['observacao'];
$id_processo     = $dados_p[0]['id'];

$res_c    		 	= $pdo->query("SELECT * FROM clientes where cpf = '$cliente'");
$dados_c  		 	= $res_c->fetchAll(PDO::FETCH_ASSOC); 
$nome_cliente		= $dados_c[0]['nome'];

$res_reu   		 	= $pdo->query("SELECT * FROM parte_contraria where cpf = '$parte_contraria'");
$dados_reu 		 	= $res_reu->fetchAll(PDO::FETCH_ASSOC); 
$nome_reu   		= @$dados_reu[0]['nome'];

?>

<div class="container-fluid">
	<h5 align="center" style="color:red">Processo Número: <?php echo $num_processo ?></h5>
	<br>
	<div class="area_cards">
		<div class="row">


			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-header bg-dark text-white" align="center">
						<b>Dados do Processo</b>
					</div>

					<div class="card-body">
							<span class="card-title text-secondary"><?php echo "<b>Cliente:</b> ".$nome_cliente ?></span>
							<span class="card-title text-secondary"><?php echo "<br><b>Réu:</b> ".$nome_reu ?></span>
							<span class="card-title text-secondary"><?php echo "<br><b>Data de Abertura:</b> ".data($data_abertura) ?></span>
							<span class="card-title text-secondary"><?php echo "<br><b>Status:</b> ".$status ?></span>
							<span class="card-title text-secondary"><?php echo "<br><b>Observação:</b> <br>".$obs_processo ?></span>
					</div>

				</div>			
			</div>

			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-header bg-dark text-white" align="center">
						<b>Dados da(s) Audiência(s)</b>
					</div>

					<div class="card-body">
						<?php  
							$res_aud = $pdo->query("SELECT * from audiencias where num_processo = '$num_processo' and data_audiencia >= curDate() order by data_audiencia,hora_audiencia asc limit 3");

							$dados_aud = $res_aud->fetchAll(PDO::FETCH_ASSOC);

							for ($i=0; $i < count($dados_aud); $i++) { 
								foreach ($dados_aud[$i] as $key => $value) {
								}
								
								$descricao 		= $dados_aud[$i]['descricao'];
								$data_audiencia = $dados_aud[$i]['data_audiencia'];
								$hora_audiencia = $dados_aud[$i]['hora_audiencia'];
								$local 			= $dados_aud[$i]['local'];
								$obs_audiencia  = $dados_aud[$i]['observacao'];
								$tipo_audiencia = $dados_aud[$i]['tipo_audiencia'];
								
								if ($i > 0) {
								?>
									<hr class="text-dark">
								<?php } ?>

								<span class="card-title text-secondary"><?php echo "<b>Descrição:</b> ".$descricao ?></span>
								<span class="card-title text-secondary"><?php echo "<br><b>Tipo da Audiência:</b> ".$tipo_audiencia ?></span>
								<span class="card-title text-secondary"><?php echo "<br><b>Local:</b> ".$local ?></span>
								<span class="card-title text-secondary"><?php echo "<br><b>Data:</b> ".data($data_audiencia)." - ". $hora_audiencia ?></span>
								<span class="card-title text-secondary"><?php echo "<br><b>Observação:</b> <br>".$obs_audiencia ?></span>
								
							<?php } ?> 
							
					</div>
					
				</div>			
			</div>

			<div class="col-sm-12 col-lg-3 col-md-6 col-sm-6 mb-4">
				<div class="card card-stats">
					<div class="card-header bg-dark text-white" align="center">
						<b>Andamento do Processo</b>
					</div>

					<div class="card-body">
						<?php  
							$res_hist = $pdo->query("SELECT * from historico where num_processo = '$num_processo' order by data desc ");
							$dados_hist = $res_hist->fetchAll(PDO::FETCH_ASSOC);

							for ($i=0; $i < count($dados_hist); $i++) { 
								foreach ($dados_hist[$i] as $key => $value) {
								}
								
								$descricao  = $dados_hist[$i]['descricao'];
								$data 		= $dados_hist[$i]['data'];
								
								if ($i > 0) {
								?>
									<hr class="text-dark">
								<?php } ?>

								<span class="card-title text-secondary"><?php echo "<b>Descrição:</b> ".$descricao ?></span>
								<span class="card-title text-secondary"><?php echo "<br><b>Data:</b> ".data($data) ?></span>
								
							<?php } ?> 
							
					</div>
					
				</div>			
			</div>

			
		</div>

	</div>

	<div class="mt-4">
		<big><i class="far fa-folder-open ml-4 text-danger"></i></big>
		<span class="text-muted ml-1"><big><b>Documentos</b></big></span>
		<a class="float-right mr-4" title="Anexar Arquivo" href="index.php?acao=<?php echo $pagina ?>&funcao=arquivo&num_processo=<?php echo $num_processo ?>">Anexar Arquivo<i class="fas fa-file-upload text-primary ml-1"></i></a>
		<hr>

		<?php  echo '
		<table class="table table-sm table-responsive-sm mt-3 tabelas">
			<thead class="thead-light">
				<tr>
					<th scope="col">Descrição</th>
					<th scope="col">Arquivo</th>
					<th scope="col">Data</th>
					<th scope="col">Ações</th>
				</tr>
			</thead>
			<tbody>';

		$res_doc = $pdo->query(" SELECT * 
		        				   FROM documentos 
				   		          WHERE num_processo = '$num_processo' 
				   		       ORDER BY id desc
				   		     ");
 	    $dados_doc = $res_doc->fetchAll(PDO::FETCH_ASSOC);

		for ($i=0; $i < count($dados_doc); $i++) { 
			foreach ($dados_doc[$i] as $key => $value) {
			}

			$id_arquivo	= $dados_doc[$i]['id'];
			$descricao 	= $dados_doc[$i]['descricao'];
			$arquivo 	= $dados_doc[$i]['arquivo'];
			$data 		= $dados_doc[$i]['data'];
			$data2 		= implode('/',array_reverse(explode('-',$data)));

	
		echo '
				<tr>

					
					<td>'.$descricao.'</td>
					
					
					<td><a title="Abrir Anexo" href="../img/arquivos/'.$arquivo.'" target="_blank">'.$arquivo.'</a></td>
					<td>'.$data2.'</td>
					<td><a title="Excluir Anexo" href="index.php?acao='.$pagina.'&funcao=excluir-arquivo&num_processo='.$num_processo.'&id='.$id_arquivo.'"><i class="far fa-trash-alt text-danger"></i></a></td>				
					
				</tr>';

			}

		echo  '
			</tbody>
		</table> ';

		?>		
		
	</div>
	<div>
		<hr>
	</div>
	<div class="row botao-novo">
		<div class="col-sm-6 col-lg-2 col-md-3 col-sm-3 mb-2">
			
			<a id="btn-novo" data-toggle="modal" data-target="#modal-editar"></a>
			<a href="index.php?acao=<?php echo $pagina ?>&funcao=editar&num_processo=<?php echo $num_processo ?>&id=<?php echo $id_processo ?>"  type="button" class="btn btn-info">Editar Processo</a>

		</div>

		<div class="col-sm-6 col-lg-2 col-md-3 col-sm-3 mb-2">
			
			<a id="btn-novo" data-toggle="modal" data-target="#modal-audiencia"></a>
			<a href="index.php?acao=<?php echo $pagina ?>&funcao=audiencia&num_processo=<?php echo $num_processo ?>"  type="button" class="btn btn-info">Marcar Audiência</a>

		</div>

		<div class="col-sm-6 col-lg-2 col-md-3 col-sm-3 mb-2">
			
			<a id="btn-novo" data-toggle="modal" data-target="#modal"></a>
			<a href="index.php?acao=<?php echo $pagina ?>&funcao=novo"  type="button" class="btn btn-info">Novo Cliente</a>

		</div>

		<div class="col-sm-6 col-lg-2 col-md-3 col-sm-3 mb-2">
			
			<a id="btn-novo" data-toggle="modal" data-target="#modal"></a>
			<a href="index.php?acao=<?php echo $pagina ?>&funcao=novo"  type="button" class="btn btn-info">Novo Cliente</a>

		</div>

		<div class="col-sm-6 col-lg-2 col-md-3 col-sm-3 mb-2">
			
			<a id="btn-novo" data-toggle="modal" data-target="#modal"></a>
			<a href="index.php?acao=<?php echo $pagina ?>&funcao=novo"  type="button" class="btn btn-info">Novo Cliente</a>

		</div>

		<div class="col-sm-6 col-lg-2 col-md-3 col-sm-3 mb-2">
			
			<a id="btn-novo" data-toggle="modal" data-target="#modal"></a>
			<a href="index.php?acao=<?php echo $pagina ?>&funcao=novo"  type="button" class="btn btn-info">Novo Cliente</a>

		</div>

		
	</div>
</div>
<?php 
function data($data){
	return date("d/m/Y", strtotime($data));
}
?>

<!--CHAMADA DA MODAL PARA ANEXAR ARQUIVOS-->
<?php 
if(@$_GET['funcao'] == 'arquivo'){ 
		$num_processo = $_GET['num_processo'];
		?>

		<div class="modal" id="modal-arquivo" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Arquivo Imagem e PDF</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">						

						<form id="form" method="post" enctype="multipart/form-data">

							<input type="hidden" class="form-control" id="num_processo" value="<?php echo $num_processo ?>" name="num_processo">

				          <div class="form-group">
				            <label for="exampleFormControlInput1">Descrição</label>
				            <input type="text" class="form-control" id="descricao" placeholder="Insira a Descrição" name="descricao">
				          </div>

				          <div class="form-group">
			                  <label for="inputAddress">Foto</label>

			                  <div class="custom-file">
			                    <input type="file" name="foto" id="foto">
			                  </div>
			              </div>

			              <div id="mensagem" align="center" class="text-success">

			              </div>						
						
					</div>
					<div class="modal-footer mb-4">
				       <button type="button" id="btn-cancelar-arquivo" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

				       <button type="submit" id="btn-arquivo" name="btn-arquivo" class="btn btn-primary">Anexar</button>
				      </form>
				    </div>
				    
				<?php 
				  	$res = $pdo->query(" SELECT * 
				  		                   FROM documentos 
				   		                  WHERE num_processo = '$num_processo' 
				   		               ORDER BY id desc
				   		              ");

				    $dados = $res->fetchAll(PDO::FETCH_ASSOC);

					for ($i=0; $i < count($dados); $i++) { 
						foreach ($dados[$i] as $key => $value) {
						}

						$id_arquivo	= $dados[$i]['id'];
						$descricao 	= $dados[$i]['descricao'];
						$arquivo 	= $dados[$i]['arquivo'];
						$data 		= $dados[$i]['data'];

						$data2 = implode('/',array_reverse(explode('-',$data)));

			    ?>
					    
					    <span class="text-muted ml-4 mb-1"><a title="Abrir Anexo" href="../img/arquivos/<?php echo $arquivo ?>" target="_blank"><?php echo $descricao ?> - <?php echo $data2 ?></a>
					    	 <a title="Excluir Anexo" href="index.php?acao=<?php echo $pagina ?>&funcao=excluir-arquivo&num_processo=<?php echo $num_processo ?>&id=<?php echo $id_arquivo ?>"><i class="far fa-trash-alt text-danger ml-1"></i></a>

					    </span>

					    
					    <hr>
				<?php } ?>

				</div>
			</div>
		</div>

		
<?php } ?>

<script>$('#modal-arquivo').modal("show");</script>


<!--CHAMADA DA MODAL DELETAR -->
	<?php 
	if(@$_GET['funcao'] == 'excluir-arquivo'){ 
		$id 		  = $_GET['id'];
		$num_processo = $_GET['num_processo'];
		?>

		<div class="modal" id="modal-deletar-arquivo" tabindex="-1" role="dialog">
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
							<input type="hidden" id="num_processo"  name="num_processo" value="<?php echo @$num_processo ?>" required>

							<button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php } ?>

<script>$('#modal-deletar-arquivo').modal("show");</script>


<!--CHAMADA DA MODAL PARA EDITAR PROCESSO-->
<?php 
if(@$_GET['funcao'] == 'editar'){ 
	$num_processo = $_GET['num_processo'];
	$id = $_GET['id'];
?>

<!-- Modal-editar-->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					<?php 

						$nome_botao = 'Editar';

							//BUSCAR DADOS DO REGISTRO A SER EDITADO
						$res = $pdo->query("select * from processos where id = '$id'");
						$dados = $res->fetchAll(PDO::FETCH_ASSOC);

						$num_processo 	= $dados[0]['num_processo'];
						$vara 			= $dados[0]['vara'];
						$tipo_acao 	    = $dados[0]['tipo_acao'];
						$data_peticao 	= $dados[0]['data_peticao'];
						$status 		= $dados[0]['status'];
						$obs_processo	= $dados[0]['observacao'];

						if ($data == '') {
							$data = date('Y-m-d');
						}

						echo 'Edição do Processo';
					?>
				</h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		
			<div class="modal-body">

				<form method="post">

					<input type="hidden" class="form-control" id="antigo" name="antigo" value="<?php echo $num_processo ?>">

					<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>">

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

											$res_vara   = $pdo->query("SELECT * from varas where id = '$vara'");
											$dados_vara = $res_vara->fetchAll(PDO::FETCH_ASSOC);

											for ($i=0; $i < count($dados_vara); $i++) { 
												foreach ($dados_vara[$i] as $key => $value) {
												}

												$id_vara   = $dados_vara[$i]['id'];	
												$nome_vara = $dados_vara[$i]['nome'];

											}

											echo '<option value="'.$id_vara.'">'.$nome_vara.'</option>';
										

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

											$res_espec  = $pdo->query("SELECT * from especialidades where id = '$tipo_acao'");
											$dados_espec = $res_espec->fetchAll(PDO::FETCH_ASSOC);

											for ($i=0; $i < count($dados_espec); $i++) { 
												foreach ($dados_espec[$i] as $key => $value) {
												}

												$id_espec   = $dados_espec[$i]['id'];	
												$nome_espec = $dados_espec[$i]['nome'];

											}

											echo '<option value="'.$id_espec.'">'.$nome_espec.'</option>';

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

					<div class="form-group">
						<label for="exampleFormControlInput1">Observação</label>
						<textarea type="text" class="form-control" name="obs_processo" id="obs_processo" maxlength="350"><?php echo @$obs_processo ?></textarea>
					</div>

					<div id="mensagem" class="">

					</div>
				</form>
			</div>
			


			<div class="modal-footer">
				<button id="btn-fechar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

				<button name="Editar" id="Editar" class="btn btn-primary"><?php echo $nome_botao ?></button>

			</div>
		
		</div>
	</div>
</div>
<?php } ?>

<script>$('#modal-editar').modal("show");</script>


<!--CHAMADA DA MODAL MARCAR AUDIENCIA -->
<?php 
if(@$_GET['funcao'] == 'audiencia'){ 
	$num_processo = $_GET['num_processo'];
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

							<label for="exampleFormControlInput1">Tipo da Audiência</label>
							<input type="text" class="form-control" id="tipo_audiencia" placeholder="Insira o Tipo da Audiência " name="tipo_audiencia" required>
						</div>

						<div class="form-group">

							<label for="exampleFormControlInput1">Observação</label>
							<input type="text" class="form-control" id="obs_audiencia" name="obs_audiencia" required>
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
						
			
					
					<div id="mensagem-audiencia" class="">
						
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


<!--MASCARAS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="../js/mascaras.js"></script>




<!--AJAX PARA INSERÇÃO DOS DADOS DOS ARQUIVOS -->
<script type="text/javascript">

$("#form").submit(function () {
	var pag = "<?=$pagina?>";
	event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/inserir-arquivo.php",
        type: 'POST',
        data: formData,
        success: function (data) {
	        $('#mensagem').text(data);
	        $('#descricao').val('');
	        $('#foto').val('');
	        location.reload();
        },
        cache: false,
        contentType: false,
        processData: false,
        xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                myXhr.upload.addEventListener('progress', function () {
                    /* faz alguma coisa durante o progresso do upload */
                }, false);
            }
        return myXhr;
        }
    });
});
</script>

<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
	$(document).ready(function(){
		var pag = "<?=$pagina?>";
		$('#btn-deletar').click(function(event){
			event.preventDefault();
			
			$.ajax({
				url: pag + "/excluir-arquivo.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "text",
				success: function(mensagem){						
					
					$('#btn-cancelar-excluir').click();
					 window.history.go(-2);
					},
				})
		})
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
						//$('#btn-fechar').click();
						window.history.go(-1);

					}else{
						
						$('#mensagem').addClass('mensagem-erro')
					}
					
					$('#mensagem').text(mensagem)

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

					$('#mensagem-audiencia').removeClass()

					if(mensagem == 'Cadastrado com Sucesso!!'){
						
						$('#mensagem-audiencia').addClass('mensagem-sucesso')				
						
						$('#btn-cancelar').click();
						

					}else{
						
						$('#mensagem-audiencia').addClass('mensagem-erro')
					}
					
					$('#mensagem-audiencia').text(mensagem)

				},
				
			})
		})
	})
</script>