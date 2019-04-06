<?php session_start();
/*if (
   (!in_array("ADMINISTRADOR", $_SESSION['s_papel'])) 
   )
{
 	echo "<script language='javascript'>parent.corpo.location.href='acessonegado.php'</script>";
	exit;
}
*/
require_once('classes/configuracao.class.php');
require_once('classes/conexao.class.php');


$conexao = new Conexao;
$conn = $conexao->Conectar();
$Classe = new Configuracao();
$Classe->conn = $conn;
$fechar = $_REQUEST['fechar'];
$anoreferencia = $_REQUEST['edtanoreferencia'];
$relanoreferenciainicial = $_REQUEST['edtrelanoreferenciainicial'];
$relanoreferenciafinal = $_REQUEST['edtrelanoreferenciafinal'];
$relmesreferenciainicial = $_REQUEST['edtrelmesreferenciainicial'];
$relmesreferenciafinal = $_REQUEST['edtrelmesreferenciafinal'];
$emailrecebimento = $_REQUEST['edtemailrecebimento'];

$Classe->anoreferencia = $anoreferencia;
$Classe->emailrecebimento = $emailrecebimento;
$Classe->relanoreferenciainicial = $relanoreferenciainicial;
$Classe->relanoreferenciafinal = $relanoreferenciafinal;
$Classe->relmesreferenciainicial = $relmesreferenciainicial;
$Classe->relmesreferenciafinal = $relmesreferenciafinal;

$result = @$Classe->alterar();
if (!$result)
	{
	   header('Location: configuracao.php?MSGCODIGO=1');
	}
	else
	{
	   header('Location: configuracao.php?MSGCODIGO=0');
	}
	
?>



