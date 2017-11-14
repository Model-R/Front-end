<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?><html lang="pt-BR">
<?php

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: https://modelr.jbrj.gov.br');

require_once('classes/conexao.class.php');
require_once('classes/projeto.class.php');
require_once('classes/experimento.class.php');
require_once('classes/tipoparticionamento.class.php');
require_once('classes/fonte.class.php');
require_once('classes/periodo.class.php');
require_once('classes/statusoccurrence.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Projeto = new Projeto();
$Projeto->conn = $conn;

$Experimento = new Experimento();
$Experimento->conn = $conn;

$TipoParticionamento = new TipoParticionamento();
$TipoParticionamento->conn = $conn;

$Fonte = new Fonte();
$Fonte->conn = $conn;

$Periodo = new Periodo();
$Periodo->conn = $conn;

$StatusOccurrence = new StatusOccurrence();
$StatusOccurrence->conn = $conn;

$tab = $_REQUEST['tab'];
$filtro = $_REQUEST['filtro']; 

if (empty($tab))
{
	$tab = 1;
}
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$idsource = $_REQUEST['cmboxfonte'];
$especie = $_REQUEST['edtespecie'];

if($id){
	$sql = "select automatic_filter from modelr.experiment where idexperiment = ".$id;

	$res = pg_exec($conn,$sql);
	$row = pg_fetch_array($res);
	if($row['automatic_filter'] == 'f' || $row['automatic_filter'] == '') $automaticfilter = false;
	else $automaticfilter = true;
}

if ($op=='A')
{
	$Experimento->getById($id);
	$idexperiment = $Experimento->idexperiment;
	$name = $Experimento->name ;
	$description = $Experimento->description ;
}

?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Model-R </title>

	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">
	
	<!-- select2 -->
    <link href="css/select/select2.min.css" rel="stylesheet">
	<!-- switchery -->
    <link rel="stylesheet" href="css/switchery/switchery.min.css" />


    <script src="js/jquery.min.js"></script>

	<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 65%;
      }
	  #map2 {
        height: 65%;
      }
	  #map3 {
        height: 65%;
	  }
	  #map4 {
        height: 400px;
	  }
    </style>


    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
	
</head>
<body class="nav-md">

<!-- loading-  Carregando... -->
			<div id="loading" style="display: none;  
					background: #FFFFFF;  
					position: absolute;  
					width: 400px;  
					top: 50%;  
					left: 50%;  
					margin-left: -200px;  
					margin-top: -100px;  
					border-style: solid;  
					border-color: black;  
					border-width: 1px;  
					text-align: center;  
					text-transform: uppercase;  
					font-family: arial;  
					font-weight: bold;  
					color: black;  
					z-index: 3;">  
				<br><img alt="Loading..." src="imagens/ajax-loader.gif" width="150">  
				<br>Processando...  
				<br> 
			</div> 

	<div id="instructionModal" class="modal fade">
		<div class="modal-dialog"> 
			<div class="modal-content"> 
			<div class="modal-header">
				<h4 class="modal-title" >Instruções CSV</h4>
			</div>
			<!-- dialog body -->
			<div class="modal-body"> 
				<p>
					O CSV deve seguir o seguinte modelo:
	  				<br><br>
					[espécie],[longitude],[latitude]
					<br><br>
					Todos os dados podem ser separados por vírgula(,), dois pontos(:) ou ponto e vírgula(;).
					Não é necessário marcar o final da linha. 
					<br><br>
					Restrições:
					<br><br>
					Espécies: O nome da espécie deve ser sem acento;
					<br><br>
					Longitude: Valor decimal (ex.: -11.6358334);
					<br><br>
					Latitude: Valor decimal (ex.: -41.0013889);
				</p>
			</div>
			<!-- dialog buttons -->
			<div class="modal-footer csv-modal-footer"> 
				<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
			</div>
			</div>
		</div>
	</div>

	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel2">Arquivo CSV</h4>
				</div>
				<div class="modal-body">
					<h4>Selecione o Arquivo</h4>
					<form action="/action_page.php">
						<input type="file" name="pic" accept="image/*" class="form-control">
					</form>
					<p></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary">Enviar</button>
				</div>
			</div>
		</div>
	</div>
	
	 <div class="modal fade" id="pointModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel2">Editar ponto</h4>
				</div>
				<div class="modal-body">
					<h4><div id="divtaxon"></div></h4>
					<p>Dados originais<br>
					<div id="dadosoriginais"></div><br>
					<div id="dadoscoletor"></div><br>
					<div id="dadosherbario"></div><br>
					<div class="row">
						<div class="col-md-1 col-sm-1 col-xs-1"></div>
						<div class="col-md-2 col-sm-2 col-xs-2">
							<div id="divimagem"></div><br>
						</div>
						
						<div class="col-md-8 col-sm-8 col-xs-8">
							<b>Dados inferidos</b><br>
							<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrence',$idstatusoccurrence,'N','class="form-control"','1,2,4,6,8,10,11,12,13,16,17,18');?>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									Latitude:<input type="text" name="edtlatitude" id="edtlatitude" class="form-control"><br>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									Longitude:<input type="text" name="edtlongitude" id="edtlongitude" class="form-control"><br>
								</div>
							</div>
	
								<div id="map4"></div>
						</div>
						<div class="col-md-1 col-sm-1 col-xs-1"></div>
					</div>
					</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="edidocorrencia" id="edidocorrencia">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary" onclick="atualizarPontos(document.getElementById('edidocorrencia').value,document.getElementById('cmboxstatusoccurrence').value,document.getElementById('edtlatitude').value,document.getElementById('edtlongitude').value)">Salvar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<h4><div id="divtaxonconfirmacao">Deseja alterar a localização do ponto ?</div></h4>
				<div id="dadosoriginaisconfirmacao"></div><br>
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-8">
						<b>Dados inferidos</b><br>
						<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrenceconfirmacao',$idstatusoccurrenceconfirmacao,'N','class="form-control"','1,2,4,6,8,10,11,12,13,16,17,18');?>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								Latitude:<input type="text" name="edtlatitude" id="edtlatitudeconfirmacao" class="form-control"><br>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								Longitude:<input type="text" name="edtlongitude" id="edtlongitudeconfirmacao" class="form-control"><br>
							</div>
						</div>
					</div>
				</div>
				</p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="edidocorrencia" id="edidocorrenciaconfirmacao">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="initMapModal(document.getElementById('edidocorrenciaconfirmacao').value)">Fechar</button>
				<button type="button" class="btn btn-primary" onclick="atualizarPontos(document.getElementById('edidocorrenciaconfirmacao').value,document.getElementById('cmboxstatusoccurrenceconfirmacao').value,document.getElementById('edtlatitudeconfirmacao').value,document.getElementById('edtlongitudeconfirmacao').value)">Salvar</button>
			</div>
		</div>
	</div>
