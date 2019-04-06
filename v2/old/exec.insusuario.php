<?php session_start();
require_once('classes/tecnico.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$tecnico = new Tecnico();
$tecnico->conn = $conn;

$sql = 'select * from tecnico';
$res = pg_exec($conn,$sql);
while ($row = pg_fetch_array($res))
{
	$pieces = explode("@", $row['email']);
	$login = substr(utf8_decode($pieces[0]),0,20); // piece1
	$email = utf8_decode($row['email']); // piece1
	$senha = md5('trocar'); // piece1
	$nome = utf8_decode($row['nometecnico']);
	$idtecnico = $row['idtecnico'];
	$sql2.= "insert into usuario (login,nome,email,senha,idtecnico) 
	                    values ('".$login."','".$nome."','".$email."','".$senha."',".$idtecnico.");";   
//	$res = pg_exec($conn,$sql2);
}
echo $sql2."<br>";
	
?>

