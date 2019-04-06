<html lang="pt-BR">
<?php
require_once('classes/conexao.class.php');
require_once('classes/projeto.class.php');
require_once('classes/experimento.class.php');
require_once('classes/tipoparticionamento.class.php');
require_once('classes/fonte.class.php');
require_once('classes/periodo.class.php');
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

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

$especie = $_REQUEST['edtespecie'];

$extensao1_norte = '44.599';
$extensao1_sul = '44.490';
$extensao1_leste = '-78.443';
$extensao1_oeste = '-78.649';

$extensao2_norte = '44.599';
$extensao2_sul = '44.490';
$extensao2_leste = '-78.443';
$extensao2_oeste = '-78.649';

if ($op=='A')
{
	$Experimento->getById($id);

			$idexperimento = 	   	$Experimento->idexperimento ;//= $row['nomepropriedade'];
			$idprojeto = 	   	$Experimento->idprojeto ;//= $row['nomepropriedade'];
		   	$experimento = $Experimento->experimento ;//= $row['inscricaoestadual'];
		   	
}
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Model-R </title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

	<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
	  #map2 {
        height: 100%;
      }
	  #map3 {
        height: 100%;
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

    <div class="container body">


        <div class="main_container">


            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <!--<a href="index.html" class="site_title"><span>Mode-R</span></a>-->
                        <!--<a href="index.html" class="site_title"><span>Mode-R</span></a>-->
                    </div>
                    <div class="clearfix"></div>
					<?php require "menu.php";?>
                </div>
            </div>

            <!-- top navigation -->
			<?php require "menutop.php";?>

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="">

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Experimento <small>Cadastro experimento</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form name='frm' id='frm' action='exec.experimento.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
									
									<div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Projeto <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Projeto->listaCombo('cmboxprojeto',$idprojeto,'N','class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Experimento <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $experimento;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" required="required">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Tipo Particionamento <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $TipoParticionamento->listaCombo('cmboxtipoparticionamento',$idtipoparticionamento,'N','class="form-control"');?>
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Num. de Partições <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
												<input onchange="document.getElementById('lblnumparticoes').value=this.value" id="edtnumparticoes" value="<?php echo $edtnumparticoes;?>" type="range" min='3' max='50' name="edtnumparticoes" class="form-control col-md-7 col-xs-12" required="required"><span id="lbl3"></span>
                                            </div>
											<div class="col-md-2 col-sm-2 col-xs-2">
                                                <input id="lblnumparticoes" onchange="document.getElementById('edtnumparticoes').value= this.value " value="<?php echo $edtnumparticoes;?>"  name="lblnumparticoes" class="form-control col-md-2 col-xs-12">
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Num. de Pontos <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input onchange="document.getElementById('lblnumpontos').value=this.value" id="edtnumpontos" value="<?php echo $numpontos;?>" type="range" min='100' max='2000' name="edtnumpontos" class="form-control col-md-7 col-xs-12" required="required"><span id="lbl2"></span>
                                            </div>
											<div class="col-md-2 col-sm-2 col-xs-2">
                                                <input id="lblnumpontos" onchange="document.getElementById('edtnumpontos').value= this.value " value="<?php echo $numpontos;?>"  name="edtnumpontos" class="form-control col-md-2 col-xs-12">
                                            </div>

                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Buffer<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input onchange="document.getElementById('lblbuffer').value=this.value" id="edtbuffer" value="<?php echo $buffer;?>" type="range" min='1' max='2' step='0.1' name="edtbuffer" class="form-control col-md-3 col-xs-5" required="required">
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input id="lblbuffer" onchange="document.getElementById('edtbuffer').value= this.value " value="<?php echo $buffer;?>"  name="lblbuffer" class="form-control col-md-2 col-xs-12">
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">TSS<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input onchange="document.getElementById('lbltss').value=this.value" id="edttss" value="<?php echo $tss;?>" type="range" min='0' max='1' step='0.1' name="edttss" class="form-control col-md-3 col-xs-5" required="required">
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input id="lbltss" onchange="document.getElementById('edttss').value= this.value " value="<?php echo $tss;?>"  name="lbltss" class="form-control col-md-2 col-xs-12">
                                            </div>
                                        </div>
									</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="x_panel">
                                <div class="x_title">
                                    <h2>Algoritmos <small>Marque os algoritmos que deseja utilizar</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
								 <p style="padding: 5px;">
								 <?php $sql = 'select * from algoritmo';
								 $res = pg_exec($conn,$sql);
								 while ($row = pg_fetch_array($res))
								 {
									 ?>
                                           <input type="checkbox" name="algoritmo[]" id="checkalgoritmo<?php echo $row['idalgoritmo'];?>" value="<?php echo $row['idalgoritmo'];?>" data-parsley-mincheck="2" required class="flat" /> <?php echo $row['algoritmo'];?>
                                            <br />
									 
								 <?php } ?>
                                    <!-- end pop-over -->

                                </div>
                            </div>
                        </div>
						
						
						
						  <div class="x_content">

						 <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content0" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Bióticos</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content10" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Data Cleaning</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Extensão Criação</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Extensão Projeção</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Dados Abióticos</a>
                                            </li>
                                        </ul>
                        <div id="myTabContent" class="tab-content">

										
						<div role="tabpanel" class="tab-pane fade active in" id="tab_content0" aria-labelledby="home-tab">
						
						
						
						<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Dados Bióticos <small></small></h2>
									 <ul class="nav navbar-right panel_toolbox">
                                        <li><a><i class="fa fa-globe"></i></a>
                                        </li>
                                        <li><a><i class="fa fa-save"></i></a>
                                        </li>
                                        <li><a data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-file-excel-o"></i></a>
                                        </li>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
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
                                        <!--<li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Settings 1</a>
                                                </li>
                                                <li><a href="#">Settings 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
										-->
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
									<form name='frmbusca' method="get" id="frmbusca">
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Fonte<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="checkbox" name="fontebiotico[]" id="checkfontegbif" value="GBIF" data-parsley-mincheck="2" required class="flat" /> GBIF
												<input type="checkbox" name="fontebiotico[]" id="checkfontejabot" value="JABOT" data-parsley-mincheck="2" required class="flat" /> JABOT
												<input type="checkbox" name="fontebiotico[]" id="checkfonteoutro" value="OUTRO" data-parsley-mincheck="2" required class="flat" /> Outro
											<br />
											</div>
											
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Espécie:
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<div class="input-group">
                                                    <input id="edtespecie" value="<?php echo $especie;?>"  name="edtespecie" class="form-control col-md-7 col-xs-12" >
													<span class="input-group-btn"><button type="button" onclick="buscar()"; class="btn btn-primary">Buscar</button></span>
                                                </div>
                                            </div>
											
                                        </div>		
                                    </form>
								 <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">Táxon </th>
                                                <th class="column-title">Tombo </th>
                                                <th class="column-title">Latitude </th>
                                                <th class="column-title">Logitude</th>
                                                <th class="column-title no-link last"><span class="nobr">Action</span>
                                                </th>
                                                <th class="bulk-actions" colspan="7">
                                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                </tr>
                            </thead>
							
							<?php 
							if (!empty($especie))
							{
								$sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude from 
								publicacao.extracao_jabot where latitude is not null and longitude is not null and
								taxoncompleto ilike '%".$especie."%'";
//echo $sql;
								$res = pg_exec($conn,$sql);
							?>
                            <tbody>
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
                                    <td class="a-center "><input type="checkbox" class="flat" name="table_records" ></td>
                                    <td class=" "><?php echo $html_imagem.' ';?><?php echo $row['taxoncompleto'];?></td>
                                    <td class="a-right a-right "><?php echo $row['numtombo'];?></td>
									<td class=" "><?php echo $row['latitude'];?></td>
                                    <td class=" "><?php echo $row['longitude'];?></td>
                                    <td class=" last">
									<a><i class="fa fa-globe"></i></a>
                                    <a><i class="fa fa-save"></i></a>
                                    </td>
                                </tr>
							<?php } 
							} // if (!empty($especie))
							
							?>
											
										</tbody>
									</table>
								 
                                    <!-- end pop-over -->

                                </div>
                                    <!-- end pop-over -->

                                
                                    <!-- end pop-over -->
                                </div>
                            </div>
						</div> <!-- row -->
						</div> <!-- table panel -->	

