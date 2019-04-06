<?php 
require_once('classes/excel.class.php');
require_once('classes/conexao.class.php');
   
$clConexao = new Conexao;
$conn = $clConexao->Conectar(); 
  
$ordem = $_REQUEST['ordem'];
if (empty($idturma))
{
	$idturma = 0;
}
$sql = " 
select e.etapa,* from turmahasaluno tha, turma t, pessoafisica aluno, curso c, etapa e 
where tha.idturma = t.idturma and t.idcurso = c.idcurso and e.idetapa = t.idetapa 
and tha.idaluno = aluno.idpessoafisica and t.anoturma = ".date('Y')." and
aluno.idsituacaoescolar = 1 ";

if ($ordem=='matricula')
{
$sql.= "order by e.idgrupoensino,e.etapa,matricula" ;
} else
{
$sql.= "order by e.idgrupoensino,e.etapa,nome" ;
}

$arr_campo = array( "matricula", "nome", "datanascimento", "etapa", ); 
$arr_coluna = array( "Matricula", "Nome", "Data Nascimento", "Etapa"); 


$clRel = new Excel();

$clRel->conn = $conn;
$clRel->sql = $sql;
$clRel->campos = $arr_campo;
$clRel->coluna = $arr_coluna;
$clRel->arquivo = "alunoExcel.xls";
$clRel->imprime();

?>
