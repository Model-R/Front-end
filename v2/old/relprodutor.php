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


$sql = " select * from produtor prod left join tecnico t on prod.idtecnico = t.idtecnico ";

$pdf = new Relatorio2('L');

	$pdf->nomefonte = 'Arial';
	$pdf->tamanhofonte = '8';
	$pdf->orientacao = 'L';
	$pdf->borda = '1';
	$pdf->titulo = 'Relação dos Produtores';

//	$pdf->descricao="Parceiro: ".utf8_decode($nomeparceiro)." no período de ".date('d/m/Y',strtotime($datainicio)).' a '.date('d/m/Y',strtotime($datafim))."<BR>Planejamento: ".$Plan->sigla;

	$pdf->logo = 'imagens/logo_baldecheio.jpg';
	$pdf->titulo1 = 'BALDE CHEIO';
	srand(microtime()*1000000);
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','B',9);
	$pdf->SetWidths(array(35,25,20,20,15,50,20,30,25,35));
	$pdf->titulo2 = 'Produtores';

	$pdf->montaCabeca();

		$pdf->SetFont('Arial','',8);
		$res = pg_exec($conn,$sql);
		$pdf->Row(array( "Produtor", "CPF/CNPJ","RG","Órgão","UF","Endereco","CEP","Telefone","E-mail","Técnico"),'N'); 

		while ($row = pg_fetch_array($res))
		{
			$pdf->Row(array(utf8_decode($row['nomeprodutor']),
			utf8_decode($row['cpfcnpj']),
			utf8_decode($row['rg']),
			utf8_decode($row['orgaoexpedidor']),
			utf8_decode($row['rguf']),
			utf8_decode($row['endereco'].' '.$row['municipio'].' '.$row['uf']),
			utf8_decode($row['cep']),
			utf8_decode($row['telefone'].' '.$row['celular']),
			utf8_decode($row['email']),
			utf8_decode($row['nometecnico'])
			),'S');
		}
	$pdf->Output();
?>