</div>

	 <div class="modal fade" id="myModalstatusoccurrence" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel2">Status Ocorrência</h4>
				</div>
				<div class="modal-body">
					<p>
					<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrence222',$idstatusoccurrence222,'N','class="form-control"','1,2,4,6,8,10,11,12,13,16,17,18');?>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary" onclick="atualizarPontos('',document.getElementById('cmboxstatusoccurrence222').value)">Salvar</button>
				</div>

			</div>
		</div>
	</div>								
								
								
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                </div>
            </div>
            <!-- top navigation -->
			<?php require "menutop.php";?>			
				<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="clearfix">
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2><a href="consexperimento.php">Experimento <small>Cadastro experimento</small></a></h2>
									<div class="clearfix">
									</div>
								</div>
								<div class="x_content">
									<form name='frm' id='frm' action='exec.experimento.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
										<input id="id" value="<?php echo $id;?>" name="id" type="hidden">
										<div class="">
											<div>
												<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtexperimento">Experimento <span class="required">*</span>
												</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input id="edtexperimento" value="<?php echo $name;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" required="required">
													</div>
												</div>
											</div>
											<div class="">
												<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtdescricao">Descrição
												</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
													<input id="edtdescricao" value="<?php echo $description;?>"  name="edtdescricao" class="form-control col-md-7 col-xs-12">
													</div>
												</div>
											</div>

											<?php 
												// incluir opção de tipo de projeto e filtros automáticos na hora da criação do projeto
												// OPÇÃO FOR ALTERAR
												
											if ($op=='I'){?>
												<div class="">
													<div class="item form-group" style="display: flex;align-items: center;">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtdescricao">Tipo do Projeto</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<div class="radio-group-new-experiment">
																<form action="">
																	<div class="radio-terrestre"><input type="radio" name="edttipo" id="edttipoterrestre" value="terrestre" checked/> Terrestre</div>
																	<div class="radio-maritimo"><input type="radio" name="edttipo" id="edttipomaritimo" value="marítimo"/> Marítimo</div>
																</form>
															</div>
														</div>
													</div>
												</div>
												<div class="">
													<div class="item form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtfiltroautomatico"></label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="checkbox" name="edtfiltroautomatico" id="edtfiltroautomatico" checked>Executar filtros automaticamente<br>
														</div>
													</div>
												</div>
											<?php } ?>
											<div class="ln_solid"></div>
											<?php if ($op!='I')
											{?>
											<div class="new_experiment_send_button">
												<button id="send" type="button" onclick="enviarExp()" class="btn btn-info" data-toggle="tooltip" data-placement="top" title data-original-title="Salvar informações">Salvar</button>

												<?php
												$sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
												path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,
												case when lat2 is not null then lat2 else lat end as lat,
												case when long2 is not null then long2
												else long end as long
												from modelr.occurrence, modelr.statusoccurrence where 
												occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
												(occurrence.idstatusoccurrence = 4 or occurrence.idstatusoccurrence = 17) and
												idexperiment = ".$id;

												$res = pg_exec($conn,$sql);
												$total = pg_num_rows($res);

												if($total > 0){
													echo '<button id="send2" type="button" onclick="liberarExperimento()" class="btn btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Liberar experimento para modelagem">Liberar</button>';
												} else {
													echo '<button id="send2" type="button" onclick="liberarExperimento()" class="btn btn-success hide" data-toggle="tooltip" data-placement="top" title data-original-title="Liberar experimentos para modelagem" >Liberar</button>';
												}
												?>
											</div>
											<?php } ?>
										</div>
											<?php 
											// SO MOSTRO O BOTÃO SE FOR INCLUIR. ASSIM O BOTÃO FICA NA PARTE DE BAIXO DA TELA QUANDO A
											// OPÇÃO FOR ALTERAR
											
										if ($op=='I'){?>
										<div class="form-group">
                                            <div class="new_experiment_send_button">
                                                <button id="send" onclick="enviarExp()" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Salvar experimento">Salvar</button>
                                            </div>
										</div>
										<?php } ?>
									<!--</div>-->
										<?php if ($op=='A')
										{?>
										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
													<li role="presentation" <?php if ($tab=='1') echo 'class="active"';?>><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Bióticos</a>
													</li>
													<li role="presentation" <?php if ($tab=='2') echo 'class="active"';?>><a href="#tab_content2" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Data Cleaning</a>
													</li>
												</ul>
												<div id="myTabContent" class="tab-content">
													<div class="tab-pane  <?php if ($tab=='1') echo 'in active';?>" id="tab_content1" aria-labelledby="home-tab">
														<div class="row">
															<div class="col-md-12 col-sm-12 col-xs-12">
																<div class="x_panel">
																	<div class="x_title">
																		<h2>Dados Bióticos <small></small></h2>
																		<div class="clearfix">
																		</div>
																	</div>
																	<div class="x_content">
																		<div>
																			<div class="item form-group files-options">
																			<label class="control-label" for="email">Fonte<span class="required">*</span>
																			</label>
																			<div class="">
																				<div class="radio-group">
																					<div><input type="radio" name="fontebiotico[]" id="checkfontejabot" value="1" <?php if ($_REQUEST['fontebiotico'][0]=='1') echo "checked";?> /> JABOT</div>
																					<div><input type="radio" name="fontebiotico[]" id="checkfontegbif" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='2') echo "checked";?>/> GBIF</div>
																					<div><input type="radio" name="fontebiotico[]" id="checkfontesibbr" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='3') echo "checked";?>/> SiBBr</div>
																					<div><input type="radio" name="fontebiotico[]" id="checkfontecsv" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='2') echo "checked";?>/> CSV</div>
																				</div>
																				<div class="csv-button">
																					<form enctype="multipart/form-data"><label id="label-arquivo" for='upload'>Arquivo CSV</label><input id="upload" type=file accept="text/csv" name="files[]" size=30></form>
																					<div class="csv-instruction" data-toggle="tooltip" data-placement="right" title data-original-title="Instruções">
																					<span class="glyphicon glyphicon-modal-window" data-toggle="modal" data-target="#instructionModal"></span>
																				</div>
																			</div>
																			
																			<span id="filename"></span>
																			</div>
																			</div>
																			<div id="csv-separator" class="item form-group files-options">
																				<label class="control-label" for="email">Selecione o separador do CSV<span class="required">*</span></label>
																				<select id="csv-select">
																					<option value=",">Vírgula (,)</option>
																					<option value=";">Ponto e vírgula (;) </option>
																					<option value=":">Dois pontos (:)</option>
																				</select>
																			</div>
																			<div class="item form-group species-name">
																				<div class="">
																					<div class="input-group">
																						<input id="edtespecie" value="<?php echo $especie;?>"  name="edtespecie" class="form-control col-md-7 col-xs-12" >
																						<span class="input-group-btn"><button type="button" onclick="buscar()" class="btn btn-primary" >Buscar</button>
																						<button type="button" onclick="adicionarOcorrencia()" class="btn btn-success btn"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Adicionar</button></span>
																					</div>
																				</div>
																			</div>
																		</div>		
																		<!--id="check-all" class="flat"-->
																		<div id='div_resultadobusca'>
																			<table class="table table-striped responsive-utilities jambo_table bulk_action">
	<?php 
	//1 jabot
	//2 Gbif
	if ((!empty($especie)) && ($_REQUEST['fontebiotico'][0]=='1'))
	{
		$sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude,
		pais,estado_prov as estado,cidade as municipio, siglacolecao as herbario
			from  
		publicacao.extracao_jabot where latitude is not null and longitude is not null and
		familia || ' ' || taxoncompleto ilike '%".$especie."%'";
		$res = pg_exec($conn,$sql);
		$totalregistroselecionados = pg_num_rows($res);
	?>
																				<tbody>

		<thead>
			<tr class="headings">
				<th>
					<input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">
				</th>
				<th class="column-title">Táxon </th>
				<th class="column-title">Tombo </th>
				<th class="column-title">Herbário </th>
				<th class="column-title">Coletor </th>
				<th class="column-title">Coordenadas </th>
				<th class="column-title">Localização</th>
			</tr>
		</thead>
	<?php while ($row = pg_fetch_array($res))
		{
		$codigobarras= str_pad($row['codtestemunho'], 8, "0", STR_PAD_LEFT);	
		$sqlimagem = "select * from jabot.imagem where codigobarras = '".$codigobarras."' limit 1";
		$resimagem = pg_exec($conn,$sqlimagem);
		$rowimagem = pg_fetch_array($resimagem);
		$servidor = $rowimagem ['servidor'];
		$path =  $rowimagem ['path'];
		$arquivo =  $rowimagem ['arquivo'];
		$html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='.$row['codtestemunho'].'&arquivo='.$arquivo.' target=\'Visualizador\'><img src="http://'.$servidor.'/fsi/server?type=image&source='.$path.'/'.$arquivo.'&width=300&height=100&profile=jpeg&quality=20"></a>';
		?>
																					<tr class="even pointer">
																						<td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="<?php echo $row['codtestemunho'];?>" type="checkbox" ></td>
																						<td class=" "><?php echo $html_imagem.' ';?><?php echo $row['taxoncompleto'];?></td>
																						<td class="a-right a-right "><?php echo $row['numtombo'];?></td>
																						<td class=" "><?php echo $row['herbario'];?></td>
																						<td class="a-right a-right "><?php echo $row['coletor'];?> <?php echo $row['numcoleta'];?></td>
																						<td class=" "><?php echo $row['latitude'];?>, <?php echo $row['longitude'];?></td>
																						<td class=" "><?php echo $row['pais'];?>, <?php echo $row['estado'];?> - <?php echo $row['municipio'];?></td>
																					</tr>
	<?php 
		} 
	} // if ((!empty($especie)) && ($_REQUEST['fontebiotico'][0]=='JABOT'))
	?>
												
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														</div> <!-- row -->
													</div> <!-- table panel -->	
													<div  class="tab-pane fade <?php if ($tab=='2') echo 'in active';?>" id="tab_content2" aria-labelledby="home-tab">
														<div class="row">
															<div class="col-md-4 col-sm-4 col-xs-12">
																<div class="x_panel">
																	<div class="x_title">
																		<h2>Data Cleaning</h2>
																		<div class="clearfix"></div>
																	</div>
																	<?php 
																		// so mostra os filtros se não tiver filtro automatico setado	
																	if ($automaticfilter == false){?>
																		<div class="row">
																				<div class="col-md-12 col-sm-12 col-xs-12">
																				<button id="send1" type="button" onclick="atualizarPontos('',10,'','')" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos fora do Brasil">Fora limite Brasil</button>
																				<button id="send2" type="button" onclick="atualizarPontos('',2,'','')" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos fora do município coletado">Fora Município coleta</button>
																				<!--<button id="send3" type="button" onclick="atualizarPontos('',11,'','')" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos no mar">Coordenada no mar</button>
																				<button id="send3" type="button" onclick="atualizarPontos('',12,'','')" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos com coordenada invertida">Coordenada invertida</button>
																				--><button id="send3" type="button" onclick="atualizarPontos('',13,'','')" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos com ambas as coordenadas 0">Coordenada com zero</button>
																				
																				<button id="send4" type="button" onclick="marcarPontosDuplicados()" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos duplicados">Duplicatas</button>
																				<button id="send3" type="button" onclick="atualizarPontos('',99,'','')" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Executar todos os filtros">Executar Todos</button>
																				<!--<button id="send5" type="button" onclick="liberarParaModelagem()" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Liberar experimento para modelagem">Liberar Modelagem</button>-->
																				</div>
																		</div>
																	<?php } ?>
																	<div class="x_content">
																	 <p style="padding: 5px;">
																	<div id="map3"></div>
																		<!-- end pop-over -->
																	</div>
																</div>
															</div>
						
															<div class="col-md-8 col-sm-8 col-xs-12">
																<div class="x_panel">
																	<div class="x_title">
																		<div class="clearfix"></div>
																		<div class="row">
																			<div class="col-md-6 col-sm-6 col-xs-12">
																				<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrencefiltro',$idstatusoccurrencefiltro,'N','class="form-control"','',$id);?>
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-12 points-table-options">
																				<button id="send" type="button" onclick="filtrar(document.getElementById('cmboxstatusoccurrencefiltro').value)" class="btn btn btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos">Filtrar</button>
																				<div class="print-options">
																					<a  class="btn btn-default btn-sm" onClick="imprimir('PDF');" data-toggle="tooltip" data-placement="top" title="Exportar tabela em PDF"><?php echo " PDF ";?></a>
																					<a  class="btn btn-default btn-sm" onClick="imprimir('CSV');"data-toggle="tooltip" data-placement="top" title="Exportar tabela em CSV"><?php echo " CSV";?></a>
																				</div>
																			</div>
																		</div>	
																		<table id="points_table" class="table table-striped responsive-utilities jambo_table bulk_action">
																			<thead>
																				<tr class="headings">
																					<th>
																						<input type="checkbox" name="chkboxtodos" id="chkboxtodos" onclick="selecionaTodos(true);">
																					</th>
																					<th class="column-title">Imagem</th>
																					<th class="column-title">Espécie</th>
																					<th class="column-title">Coletor</th>
																					<th class="column-title">Localização</th>
																					<th class="column-title">Status</th>
																					<th class="column-title">Ação<a data-toggle="tooltip" data-placement="top" title data-original-title="Editar" onclick="abreModelStatusOcorrencia()" class="points-table-action-header"><span class="glyphicon glyphicon-edit edit-button" aria-hidden="true"></span></a></th>
																				</tr>
																			</thead>
