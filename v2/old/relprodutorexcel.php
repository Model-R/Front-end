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
select * from produtor prod left join tecnico t on prod.idtecnico = t.idtecnico ";



//$sql = 'select * from usuario left join tecnico on usuario.idtecnico = tecnico.idtecnico order by sem_acentos(usuario.nome) ';

$nomeprodutor = $Produtor->nomeprodutor;
		   	$cpfcnpj = $Produtor->cpfcnpj;
		   	$rg = $Produtor->rg;
		   	$orgaoexpedidor= $Produtor->orgaoexpedidor;
		   	$rguf = $Produtor->rguf;
		   	$endereco = $Produtor->endereco;
		   	$municipio = $Produtor->municipio;
		   	$uf = $Produtor->uf;
		   	$cep = $Produtor->cep;
		   	$telefone = $Produtor->telefone;
		   	$celular = $Produtor->celular;
		   	$email = $Produtor->email;
			$idtecnico = $Produtor->idtecnico;	

$arr_campo = array( "nomeprodutor", "cpfcnpj","rg","orgaoexpedidor","rguf","endereco","municipio","uf","cep","telefone","celular","email","nometecnico"); 
$arr_coluna = array( "Produtor", "CPF/CNPJ","RG","Orgão Exped","RG UF","Endereco","Municipio","UF","CEP","Telefone","Celular","Email","Técnico"); 


$clRel = new Excel();

$clRel->conn = $conn;
$clRel->sql = $sql;
$clRel->campos = $arr_campo;
$clRel->coluna = $arr_coluna;
$clRel->arquivo = "relprodutor.xls";
$clRel->imprime();

?>
