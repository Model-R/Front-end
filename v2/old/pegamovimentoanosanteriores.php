<?php 

require_once('classes/conexao.class.php');
require_once('classes/avaliacao.class.php');
$idavaliacao = $_REQUEST['idavaliacao'];
$idtipomovimento = $_REQUEST['idtipomovimento'];
$anoanterior = $_REQUEST['anoanterior'];
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Avaliacao = new Avaliacao;
$Avaliacao->conn = $conn;
//echo "aqui".$_REQUEST['idavaliacao'].' '.$_REQUEST['idtipomovimento'].' '.$_REQUEST['anoanterior'];;

echo $Avaliacao->pegaAnosAnteriores($idavaliacao,$idcategoriatipomovimento,$idtipomovimento,$anoanterior);

?>
