<?php 
require_once('classes/excel.class.php');
require_once('classes/conexao.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$sql= $_REQUEST['sql'];
//echo "<br>";
$sql= stripslashes($sql);

//$sql = 'select * from usuario left join tecnico on usuario.idtecnico = tecnico.idtecnico order by sem_acentos(usuario.nome) ';

$arr_campo = array( "idusuario", "nome", "login", "email", "nometecnico","situacao"); 
$arr_coluna = array( "ID", "Nome", "Login", "E-mail", "Técnico","Situação"); 


$clRel = new Excel();

$clRel->conn = $conn;
$clRel->sql = $sql;
$clRel->campos = $arr_campo;
$clRel->coluna = $arr_coluna;
$clRel->arquivo = "usuarioExcel.xls";
$clRel->imprime();

?>