<?php 
$sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,herbario,numtombo,
case when lat2 is not null then lat2 else lat end as lat,
case when long2 is not null then long2
else long end as long
from modelr.occurrence, modelr.statusoccurrence where 
occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
idexperiment = ".$id;
if (!empty($filtro))
{
	$sql.=' and occurrence.idstatusoccurrence = '.$filtro;
}
$res = pg_exec($conn,$sql);
$conta = pg_num_rows($res);
$marker = '';
$info = '';
?>
																			<tbody>
<tr class="even pointer">
	<td class="a-center " colspan=7>Total: <?php echo $conta;?></td>
</tr>

<?php 
$c=0;
while ($row = pg_fetch_array($res))
{
	$servidor = $row['server'];
	$path =  $row['path'];
	$arquivo =  $row['file'];
	$herbario =  $row['herbario'];
	$tombo =  $row['numtombo'];
	$localizacao = $row['country'].', '.$row['majorarea'].' - '.$row['minorarea'];
	$coletor = $row['collector'].' '.$row['collectnumber'];
	
	$html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='.$row['codtestemunho'].'&arquivo='.$arquivo.' target=\"Visualizador\"><img src="http://'.$servidor.'/fsi/server?type=image&source='.$path.'/'.$arquivo.'&width=300&height=70&profile=jpeg&quality=20"></a>';
	
	// preparo os quadros de informação para cada ponto
	$c++;
	if ($c < $conta) {
		$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."','".$coletor."','".$herbario."','".$tombo."'],";
	}
	else
	{
		$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."','".$coletor."','".$herbario."','".$tombo."']";
		$latcenter = $row['lat'];
		$longcenter = $row['long'];
	}
	$icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
	if ($row['idstatusoccurrence']!='')
	{
		$icone = 'http://maps.google.com/mapfiles/ms/icons/'.$row['pathicon'];
	}
	?>
								
																				<tr class="even pointer points-table-line">
																					<td class="a-center "><input type="checkbox" name="table_records[]" id="table_records[]" value="<?php echo $row['idoccurrence'];?>" ></td><td><?php echo $html_imagem.' ';?></td>
																					<td class="a-right a-right " style="min-width: 300px;"><?php echo $row['taxon'];?><?php echo $row['numtombo'];?></td>
																					<td class="a-right a-right "><?php echo $row['collector'];?> <?php echo $row['collectnumber'];?></td>
																					<td class=" "><?php if($row['country']) echo $row['country'] . ',';?> <?php if($row['majorarea']) echo $row['majorarea'] . '-';?> <?php if($row['minorarea']) echo $row['minorarea'] . '.';?><br>(<?php echo $row['lat'];?>,<?php echo $row['long'];?>)</td>
																					<td class=" " style="min-width: 250px;"><?php echo "<image src='".$icone."'>".' '.$row['statusoccurrence'];?></td>
																					<td class="points-table-action"><a data-toggle="tooltip" data-placement="top" title data-original-title="Editar" onclick="abreModal('<?php echo $row['taxon'];?>','<?php echo $row['lat'];?>','<?php echo $row['long'];?>','<?php echo $row['idoccurrence'];?>','<?php echo $row[''];?>','<?php echo $row[''];?>','<?php echo $servidor;?>','<?php echo $path;?>','<?php echo $arquivo;?>','<?php echo $row['idstatusoccurrence'];?>','<?php echo $localizacao;?>','<?php echo $coletor;?>','<?php echo $herbario;?>','<?php echo $tombo;?>')">  <span class="glyphicon glyphicon-edit edit-button" aria-hidden="true"></span></a></td>
																				</tr>
	<?php }// while  ?>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div> <!-- row -->
													</div> <!-- table panel -->
												</div> <!-- myTabContent -->
											</div> <!-- tabpanel -->
										</div>
