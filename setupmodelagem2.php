<?php 
echo "teste";
exit;

session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

#require_once('classes/experimento.class.php');
#require_once('classes/conexao.class.php');
#$clConexao = new Conexao;
#$conn = $clConexao->Conectar();

$id = $_REQUEST['expid'];
//$id = 113;
$ws = file_get_contents("https://model-r.jbrj.gov.br/ws/?id=" . $id);
$json = json_decode($ws);
# preciso enviar ocorrencias.csv, raster.csv, partitions, buffer, num_points, tss, hash id
#hash id
$hashId = $json->experiment[0]->idexperiment;

#Change experiment status
$sql =" update modelr.experiment set idstatusexperiment = '3' where
		md5(cast(idexperiment as text)) = '".$hashId."'";
		
		$res = pg_exec($conn,$sql);

rrmdir("temp/result/" . $hashId);
removeRowExperimentResult($conn, $id);

echo 'hashId: ' . $hashId;
echo '<br>';
#partitions
$partitions = $json->experiment[0]->num_partition;
echo 'partitions: ' . $partitions;
echo '<br>';
#buffer
$buffer = $json->experiment[0]->buffer;
echo 'buffer: ' . $buffer;
echo '<br>';
#num_points
$num_points = $json->experiment[0]->num_points;
echo 'num_points: ' . $num_points;
echo '<br>';
#tss
$tss = $json->experiment[0]->tss;
echo 'tss: ' . $tss;
echo '<br>';
#raster.csv
$rasterList = $json->experiment[0]->raster;
$rasterPathList = [];
foreach($rasterList as $raster){
	
    $path = 'mnt/dados/modelr/env';
	if($raster->source == 'WordClim v1'){
		$path = $path . '/Worldclim1/10min/' . strtolower($raster->raster) . '.bil';
		array_push($rasterPathList,"'" . $path . "'");
	}
	} else if($raster->source == 'WordClim v2'){
		$path = $path . '/Worldclim2/10min/' . strtolower($raster->raster) . '.tif';
	} else {
		$path = $path . '/Biooracle/Surface/' . strtolower($raster->raster) . '.tif';
	}
}
print_r($rasterPathList);
if (!file_exists("temp/" . $id )) {
    mkdir("temp/" . $id , 0777, true);
}
if (!file_exists("temp/result/" . $hashId )) {
    mkdir("temp/result/" . $hashId  , 0777, true);
}

$rasterCSVPath = 'temp/'. $id . '/raster.csv';
$file = fopen($rasterCSVPath, 'w');
fputcsv($file, $rasterPathList, ";");
fclose($file);

#ocorrencias.csv
$ocorrenciasCSVPath = 'temp/'. $id . '/ocorrencias.csv';
$file = fopen($ocorrenciasCSVPath, 'w');
fputcsv($file, array("taxon","lon","lat"), ";");

$occurrenceList = $json->experiment[0]->occurrences;
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
exec("Rscript script_number_valid_points.r " . $id . ' ' . $rasterCSVPath . ' '. $ocorrenciasCSVPath, $a, $b);
$returnData = explode(" ",$a[1]);
echo "Rscript script_exemplo_modelr.r " . $id . ' ' . $hashId . ' '. $partitions . ' '. $buffer . ' '. $num_points . ' '. $tss . ' '. $rasterCSVPath . ' '. $ocorrenciasCSVPath;

if($returnData[1] < 10){
	header("Location: cadexperimento.php?op=A&tab=3&MSGCODIGO=76&id=" . $id);
} else {
	//echo "Rscript script_exemplo_modelr.r " . $id . ' ' . $hashId . ' '. $partitions . ' '. $buffer . ' '. $num_points . ' '. $tss . ' '. $rasterCSVPath . ' '. $ocorrenciasCSVPath;
	exec("Rscript script_exemplo_modelr.r $id $hashId $partitions '$buffer' $num_points $tss '$rasterCSVPath' '$ocorrenciasCSVPath'");
	if (!file_exists("temp/result/" . $hashId . "/" . $speciesName . ".csv")) {
		header("Location: cadexperimento.php?op=A&tab=3&MSGCODIGO=77&id=" . $id);
	} else {
		$csvFile = file("temp/result/" . $hashId . "/" . $speciesName . ".csv");
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
		header("Location: cadexperimento.php?op=A&tab=3&id=" . $id);
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
		$raster_png_path = $baseUrl.$speciesName . '_Final.mean4_ensemble_without_margins.png';
		$png_path = $baseUrl.$speciesName . '_Final.mean4_ensemble.png';
		$tiff_path = $baseUrl.$speciesName . '_Final.mean4_ensemble.tif';
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
?>