<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

//print_r($_REQUEST);
//exit;

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

$idexperimento = $_REQUEST['id'];
$especie = $_REQUEST['edtespecie'];
$fontedados = $_REQUEST['fontebiotico'][0];

//echo $fontedados;
//exit;

//$idfontedados = 1;

// print_r($_REQUEST);
// exit;

if ($fontedados==1)
{
	$sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude,pais,estado_prov as estado,cidade as municipio
			from  
								publicacao.extracao_jabot where latitude is not null and longitude is not null and ";
//								familia || ' ' || taxoncompleto ilike '%".$especie."%' ";

	$box=$_POST['chtestemunho'];
	$in = 'extracao_jabot.codtestemunho in (';
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
		$coletor = $row['coletor'];
		$numcoleta = $row['numcoleta'];
		$pais = $row['pais'];
		$estado = $row['estado'];
		$municipio = $row['municipio'];
		
//		echo $pais.','.$estado.','.$municipio;
//		exit;
		
		$sqlimagem = "select * from jabot.imagem where codigobarras = '".$codigobarras."' limit 1";
		$resimagem = pg_exec($conn,$sqlimagem);
		$rowimagem = pg_fetch_array($resimagem);
		$imagemservidor = $rowimagem ['servidor'];
		$imagemcaminho =  $rowimagem ['path'];
		$imagemarquivo =  $rowimagem ['arquivo'];
	
		$Experimento->adicionarOcorrencia($idexperimento,$fontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio);
	}
}
if ($fontedados==2)
{ // gbif
	$box=$_POST['chtestemunho'];
	// print_r($box);
	// exit;
	$in = 'extracao_jabot.codtestemunho in (';
	while (list ($key,$val) = @each($box)) { 
		//$result = $Cobertura->excluir($val);
		$val = explode("|", $val);
		
		//echo $val.'<br>';
		$idexperimento = $val[0];
		$latitude = $val[2];
		$longitude = $val[3];
		$taxon = $val[4];
		$coletor = $val[5];
		$numcoleta = $val[6];
		$imagemservidor=$val[7];
		$imagemcaminho=$val[8];
		$imagemarquivo=$val[9];
		$pais=$val[10];
		$estado = $val[11];
		$municipio=$val[12]; 
		$Experimento->adicionarOcorrencia($idexperimento,$fontedados,$latitude,$longitude,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio);
	} 
	
}

 header("Location: cadexperimento.php?op=A&pag=2&MSGCODIGO=71&id=$idexperimento");
?>