<?php } //<?php if ($op=='A') ?>
									<!--</div> <!-- div class="" -->
									</form>
								</div>
										
                                <!-- <div class="ln_solid"></div> -->
<?php 
	// MOSTRO APENAS PARA A OPÇÃO ALTERAR
	// ASSIM O BOTÃO FICA NA PARTE DE BAIXO DA TELA
if ($op=='A')
	{?>
								<div class="form-group">
									<div class="col-md-6 col-md-offset-5">
										<button id="send" type="button" onclick="enviarExp()" class="btn btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Salvar modificações">Salvar</button>
									</div>
								</div>
<?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
                <!-- footer content -->
            <footer>
                <div class="" id="demo">
                    
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
                
        </div>
            <!-- /page content -->
    </div>

<!--    </div>-->

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>
	<!-- select2 -->
    <script src="js/select/select2.full.js"></script>
	
    <script src="js/custom.js"></script>
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
	
	<script src="js/loading.js"></script>	
	
<!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>		
<script>

function teste(){
	console.log('entrou');
}

function enviarExp(){
	exibe('loading');
	if (
	(document.getElementById('edtexperimento').value=='')  ||
	(document.getElementById('edtdescricao').value=='') 
	)
	{
		criarNotificacao('Atenção','Verifique o preenchimento','warning');
	}
	else
	{
		document.getElementById('frm').action='exec.experimento.php';
		document.getElementById('frm').submit();
	}
}

</script>		
<script>

// This example adds a user-editable rectangle to the map.
function selecionaTodos2(isChecked) {
	//alert('');
	var chks = document.getElementsByName('chtestemunho[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=document.getElementById('chkboxtodos2').checked;
				
	}
	
}

function selecionaTodos(isChecked) {
	//alert('');
	var chks = document.getElementsByName('table_records[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=document.getElementById('chkboxtodos').checked;
				
	}
	
}

function imprimir(tipo)
{
	document.getElementById('frm').target="_blank";//"'cons<?php echo strtolower($FORM_ACTION);?>.php';
	if (tipo=='PDF')
	{
		//console.log(document.getElementById('frm').action='export' + tipo + '.php?table=points')
		document.getElementById('frm').action='export' + tipo + '.php?table=points&expid=' + <?php echo $id;?>;
		document.getElementById('frm').submit();
	}
	if (tipo=='CSV')
	{
		//console.log(document.getElementById('frm').action='export' + tipo + '.php?table=points')
		document.getElementById('frm').action='export' + tipo + '.php?table=points&expid=' + <?php echo $id;?>;
		document.getElementById('frm').submit();
	}
}

function editar()
{
	//alert('');
}

function buscar()
{
	//alert(document.getElementById('checkfontegbif').checked);
	if (document.getElementById('edtespecie').value=='' && document.getElementById('checkfontecsv').checked==false)
	{
		criarNotificacao('Atenção','Informe o nome da espécie','warning')
	}
	else
	{
		var texto = document.getElementById('edtespecie').value;
		var palavra = texto.split(' ');
		if ((palavra.length)<2 && document.getElementById('checkfontecsv').checked==false)
		{
			criarNotificacao('Atenção','Informe o nome da espécie','warning');
		}
		else
		{
			if (document.getElementById('checkfontegbif').checked==true)
			{
				//alert('gbif');
				getTaxonKeyGbif(texto);
				//gbif(texto);
			}
			else if (document.getElementById('checkfontejabot').checked==true)
			{
				//alert('jabot');
				document.getElementById('frm').action="cadexperimento.php?busca=TRUE";
				document.getElementById('frm').submit();
			}
			else if (document.getElementById('checkfontesibbr').checked==true)
			{
				//alert('jabot');
				getSibbr(texto);
			}
			else printCSV(file);
		}
	}
}

function getTaxonKeyGbif(sp)
{
	//alert('');
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myObj = JSON.parse(this.responseText);
        document.getElementById("demo").innerHTML = myObj.results[0]["key"]; //this.responseText;//myObj.result[key];//count;
		gbif(myObj.results[0]["key"]);
		}
	};
	console.log(sp);
	xmlhttp.open("GET", "http://api.gbif.org/v1/species?name="+sp, true);
	xmlhttp.send();
}

