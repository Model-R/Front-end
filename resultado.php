<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?><html lang="pt-BR">
<?php
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
	$tab = 3;
}
$op=$_REQUEST['op'];

$id=$_REQUEST['id'];
$hash = md5($id);

$idsource = $_REQUEST['cmboxfonte'];

$especie = $_REQUEST['edtespecie'];

$extensao1_norte = '6.41';
$extensao1_sul = '-32.490';
$extensao1_leste = '-34.443';
$extensao1_oeste = '-62.649';

$extensao2_norte = '6.41';
$extensao2_sul = '-32.490';
$extensao2_leste = '-34';
$extensao2_oeste = '-62';

$idproject = $_REQUEST['idproject'];

$Experimento->getById($id);
$idexperiment = 	   	$Experimento->idexperiment;//= $row['nomepropriedade'];
$idproject = 	   	$Experimento->idproject ;//= $row['nomepropriedade'];
$name = $Experimento->name ;//= $row['inscricaoestadual'];
$idtipoparticionamento = $Experimento->idpartitiontype;
$num_partition = $Experimento->num_partition;
$buffer = $Experimento->buffer;
$numpontos = $Experimento->num_points;
$tss = $Experimento->tss;


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
	  #map3 {
        height: 65%;
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
	
	 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
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
												<div id="divimagem"></div><br>
												<b>Dados inferidos</b><br>
												<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrence',$idstatusoccurrence,'N','class="form-control"','1,4,6,7,16,17');?>
												<br>
												Latitude:<input type="text" name="edtlatitude" id="edtlatitude" class="form-control"><br>
												Longitude:<input type="text" name="edtlongitude" id="edtlongitude" class="form-control"><br>
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

	 <div class="modal fade" id="myModalstatusoccurrence" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Status Ocorrência</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>
												<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrence222',$idstatusoccurrence222,'N','class="form-control"','1,4,6,7,16,17');?>
												</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" onclick="atualizarPontos('',document.getElementById('cmboxstatusoccurrence222').value)">Salvar</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>								
								
								
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    
					<?php //require "menu.php";?>
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
									<h2><a href="consexperimento.php">Resultado</a> [ <?php echo $name;?> ]</h2>
									<div class="clearfix">
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
									 
									</div>
								</div>
									
									
								<div class="x_content">
									<form name='frm' id='frm' action='exec.modelagem.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
										<input id="id" value="<?php echo $id;?>" name="id" type="hidden">
									
										<div class="x_content">
                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
												<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
													<li role="presentation" <?php if ($tab=='3') echo 'class="active"';?>><a href="#tab_content3" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Modelos Gerados</a>
													</li>
													<li role="presentation" <?php if ($tab=='4') echo 'class="active"';?>><a href="#tab_content4" id="home-tab" role="tab"  data-toggle="tab"  aria-expanded="true">Modelos Finais (Ensemble)</a>
													</li>
                                                    <li role="presentation" <?php if ($tab=='5') echo 'class="active"';?>><a href="#tab_content5" id="home-tab" role="tab"  data-toggle="tab"  aria-expanded="true">Modelos Finais (Presfinal)</a>
													</li>
												</ul>
                        <div id="myTabContent" class="tab-content">

                         <div  class="tab-pane fade <?php if ($tab=='3') echo 'in active';?>" id="tab_content3" >
						
						<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Dados estatísticos <small></small></h2>
                                    <div class="clearfix"></div>
									<table class="table table-striped">
   
    <tbody>
	<thead>
<tr>
<th>algoritmo</th>
<th>partition</th>
<th>kappa</th>
<th>spec_sens</th>
<th>no_omission</th>
<th>prevalence</th>
<th>equal_sens_spec</th>
<th>sensitivity</th>
<th>AUC</th>
<th>TSS</th>
</tr>
</thead>
	<?php
	
	$sql = 'select * from modelr.experiment_result';
	$res = pg_exec($conn,$sql);
	while ($row = pg_fetch_array($res))
	{
		$kappa = $row['kappa'];
		$spec_sens = $row['spec_sens'];
		$no_omission = $row['no_omission'];
		$prevalence = $row['prevalence'];
		$equal_sens_spec = $row['equal_sens_spec'];
		$sensitivity = $row['sensitivity'];
		$auc = $row['auc'];
		$tss = $row['tss'];
		$algoritmo = $row['algorithm'];
		$partition = $row['partition'];
		echo '<tr>';
   echo '<td>'.$algoritmo.'</td>';
   echo '<td>'.$partition.'</td>';
   echo '<td>'.$kappa.'</td>';
   echo '<td>'.$spec_sens.'</td>';
   echo '<td>'.$no_omission.'</td>';
   echo '<td>'.$prevalence.'</td>';
   echo '<td>'.$equal_sens_spec.'</td>';
   echo '<td>'.$sensitivity.'</td>';
   echo '<td>'.$auc.'</td>';
   echo '<td>'.number_format($tss,3,',','').'</td>';
   echo '</tr>';
	}
