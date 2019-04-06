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


$sql = " select * from tecnico ";

$pdf = new Relatorio2('L');

	$pdf->nomefonte = 'Arial';
	$pdf->tamanhofonte = '8';
	$pdf->orientacao = 'L';
	$pdf->borda = '1';
	$pdf->titulo = 'Relação dos Técnicos';

//	$pdf->descricao="Parceiro: ".utf8_decode($nomeparceiro)." no período de ".date('d/m/Y',strtotime($datainicio)).' a '.date('d/m/Y',strtotime($datafim))."<BR>Planejamento: ".$Plan->sigla;

	$pdf->logo = 'imagens/logo_baldecheio.jpg';
	$pdf->titulo1 = 'BALDE CHEIO';
	srand(microtime()*1000000);
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','B',9);
	$pdf->SetWidths(array(75,35,85,40,40));
	$pdf->titulo2 = 'Técnicos';

	$pdf->montaCabeca();

		$pdf->SetFont('Arial','',8);
		$res = pg_exec($conn,$sql);
		$pdf->Row(array( "nometecnico", "matricula","endereco",
"telefone","celular"),'S');
		
		while ($row = pg_fetch_array($res))
		{
			$pdf->Row(array(utf8_decode($row['nometecnico']),
			utf8_decode($row['matricula']),
			utf8_decode($row['endereco']),
			utf8_decode($row['telefone']),
			utf8_decode($row['celular'])
			),'S');
		}
	$pdf->Output();
?>
