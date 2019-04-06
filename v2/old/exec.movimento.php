<?php session_start();
require_once('classes/movimento.class.php');
require_once('classes/conexao.class.php');
require_once('classes/avaliacao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Movimento = new Movimento();
$Movimento->conn = $conn;

$Avaliacao = new Avaliacao();
$Avaliacao->conn = $conn;

$operacao = $_REQUEST['op'];
if (empty($operacao))
{
	$operacao = 'I';
}
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['id'];
	$idavaliacao = $_REQUEST['cmboxavaliacao'];
	$Avaliacao->getById($idavaliacao);
	$ano = $Avaliacao->anoreferencia;
	$idtipomovimento = $_REQUEST['cmboxtipomovimento'];
	$idcategoriatipomovimento = $_REQUEST['cmboxcategoriatipomovimento'];

   $valor1 = $_REQUEST['edtjan'];
   $valor2 = $_REQUEST['edtfev'];
   $valor3 = $_REQUEST['edtmar'];
   $valor4 = $_REQUEST['edtabr'];
   $valor5 = $_REQUEST['edtmai'];
   $valor6 = $_REQUEST['edtjun'];
   $valor7 = $_REQUEST['edtjul'];
   $valor8 = $_REQUEST['edtago'];
   $valor9 = $_REQUEST['edtset'];
   $valor10 = $_REQUEST['edtout'];
   $valor11 = $_REQUEST['edtnov'];
   $valor12 = $_REQUEST['edtdez'];
   
   $valor = $_REQUEST['valor'];

	$Movimento->idmovimento = $id;
	$Movimento->ano = $ano;
	$Movimento->valor = $valor;
	$Movimento->idavaliacao = $idavaliacao;
	$Movimento->idtipomovimento = $idtipomovimento;
}
if ($operacao=='I')
{
   $result = $Movimento->excluirAno($ano,$idavaliacao,$idtipomovimento);
   if (!empty($valor1)){
      $Movimento->mes = 1;
      $Movimento->valor = $valor1;
      $result = $Movimento->incluir();
   }
   if (!empty($valor2)){
      $Movimento->mes = 2;
      $Movimento->valor = $valor2;
      $result = $Movimento->incluir();
   }
   if (!empty($valor3)){
      $Movimento->mes = 3;
      $Movimento->valor = $valor3;
      $result = $Movimento->incluir();
   }
   if (!empty($valor4)){
      $Movimento->mes = 4;
      $Movimento->valor = $valor4;
      $result = $Movimento->incluir();
   }
   if (!empty($valor5)){
      $Movimento->mes = 5;
      $Movimento->valor = $valor5;
      $result = $Movimento->incluir();
   }
   if (!empty($valor6)){
      $Movimento->mes = 6;
      $Movimento->valor = $valor6;
      $result = $Movimento->incluir();
   }
   if (!empty($valor7)){
      $Movimento->mes = 7;
      $Movimento->valor = $valor7;
      $result = $Movimento->incluir();
   }
   if (!empty($valor8)){
      $Movimento->mes = 8;
      $Movimento->valor = $valor8;
      $result = $Movimento->incluir();
   }
   if (!empty($valor9)){
      $Movimento->mes = 9;
      $Movimento->valor = $valor9;
      $result = $Movimento->incluir();
   }
   if (!empty($valor10)){
      $Movimento->mes = 10;
      $Movimento->valor = $valor10;
      $result = $Movimento->incluir();
   }
   if (!empty($valor11)){
      $Movimento->mes = 11;
      $Movimento->valor = $valor11;
      $result = $Movimento->incluir();
   }
   if (!empty($valor12)){
      $Movimento->mes = 12;
      $Movimento->valor = $valor12;
      $result = $Movimento->incluir();
   }
   echo "<script language= 'javascript'>parent.corpo.location.href='cadmovimento.php?op=I&cmboxavaliacao=".$idavaliacao."&cmboxtipomovimento=".$idtipomovimento."&cmboxcategoriatipomovimento=".$idcategoriatipomovimento."'</script>";
}
if ($operacao=='A')
{
   $result = $Movimento->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadmovimento.php?op=A&id=".$idvisitatecnica."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Alterado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='cadmovimento.php?op=I&cmboxavaliacao=".$idavaliacao."&cmboxtipocapital=".$idtipocapital."&cmboxprodutor=".$idprodutor."&cmboxpropriedade=".$idpropriedade."'</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Movimento->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_movimento'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Movimento->excluir($val);
		}
	} 
    echo "<script language= 'javascript'>parent.corpo.location.href='cadmovimento.php'</script>";

}

?>