/*
	$names=file('./result/'.$hash.'/estatistica.txt');
// To check the number of lines
//echo count($names).'<br>';
$linha = 0;
foreach($names as $name)
{
	list ($kappa, $spec_sens,$no_omission,$prevalence,$equal_sens_spec,$sensitivity,$AUC,$TSS,$algoritmo,$partition) = split (';', $name);
	if ($linha == 0)
	{
		echo ' <thead><tr>';
//   echo '<th>'.$kappa.'</th>';
   echo '<th>'.$spec_sens.'</th>';
   echo '<th>'.$no_omission.'</th>';
   echo '<th>'.$prevalence.'</th>';
   echo '<th>'.$equal_sens_spec.'</th>';
   echo '<th>'.$sensitivity.'</th>';
   echo '<th>'.$AUC.'</th>';
   echo '<th>'.$TSS.'</th>';
   echo '<th>'.$algoritmo.'</th>';
   echo '<th>'.$partition.'</th>';
   echo '</tr> </thead>';
	}
	else
	{
	echo '<tr>';
//   echo '<td>'.$kappa.'</td>';
   echo '<td>'.$spec_sens.'</td>';
   echo '<td>'.$no_omission.'</td>';
   echo '<td>'.$prevalence.'</td>';
   echo '<td>'.$equal_sens_spec.'</td>';
   echo '<td>'.$sensitivity.'</td>';
   echo '<td>'.$AUC.'</td>';
   echo '<td>'.number_format($TSS,3,',','').'</td>';
   echo '<td>'.$algoritmo.'</td>';
   echo '<td>'.$partition.'</td>';
   echo '</tr>';
	}
	$linha ++;
}
*/
?>
<?php
/*	$meuArray = Array();
$file = fopen('./result/e369853df766fa44e1ed0ff613f563bd/evaluateEugenia aurata O.Berg_5_bioclim.txt', 'r');
while (($line = fgetcsv($file)) !== false)
{
  $meuArray[] = $line;
}
fclose($file);
print_r($meuArray);

foreach($meuArray as $linha => $valor){
echo 'linha '.$linha.' = '.$valor;
}
	
for($i = 0; $i < count($meuArray); $i++){
echo '<td>'.$meuArray[$i].'</td>';
}
*/
?>

	
    </tbody>
  </table>
                                </div>
								
								<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="row">
                                <div class="x_title">
                                    <h2>Modelos Gerados <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
<?php								
								$log_directory = './result/'.$hash.'';

$results_array = array();
$conta_arquivos = 0;
if (is_dir($log_directory))
{
        if ($handle = opendir($log_directory))
        {
                //Notice the parentheses I added:
                while(($file = readdir($handle)) !== FALSE)
                {
					$tamanho = strlen($file); 
					list ($arquivo, $ext) = split ('[.]', $file);
					
					$ext = substr($file,-3);
					
					if (($file != 'ensemble_geral_legend.png') &&
						($file != 'ensemble_geral.png')
					)
					{
					if ($ext=='png') 
					//{
						//echo $ext.'<br>';
                        $results_array[] = $file;
						$conta_arquivos++;
					//}
					}
                }
                closedir($handle);
        }
}

