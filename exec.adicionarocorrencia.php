<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

$idexperimento = $_REQUEST['id'];
$especie = $_REQUEST['edtespecie'];
$fontedados = $_REQUEST['fontebiotico'][0];

$Experimento->getById($idexperimento);
$automaticfilter = $Experimento->automaticfilter;
$box = $_POST['chtestemunho'];
$jabotData = [];
$gbifData = [];
while (list ($key,$val) = @each($box)) { 
	if(is_numeric ($val)){
		array_push($jabotData,$val);
	} else {
		array_push($gbifData,$val);
	}
}

$bool_automaticfilter = $automaticfilter === 't'? true: false;

//if ($fontedados==1)
//{
	$sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude,pais,estado_prov as estado,cidade as municipio, siglacolecao as herbario
			from  
								publicacao.extracao_jabot_geral where latitude is not null and longitude is not null and
        familia || ' ' || taxoncompleto ilike '%".$especie."%' and ";

	$box=$jabotData;
	$in = 'extracao_jabot_geral.codtestemunho in (';
	while (list ($key,$val) = @each($box)) { 
		//$result = $Cobertura->excluir($val);
		$in .= $val.','; 
	} 
	$in.='0)';
	
	$sql.= $in;

	$res = pg_exec($conn,$sql);

	while ($row = pg_fetch_array($res))
	{
		$codigobarras= str_pad($row['codtestemunho'], 8, "0", STR_PAD_LEFT);	
		$lat = $row['latitude'];
		$long = $row['longitude'];
		$taxon = $row['taxoncompleto'];
		$herbario = $row['herbario'];
		$coletor = $row['coletor'];
		$numcoleta = $row['numcoleta'];
		$pais = $row['pais'];
		$estado = $row['estado'];
		$municipio = $row['municipio'];
		$tombo = $row['numtombo'];
		$codtestemunho = $row['codtestemunho'];
//		echo $pais.','.$estado.','.$municipio;
//		exit;
		
		$sqlimagem = "select * from jabot.imagem where codigobarras = '".$codigobarras."' limit 1";
		$resimagem = pg_exec($conn,$sqlimagem);
		$rowimagem = pg_fetch_array($resimagem);
		$imagemservidor = $rowimagem ['servidor'];
		$imagemcaminho =  $rowimagem ['path'];
		$imagemarquivo =  $rowimagem ['arquivo'];
	
		$Experimento->adicionarOcorrencia($idexperimento,$fontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio, $herbario,$tombo,$codtestemunho,'Jabot');
	}
//}
//if ($fontedados==2)
//{ // gbif
	$box=$gbifData;
	// print_r($box);
	// exit;
	$in = 'extracao_jabot_geral.codtestemunho in (';
	while (list ($key,$val) = @each($box)) { 
		//$result = $Cobertura->excluir($val);
		$val = explode("*", $val);
		//echo $val.'<br>';
		//print_r($val);
		//echo '<br>';
		$idexperimento = $val[0];
		$latitude = $val[2];
		$longitude = $val[3];
		$taxon = $val[4];
		$coletor = str_replace("'","",$val[5]);
		if($val[6] != 'undefined'){
			$numcoleta = $val[6];
		} else {
			$numcoleta = null;
		}
		$imagemservidor=$val[7];
		$imagemcaminho=$val[8];
		$imagemarquivo=$val[9];
		$pais=$val[10];
		$estado = $val[11];
		$municipio=str_replace("'","",$val[12]); 
		$herbario=$val[13];
		//var_dump($val[14]);
		//echo '<br>';
		if(isset($val[14])){
			if ($val[14] == 'undefined' || $val[14] == ''){
				$tombo = 'null';
			} else {
				$tombo = $val[14];
			} 
		} else {
			$tombo = 'null';
		}
		if(empty($herbario)){
			$fonte = 'CSV';
		} else {
			$fonte = 'GBIF';
		}
		$Experimento->adicionarOcorrencia($idexperimento,$fontedados,$latitude,$longitude,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio,$herbario,$tombo,0,$fonte);
	} 
	
//}

if($bool_automaticfilter === true){
	header("Location: exec.atualizarpontos.php?idstatus=99&idponto=&latinf=&longinf=&id=$idexperimento");
} else {
	header("Location: cadexperimento.php?op=A&tab=10&MSGCODIGO=71&id=$idexperimento");
}
?>



