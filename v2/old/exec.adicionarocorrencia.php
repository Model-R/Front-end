<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

$idexperimento = $_REQUEST['id'];
$especie = $_REQUEST['edtespecie'];
$fontedados = $_REQUEST['fontebiotico'][0];
$idfontedados = 1;
if ($fontedados=='JABOT')
{
	$idfontedados = 2;
}


if ((!empty($especie)) && ($fontedados))
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
	
//	echo $sql;
//	exit;


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
	
		$Experimento->adicionarOcorrencia($idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio);
	}
}
 header("Location: cadexperimento.php?op=A&pag=2&MSGCODIGO=71&id=$idexperimento");
?>



