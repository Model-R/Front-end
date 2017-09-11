<?php //error_reporting(E_ALL);
//ini_set("display_errors", 1);

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: https://modelr.jbrj.gov.br');
require_once('../classes/conexao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

if (isset($_REQUEST['op']))
{
	$op=$_REQUEST['op'];
	$id=$_REQUEST['id'];
	$idresulttype=$_REQUEST['idresulttype'];
	
/*
	1;"Partições"
	2;"Modelos Finais"
	3;"Essembles"
	4;"Outros"
*/	

	$file_tiff=$_REQUEST['file_tiff'];
	$file_png=$_REQUEST['file_png'];
	$partition=$_REQUEST['partition'];
	$algorithm=$_REQUEST['algorithm'];
	$tss=$_REQUEST['tss'];
	$auc=$_REQUEST['auc'];
	$sensitivity=$_REQUEST['sensitivity'];
	$equal_sens_spec=$_REQUEST['equal_sens_spec'];
	$prevalence=$_REQUEST['prevalence'];
	$no_omission=$_REQUEST['no_omission'];
	$spec_sens=$_REQUEST['spec_sens'];
	
	if (empty($partition))
	{
		$partition = 'null';
	}
	if (empty($tss))
	{
		$tss = 'null';
	}
	if (empty($auc))
	{
		$auc = 'null';
	}	
	if (empty($sensitivity))
	{
		$sensitivity = 'null';
	}	
	if (empty($equal_sens_spec))
	{
		$equal_sens_spec = 'null';
	}	
	if (empty($prevalence))
	{
		$prevalence = 'null';
	}	
	if (empty($no_omission))
	{
		$no_omission = 'null';
	}		
	if (empty($spec_sens))
	{
		$spec_sens = 'null';
	}	
	if ($op=='I')
	{
		$sql = "insert into modelr.experiment_result (
			idexperiment ,  idresulttype ,  file_tiff ,  file_png ,
		partition ,  algorithm ,  tss,  auc ,  sensitivity ,  equal_sens_spec ,
  prevalence ,  no_omission ,  spec_sens  ) values
  (".$id.",".$idresulttype.",'".$file_tiff."','".$file_png."',".$partition.",
  '".$algorithm."',".$tss.",".$auc.",".$sensitivity.",".$equal_sens_spec.",".$prevalence.",
  ".$no_omission.",".$spec_sens.");";
//		echo $sql;
	}
	
	if ($op=='E')
	{
		$sql.=" delete from modelr.experiment_result where idexperiment = ".$id;
	}

	$res = pg_exec($conn,$sql);

	if ($res)
	{
		if ($op=='I')
		{
			$msg='Adicionado com sucesso';
		}
		if ($op=='E')
		{
			$msg='Excluído com sucesso';
		}
	}
	else
	{
		if ($op=='I')
		{
			$msg='Não foi possível adicionar';
		}
		if ($op=='E')
		{
			$msg='Não foi possível excluir';
		}
	}
	$json_str = utf8_decode('{"experiment":[{"id":"'.$id.'","op": "'.$op.'","msg": "'.$msg.'"}]}');
}
	echo $json_str;
?>