<div role="tabpanel" class="tab-pane fade active out" id="tab_content10" aria-labelledby="home-tab">
						
						<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Data Cleaning<small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
								 <p style="padding: 5px;">
								 <div id="map3"></div>
                                    <!-- end pop-over -->
                                </div>
                            </div>
                        </div>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <h2>
									<button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir pontos Selecionados</button>
									<button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir pontos duplicados</button>
									<small></small></h2>
                                    <div class="clearfix"></div>
									
									
																	 <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">Táxon </th>
                                                <th class="column-title">Tombo </th>
                                                <th class="column-title">Latitude </th>
                                                <th class="column-title last">Logitude</th>
												<th class="bulk-actions" colspan="6">
                                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                </tr>
                            </thead>
							
							<?php 
							$sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude from 
							publicacao.extracao_jabot where latitude is not null and longitude is not null and
							taxoncompleto ilike '%".$especie."%'				
limit 10 ";
//echo $sql;
$res = pg_exec($conn,$sql);
$conta = pg_num_rows($res);

$marker = '';
							?>
                            <tbody>
							<?php 
							$c=0;
							while ($row = pg_fetch_array($res))
							{
								$c++;
								if ($c < $conta) {
									$marker .= "['".$row['taxoncompleto']."', ".$row['latitude'].",".$row['longitude']."],";
								}
								else
								{
									$marker .= "['".$row['taxoncompleto']."', ".$row['latitude'].",".$row['longitude']."]";
									$latcenter = $row['latitude'];
									$longcenter = $row['longitude'];
								}
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
                                    <td class="a-center "><input type="checkbox" class="flat" name="table_records" ></td>
                                    <td class=" "><?php echo $html_imagem.' ';?><?php echo $row['taxoncompleto'];?></td>
                                    <td class="a-right a-right "><?php echo $row['numtombo'];?></td>
									<td class=" "><?php echo $row['latitude'];?></td>
                                    <td class=" last"><?php echo $row['longitude'];?></td>
                                </tr>
							<?php } ?>
											
										</tbody>
									</table>
									
									
                                </div>
                               
							</div>
						</div>
						
						</div> <!-- row -->
						</div> <!-- table panel -->
                        
						
										
										
                         <div role="tabpanel" class="tab-pane fade active out" id="tab_content1" aria-labelledby="home-tab">
						
						<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Extensão Criação <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
								 <p style="padding: 5px;">
								 <div id="map"></div>
                                    <!-- end pop-over -->
                                </div>
                            </div>
                        </div>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Extensão Criação <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Longitude esquerda: </span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $extensao1_oeste;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" >
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Longitude direita:</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $extensao1_leste;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>	
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Latitude superior:</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $extensao1_norte;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" >
                                            </div>
                                        </div>	
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Latitude inferior:</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $extensao1_sul;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" >
                                            </div>
                                        </div>										
								</div>
							</div>
						</div>
						
						</div> <!-- row -->
						</div> <!-- table panel -->
                        
						
						<div role="tabpanel" class="tab-pane fade active out" id="tab_content2" aria-labelledby="home-tab">
						
						<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Extensão Projeção <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
								 <p style="padding: 5px;">
								 <div id="map2"></div>
                                    <!-- end pop-over -->
                                </div>
                            </div>
                        </div>
						
												<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Extensão Projeção <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Longitude esquerda:</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $extensao2_oeste;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" >
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Longitude direita:
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $extensao2_leste;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" >
                                            </div>
                                        </div>	
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Latitude superior:
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $extensao2_norte;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" >
                                            </div>
                                        </div>	
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Latitude inferior:
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtexperimento" value="<?php echo $extensao2_sul;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" >
                                            </div>
                                        </div>										
								</div>
							</div>
						</div>
						</div> <!-- row -->
						</div> <!-- table panel -->
						
						
						
						<div role="tabpanel" class="tab-pane fade active out" id="tab_content3" aria-labelledby="home-tab">
						
						<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Dados Abióticos <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
								
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Fonte<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Fonte->listaCombo('cmboxfonte',$idfonte,'N','class="form-control"');?>
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Período<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Periodo->listaCombo('cmboxperiodo',$idperiodo,'N','class="form-control"');?>
                                            </div>
                                        </div>
                                   <div class="x_content">
								 <p style="padding: 5px;">
								 <?php $sql = 'select * from raster';
								 $res = pg_exec($conn,$sql);
								 while ($row = pg_fetch_array($res))
								 {
									 ?>
                                           <input type="checkbox" name="raster[]" id="checkraster<?php echo $row['idraster'];?>" value="<?php echo $row['idraster'];?>" data-parsley-mincheck="2" required class="flat" /> <?php echo $row['raster'];?>
                                            <br />
									 
								 <?php } ?>
                                    <!-- end pop-over -->

                                </div>
                                    <!-- end pop-over -->

                                
                                    <!-- end pop-over -->
                                </div>
                            </div>
                        </div>
						
						</div> <!-- row -->
						</div> <!-- table panel -->
						
						

						
						
						
						
						</div> <!-- myTabContent -->
						
						
						
						</div> <!-- tabpanel -->
						</div>
						
						
						
						
						
						
						
						</div> <!-- div class="" -->
						</div>

										
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-5">
                                                <button id="send" type="button" onclick="enviar()" class="btn btn-success">Salvar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- footer content -->
            <footer>
                <div class="">
                    
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
                
            </div>
            <!-- /page content -->
        </div>

    </div>

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

    <script src="js/custom.js"></script>
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
	
