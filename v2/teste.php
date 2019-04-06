<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();
$user = 'marcosga';

$sql ="select * from modelr.user where login = '$user'";
		
$res = pg_exec($conn,$sql);

while ($row = pg_fetch_array($res))
{	$sql ="update modelr.user set password='" . md5('trocar') . "' where login = '$user'";
		
	$res = pg_exec($conn,$sql);
	echo 'terminou';
}
?>