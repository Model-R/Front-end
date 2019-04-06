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
select * from propriedade prop left join tecnico t on prop.idtecnico = t.idtecnico 
left join produtor prod on prop.idprodutor = prod.idprodutor
left join unidademedida um on prop.idunidademedida = um.idunidademedida
,
programa p, situacaopropriedade sp
where
prop.idsituacaopropriedade = sp.idsituacaopropriedade and
prop.idprograma = p.idprograma
 
";



//$sql = 'select * from usuario left join tecnico on usuario.idtecnico = tecnico.idtecnico order by sem_acentos(usuario.nome) ';

$idpropriedade = $Propriedade->idpropriedade;// = $row['idpropriedade'];
	$idprodutor = $Propriedade->idprodutor ;//= $row['idprodutor'];
		   	$nomepropriedade = 	   	$Propriedade->nomepropriedade ;//= $row['nomepropriedade'];
		   	$inscricaoestadual = $Propriedade->inscricaoestadual ;//= $row['inscricaoestadual'];
		   	$tecnicoresponsavel = $Propriedade->tecnicoresponsavel ;//= $row['tecnicoresponsavel'];
		   	$tamanho = $Propriedade->tamanho;// = $row['tamanho'];
		   	$idunidademedida = $Propriedade->idunidademedida;// = $row['idunidademedida'];
		   	$endereco = $Propriedade->endereco ;//= $row['endereco'];
		   	$municipio = $Propriedade->municipio;// = $row['municipio'];
		   	$uf = $Propriedade->uf ;//= $row['uf'];
		   	$latitude = $Propriedade->latitude ;//= $row['latitude'];
		   	$longitude = $Propriedade->longitude;// = $row['longitude'];
		   	$idsituacaopropriedade = $Propriedade->idsituacaopropriedade ;//= $row['idsituacaopropriedade'];
		   	$idtipoconsultoria = $Propriedade->idtipoconsultoria ;//= $row['idtipoconsultoria'];
			$idtecnico = $Propriedade->idtecnico;// = $row['idtecnico'];
			$dataentradaprojeto = $Propriedade->dataentradaprojeto;// = $row['dataentradaprojeto'];
			$empresacompradoraleite = $Propriedade->empresacompradoraleite;// = $row['empresacompradoraleite'];
			$producaoinicial = $Propriedade->producaoinicial ;//= $row['producaoinicial'];
			$idprograma = $Propriedade->idprograma;//= $row['idprograma'];	

$arr_campo = array( "nomepropriedade", "nomeprodutor","inscricaoestadual","tecnicoresponsavel","tamanho","siglaunidademedida",
"endereco","municipio","uf","latitude","longitude","situacaopropriedade","nometecnico","dataentradaprojeto",
"empresacompradoraleite","producaoinicial","programa"
); 
$arr_coluna = array( "Propriedade", "Produtor","Insc. Estadual","Técnico Resp.","Tamanho","Unid. Medida",
"Endereco","Municipio","UF","Latitude","Longitude","Situacao Propriedade","Técnico","Data entrada Proj.",
"Empresa compradora do leite","Prod. inicial","Programa"
); 
//$arr_coluna = array( "Produtor", "CPF/CNPJ","RG","Orgão Exped","RG UF","Endereco","Municipio","UF","CEP","Telefone","Celular","Email","Técnico"); 


$clRel = new Excel();

$clRel->conn = $conn;
$clRel->sql = $sql;
$clRel->campos = $arr_campo;
$clRel->coluna = $arr_coluna;
$clRel->arquivo = "relpropriedade.xls";
$clRel->imprime();

?>