//Output findings
$c = 0;
foreach($results_array as $value)
{
	?>
  <div class="col-md-3 image-model">
      <a href="<?php echo $log_directory.'/'.$value;?>" target="result">
        <img src="<?php echo $log_directory.'/'.$value;?>" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
          <p><?php //echo $value;?></a><br>
          <a href="<?php echo $log_directory.'/'.$value;?>" class="btn btn-default btn-sm download-button" download><i class="fa fa-download"></i>PNG</a>
          <a href="<?php echo $log_directory.'/'.str_replace('png','tif',$value);?>" class="btn btn-default btn-sm download-button" download><i class="fa fa-download"></i>RASTER</a>
		  <?php //echo str_replace('.png','.tiff',$value);?>
          </p>
        
      
  </div>
 <?php } ?>
                                   <!-- end pop-over -->

                                
                                    <!-- end pop-over -->
                            </div>
                        </div>

								

						
						</div> <!-- row -->
								</div>
								
                            </div>
                        </div>
						
						</div> <!-- row -->

                        <div class="tab-pane fade<?php if ($tab=='4') echo ' in active';?>" id="tab_content4">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                        <div class="x_title">
                                <h2>Dados estatísticos <small></small></h2>
                                <div class="clearfix"></div>
									<table class="table table-striped">
   
                                        <tbody>
                                        <thead>
                                    <tr>
                                    <th>algoritmo</th>
                                    <th>partition</th>
                                    <th>kappa</th>
                                    <th>spec_sens</th>
                                    <th>no_omission</th>
                                    <th>prevalence</th>
                                    <th>equal_sens_spec</th>
                                    <th>sensitivity</th>
                                    <th>AUC</th>
                                    <th>TSS</th>
                                    </tr>
                                    </thead>
                                        <?php
                                        
                                        $sql = 'select * from modelr.experiment_result';
                                        $res = pg_exec($conn,$sql);
                                        while ($row = pg_fetch_array($res))
                                        {
                                            $kappa = $row['kappa'];
                                            $spec_sens = $row['spec_sens'];
                                            $no_omission = $row['no_omission'];
                                            $prevalence = $row['prevalence'];
                                            $equal_sens_spec = $row['equal_sens_spec'];
                                            $sensitivity = $row['sensitivity'];
                                            $auc = $row['auc'];
                                            $tss = $row['tss'];
                                            $algoritmo = $row['algorithm'];
                                            $partition = $row['partition'];
                                            echo '<tr>';
                                    echo '<td>'.$algoritmo.'</td>';
                                    echo '<td>'.$partition.'</td>';
                                    echo '<td>'.$kappa.'</td>';
                                    echo '<td>'.$spec_sens.'</td>';
                                    echo '<td>'.$no_omission.'</td>';
                                    echo '<td>'.$prevalence.'</td>';
                                    echo '<td>'.$equal_sens_spec.'</td>';
                                    echo '<td>'.$sensitivity.'</td>';
                                    echo '<td>'.$auc.'</td>';
                                    echo '<td>'.number_format($tss,3,',','').'</td>';
                                    echo '</tr>';
                                        }
                                    /*
                                        $names=file('./result/'.$hash.'/estatistica.txt');
                                    // To check the number of lines
                                    //echo count($names).'<br>';
                                    $linha = 0;
                                    foreach($names as $name)
                                    {
                                        list ($kappa, $spec_sens,$no_omission,$prevalence,$equal_sens_spec,$sensitivity,$AUC,$TSS,$algoritmo,$partition) = split (';', $name);
                                        if ($linha == 0)
                                        {
                                            echo ' <thead><tr>';
                                    //   echo '<th>'.$kappa.'</th>';
                                    echo '<th>'.$spec_sens.'</th>';
                                    echo '<th>'.$no_omission.'</th>';
                                    echo '<th>'.$prevalence.'</th>';
                                    echo '<th>'.$equal_sens_spec.'</th>';
                                    echo '<th>'.$sensitivity.'</th>';
                                    echo '<th>'.$AUC.'</th>';
                                    echo '<th>'.$TSS.'</th>';
                                    echo '<th>'.$algoritmo.'</th>';
                                    echo '<th>'.$partition.'</th>';
                                    echo '</tr> </thead>';
                                        }
                                        else
                                        {
                                        echo '<tr>';
                                    //   echo '<td>'.$kappa.'</td>';
                                    echo '<td>'.$spec_sens.'</td>';
                                    echo '<td>'.$no_omission.'</td>';
                                    echo '<td>'.$prevalence.'</td>';
                                    echo '<td>'.$equal_sens_spec.'</td>';
                                    echo '<td>'.$sensitivity.'</td>';
                                    echo '<td>'.$AUC.'</td>';
                                    echo '<td>'.number_format($TSS,3,',','').'</td>';
                                    echo '<td>'.$algoritmo.'</td>';
                                    echo '<td>'.$partition.'</td>';
                                    echo '</tr>';
                                        }
                                        $linha ++;
                                    }
                                    */
                                    ?>
                                    <?php
                                    /*	$meuArray = Array();
                                    $file = fopen('./result/e369853df766fa44e1ed0ff613f563bd/evaluateEugenia aurata O.Berg_5_bioclim.txt', 'r');
                                    while (($line = fgetcsv($file)) !== false)
                                    {
                                    $meuArray[] = $line;
                                    }
                                    fclose($file);
                                    print_r($meuArray);

                                    foreach($meuArray as $linha => $valor){
                                    echo 'linha '.$linha.' = '.$valor;
                                    }
                                        
                                    for($i = 0; $i < count($meuArray); $i++){
                                    echo '<td>'.$meuArray[$i].'</td>';
                                    }
                                    */
                                    ?>

                                        
                                        </tbody>
                                    </table>
                                </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="x_content">

                            <div class="row">
                                                            <div class="x_title">
                                                                <h2>Modelos Finais (Ensemble) <small></small></h2>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div class="x_content">
                            <?php								
                                                            $log_directory = './result/'.$hash.'/ensemble';

                            $results_array = array();
                            $conta_arquivos = 0;
                            if (is_dir($log_directory))
                            {
                                    if ($handle = opendir($log_directory))
                                    {
                                            //Notice the parentheses I added:
                                            while(($file = readdir($handle)) !== FALSE)
                                            {
                                                $tamanho = strlen($file); 
                                                list ($arquivo, $ext) = split ('[.]', $file);
                                                
                                                $ext = substr($file,-3);
                                                
                                                if (($file != 'ensemble_geral_legend.png') &&
                                                    ($file != 'ensemble_geral.png')
                                                )
                                                {
                                                if ($ext=='png') 
                                                //{
                                                    //echo $ext.'<br>';
                                                    $results_array[] = $file;
                                                    $conta_arquivos++;
                                                //}
                                                }
                                            }
                                            closedir($handle);
                                    }
                            }

                            //Output findings
                            $c = 0;
                            foreach($results_array as $value)
                            {
                                ?>
                            <div class="col-md-6 image-model">
                                <a href="<?php echo $log_directory.'/'.$value;?>" target="result">
                                    <img src="<?php echo $log_directory.'/'.$value;?>" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
                                    <p><?php //echo $value;?></a><br>
                                    <?php //echo str_replace('.png','.tiff',$value);?>
                                    <a href="<?php echo $log_directory.'/'.$value;?>" class="btn btn-default btn-sm download-button" download><i class="fa fa-download"></i>PNG</a>
                                    <a href="<?php echo $log_directory.'/'.str_replace('png','tif',$value);?>" class="btn btn-default btn-sm download-button" download><i class="fa fa-download"></i>RASTER</a>
                                    </p>
                                    
                                
                            </div>
                            <?php } ?>
                                                            <!-- end pop-over -->

                                                            
                                                                <!-- end pop-over -->
                                                        </div>
                                                    </div>


                                </div>
                        </div>
						
						</div> <!-- table panel -->

                        </div>
                        </div>

                        <div class="tab-pane fade<?php if ($tab=='5') echo ' in active';?>" id="tab_content5">
                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                        <div class="x_title">
                            <h2>Dados estatísticos <small></small></h2>
                            <div class="clearfix"></div>
                            <table class="table table-striped">
   
                                        <tbody>
                                        <thead>
                                    <tr>
                                    <th>algoritmo</th>
                                    <th>partition</th>
                                    <th>kappa</th>
                                    <th>spec_sens</th>
                                    <th>no_omission</th>
                                    <th>prevalence</th>
                                    <th>equal_sens_spec</th>
                                    <th>sensitivity</th>
                                    <th>AUC</th>
                                    <th>TSS</th>
                                    </tr>
                                    </thead>
                                        <?php
                                        
                                        $sql = 'select * from modelr.experiment_result';
                                        $res = pg_exec($conn,$sql);
                                        while ($row = pg_fetch_array($res))
                                        {
                                            $kappa = $row['kappa'];
                                            $spec_sens = $row['spec_sens'];
                                            $no_omission = $row['no_omission'];
                                            $prevalence = $row['prevalence'];
                                            $equal_sens_spec = $row['equal_sens_spec'];
                                            $sensitivity = $row['sensitivity'];
                                            $auc = $row['auc'];
                                            $tss = $row['tss'];
                                            $algoritmo = $row['algorithm'];
                                            $partition = $row['partition'];
                                            echo '<tr>';
                                    echo '<td>'.$algoritmo.'</td>';
                                    echo '<td>'.$partition.'</td>';
                                    echo '<td>'.$kappa.'</td>';
                                    echo '<td>'.$spec_sens.'</td>';
                                    echo '<td>'.$no_omission.'</td>';
                                    echo '<td>'.$prevalence.'</td>';
                                    echo '<td>'.$equal_sens_spec.'</td>';
                                    echo '<td>'.$sensitivity.'</td>';
                                    echo '<td>'.$auc.'</td>';
                                    echo '<td>'.number_format($tss,3,',','').'</td>';
                                    echo '</tr>';
                                        }
                                    /*
                                        $names=file('./result/'.$hash.'/estatistica.txt');
                                    // To check the number of lines
                                    //echo count($names).'<br>';
                                    $linha = 0;
                                    foreach($names as $name)
                                    {
                                        list ($kappa, $spec_sens,$no_omission,$prevalence,$equal_sens_spec,$sensitivity,$AUC,$TSS,$algoritmo,$partition) = split (';', $name);
                                        if ($linha == 0)
                                        {
                                            echo ' <thead><tr>';
                                    //   echo '<th>'.$kappa.'</th>';
                                    echo '<th>'.$spec_sens.'</th>';
                                    echo '<th>'.$no_omission.'</th>';
                                    echo '<th>'.$prevalence.'</th>';
                                    echo '<th>'.$equal_sens_spec.'</th>';
                                    echo '<th>'.$sensitivity.'</th>';
                                    echo '<th>'.$AUC.'</th>';
                                    echo '<th>'.$TSS.'</th>';
                                    echo '<th>'.$algoritmo.'</th>';
                                    echo '<th>'.$partition.'</th>';
                                    echo '</tr> </thead>';
                                        }
                                        else
                                        {
                                        echo '<tr>';
                                    //   echo '<td>'.$kappa.'</td>';
                                    echo '<td>'.$spec_sens.'</td>';
                                    echo '<td>'.$no_omission.'</td>';
                                    echo '<td>'.$prevalence.'</td>';
                                    echo '<td>'.$equal_sens_spec.'</td>';
                                    echo '<td>'.$sensitivity.'</td>';
                                    echo '<td>'.$AUC.'</td>';
                                    echo '<td>'.number_format($TSS,3,',','').'</td>';
                                    echo '<td>'.$algoritmo.'</td>';
                                    echo '<td>'.$partition.'</td>';
                                    echo '</tr>';
                                        }
                                        $linha ++;
                                    }
                                    */
                                    ?>
                                    <?php
                                    /*	$meuArray = Array();
                                    $file = fopen('./result/e369853df766fa44e1ed0ff613f563bd/evaluateEugenia aurata O.Berg_5_bioclim.txt', 'r');
                                    while (($line = fgetcsv($file)) !== false)
                                    {
                                    $meuArray[] = $line;
                                    }
                                    fclose($file);
                                    print_r($meuArray);

                                    foreach($meuArray as $linha => $valor){
                                    echo 'linha '.$linha.' = '.$valor;
                                    }
                                        
                                    for($i = 0; $i < count($meuArray); $i++){
                                    echo '<td>'.$meuArray[$i].'</td>';
                                    }
                                    */
                                    ?>

                                        
                                        </tbody>
                                    </table>
                                </div>

                        <div class="col-md-6 col-sm-6 col-xs-6">							
								
