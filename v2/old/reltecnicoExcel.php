<?php 
require_once('classes/excel.class.php');
require_once('classes/conexao.class.php');
require_once('classes/relatorio2.class.php');
require_once('classes/conexao.class.php');
require_once('classes/tecnico.class.php');
require_once('classes/programa.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$sql = "
select * from tecnico 
";



//$sql = 'select * from usuario left join tecnico on usuario.idtecnico = tecnico.idtecnico order by sem_acentos(usuario.nome) ';


$arr_campo = array( "nometecnico", "matricula","email","endereco","telefone","celular"
); 
$arr_coluna = array( "Nome", "Matricula","Endereço","Telefone.","Celular"
); 
//$arr_coluna = array( "Produtor", "CPF/CNPJ","RG","Orgão Exped","RG UF","Endereco","Municipio","UF","CEP","Telefone","Celular","Email","Técnico"); 


$clRel = new Excel();

$clRel->conn = $conn;
$clRel->sql = $sql;
$clRel->campos = $arr_campo;
$clRel->coluna = $arr_coluna;
$clRel->arquivo = "reltecnico.xls";
$clRel->imprime();

?>
