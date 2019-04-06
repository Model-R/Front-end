<?php session_start();

require_once('classes/relatorio2.class.php');
require_once('classes/conexao.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$tipo = $_REQUEST['tipo'];

$sql = "select prop.nomepropriedade,prod.nomeprodutor,tec.nometecnico, prop.municipio from propriedade prop, produtor prod, tecnico tec, visitatecnica
 where
prop.idprodutor = prod.idprodutor and
prod.idtecnico = tec.idtecnico and
visitatecnica.idtecnico = tec.idtecnico and
nometecnico <> 'Rafael Oliveira Lima' and prop.idsituacaopropriedade = 1 and
(visitatecnica.mesreferencia >= 6 and visitatecnica.anoreferencia=2013)
group by 1,2,3,4
";
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
	$sql.="select prop.nomepropriedade,prod.nomeprodutor,tec.nometecnico, datavisita,horachegada,relatorio from propriedade prop, produtor prod, tecnico tec, visitatecnica
 where
prop.idprodutor = prod.idprodutor and
prod.idtecnico = tec.idtecnico and
visitatecnica.idtecnico = tec.idtecnico and
nometecnico <> 'Rafael Oliveira Lima' and prop.idsituacaopropriedade = 1 and
(visitatecnica.mesreferencia >= 6 and visitatecnica.anoreferencia=2013)
order by tec.nometecnico,prop.nomepropriedade,datavisita, horachegada
"

}


$pdf = new Relatorio2('L');

	$pdf->nomefonte = 'Arial';
	$pdf->tamanhofonte = '8';
	$pdf->orientacao = 'L';
	$pdf->borda = '1';
//	$pdf->titulo = 'Rela��o de T�cnicos';

//	$pdf->descricao="Parceiro: ".utf8_decode($nomeparceiro)." no per�odo de ".date('d/m/Y',strtotime($datainicio)).' a '.date('d/m/Y',strtotime($datafim))."<BR>Planejamento: ".$Plan->sigla;

	$pdf->logo = 'imagens/logo_baldecheio.jpg';
	$pdf->titulo1 = 'BALDE CHEIO';
	srand(microtime()*1000000);
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','B',9);
	$pdf->SetWidths(array(65,80,70,60));
	if ($tipo == 1) {
		$pdf->titulo2 = 'Rela��o: T�cnico x Produtor x Propriedade';
		$pdf->Row(array('T�cnico','Produtor','Propriedade','Municipio'),'N');
	}
	if ($tipo == 2) {
		$pdf->titulo2 = 'Rela��o: Produtor x Propriedade x T�cnico';
		$pdf->Row(array('Produtor','Propriedade','T�cnico'),'N');
	}
	if ($tipo == 3) {
		$pdf->titulo2 = 'Rela��o: Propriedade x Produtor x T�cnico';
		$pdf->Row(array('Propriedade','Produtor','T�cnico'),'N');
	}
	if ($tipo == 4) {
		$pdf->titulo2 = 'Rela��o: T�cnico x Propriedade x Produtor x Visita t�cnica';
		$pdf->Row(array('T�cnico','Propriedade','Produtor','Visita T�cnica','Data','Horario Visita','Relat�rio'),'N');
	}

	$pdf->montaCabeca();

	if ($tipo == 1) {
		$pdf->Row(array('T�cnico','Produtor','Propriedade','Munic�pio'),'N');
	}
	if ($tipo == 2) {
		$pdf->Row(array('Produtor','Propriedade','T�cnico'),'N');
	}
	if ($tipo == 3) {
		$pdf->Row(array('Propriedade','Produtor','T�cnico'),'N');
	}
	if ($tipo == 4) {
		$pdf->Row(array('T�cnico','Propriedade','Produtor','Visita T�cnica','Data','Horario Visita','Relat�rio'),'N');
	}

		$pdf->SetFont('Arial','',9);
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
				$pdf->Row(array(utf8_decode($row['nometecnico'],utf8_decode($row['nomepropriedade']),utf8_decode($row['nomeprodutor']),
				$row['datavisita'],$row['horachegada'],utf8_decode($row['relatorio'])),'S');
			}
		}
	$pdf->Output();
?>
