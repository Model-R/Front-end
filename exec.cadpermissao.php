<?php session_start();
if (
   (!in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (!in_array("ADMINISTRADOR", $_SESSION['s_papel'])) 
   )
{
 	echo "<script language='javascript'>parent.corpo.location.href='acessonegado.php'</script>";
	exit;
}
require_once('classes/funcao.class.php');
require_once('classes/conexao.class.php');
$idusuario = $_REQUEST['cmboxusuario'];
$conexao = new Conexao;
$conn = $conexao->Conectar();
$funcao = new Funcao();
$funcao->conn = $conn;
$f=$_REQUEST['checkpermissao'];
$funcao->removerAcesso($idusuario);
while (list ($key,$val) = @each($f)) { 
    $funcao->adicionarAcesso($idusuario,$val);
}
header("Location: cadpermissao.php?cmboxusuario=".$idusuario);
?>
