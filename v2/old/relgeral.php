<?php session_start();

require_once('classes/relatorio2.class.php');
require_once('classes/conexao.class.php');
require_once('classes/programa.class.php');
require_once('classes/configuracao.class.php');


$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Config = new Configuracao();
$Config->conn = $conn;


$Config->getConfiguracao();
$tipo = $_REQUEST['tipo'];

$Programa = new Programa();
$Programa->conn = $conn;

$idprograma = $_REQUEST['idprograma'];

$Programa->getById($idprograma);


$sql = "select prop.nomepropriedade,prod.nomeprodutor,tec.nometecnico, prop.municipio from propriedade prop, produtor prod, tecnico tec, visitatecnica
 where
prop.idprodutor = prod.idprodutor and
prod.idtecnico = tec.idtecnico and
nometecnico <> 'Rafael Oliveira Lima' and prop.idsituacaopropriedade = 1 and
((visitatecnica.mesreferencia >= ".$Config->relmesreferenciainicial." and visitatecnica.anoreferencia>=".$Config->relanoreferenciainicial.") and
(visitatecnica.mesreferencia <= ".$Config->relmesreferenciafinal." and visitatecnica.anoreferencia<=".$Config->relanoreferenciafinal."))
group by 1,2,3,4
";
//echo $sql;
//exit;
if ($tipo == 1) {
	$sql.=' order by upper(tec.nometecnico) ';
}
if ($tipo == 2) {
	$sql.=' order by upper(prod.nomeprodutor) ';
}
if ($tipo == 3) {
	$sql.=' order by upper(prop.nomepropriedade) ';
}

if ($tipo==4)
{
	$datainicio = $_REQUEST['datainicio'];
	$datatermino = $_REQUEST['datatermino'];
	
	$dia = substr($datainicio,0,2);
	$mes = intval(substr($datainicio,3,2));
	$ano = substr($datainicio,6,4);
	
	if (empty($datatermino))
	{
		$datatermino = date('d/m/Y');
	}
	$diaT = substr($datatermino,0,2);
	$mesT = intval(substr($datatermino,3,2));
	$anoT = substr($datatermino,6,4);
	
$datainicio = $mes.'-'.$dia.'-'.$ano;
$datatermino = $mesT.'-'.$diaT.'-'.$anoT;

	$sql="select prop.nomepropriedade,prod.nomeprodutor,tec.nometecnico, datavisita,horachegada,horasaida,relatorio from propriedade prop, produtor prod, tecnico tec, visitatecnica
 where
prop.idprodutor = prod.idprodutor and
visitatecnica.idtecnico = tec.idtecnico and
visitatecnica.idpropriedade = prop.idpropriedade and
nometecnico <> 'Rafael Oliveira Lima' ";
if (!empty($idprograma))
{
	$sql.=" and prop.idprograma = '".$idprograma."'";
	
}
$sql.=" 
and (datavisita >= '".$datainicio."' and datavisita <='".$datatermino."')
order by tec.nometecnico,prop.nomepropriedade,datavisita, horachegada ";
//echo $sql;
}


$pdf = new Relatorio2('L');

	$pdf->nomefonte = 'Arial';
	$pdf->tamanhofonte = '8';
	$pdf->orientacao = 'L';
	$pdf->borda = '1';
//	$pdf->titulo = 'Relação de Técnicos';

//	$pdf->descricao="Parceiro: ".utf8_decode($nomeparceiro)." no período de ".date('d/m/Y',strtotime($datainicio)).' a '.date('d/m/Y',strtotime($datafim))."<BR>Planejamento: ".$Plan->sigla;

	$pdf->logo = 'imagens/logo_baldecheio.jpg';
	$pdf->titulo1 = 'BALDE CHEIO';
	srand(microtime()*1000000);
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','B',9);
	$pdf->SetWidths(array(65,80,70,60));
	if ($tipo == 1) {
		$pdf->titulo2 = 'Relação: Técnico x Produtor x Propriedade';
		$pdf->Row(array('Técnico','Produtor','Propriedade','Municipio'),'N');
	}
	if ($tipo == 2) {
		$pdf->titulo2 = 'Relação: Produtor x Propriedade x Técnico';
		$pdf->Row(array('Produtor','Propriedade','Técnico'),'N');
	}
	if ($tipo == 3) {
		$pdf->titulo2 = 'Relação: Propriedade x Produtor x Técnico';
		$pdf->Row(array('Propriedade','Produtor','Técnico'),'N');
	}
	if ($tipo == 4) {
		$pdf->SetWidths(array(65,60,20,30,100));
		$pdf->titulo2 = 'Relação: Técnico x Propriedade x Produtor x Visita técnica';
		$pdf->Row(array('Técnico','Propriedade','Produtor','Data','Horario Visita','Relatório'),'N');
	}
	
	$pdf->descricao = 'Programa: '.$Programa->programa;

	$pdf->montaCabeca();

	if ($tipo == 1) {
		$pdf->Row(array('Técnico','Produtor','Propriedade','Município'),'N');
	}
	if ($tipo == 2) {
		$pdf->Row(array('Produtor','Propriedade','Técnico'),'N');
	}
	if ($tipo == 3) {
		$pdf->Row(array('Propriedade','Produtor','Técnico'),'N');
	}
	if ($tipo == 4) {
		$pdf->Row(array('Técnico','Propriedade/Produtor','Data','Horario Visita','Relatório'),'N');
	}

		$pdf->SetFont('Arial','',8);
		$res = pg_exec($conn,$sql);
		while ($row = pg_fetch_array($res))
		{
			if ($tipo == 1) {
				$pdf->Row(array(utf8_decode($row['nometecnico']),
				utf8_decode($row['nomeprodutor']),
				utf8_decode($row['nomepropriedade']),
				utf8_decode($row['municipio'])
				),'S');
			}
			if ($tipo == 2) {
				$pdf->Row(array(utf8_decode($row['nomeprodutor']),
				utf8_decode($row['nomepropriedade']),
				utf8_decode($row['nometecnico'])
				),'S');
			}
			if ($tipo == 3) {
				$pdf->Row(array(utf8_decode($row['nomepropriedade']),
				utf8_decode($row['nomeprodutor']),
				utf8_decode($row['nometecnico'])
				),'S');
			}
			if ($tipo == 4) {
				$pdf->Row(array(utf8_decode($row['nometecnico']),utf8_decode($row['nomepropriedade']).' ('.utf8_decode($row['nomeprodutor']).')',
				date('d/m/Y',strtotime($row['datavisita'])),date('H:i',strtotime($row['horachegada'])).' às '.date('H:i',strtotime($row['horasaida'])),utf8_decode($row['relatorio'])),'S');
			}
		}
	$pdf->Output();
?>
