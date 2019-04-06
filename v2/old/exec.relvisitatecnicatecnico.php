<?php
require_once('classes/formulariovisitatecnica.class.php');
require_once('classes/conexao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$sql = "select u2.siglaunidademedida as siglaunidademedidaprojeto,* from visitatecnica vt
left join unidademedida u2 on vt.idunidademedida = u2.idunidademedida
, 
propriedade prop left join unidademedida on
prop.idunidademedida = unidademedida.idunidademedida
,
produtor prod,
tecnico tec
 where vt.idvisitatecnica = vt.idvisitatecnica and
 vt.idpropriedade = prop.idpropriedade and
 prop.idprodutor = prod.idprodutor and
 vt.idtecnico = tec.idtecnico";

//if ( (isset($_REQUEST['id_'])) || ($!) )
//{
if (isset($_REQUEST['idvisitatecnica']))
{
	$idvisitatecnica = $_REQUEST['idvisitatecnica'];
	$sql.= " and vt.idvisitatecnica = ".$idvisitatecnica;
}
else
{
	$box=$_POST['id_visitatecnica'];
	$sql.=' and vt.idvisitatecnica in (0';
	while (list ($key,$val) = @each($box)) { 
		$sql.=','.$val;
	}
	$sql.=')';
}

$resultado = pg_exec($conn,$sql);	
$Formulario = new FormularioVisitaTecnica('P','mm','A4');
$Formulario->res = $resultado;
$Formulario->conn = $conn;
$Formulario->AliasNbPages();
$Formulario->montaCorpo();
$Formulario->Output();	   
 ?>