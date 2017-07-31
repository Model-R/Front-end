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
$idexperimento = $_REQUEST['id'];

$idponto = $_REQUEST['idponto'];
$idstatus = $_REQUEST['idstatus'];
$latinf = $_REQUEST['latinf'];
$longinf = $_REQUEST['longinf'];

$MSGCODIGO = 19;
if (($idponto != 'undefined') && (!empty($idponto)))
{
	
	$Experimento->excluirPonto($idexperimento,$idponto,$idstatus,$latinf,$longinf);
		
}
else
{
	$lista = $_REQUEST['table_records'];
	foreach($lista as $idponto){
		
				
			$sql = "update modelr.occurrence set idstatusoccurrence=$idstatus ";
			
			$sql.="	where
			idoccurrence = $idponto";
			$res = pg_exec($conn,$sql);

	}
	// FORA DO LIMITE DO BRASIL
	
	if (($idstatus == '17') || ($idstatus=='4'))
	{
		$sql = "update modelr.experiment set idstatusexperiment = 2 where idexperiment = ".$idexperimento;
		$res = pg_exec($conn,$sql);
	}
	
	
	if ($idstatus=='10')
	{
		$sql = "update modelr.occurrence set idstatusoccurrence=10 where
			idexperiment = ".$idexperimento." and
			idoccurrence in (
			select idoccurrence from modelr.occurrence o,
 base_geografica.\"shp_limite_brasil_250MIL\" shape
where
not contains(GeomFromEWKT(shape.geom),GeomFromEWKT('SRID=4326;POINT(' || o.long || ' ' || o.lat || ')')) 
			)";
		$MSGCODIGO = 74;
		$res = pg_exec($conn,$sql);
	}
	if ($idstatus=='2')
	{
		$sql = "update modelr.occurrence set idstatusoccurrence=2 where
			idexperiment = ".$idexperimento." and
			idoccurrence in (
select idoccurrence from modelr.occurrence o,
 base_geografica.\"municipios_2014\" shape
where
contains(GeomFromEWKT(shape.geom),GeomFromEWKT('SRID=4326;POINT(' || o.long || ' ' || o.lat || ')' )) 
and (shape.pais <> country
or shape.nm_uf <> majorarea
or shape.nm_mun <> minorarea)
)";

		$MSGCODIGO = 73;
		$res = pg_exec($conn,$sql);
	}
	if ($idstatus=='13')
	{
		$sql = "update modelr.occurrence set idstatusoccurrence=13 where
		lat = 0 or long = 0 and
			idexperiment = ".$idexperimento;
		$MSGCODIGO = 73;
		$res = pg_exec($conn,$sql);
	}
	
}
header("Location: cadexperimento.php?op=A&MSGCODIGO=$MSGCODIGO&tab=2&pag=2&id=$idexperimento");
?>



