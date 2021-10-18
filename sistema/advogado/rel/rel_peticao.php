
<?php 
include('../../conexao.php');

$num_processo = $_GET['num_processo'];

$res        = $pdo->query("SELECT * from peticoes where num_processo = '$num_processo'");
$dados 		= $res->fetchAll(PDO::FETCH_ASSOC);
$titulo 	= $dados[0]['titulo'];
$tipo_acao 	= $dados[0]['tipo_acao'];
$agravante 	= $dados[0]['agravante'];
$agravado 	= $dados[0]['agravado'];
$texto 		= $dados[0]['texto'];
$data 		= $dados[0]['data'];

?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>

	@page {
		margin: 0px;

	}

	.footer {
		position:absolute;
		bottom:0;
		width:100%;
		background-color: #ebebeb;
		padding:10px;
	}

	.cabecalho {    
		background-color: #ebebeb;
		padding-top:15px;
		margin-bottom:30px;
	}


	.red{
		color:red;
	}


	.texto{
		font-size:12px;
	}

	.titulo-rel{
		font-size:24px;
		font-weight:300;
	}



</style>


<div class="cabecalho">
	
	<div class="row">
		<div class="col-sm-4">	
			 <img src="../../img/logo.png" width="250px">
		</div>
		<div class="col-sm-6">	
			<h4 class="titulo"><b><?php echo $nome_empresa ?> - Escritório de Advocacia</b></h4>
			<h6 class="titulo">Rua da Q-Cursos Networks Nº 1000, Centro - BH - MG - CEP 30555-555</h6>
		</div>
	</div>
	

</div>

<div class="container">


	<div class="row">
		
			<p class="titulo-rel" align="center"><b><?php echo $titulo ?> </b></p> 
			 <hr>
	

	</div>

	<div class="row">
		<p class="texto" align="center"> EXCELENTÍSSIMO SENHOR DOUTOR DESEMBARGADOR PRESIDENTE DO EGRÉGIO TRIBUNAL DE JUSTIÇA DO ESTADO </p>

	</div>

	<div>

		<br><br>

		<b><p align="center">REFERENTE<br>
			______________________________________________
			<br><?php echo $tipo_acao ?><br>
			<span class="red">PROCESSO - <?php echo $num_processo ?></span></b>
			<br>
			Agravante: <?php echo $agravante ?><br>
			Agravado: <?php echo $agravado ?><br>
			</p>
	</div>

	<br><br><br>
	<div>
		<?php echo $texto ?>
	</div>	
	

<div class="footer">
	<p style="font-size:12px" align="center">Desenvolvido por Hugo Vasconcelos - Q-Cursos Networks</p> 
</div>