<div class="x_content">

<div class="row">
                                <div class="x_title">
                                    <h2>Modelos Finais (Presfinal) <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
<?php								
								$log_directory = './result/'.$hash.'/presfinal';

$results_array = array();
$conta_arquivos = 0;
if (is_dir($log_directory))
{
        if ($handle = opendir($log_directory))
        {
                //Notice the parentheses I added:
                while(($file = readdir($handle)) !== FALSE)
                {
					$tamanho = strlen($file); 
					list ($arquivo, $ext) = split ('[.]', $file);
					
					$ext = substr($file,-3);
					
					if (($file != 'ensemble_geral_legend.png') &&
						($file != 'ensemble_geral.png')
					)
					{
					if ($ext=='png') 
					//{
						//echo $ext.'<br>';
                        $results_array[] = $file;
						$conta_arquivos++;
					//}
					}
                }
                closedir($handle);
        }
}

//Output findings
$c = 0;
foreach($results_array as $value)
{
	?>
  <div class="col-md-6 image-model">
      <a href="<?php echo $log_directory.'/'.$value;?>" target="result">
        <img src="<?php echo $log_directory.'/'.$value;?>" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
          <p><?php //echo $value;?></a><br>
          <?php //echo str_replace('.png','.tiff',$value);?>
          <a href="<?php echo $log_directory.'/'.$value;?>" class="btn btn-default btn-sm download-button" download><i class="fa fa-download"></i>PNG</a>
          <a href="<?php echo $log_directory.'/'.str_replace('png','tif',$value);?>" class="btn btn-default btn-sm download-button" download><i class="fa fa-download"></i>RASTER</a>
		  </p>
        
      
  </div>
 <?php } ?>
                                   <!-- end pop-over -->

                                
                                    <!-- end pop-over -->
                            </div>
                        </div>


                                </div>								
									
								</div>
							
							
							
							<div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="x_content map-content">
								 <div id="map"></div>
                                    <!-- end pop-over -->
                                </div>
							</div>
						
						</div> <!-- table panel -->

                        </div>								
									
								</div>

                        </div> <!-- end class="tab-content" -->

                        </div> <!-- end tags toggle -->

 						</div> <!-- table panel -->
						<!--
						active out
						active in 
						-->
						
						
						</div>
						
										
						
						
						
						
						
						</div> <!-- div class="" -->
						</form>
						</div>
										
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
	
	<script src="js/loading.js"></script>	
	