function gbif(taxonKey)
{
	//alert(taxonKey);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myObj = JSON.parse(this.responseText);
		var body = '';
		for (i = 0; i < myObj.results.length; i++) {
			//alert(i);
			longitude = myObj.results[i].decimalLongitude;
			latitude = myObj.results[i].decimalLatitude;

			taxon = myObj.results[i].scientificName;
			tombo = myObj.results[i].catalogNumber;
			coletor = myObj.results[i].recordedBy;
			numcoleta = myObj.results[i].recordNumber;
			pais = myObj.results[i].country;
			estado = myObj.results[i].stateProvince;
			cidade = myObj.results[i].municipality;
			herbario = myObj.results[i].datasetName;
			
			//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
			var idexperimento = document.getElementById('id').value;
			
			var Jval = idexperimento + '|2|'+latitude+'|'+longitude+'|'+taxon+'|'+ coletor+'|'+numcoleta+'||||'+ pais+'|'+ estado+'|'+ cidade + '|' + herbario + '|' + tombo; 

				body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
				body +='<td class=" ">'+taxon+'</td>';
				body +='<td class="a-right a-right ">'+tombo+'</td>';
				body +='<td class="a-right a-right ">'+herbario+'</td>';
				body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
				body +='<td class=" ">'+latitude+', '+longitude+'</td>';
				body +='<td class=" ">'+pais+', '+estado+' - '+cidade+'</td>';
			
			//var str = "insert into modelr.occurrence (idexperiment,iddatasource,lat,long,taxon,collector,collectnumber,server,path,file,idstatusoccurrence,country,majorarea,minorarea) values (";
			//str+=idexperiment+','+'2'+','+latitude+','+longitude+",'"+taxon+"','"+coletor+"','"+numcoleta+"','','','','','',


			//x =  myObj.results[i].decimalLongitude + ', '+ myObj.results[i].decimalLatitude;
			//exec.adicionarocorrenciagbif
			//alert(x);
		}
		
		var table = '';
		table += '<table class="table table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
		table += '</th><th class="column-title">Táxon </th><th class="column-title">Tombo </th><th class="column-title">Herbário </th><th class="column-title">Coletor </th><th class="column-title">Coordenadas </th>';
		table += '<th class="column-title">Localização</th>';
		table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
		table += '</th></tr></thead>';
		table += '<tbody>'+body+'</tbody></table>';
		table += '';
			
//			x += '('+myObj.results[i]['decimalLongitude'] + ', '+myObj.results[i]['decimalLongitude']+ ')';
//		}

//		decimalLongitude":-41.336139,"decimalLatitude
		
			document.getElementById("div_resultadobusca").innerHTML = table;
		}
	};
	xmlhttp.open("GET", "http://api.gbif.org/v1/occurrence/search?taxonKey="+taxonKey+'&hasCoordinate=true', true);
	xmlhttp.send();
}