<!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>		
		
<script>
// This example adds a user-editable rectangle to the map.
function buscar()
{
	if (document.getElementById('edtespecie').value=='')
	{
		alert('Informe o nome da espécie');
		
	}
	else
	{
		document.getElementById('frmbusca').action="cadexperimento.php?busca=TRUE";
		document.getElementById('frmbusca').submit();
	}
}

function initMap() {
	<?php if (empty($latcenter))
	{
		$latcenter = 44.5452;
		$longcenter = -78.5389;
	}
	?>
	
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 44.5452, lng: -78.5389},
   // center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
    zoom: 9
  });

    var map2 = new google.maps.Map(document.getElementById('map2'), {
    center: {lat: 44.5452, lng: -78.5389},
    //center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
    zoom: 9
  });
  
    var map3 = new google.maps.Map(document.getElementById('map3'), {
     center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
    zoom: 9
  });

// [START region_rectangle]
  var bounds1 = {
    north: <?php echo $extensao1_norte;?>,
    south: <?php echo $extensao1_sul ;?>,
    east: <?php echo $extensao1_leste ;?>,
    west: <?php echo $extensao1_oeste ;?>
  };

  var bounds2 = {
    north: <?php echo $extensao2_norte;?>,
    south: <?php echo $extensao2_sul ;?>,
    east: <?php echo $extensao2_leste ;?>,
    west: <?php echo $extensao2_oeste ;?>
  };
  
  // Define a rectangle and set its editable property to true.
  var rectangle = new google.maps.Rectangle({
    bounds: bounds1,
    editable: true
  });

  var rectangle2 = new google.maps.Rectangle({
    bounds: bounds2,
    editable: true
  });
  
  // [END region_rectangle]
  rectangle.setMap(map);
  rectangle2.setMap(map2);
  
  	var markers = [
        <?php echo $marker;?>
    ];
                        
    // Info Window Content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3>Caesalpinia Echinata</h3>' +
        '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="enviar()" class="btn btn-default">Salvar Posição</button></p>' +        '</div>'],
        ['<div class="info_content">' +
        '<h3>Caesalpinia echinata</h3>' +
        '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="enviar()" class="btn btn-default">Salvar Posição</button></p>' +
        '</div>']
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        //bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map3,
			draggable: true,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
       // map3.fitBounds(bounds);
    }

  
}


    </script>
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhi_DlmaFvRu7eP357bOzl29fyZXKIJE0&callback=initMap" async defer>
    </script>	
	
    <script>
	

<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
?>
		
function enviar()
		{
			if (
			(document.getElementById('edtexperimento').value=='')  ||
			(document.getElementById('cmboxprojeto').value=='') 
			)
			{
				criarNotificacao('Atenção','Verifique o preenchimento','warning');
			}
			else
			{
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
    </script>

</body>

</html>