<!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>		
		
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

function buscar()
{
	if (document.getElementById('edtespecie').value=='')
	{
		criarNotificacao('Atenção','Informe o nome da espécie','warning')
	}
	else
	{
		var texto = document.getElementById('edtespecie').value;
		var palavra = texto.split(' ');
		if ((palavra.length)<2)
		{
			criarNotificacao('Atenção','Informe o nome da espécie','warning');
		}
		else
		{
			document.getElementById('frm').action="cadexperimento.php?busca=TRUE";
			document.getElementById('frm').submit();
		}
	}
}


function atualizar(tab)
{
	//$('.nav-tabs a[href="#tab_content5"]').tab('show')
	document.getElementById('frm').action="cadmodelagem.php?tab="+tab;
	document.getElementById('frm').submit();
}

function HomeControl(controlDiv, map) {
  controlDiv.style.padding = '5px';
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = '#FFCC00';
  controlUI.style.border='1px solid';
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Minha Localização';
  controlDiv.appendChild(controlUI);
  var controlText = document.createElement('div');
  controlText.style.fontFamily='Arial,sans-serif';
  controlText.style.fontSize='12px';
  controlText.style.paddingLeft = '4px';
  controlText.style.paddingRight = '4px';
  controlText.innerHTML = '<img src="imagens/eu.png" height="30px">'
  controlUI.appendChild(controlText);
  map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlUI);

  // Setup click-event listener: simply set the map to London
  google.maps.event.addDomListener(controlUI, 'click', function() {
   minhaLocaizacao()
  });
}