function atualizar(tab)
{
	//$('.nav-tabs a[href="#tab_content5"]').tab('show')
	document.getElementById('frm').action="cadexperimento.php?tab="+tab;
	document.getElementById('frm').submit();
}

function initMap() {
	<?php if (empty($latcenter))
	{
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	}
	?>
	
    var map3 = new google.maps.Map(document.getElementById('map3'), {
     center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
	 mapTypeId: 'terrain',
	 gestureHandling: 'greedy',
        mapTypeControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['terrain','roadmap', 'satellite']
        },
        styles: [
            {
                "featureType": "landscape",
                "stylers": [
                    {"hue": "#FFA800"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {"hue": "#53FF00"},
                    {"saturation": -73},
                    {"lightness": 40},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {"hue": "#FBFF00"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {"hue": "#00FFFD"},
                    {"saturation": 0},
                    {"lightness": 30},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {"hue": "#00BFFF"},
                    {"saturation": 6},
                    {"lightness": 8},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {"hue": "#679714"},
                    {"saturation": 33.4},
                    {"lightness": -25.4},
                    {"gamma": 1}
                ]
            }
        ],
    zoom: 2
  });
 
  	var markers = [
        <?php echo $marker;?>
    ];
                        
    // Info Window Content
	
	var infoWindowContent = [
		<?php echo $info;?>
    ];

//        ['<div class="info_content">' +
 //       '<h3>Caesalpinia Echinata</h3>' +
  //      '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +        '</div>'],
   //     ['<div class="info_content">' +
    //    '<h3>Caesalpinia echinata</h3>' +
     //   '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +
      //  '</div>']
	
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        //bounds.extend(position);
		var icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
		if (markers[i][7]!='')
		{
			icone = 'http://maps.google.com/mapfiles/ms/icons/'+markers[i][7];
		}
		
        marker = new google.maps.Marker({
            position: position,
            map: map3,
			draggable: false,
            title: markers[i][0],
			icon: icone,
			scrollwheel:true
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
				abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],'','',markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9],markers[i][10],markers[i][11],markers[i][12]);
				
            }
        })(marker, i));
		
        // Automatically center the map fitting all markers on the screen
       // map3.fitBounds(bounds);
    }

	tabMap = map3;
	console.log('rodou1')
	initMapModal()//start map inside modal
  
}
var tabMap;
var modalMap;

