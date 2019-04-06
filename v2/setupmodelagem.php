<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$id = $_REQUEST['expid'];
//$id = 113;
$ws = file_get_contents("https://model-r.jbrj.gov.br/ws/?id=" . $id);
$json = json_decode($ws); 
//print_r($json);
//exit;

if(dirname(__FILE__) == '/var/www/html/rafael/modelr/v2' || dirname(__FILE__) == '/var/www/html/rafael/modelr/v3'){
	$baseUrl = '../';
} else {
	$baseUrl = '';
}
if($_SESSION['s_idtipousuario']==6 && sizeof($json[0]->raster) == 0){
	header("Location: cadexperimento.php?op=A&tab=6&MSGCODIGO=78&id=" . $id);
	exit;
}

# preciso enviar ocorrencias.csv, raster.csv, partitions, buffer, num_points, tss, hash id
#hash id

$hashId = $json[0]->idexperiment;

#Change experiment status
$sql =" update modelr.experiment set idstatusexperiment = '3' where
		md5(cast(idexperiment as text)) = '".$hashId."'";
		
		$res = pg_exec($conn,$sql);

rrmdir($baseUrl . "temp/result/" . $hashId);
removeRowExperimentResult($conn, $id);
//echo 'hashId: ' . $hashId;
//echo '<br>';
#partitions
$partitions = $json[0]->num_partition;
//echo 'partitions: ' . $partitions;
//echo '<br>';
#buffer
$buffer = $json[0]->buffer;
//echo 'buffer: ' . $buffer;
//echo '<br>';
#num_points
$num_points = $json[0]->num_points;
//echo 'num_points: ' . $num_points;
//echo '<br>';
#tss
$tss = $json[0]->tss;
//echo 'tss: ' . $tss;
//echo '<br>';
#partition type
$partitiontype = strtolower($json[0]->partitiontype);
//echo 'partitiontype: ' . $partitiontype;
//echo '<br>';
$resolution= $json[0]->resolution;
//echo 'resolution: ' . $resolution;
//echo '<br>';
$repetitions= $json[0]->num_repetitions;
//echo 'repetitions: ' . $repetitions;
//echo '<br>';
$trainpercent= $json[0]->trainpercent;
//echo 'trainpercent: ' . $trainpercent;
//echo '<br>';
#raster.csv
$rasterList = $json[0]->raster;
$rasterPathList = [];

#checar se usuário é Reflora - Raster -> PCA
if($_SESSION['s_idtipousuario']==5){
	$path = 'mnt/dados/modelr/env';
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_05.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_06.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_12.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_13.tif' . "'");
} else {
	foreach($rasterList as $raster){
		$path = 'mnt/dados/modelr/env';
		if($raster->source == 'Worldclim v1' || $raster->source == 'WordClim v1'){
			$path = $path . '/Worldclim1/'.$resolution.'min/' . strtolower(explode(" ",$raster->raster)[0]) . '.bil';
			array_push($rasterPathList,"'" . $path . "'");
		} else if($raster->source == 'Worldclim v2' || $raster->source == 'WordClim v2'){
			$bio = str_replace("bio","",strtolower(explode(" ",$raster->raster)[0]));
			if($bio < 10) {
				$path = $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_0' . $bio . '.tif';
				array_push($rasterPathList,"'" . $path . "'");
			} else {
				$path = $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_' . $bio . '.tif';
				array_push($rasterPathList,"'" . $path . "'");
			}
		} else {
			$params = explode(",",$raster->params);
			foreach($params as $param){
				$path = 'mnt/dados/modelr/env';
	//			echo $raster->raster;
		//		echo '<br>';
				if($raster->raster == 'pH'){
					$path = $path . '/Biooracle/Surface/Present.Surface.' . $raster->raster .'.tif';
				} else {
					$path = $path . '/Biooracle/Surface/Present.Surface.' . $raster->raster . ' '. $param .'.tif';
				}
				array_push($rasterPathList,"'" . str_replace(' ', '.', $path) . "'");
			}
		}
	}
}

if (!file_exists($baseUrl . "temp/" . $id )) {
    mkdir($baseUrl . "temp/" . $id , 0777, true);
}
if (!file_exists($baseUrl . "temp/result/" . $hashId )) {
    mkdir($baseUrl . "temp/result/" . $hashId  , 0777, true);
}

$rasterCSVPath = $baseUrl . 'temp/'. $id . '/raster.csv';
$file = fopen($rasterCSVPath, 'w');
fputcsv($file, $rasterPathList, ";");
fclose($file);
 
#ocorrencias.csv
$ocorrenciasCSVPath = $baseUrl . 'temp/'. $id . '/ocorrencias.csv';
$file = fopen($ocorrenciasCSVPath, 'w');
fputcsv($file, array("taxon","lon","lat"), ";");