function initMap() {
	<?php if (empty($latcenter))
	{
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	}
	?>
	
 var overlay;
   USGSOverlay.prototype = new google.maps.OverlayView();

	
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -24.5452, lng: -42.5389},
	panControl:false,
      	zoomControl:true,
	  	zoomControlOptions: {
  		style:google.maps.ZoomControlStyle.DEFAULT
	 	},
   // center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
    zoom: 2
  });
  //var homeControlDiv = document.createElement('div');
  //var homeControl = new HomeControl(homeControlDiv, map);
  	//map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);

	var kmlLayer = new google.maps.KmlLayer({
    	url: 'http://model-r.jbrj.gov.br/teste.kml',
    	suppressInfoWindows: true,
    	map: map,
    	preserveViewport: true
  	});
	
	
var drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.POLYGON,
    drawingControl: true,

    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_CENTER,
      drawingModes: [
        google.maps.drawing.OverlayType.POLYGON
      ]
    },
    markerOptions: {
		icon: {
					path: google.maps.SymbolPath.CIRCLE,
					scale: 6,
					fillColor: '#A74EAF',
					fillOpacity: 0.8,
					strokeColor: '#fff',
					strokeWeight: 1
					}
		
//      icon: 'imagens/place-03.png'
    },
    circleOptions: {
      fillColor: '#ffff00',
      fillOpacity: 1,
      strokeWeight: 5,
      clickable: false,
      editable: true,
      zIndex: 1
    }
  });	
  
 /* 	google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
 });
  drawingManager.setMap(map);
*/
  drawingManager.setMap(map);
  
/*    var map2 = new google.maps.Map(document.getElementById('map2'), {
    center: {lat: -24.5452, lng: -42.5389},
    //center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
    zoom: 2
  });
*/
  
// [START region_rectangle]
  var bounds1 = {
    north: <?php echo $extensao1_norte;?>,
    south: <?php echo $extensao1_sul ;?>,
    east: <?php echo $extensao1_leste ;?>,
    west: <?php echo $extensao1_oeste ;?>
  };

/*  var bounds2 = {
    north: <?php echo $extensao2_norte;?>,
    south: <?php echo $extensao2_sul ;?>,
    east: <?php echo $extensao2_leste ;?>,
    west: <?php echo $extensao2_oeste ;?>
  };
  */
//new google.maps.LatLng(62.281819, -150.287132),
//new google.maps.LatLng(62.400471, -150.005608));
  
