<?php session_start();
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();

$idpropriedade = $_REQUEST['idpropriedade'];
$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];
$idcategoria = $_REQUEST['idcategoria'];
$valor = $_REQUEST['valor'];

$valor = str_replace(",",".",$valor);

$sql = "delete from lancamento where idpropriedade=$idpropriedade and mes=$mes and ano=$ano and idcategoria=$idcategoria;";
$sql .= "insert into lancamento (idpropriedade,mes,ano,idcategoria,valor)
		values ($idpropriedade,$mes,$ano,$idcategoria,$valor)";
	
$res = pg_exec($conn,$sql);

echo $res;
?>



