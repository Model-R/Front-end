<?php session_start();

require_once('classes/propriedade.class.php');
require_once('classes/conexao.class.php');
require_once('classes/funcao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;

$Funcao = new Funcao();
$Funcao->conn = $conn;

$operacao = $_REQUEST['op'];


if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];

	$idpropriedade = $_REQUEST['id'];
	$idprodutor = $_REQUEST['cmboxprodutor'];
	$nomepropriedade = $_REQUEST['edtnomepropriedade'];
	$inscricaoestadual = $_REQUEST['edtinscricaoestadual'];
	$tecnicoresponsavel = $_REQUEST['edttecnicoresponsavel'];
	$tamanho = $_REQUEST['edttamanho'];
	$idunidademedida = $_REQUEST['cmboxunidademedida'];
	$endereco = $_REQUEST['edtendereco'];
	$municipio = $_REQUEST['edtmunicipio'];
	$estado = $_REQUEST['cmboxestado'];
	$empresacompradoraleite = $_REQUEST['empresacompradoraleite'];
	$dataentradaprojeto = $_REQUEST['edtdataentradaprojeto'];
	$producaoinicial = $_REQUEST['edtproducaoinicial'];
	$latitude = $_REQUEST['edtlatitude'];
	$longitude = $_REQUEST['edtlontitude'];
	$idsituacaopropriedade = $_REQUEST['cmboxsituacaopropriedade'];
	$idprograma = $_REQUEST['cmboxprograma'];
	$idtecnico = $_REQUEST['cmboxtecnico'];

	$Propriedade->idpropriedade =$idpropriedade ;
	$Propriedade->nomepropriedade = $nomepropriedade;
	$Propriedade->inscricaoestadual = $inscricaoestadual;
	$Propriedade->idprodutor = $idprodutor;
	$Propriedade->tecnicoresponsavel = $tecnicoresponsavel ;
	$Propriedade->tamanho = $tamanho ; 
	$Propriedade->idunidademedida=$idunidademedida  ;
	$Propriedade->endereco=$endereco;
	$Propriedade->municipio=$municipio;
	$Propriedade->uf=$estado;
	$Propriedade->latitude=$latitude;
	$Propriedade->longitude=$longitude;
	$Propriedade->idsituacaopropriedade=$idsituacaopropriedade;
	//$Propriedade->idtipoconsultoria=;
	$Propriedade->idtecnico=$idtecnico;
	$Propriedade->dataentradaprojeto=$dataentradaprojeto;
	$Propriedade->empresacompradoraleite=$empresacompradoraleite;
	$Propriedade->producaoinicial=$producaoinicial;
	$Propriedade->idprograma=$idprograma;	
	
}

if ($operacao=='I')
{
   if ($result = $Propriedade->incluir())
	{
	// MENSAGEM 15 ==> CADASTRAR PROPRIEDADE
	 header("Location: cadpropriedade.php?op=A&MSGCODIGO=15&id=$result");
	}
	else
	{
	// MENSAGEM 16 ==> NÃO FOI POSSÍVEL CADASTRAR PROPRIEDADE
	 header("Location: cadpropriedade.php?op=I&MSGCODIGO=16");
	}

}

if ($operacao=='A')
{
    if ($result = $Propriedade->alterar($idpropriedade))
	{
	// MENSAGEM 17 ==> ALTERAR PROPRIEDADE
	 header("Location: cadpropriedade.php?op=A&MSGCODIGO=17&id=$id");
	}
	else
	{
	// MENSAGEM 18 ==> NÃO FOI POSSÍVEL ALTERAR PROPRIEDADE
	 header("Location: cadpropriedade.php?op=A&MSGCODIGO=18&id=$id");
	}
   
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Propriedade->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_propriedade'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Propriedade->excluir($val);
		}
	}
	header("Location: conspropriedade.php");	
}



?>



