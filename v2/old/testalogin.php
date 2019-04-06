<?php
session_start();
session_destroy();
require_once('classes/conexao.class.php');
require_once('classes/usuario.class.php');
session_cache_expire(6000);
$Conexao = new Conexao;
$conn = $Conexao->Conectar();
$Usuario = new Usuario();
$Usuario->conn = $conn;
$login = $_REQUEST['edtlogin'];
$senha = $_REQUEST['edtsenha'];
//header("Location: consprojeto.php");

if (!$Usuario->autentica($login,$senha) ) 
{
	header("Location: login.php?MSGCODIGO=10");
}
else
{
	$Usuario->getUsuarioByLogin($login);
	session_register("s_idusuario"); 
	session_register("s_nome");
	session_register("s_email"); 
	session_register("s_idsituacaousuario"); 
	session_register("s_idtipousuario"); 
	session_register("s_sistema"); 
	session_register("s_idprojeto"); 
	$_SESSION['s_idusuario']=$Usuario->idusuario;
	$_SESSION['s_nome']=$Usuario->nome;
	$_SESSION['s_email']=$Usuario->email;
	$_SESSION['ID_SESSION']=session_id();
	$_SESSION['s_idsituacaousuario']=$Usuario->idsituacaousuario;
	$_SESSION['s_idtipousuario']=$Usuario->idtipousuario;
	$_SESSION['s_idprojeto']=$Usuario->idprojeto;
	$_SESSION['s_sistema']='MODEL-R';
	
//	if (!empty($Usuario->idprojeto))
//	{
		header("Location: consexperimento.php?idproject=".$Usuario->idprojeto);
//	}
//	else
//	{
//		header("Location: consprojeto.php");
//	}
}

?>