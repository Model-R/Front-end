<?php 
require_once('classes/excel.class.php');
require_once('classes/conexao.class.php');
require_once('classes/relatorio2.class.php');
require_once('classes/conexao.class.php');
require_once('classes/tecnico.class.php');
require_once('classes/programa.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$Programa = new Programa();
$Programa->conn = $conn;

$idprograma = $_REQUEST['idprograma'];
$idtecnio = $_REQUEST['idtecnico'];
$datainicio = $_REQUEST['datainicio'];
$mesreferencia = $_REQUEST['mesreferencia'];
$anoreferencia = $_REQUEST['anoreferencia'];
$ordenadopor = $_REQUEST['ordenadopor'];
if (!empty($datainicio))
{
	$datainicio = substr($datainicio,6,4).'-'.substr($datainicio,3,2).'-'.substr($datainicio,0,2);
}
$datatermino = $_REQUEST['datatermino'];
if (!empty($datatermino))
{
	$datatermino = substr($datatermino,6,4).'-'.substr($datatermino,3,2).'-'.substr($datatermino,0,2);
}
else
{
	$datatermino = date('Y-m-d');
}

$sql = "
select visitatecnica.*,propriedade.*,tecnico.nometecnico as tecnico,
produtor.* 
from visitatecnica, propriedade, tecnico,produtor 
where propriedade.idprodutor = produtor.idprodutor and 
visitatecnica.idpropriedade = propriedade.idpropriedade and 
visitatecnica.idtecnico = tecnico.idtecnico ";

if (!empty($idtecnico))
{
	$Tecnico->getTecnicoById($idtecnico);
	$sql.=' and visitatecnica.idtecnico = '.$idtecnico;
}

if (!empty($mesreferencia))
{
	$sql.= " and mesreferencia = ".$mesreferencia;
}
if (!empty($anoreferencia))
{
	$sql.= " and anoreferencia = ".$anoreferencia;
}
if (!empty($idprograma))
{
	$sql.= " and idprograma = ".$idprograma;
}

if (!empty($datainicio))
{
	$sql .= " and (visitatecnica.datapagamento >= '".$datainicio."'";
	if (!empty($datatermino))
	{
		$sql_where .= " and visitatecnica.datapagamento <='".$datatermino."'";
	}
	$sql.=') ';
}
if ($ordenadopor=='TECNICO')
{
	$sql_order = ' ORDER BY tecnico.nometecnico,propriedade.nomepropriedade,visitatecnica.anoreferencia,visitatecnica.mesreferencia ';
}
if ($ordenadopor=='PROPRIEDADE')
{
	$sql_order = ' ORDER BY propriedade.nomepropriedade,tecnico.nometecnico,visitatecnica.anoreferencia,visitatecnica.mesreferencia ';
}
if ($ordenadopor=='DATA')
{
	$sql_order = ' ORDER BY visitatecnica.datavisita ';
}

$sql.=$sql_order;
//$sql = 'select * from usuario left join tecnico on usuario.idtecnico = tecnico.idtecnico order by sem_acentos(usuario.nome) ';

$arr_campo = array( "nomepropriedade","nomeprodutor", "nometecnico", "datavisita", "mesreferencia","anoreferenica", "relatorio"); 
$arr_coluna = array( 'Propriedade','Nome produtor','Técnico','Data Visita','Mes Ref.','Ano Ref.','Relatório'); 


$clRel = new Excel();

$clRel->conn = $conn;
$clRel->sql = $sql;
$clRel->campos = $arr_campo;
$clRel->coluna = $arr_coluna;
$clRel->arquivo = "visitanoperiodoExcel.xls";
$clRel->imprime();

?>
