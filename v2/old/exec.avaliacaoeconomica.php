<?php session_start();

require_once('classes/categoria.class.php');
require_once('classes/conexao.class.php');
require_once('classes/funcao.class.php');
require_once('classes/avaliacaoeconomica.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Categoria = new Categoria();
$Categoria->conn = $conn;

$AvaliacaoEconomica = new AvaliacaoEconomica();
$AvaliacaoEconomica->conn = $conn;


$operacao = $_REQUEST['op'];
$tipo = $_REQUEST['cmboxtipo'];
$ano = $_REQUEST['edtano'];
$idpropriedade = $_REQUEST['cmboxpropriedade'];
$quantidade = $_REQUEST['edtquantidade'];
$idunidademedida = $_REQUEST['cmboxunidademedida'];
$valorunitario = $_REQUEST['edtvalorunitario'];
$idcategoria = $_REQUEST['cmboxcategoriatipocapital'];
$vidautil = $_REQUEST['edtvidautil'];
$valorindividual = $_REQUEST['edtvalorindividual'];
								

if ($tipo=='T')
{
	$resultado = $AvaliacaoEconomica->incluirTerra($idpropriedade,$ano,$idunidademedida,$quantidade,$valorunitario);
}
if ($tipo=='A')
{
	$resultado = $AvaliacaoEconomica->incluirAnimal($idpropriedade,$ano,$idcategoria,$quantidade,$valorindividual);
}
if ($tipo=='E')
{
	$resultado = $AvaliacaoEconomica->incluirEquipamento($idpropriedade,$ano,$idcategoria,$vidautil,$valorunitario);
}
if ($tipo=='I')
{
	$resultado = $AvaliacaoEconomica->incluirInstalacao($idpropriedade,$ano,$idcategoria,$vidautil,$valorunitario);
}

header("Location: cadavaliacaoeconomica.php?op=I&cmboxtipo=$tipo&idpropriedade=$idpropriedade");

?>



