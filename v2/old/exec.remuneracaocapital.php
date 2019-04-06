<?php session_start();
require_once('classes/remuneracaocapital.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$RemuneracaoCapital = new RemuneracaoCapital();
$RemuneracaoCapital->conn = $conn;

$operacao = $_REQUEST['op'];
if (empty($operacao))
{
	$operacao = 'I';
}
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idtipocapital = $_REQUEST['cmboxtipocapital'];
	$idprodutor = $_REQUEST['cmboxprodutor'];
	$idpropriedade = $_REQUEST['cmboxpropriedade'];

	$id = $_REQUEST['edtidremuneracaocapital'];
	$idavaliacao = $_REQUEST['cmboxavaliacao'];
	$idcategoriacapital = $_REQUEST['cmboxcategoriatipocapital'];
	$taxajuros = $_REQUEST['edttaxajuros'];
	$quantidade = $_REQUEST['edtquantidade'];
	$valorunitario = $_REQUEST['edtvalorunitario'];
	$vidautil = $_REQUEST['edtvidautil'];
	
	$RemuneracaoCapital->idremuneracaocapital = $id;
	$RemuneracaoCapital->idavaliacao = $idavaliacao;
	$RemuneracaoCapital->idcategoriacapital = $idcategoriacapital;
	$RemuneracaoCapital->taxajuros = $taxajuros;
	$RemuneracaoCapital->quantidade = $quantidade;
	$RemuneracaoCapital->valorunitario = $valorunitario;
	$RemuneracaoCapital->vidautil = $vidautil;
}
if ($operacao=='I')
{

   $result = $RemuneracaoCapital->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Cadastrar remuneracao Capital')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadremuneracaocapital.php?op=I&cmboxavaliacao=".$idavaliacao."&cmboxtipocapital=".$idtipocapital."</script>";
	}
	else
	{
       echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
       echo "<script language= 'javascript'>parent.corpo.location.href='cadremuneracaocapital.php?op=I&cmboxavaliacao=".$idavaliacao."&cmboxtipocapital=".$idtipocapital."&cmboxprodutor=".$idprodutor."&cmboxpropriedade=".$idpropriedade."'</script>";
	}
}
if ($operacao=='A')
{
   $result = $RemuneracaoCapital->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadremuneracaocapital.php?op=A&id=".$idvisitatecnica."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Alterado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='cadremuneracaocapital.php?op=I&cmboxavaliacao=".$idavaliacao."&cmboxtipocapital=".$idtipocapital."&cmboxprodutor=".$idprodutor."&cmboxpropriedade=".$idpropriedade."'</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
	$idavaliacao = $_REQUEST['idavaliacao'];
	$idtipocapital = $_REQUEST['idtipocapital'];
	$idcategoriacapital = $_REQUEST['idcategoriatipocapital'];
	
    if (!empty($id)){
 		$result = $RemuneracaoCapital->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_remuneracaocapital'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $RemuneracaoCapital->excluir($val);
		}
	} 
       echo "<script language= 'javascript'>parent.corpo.location.href='cadremuneracaocapital.php?op=I&cmboxavaliacao=".$idavaliacao."&idtipocapital=".$idtipocapital."&idcategoriatipocapital=".$idcategoriatipocapital."'</script>";

}

?>

