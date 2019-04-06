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


$sql = " select * from propriedade prop left join tecnico t on prop.idtecnico = t.idtecnico 
left join produtor prod on prop.idprodutor = prod.idprodutor
left join unidademedida um on prop.idunidademedida = um.idunidademedida
,
programa p, situacaopropriedade sp
where
prop.idsituacaopropriedade = sp.idsituacaopropriedade and
prop.idprograma = p.idprograma ";

$pdf = new Relatorio2('L');

	$pdf->nomefonte = 'Arial';
	$pdf->tamanhofonte = '8';
	$pdf->orientacao = 'L';
	$pdf->borda = '1';
	$pdf->titulo = 'Relação dos Propriedades';

//	$pdf->descricao="Parceiro: ".utf8_decode($nomeparceiro)." no período de ".date('d/m/Y',strtotime($datainicio)).' a '.date('d/m/Y',strtotime($datafim))."<BR>Planejamento: ".$Plan->sigla;

	$pdf->logo = 'imagens/logo_baldecheio.jpg';
	$pdf->titulo1 = 'BALDE CHEIO';
	srand(microtime()*1000000);
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','B',9);
	$pdf->SetWidths(array(55,45,20,60,15,50,30));
	$pdf->titulo2 = 'Propriedades';

	$pdf->montaCabeca();

		$pdf->SetFont('Arial','',8);
		$res = pg_exec($conn,$sql);
		$pdf->Row(array( "nomepropriedade", "nomeprodutor","inscricaoestadual",
"endereco","situacaopropriedade","nometecnico","programa"),'S');
		
		while ($row = pg_fetch_array($res))
		{
			$pdf->Row(array(utf8_decode($row['nomepropriedade']),
			utf8_decode($row['nomeprodutor']),
			utf8_decode($row['inscricaoestadual']),
			utf8_decode($row['endereco'].' '.$row['municipio'].' '.$row['uf']),
			utf8_decode($row['situacaopropriedade']),
			utf8_decode($row['nometecnico']),
			utf8_decode($row['programa'])
			),'S');
		}
	$pdf->Output();
?>