function initMapModal(idocorrencia) {
	<?php if (empty($latcenter))
	{
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	}
	?>
	
    var map4 = new google.maps.Map(document.getElementById('map4'), {
     center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
	 mapTypeId: 'terrain',
	 gestureHandling: 'greedy',
        mapTypeControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['terrain','roadmap', 'satellite']
        },
        styles: [
            {
                "featureType": "landscape",
                "stylers": [
                    {"hue": "#FFA800"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {"hue": "#53FF00"},
                    {"saturation": -73},
                    {"lightness": 40},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {"hue": "#FBFF00"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {"hue": "#00FFFD"},
                    {"saturation": 0},
                    {"lightness": 30},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {"hue": "#00BFFF"},
                    {"saturation": 6},
                    {"lightness": 8},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {"hue": "#679714"},
                    {"saturation": 33.4},
                    {"lightness": -25.4},
                    {"gamma": 1}
                ]
            }
        ],
    zoom: 2
  });
 
  	var markers = [
        <?php echo $marker;?>
    ];
                        
    // Info Window Content
	
	var infoWindowContent = [
		<?php echo $info;?>
    ];

//        ['<div class="info_content">' +
 //       '<h3>Caesalpinia Echinata</h3>' +
  //      '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +        '</div>'],
   //     ['<div class="info_content">' +
    //    '<h3>Caesalpinia echinata</h3>' +
     //   '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +
      //  '</div>']
	
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  

    for( i = 0; i < markers.length; i++ ) {
		if(markers[i][3] != idocorrencia) continue; //only print clicked ocurrence
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        //bounds.extend(position);
		var icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
		if (markers[i][7]!='')
		{
			icone = 'http://maps.google.com/mapfiles/ms/icons/'+markers[i][7];
		}
		
        marker = new google.maps.Marker({
            position: position,
            map: map4,
			draggable: true,
            title: markers[i][0],
			icon: icone,
			scrollwheel:true
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
				abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],'','',markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9],markers[i][10],markers[i][11],markers[i][12]);
				
            }
        })(marker, i));
		
        google.maps.event.addListener(marker, 'dragend', (function(marker, i) {
            return function() {
				abreConfirmacao(markers[i][0],markers[i][1],markers[i][2],markers[i][3],this.position.lat(),this.position.lng(),markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9],markers[i][10],markers[i][11],markers[i][12]);
				//abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],this.position.lat(),this.position.lng(),markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9]);
				
            }
        })(marker, i));
        // Automatically center the map fitting all markers on the screen
       // map3.fitBounds(bounds);
    }

	modalMap = map4;

  
}


function contaSelecionados(objeto)
{
    var chks = objeto;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		if (chks[i].checked){
			conta = conta + 1;
		}
	}
	return conta;
}

function atualizarPontos(idponto,idstatus,latinf,longinf)
{
	//alert('?idstatus='+idstatus+'&idponto='+idponto+'&latinf='+latinf+'&longinf='+longinf);
	
	exibe('loading');
	document.getElementById('frm').action='exec.atualizarpontos.php?idstatus='+idstatus+'&idponto='+idponto+'&latinf='+latinf+'&longinf='+longinf;
	document.getElementById('frm').submit();
}

function adicionarOcorrencia()
{

	if (contaSelecionados(document.getElementsByName('chtestemunho[]'))>0)
	{
		exibe('loading');
		document.getElementById('frm').action='exec.adicionarocorrencia.php';
		document.getElementById('frm').submit();
	}
	else
	{
		criarNotificacao('Atenção','Selecione os registros que deseja adicionar','warning');
	}
}

function abreModelStatusOcorrencia()
{
	if (contaSelecionados(document.getElementsByName('table_records[]'))>0)
	{
		$('#myModalstatusoccurrence').modal('show');
	}
	else
	{
		criarNotificacao('Atenção','Selecione os registros que deseja alterar o status','warning');
	}
}

function abreModal(taxon,lat,lng,idocorrencia,latinf,lnginf,servidor,path,arquivo,idstatusocorrence,localizacao, coletor, herbario, tombo)
{

   document.getElementById('divtaxon').innerHTML=taxon;
	
	html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho=&arquivo='+arquivo+' target=\"Visualizador\"><img src="http://'+servidor+'/fsi/server?type=image&source='+path+'/'+arquivo+'&width=600&height=200&profile=jpeg&quality=20"></a>';

	document.getElementById('edidocorrencia').value=idocorrencia;
	document.getElementById('divimagem').innerHTML=html_imagem;
	document.getElementById('dadosoriginais').innerHTML='Latitude: '+lat+' Longitude: '+lng+' - '+localizacao;
	document.getElementById('dadoscoletor').innerHTML='Coletor: '+coletor;
	document.getElementById('dadosherbario').innerHTML='Herbário: '+herbario + ' - Tombo: ' + tombo;
	document.getElementById('edtlatitude').value=lat;
	document.getElementById('edtlongitude').value=lng;
	document.getElementById('cmboxstatusoccurrence').value=idstatusocorrence;
	$('#pointModal').modal('show');
	setTimeout(() => { 
		initMapModal(idocorrencia);
	}, 200);
}