$occurrenceList = $json[0]->occurrences;
$count = 0;
$speciesName;
foreach($occurrenceList as $occurrence){
    $item = [];
	if($occurrence->idstatusoccurrence == 4 || $occurrence->idstatusoccurrence == 17){
		array_push($item,$occurrence->taxon,$occurrence->lon,$occurrence->lat);
		fputcsv($file, $item, ";");
		$count = $count + 1;
		$speciesName = $occurrence->taxon;
	}
}
fclose($file);

#algorithms.csv
$algorithmJSONList = $json[0]->algorithm;
$algorithmList = [];
foreach($algorithmJSONList as $algorithm){
	//print_r($algorithm->algorithm);
	array_push($algorithmList,$algorithm->algorithm);
}

#Mahalanobis;Maxent;GLM;Bioclim;Random Forest;Domain;SVM 
$arrayAlg = array('F','F','F','F','F','F','F');
if(in_array("Mahalanobis", $algorithmList)){
	$arrayAlg[0] = 'TRUE';
}
if(in_array("Maxent", $algorithmList)){
	$arrayAlg[1] = 'TRUE';
}
if(in_array("GLM", $algorithmList)){
	$arrayAlg[2] = 'TRUE';
}
if(in_array("Bioclim", $algorithmList)){
	$arrayAlg[3] = 'TRUE';
}
if(in_array("Random Forest", $algorithmList)){
	$arrayAlg[4] = 'TRUE';
}
if(in_array("Domain", $algorithmList)){
	$arrayAlg[5] = 'TRUE';
}
if(in_array("SVM", $algorithmList)){
	$arrayAlg[6] = 'TRUE';
}


#extent model

$ExtentModelPath = $baseUrl . "temp/" . $id . "/extent_model.json";
$file = fopen($ExtentModelPath, 'w');

$extent_model = $json[0]->extent_model;

if($extent_model == ""){
	$ExtentModelPath = $baseUrl . 'temp/dados/polygon-brazil.json';
	echo $ExtentModelPath;
} else {
	$extent_model = explode(";",$extent_model);
	$west = $extent_model[0];
	$east = $extent_model[1];
	$north = $extent_model[2];
	$south = $extent_model[3];

	$result = [];
	$result[] = [$east,$south];
	$result[] = [$east,$north];
	$result[] = [$west,$south];
	$result[] = [$west,$north];
	$coordinates[] = [$result];
	
	$myObj->type = "MultiPolygon";
	$myObj->coordinates = $coordinates;
	$myJSON = json_encode($myObj, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);

	fwrite($file, $myJSON);
	fclose($file);
	print_r($myJSON);
}

#start time
$time = $_SESSION['s_nome'] . " - experimento " . $id . " - Inicio: " . date("h:i:sa");

$algString = implode(";",$arrayAlg);
exec("Rscript script_number_valid_points.r " . $id . ' ' . $rasterCSVPath . ' '. $ocorrenciasCSVPath, $a, $b);
$returnData = explode(" ",$a[1]);
//echo "Rscript script_exemplo_modelr.r $id $hashId $repetitions $partitions $partitiontype $trainpercent '$buffer' $num_points $tss '$rasterCSVPath' '$ocorrenciasCSVPath' '$algString' '$ExtentModelPath'";
//exit;
if($returnData[1] < 10){
	header("Location: cadexperimento.php?op=A&tab=6&MSGCODIGO=76&id=" . $id);
} else {
	//echo "Rscript script_exemplo_modelr.r " . $id . ' ' . $hashId . ' '. $partitions . ' '. $buffer . ' '. $num_points . ' '. $tss . ' '. $rasterCSVPath . ' '. $ocorrenciasCSVPath;
	exec("Rscript script_exemplo_modelr.r $id $hashId $repetitions $partitions $partitiontype $trainpercent '$buffer' $num_points $tss '$rasterCSVPath' '$ocorrenciasCSVPath' '$algString' '$ExtentModelPath'");
	if (!file_exists($baseUrl . "temp/result/" . $hashId . "/" . $speciesName . ".csv")) {
		header("Location: cadexperimento.php?op=A&tab=6&MSGCODIGO=77&id=" . $id);
	} else {
		$csvFile = file($baseUrl . "temp/result/" . $hashId . "/" . $speciesName . ".csv");
		$data = [];
		foreach ($csvFile as $line) {
			$csvline = str_getcsv($line);
			$data = explode(";", $csvline[0]);
			if($data[0] != "kappa"){	
				//print_r($data);
				//echo "<br>";
				addToExperimentResult($conn, $id, $data, $speciesName,$hashId);
			}
		}
		addMapImageToExperimentResult($conn, $id, $speciesName,$hashId);
		$sql =" update modelr.experiment set idstatusexperiment = '4' where
		md5(cast(idexperiment as text)) = '".$hashId."'";
		
		$res = pg_exec($conn,$sql);
		calculateTime($time);
		header("Location: cadexperimento.php?op=A&tab=14&id=" . $id);
	}
}   


