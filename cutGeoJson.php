<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;
$expid = $_REQUEST['expid'];

$Experimento->getById($expid);
$Experimento->getPath($expid);

$isImageCut = $Experimento->isImageCut;
$isImageCut = $isImageCut === 't'? true: false;

if($isImageCut){
	$pngCutPath = $Experimento->pngCutPath;
    $rasterCutPath = "'" . $Experimento->rasterCutPath . "'";
} else {
	$pngCutPath = $Experimento->rasterPngPath;
	$rasterCutPath = "'" . $Experimento->tiffPath . "'";
}

$Experimento->alterarPathPngRaster($expid, "'./temp/" . $expid ."/png_map-" . $expid . ".png'", "'./temp/" . $expid ."/raster_crop-" . $expid . ".tif'");

$filePath = '../../../../../../mnt/dados/modelr/json/polygon-' . $expid . '.json';
$file = fopen($filePath, 'w');

$polygons = explode(':',$_REQUEST['array']);
$coordinates = [];
// loop over the rows, outputting them
foreach($polygons as $p){
    $vertices = explode(';',$p);
    $result = [];
    foreach($vertices as $v){
        $result[] = [explode(',',$v)[1], explode(',',$v)[0]];
    }
    $coordinates[] = [$result];

}

$myObj->type = "MultiPolygon";
$myObj->coordinates = $coordinates;
$myJSON = json_encode($myObj, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
fwrite($file, $myJSON);
fclose($file);
if (!file_exists("temp/" . $expid )) {
    mkdir("temp/" . $expid , 0777, true);
}

exec("Rscript script_pos.R $expid $filePath $rasterCutPath");

return 'success';

?>