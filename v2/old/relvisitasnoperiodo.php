<?php session_start();

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

$pdf = new Relatorio2('L');

	$pdf->nomefonte = 'Arial';
	$pdf->tamanhofonte = '8';
	$pdf->orientacao = 'P';
	$pdf->borda = '1';
//	$pdf->titulo = 'Relação de Técnicos';

//	$pdf->descricao="Parceiro: ".utf8_decode($nomeparceiro)." no período de ".date('d/m/Y',strtotime($datainicio)).' a '.date('d/m/Y',strtotime($datafim))."<BR>Planejamento: ".$Plan->sigla;

	$pdf->logo = 'imagens/logo_baldecheio.jpg';
	$pdf->titulo1 = 'BALDE CHEIO';
	$pdf->titulo2 = 'Visitas no período';
	
	$pdf->descricao = 'Período: '.date('d/m/Y', strtotime($datainicio)).' a '.date('d/m/Y', strtotime($datatermino));
	
	srand(microtime()*1000000);
	$pdf->AliasNbPages();
	$pdf->montaCabeca();
	$pdf->SetFont('Arial','B',9);
		$pdf->SetWidths(array(50,50,20,20,135));
		$pdf->Row(array('Propriedade','Técnico','Data Visita','Mes/Ano','Relatório'),'N');
		$pdf->SetFont('Arial','',8);
		$res = pg_exec($conn,$sql);
		while ($row = pg_fetch_array($res))
		{
			$pdf->Row(array(
				utf8_decode($row['nomepropriedade']).' ('.utf8_decode($row['nomeprodutor']).')',
				utf8_decode($row['tecnico']),
				date('d/m/Y', strtotime($row['datavisita'])),
				utf8_decode($row['mesreferencia'].'/'.$row['anoreferencia']),
				utf8_decode($row['relatorio'])
				),'S');
		}
	$pdf->Output();
?>