var bounds = new google.maps.LatLngBounds(
new google.maps.LatLng(-35.074, -73.844),
new google.maps.LatLng(6.485, -32.766));
//            new google.maps.LatLng(10, -75),
//            new google.maps.LatLng(-45, -20));
//            new google.maps.LatLng( -75,10),
//          new google.maps.LatLng(-30,-40));

        // The photograph is courtesy of the U.S. Geological Survey.
//        var srcImage = 'https://developers.google.com/maps/documentation/' +
 //           'javascript/examples/full/images/talkeetna.png';

		//var srcImage = '<?php echo $log_directory.'/'.'raster.jpg';?>';
			
        // The custom USGSOverlay object contains the USGS image,
        // the bounds of the image, and a reference to the map.
        //overlay = new USGSOverlay(bounds, srcImage, map);
  
  
  
  // Define a rectangle and set its editable property to true.
  var rectangle = new google.maps.Rectangle({
    bounds: bounds1,
    editable: true,
	draggable: true
  });


/*  var rectangle2 = new google.maps.Rectangle({
    bounds: bounds2,
    editable: true,
	draggable: true
  });
  */
  // [END region_rectangle]
 // rectangle.setMap(map);
 // rectangle2.setMap(map2);
 
 
function USGSOverlay(bounds, image, map) {

        // Initialize all properties.
        this.bounds_ = bounds;
        this.image_ = image;
        this.map_ = map;

        // Define a property to hold the image's div. We'll
        // actually create this div upon receipt of the onAdd()
        // method so we'll leave it null for now.
        this.div_ = null;

        // Explicitly call setMap on this overlay.
        this.setMap(map);
      }

      /**
       * onAdd is called when the map's panes are ready and the overlay has been
       * added to the map.
       */
      USGSOverlay.prototype.onAdd = function() {

        var div = document.createElement('div');
        div.style.borderStyle = 'none';
        div.style.borderWidth = '0px';
        div.style.position = 'absolute';

        // Create the img element and attach it to the div.
        var img = document.createElement('img');
        img.src = this.image_;
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.position = 'absolute';
        div.appendChild(img);

        this.div_ = div;

        // Add the element to the "overlayLayer" pane.
        var panes = this.getPanes();
        panes.overlayLayer.appendChild(div);
      };

      USGSOverlay.prototype.draw = function() {

        // We use the south-west and north-east
        // coordinates of the overlay to peg it to the correct position and size.
        // To do this, we need to retrieve the projection from the overlay.
        var overlayProjection = this.getProjection();

        // Retrieve the south-west and north-east coordinates of this overlay
        // in LatLngs and convert them to pixel coordinates.
        // We'll use these coordinates to resize the div.
        var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
        var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

        // Resize the image's div to fit the indicated dimensions.
        var div = this.div_;
        div.style.left = sw.x + 'px';
        div.style.top = ne.y + 'px';
        div.style.width = (ne.x - sw.x) + 'px';
        div.style.height = (sw.y - ne.y) + 'px';
      };

      // The onRemove() method will be called automatically from the API if
      // we ever set the overlay's map property to 'null'.
      USGSOverlay.prototype.onRemove = function() {
        this.div_.parentNode.removeChild(this.div_);
        this.div_ = null;
      };
 
 
  
  rectangle.addListener('bounds_changed', showNewRect);
  
   function showNewRect(event) {
        var ne = rectangle.getBounds().getNorthEast();
        var sw = rectangle.getBounds().getSouthWest();

        document.getElementById('edtextensao1_oeste').value=ne.lat();
        document.getElementById('edtextensao1_sul').value=sw.lat();
        document.getElementById('edtextensao1_leste').value=sw.lng();
        document.getElementById('edtextensao1_norte').value=ne.lng();
		
      }
 
/*  rectangle2.addListener('bounds_changed', showNewRect2);
  
   function showNewRect2(event) {
        var ne = rectangle2.getBounds().getNorthEast();
        var sw = rectangle2.getBounds().getSouthWest();

        document.getElementById('edtextensao2_oeste').value=ne.lat();
        document.getElementById('edtextensao2_sul').value=sw.lat();
        document.getElementById('edtextensao2_leste').value=sw.lng();
        document.getElementById('edtextensao2_norte').value=ne.lng();
		
      }
 */
<?php 
	$sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,
case when lat2 is not null then lat2 else lat end as lat, case when long2 is not null then long2
else long end as long
 from modelr.occurrence, modelr.statusoccurrence where 
							occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
							idexperiment = ".$id. ' 
 and occurrence.idstatusoccurrence in (4,17) ';

