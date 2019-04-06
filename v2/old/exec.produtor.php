<?php session_start();

require_once('classes/produtor.class.php');
require_once('classes/conexao.class.php');
require_once('classes/funcao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Funcao = new Funcao();
$Funcao->conn = $conn;

$operacao = $_REQUEST['op'];

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idprodutor = $_REQUEST['id'];
	$nomeprodutor = $_REQUEST['edtnomeprodutor'];
	$cpfcnpj = $_REQUEST['edtcpfcnpj'];
	$rg = $_REQUEST['edtrg'];
	$orgaoexpedidor = $_REQUEST['edtorgaoexpedidor'];
	$estado = $_REQUEST['cmboxestado'];
	$endereco = $_REQUEST['edtendereco'];
	$municipio = $_REQUEST['edtmunicipio'];
	$estado2 = $_REQUEST['cmboxestado2'];
	$cep = $_REQUEST['edtcep'];
	$telefone = $_REQUEST['edttelefone'];
	$celular = $_REQUEST['edtcelular'];
	$email = $_REQUEST['edtemail'];
	$idtecnico = $_REQUEST['cmboxtecnico'];

	$Produtor->idprodutor = $idprodutor;
	$Produtor->nomeprodutor = $nomeprodutor;
	$Produtor->cpfcnpj = $cpfcnpj;
	$Produtor->rg = $rg;
	$Produtor->orgaoexpedidor = $orgaoexpedidor;
	$Produtor->rguf = $estado;
	$Produtor->endereco = $endereco;
	$Produtor->municipio = $municipio;
	$Produtor->uf = $estado2;
	$Produtor->cep = $cep;
	$Produtor->telefone = $telefone;
	$Produtor->celular = $celular;
	$Produtor->email = $email;
	$Produtor->idtecnico = $idtecnico;
	
}

if ($operacao=='I')
{
   if ($result = $Produtor->incluir())
	{
	// MENSAGEM 11 ==> CADASTRAR PRODUTOR
	 header("Location: cadprodutor.php?op=A&MSGCODIGO=11&id=$result");
	}
	else
	{
	// MENSAGEM 12 ==> NÃO FOI POSSÍVEL CADASTRAR PRODUTOR
	 header("Location: cadprodutor.php?op=I&MSGCODIGO=12");
	}

}

if ($operacao=='A')
{
	if ($result = $Produtor->alterar($idprodutor))
	{
	// MENSAGEM 13 ==> ALTERAR PRODUTOR
	 header("Location: cadprodutor.php?op=A&MSGCODIGO=13&id=$id");
	}
	else
	{
	// MENSAGEM 14 ==> NÃO FOI POSSÍVEL ALTERAR PRODUTOR
	 header("Location: cadprodutor.php?op=A&MSGCODIGO=14&id=$id");
	}
   
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Produtor->excluir($id);
	}
	else
	{
		$box=$_POST['id_produtor'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Produtor->excluir($val);
		}
	}
	header("Location: consprodutor.php");	
}



?>



