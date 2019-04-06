<?php session_start();

require_once('classes/relatorio2.class.php');
require_once('classes/conexao.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();
//echo $_REQUEST;
$sql= $_REQUEST['sql'];
//echo "<br>";
$sql= stripslashes($sql);
//echo $sql;
//exit;

//$sql = "Select * from usuario left join tecnico on usuario.idtecnico = tecnico.idtecnico order by sem_acentos(usuario.nome)";

$pdf = new Relatorio2('L');

	$pdf->nomefonte = 'Arial';
	$pdf->tamanhofonte = '8';
	$pdf->orientacao = 'L';
	$pdf->borda = '1';
//	$pdf->titulo = 'Relação de Técnicos';

//	$pdf->descricao="Parceiro: ".utf8_decode($nomeparceiro)." no período de ".date('d/m/Y',strtotime($datainicio)).' a '.date('d/m/Y',strtotime($datafim))."<BR>Planejamento: ".$Plan->sigla;

	$pdf->logo = 'imagens/logo_baldecheio.jpg';
	$pdf->titulo1 = 'BALDE CHEIO';
	$pdf->titulo2 = 'Relação de Usuários';
	srand(microtime()*1000000);
	$pdf->AliasNbPages();
	$pdf->montaCabeca();
	$pdf->SetFont('Arial','B',9);
		$pdf->SetWidths(array(10,70,35,65,70,25));
		$pdf->Row(array('ID','Nome','Login','E-mail','Técnico','Situação'),'N');
		$pdf->SetFont('Arial','',8);
		$res = pg_exec($conn,$sql);
		while ($row = pg_fetch_array($res))
		{
			$pdf->Row(array(utf8_decode($row['idusuario']),
				utf8_decode($row['nome']),
				utf8_decode($row['login']),
				utf8_decode($row['email']),
				utf8_decode($row['nometecnico']),
				utf8_decode($row['situacao'])
				),'S');
		}
	$pdf->Output();
?>