function abreConfirmacao(taxon,lat,lng,idocorrencia,latinf,lnginf,servidor,path,arquivo,idstatusocorrence,localizacao)
{
	
	html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho=&arquivo='+arquivo+' target=\"Visualizador\"><img src="http://'+servidor+'/fsi/server?type=image&source='+path+'/'+arquivo+'&width=600&height=200&profile=jpeg&quality=20"></a>';

	document.getElementById('edidocorrenciaconfirmacao').value=idocorrencia;
	document.getElementById('edtlatitudeconfirmacao').value=latinf;
	document.getElementById('edtlongitudeconfirmacao').value=lnginf;
	document.getElementById('cmboxstatusoccurrenceconfirmacao').value=idstatusocorrence;
	$('#confirmationModal').modal('show');
}

function filtrar(idstatusoccurrence)
{
	exibe('loading');
	document.getElementById('frm').action='cadexperimento.php?tab=2&filtro='+idstatusoccurrence;
	document.getElementById('frm').submit();
}

function toggle(isChecked) {
	var chks = document.getElementsByName('chtestemunho[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=isChecked
		
	}
}

function liberarParaModelagem()
{
	document.getElementById('frm').action='exec.liberarmodelagtem.php';
	document.getElementById('frm').submit();
}

function excluirPontosDuplicados()
{
	exibe('loading');
	document.getElementById('frm').action='exec.excluirpontosduplicados.php';
	document.getElementById('frm').submit();
}

function marcarPontosDuplicados()
{
	exibe('loading');
	document.getElementById('frm').action='exec.marcarpontosduplicados.php';
	document.getElementById('frm').submit();
}
		
function liberarExperimento()
{
	if (
		(document.getElementById('edtexperimento').value=='')  ||
		(document.getElementById('edtdescricao').value=='') 
		)
		{
			criarNotificacao('Atenção','Verifique o preenchimento','warning');
		}
		else
		{
			exibe('loading');
			document.getElementById('op').value='LE';
			document.getElementById('frm').action='exec.experimento.php';
			document.getElementById('frm').submit();
		}
}
				
	
        // initialize the validator function
        validator.message['date'] = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
            .on('keyup blur', 'input', function () {
                validator.checkField.apply($(this).siblings().last()[0]);
            });

        // bind the validation to the form submit event
        //$('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();
            return false;
        });

        /* FOR DEMO ONLY */
        $('#vfields').change(function () {
            $('form').toggleClass('mode2');
        }).prop('checked', false);

        $('#alerts').change(function () {
            validator.defaults.alerts = (this.checked) ? false : true;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);

		$('.nav-tabs a[href="#tab_content2"]').click(function(){
			$(this).tab('show');
			initMap();
			setTimeout(function(){ google.maps.event.trigger(tabMap, "resize");}, 200);
		})

var file;

function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // use the 1st file from the list
    f = files[0];

    var reader = new FileReader();

    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {

		//console.log(e.target.result)
		var arr = e.target.result.split('\n');

		document.getElementById("checkfontecsv").checked = true;
		document.getElementById("filename").innerHTML = f.name;
		document.getElementById("csv-separator").style.display = 'flex';
		file = arr;
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsText(f);
  }

function printCSV(lines){
	var body = '';
	var separator = document.getElementById("csv-select").options[document.getElementById("csv-select").selectedIndex].value;
	for (i = 0; i < lines.length-1; i++) {

		var values = lines[i].split(separator);
		//alert(i);
		longitude = values[1] || 0;
		latitude = values[2] || 0;

		taxon = values[0];
		
		var idexperimento = document.getElementById('id').value;
		
		var Jval = idexperimento + '|2|'+latitude+'|'+longitude+'|'+taxon+'||||||||'; 

		body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
		body +='<td class=" ">'+taxon+'</td>';
		body +='<td class=" ">'+latitude+', '+longitude+'</td>';

	}
	
	var table = '';
	table += '<table class="table table-csv table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
	table += '</th><th class="column-title">Táxon </th><th class="column-title">Coordenadas</th>';
	table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
	table += '</th></tr></thead>';
	table += '<tbody>'+body+'</tbody></table>';
	table += '';
	
	document.getElementById("div_resultadobusca").innerHTML = table;
}

  document.getElementById('upload').addEventListener('change', handleFileSelect, false);

    </script>
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhi_DlmaFvRu7eP357bOzl29fyZXKIJE0&callback=initMap" async defer>
    </script>	
	
    <script>
	
	

<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
//$tab = $_REQUEST['tab'];
?>
$(document ).ready(function() {
	var automaticFilter = <?php echo $automaticfilter;?>;
	var MSGCODIGO = <?php echo $MSGCODIGO;?>;
	if(automaticFilter && MSGCODIGO == 71) atualizarPontos('',99,'','');

});
		
// $('.nav-tabs a[href="#tab_content1"]').on('shown', function () {
// 	console.log('entroiu')
// 	google.maps.event.trigger(tabMap, "resize");
// });

$('.nav-tabs a[href="#tab_content2"]').click(function(){
    $(this).tab('show');
	filtrar('');
})	

// $('.points-table-action').click(function(){
// 	google.maps.event.trigger(modalMap, "resize");
// })

$('#pointModal').on('shown', function () {
        console.log('entroiu')
		google.maps.event.trigger(modalMap, "resize");
    });

$(".enviar-exp").click(function(){
  // Holds the product ID of the clicked element
  console.log('entrou')
});

    </script>

</body>

</html>