//echo $sql; 
$res = pg_exec($conn,$sql);
$conta = pg_num_rows($res);
$marker = '';
	
	$c=0;
							while ($row = pg_fetch_array($res))
							{
								
								// preparo os quadros de informação para cada ponto
								$c++;
								if ($c < $conta) {
									$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."'],";
								}
								else
								{
									$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."']";
									$latcenter = $row['lat'];
									$longcenter = $row['long'];
								}
							}   
?>							
  	var markers = [
        <?php echo $marker;;?>
    ];

    // Info Window Content
	
//	var infoWindowContent = [
//		<?php echo $info;?>
 //   ];

//        ['<div class="info_content">' +
 //       '<h3>Caesalpinia Echinata</h3>' +
  //      '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +        '</div>'],
   //     ['<div class="info_content">' +
    //    '<h3>Caesalpinia echinata</h3>' +
     //   '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +
      //  '</div>']
	
    // Display multiple markers on a map
//    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
       // bounds.extend(position);
//		var icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
//		if (markers[i][7]!='')
//		{
//			icone = 'http://maps.google.com/mapfiles/ms/icons/'+markers[i][7];
//		}
		
    /*    marker = new google.maps.Marker({
            position: position,
            map: map2,
			draggable: false,
            title: markers[i][0]
        });
      */  
		marker2 = new google.maps.Marker({
            position: position,
            map: map,
			draggable: false,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
 //       google.maps.event.addListener(marker, 'click', (function(marker, i) {
 //           return function() {
//				abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],'','',markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9]);
				
//            }
//        })(marker, i));
		
 //       google.maps.event.addListener(marker, 'dragend', (function(marker, i) {
  //          return function() {
//				abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],this.position.lat(),this.position.lng(),markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9]);
				
 //           }
 //       })(marker, i));
        // Automatically center the map fitting all markers on the screen
       // map2.fitBounds(bounds);
    }
	
	

	
	
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

function abreModal(taxon,lat,lng,idocorrencia,latinf,lnginf,servidor,path,arquivo,idstatusocorrence,localizacao)
{
	/*alert('Taxon '+taxon);
	alert('lat '+lat);
	alert('lng '+lng);
	alert('idocorrencia '+idocorrencia);
	alert('latinf '+latinf);
	alert('servidor '+servidor);
	alert('path '+path);
	alert('arquivo '+arquivo);
	alert('idstatusocorrence '+idstatusocorrence);
	*/
	document.getElementById('divtaxon').innerHTML=taxon;
	
	html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho=&arquivo='+arquivo+' target=\"Visualizador\"><img src="http://'+servidor+'/fsi/server?type=image&source='+path+'/'+arquivo+'&width=300&height=100&profile=jpeg&quality=20"></a>';

	document.getElementById('edidocorrencia').value=idocorrencia;
	document.getElementById('divimagem').innerHTML=html_imagem;
	document.getElementById('dadosoriginais').innerHTML='Latitude: '+lat+' Longitude: '+lng+'<br>'+localizacao;
	document.getElementById('edtlatitude').value=latinf;
	document.getElementById('edtlongitude').value=lnginf;
	//alert(idstatusocorrence);
	document.getElementById('cmboxstatusoccurrence').value=idstatusocorrence;

	$('#myModal').modal('show');
}

    </script>
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhi_DlmaFvRu7eP357bOzl29fyZXKIJE0&libraries=drawing&callback=initMap" async defer>
    </script>	
	
    <script>
	
	

<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];

//$tab = $_REQUEST['tab'];
?>

$(document ).ready(function() {
	//alert('');
 	//$('.nav-tabs a[href="#tab_content<?php echo $tab;?>"]').tab('show')
	initMap();
	
});
		
$('.nav-tabs a[href="#tab_content3"]').click(function(){
	//alert('3');
    $(this).tab('show');
});	

$('.nav-tabs').on('shown.bs.tab', function () {
    console.log('aaa');
    google.maps.event.trigger(window, 'resize', {});
    initMap();
});

function toggle(isChecked) {
	var chks = document.getElementsByName('chtestemunho[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=isChecked
	}
}

function filtrar(idstatusoccurrence)
{
	exibe('loading');
	document.getElementById('frm').action='cadmodelagem.php?tab=3&filtro='+idstatusoccurrence;
	document.getElementById('frm').submit();
}
		
function enviar()
		{
			exibe('loading');
			document.getElementById('frm').action='exec.modelagem.php';
			document.getElementById('frm').submit();
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