function rrmdir($dir) { 
	if (is_dir($dir)) { 
	  $objects = scandir($dir); 
	  foreach ($objects as $object) { 
		if ($object != "." && $object != "..") { 
		  if (is_dir($dir."/".$object))
			rrmdir($dir."/".$object);
		  else
			unlink($dir."/".$object); 
		} 
	  }
	  rmdir($dir); 
	} 
} 

function removeRowExperimentResult ($conn, $expid){
	$sql = "delete from modelr.experiment_result where idexperiment=" . $expid;
	//		echo $sql;

	$res = pg_exec($conn,$sql);
}

function addToExperimentResult ($conn, $expid, $expdata, $speciesName,$hashId) {
	$baseUrl = '/var/www/html/rafael/modelr/temp/result/'.$hashId.'/'.$speciesName.'/present/partitions/';
	for ($i = 1; $i <= 3; $i++) {
		$partition = $expdata[9];
		$algorithm = str_replace('"',"",$expdata[8]);

		if($i == 1){
			$raster_png_path = '';
			$png_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '001.png';
			$tiff_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '.tif';
		}
		else if($i == 2){
			$raster_png_path = '';
			$png_path = $baseUrl.$algorithm  . $speciesName . '_' . $partition . '002.png';
			$tiff_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '.tif';
		}
		else if($i == 3){
			$raster_png_path = '';
			$png_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '003.png';
			$tiff_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '.tif';
		}
		$unhashedid = $expid;
		$idresulttype = (100 + $i);
		$tss = $expdata[7];
		$auc = $expdata[6];
		$sensitivity = $expdata[5];
		$equal_sens_spec = $expdata[4];
		$prevalence = $expdata[3];
		$no_omission = $expdata[2];
		$spec_sens = $expdata[1];
		$kappa = $expdata[0];
		$sql = "insert into modelr.experiment_result (
				idexperiment ,  idresulttype ,  
			partition ,  algorithm ,  tss,  auc ,  sensitivity ,  equal_sens_spec ,
	  prevalence ,  no_omission ,  spec_sens, raster_bin_path, raster_cont_path, raster_cut_path,
	  png_bin_path, png_cont_path, png_cut_path , kappa, raster_path, raster_png_path, png_path, tiff_path
	  ) values
	  (".$unhashedid.",".$idresulttype.",".$partition.",
	  '".$algorithm."',".$tss.",".$auc.",".$sensitivity.",".$equal_sens_spec.",".$prevalence.",
	  ".$no_omission.",".$spec_sens.",
	  '','','','','','',".$kappa.",'','".$raster_png_path."','".$png_path."','".$tiff_path."'
	  );";
	//		echo $sql;
	
		$res = pg_exec($conn,$sql);
	}
}	

function addMapImageToExperimentResult ($conn, $expid, $speciesName,$hashId) {
	$baseUrl = '/var/www/html/rafael/modelr/temp/result/'.$hashId.'/'.$speciesName.'/present/ensemble/';
		$partition = '';
		$algorithm = '';
		$raster_png_path = $baseUrl.$speciesName . '_cut_mean_th_ensemble_mean_without_margins.png';
		$png_path = $baseUrl.$speciesName . '_cut_mean_th_ensemble_mean.png';
		$tiff_path = $baseUrl.$speciesName . '_cut_mean_th_ensemble_mean.tif';
		$unhashedid = $expid;
		$idresulttype = 303;
		$tss = '';
		$auc = '';
		$sensitivity = '';
		$equal_sens_spec = '';
		$prevalence = '';
		$no_omission = '';
		$spec_sens = '';
		$kappa = '';
		$sql = "insert into modelr.experiment_result (
				idexperiment ,  idresulttype ,  
			partition ,  algorithm ,  tss,  auc ,  sensitivity ,  equal_sens_spec ,
	  prevalence ,  no_omission ,  spec_sens, raster_bin_path, raster_cont_path, raster_cut_path,
	  png_bin_path, png_cont_path, png_cut_path , kappa, raster_path, raster_png_path, png_path, tiff_path
	  ) values
	  (".$unhashedid.",".$idresulttype.",null,
	  '".$algorithm."',null,null,null,null,null,
	  null,null,
	  '','','','','','',null,'','".$raster_png_path."','".$png_path."','".$tiff_path."'
	  );";
	
		$res = pg_exec($conn,$sql);
}

function calculateTime ($time) {
	print_r($_SESSION);
	if (!file_exists($baseUrl . "temp/dados" )) {
		mkdir($baseUrl . "temp/dados", 0777, true);
	}
	$dadosPath = $baseUrl . 'temp/dados/listamodelagem.txt';
	$myfile = fopen($dadosPath, "w");
	$txt = $time . " - Final: ". date("h:i:sa") . "\n";
	fwrite($myfile, $txt);
	fclose($myfile);
}	
?>