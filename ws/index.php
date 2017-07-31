<?php 
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: https://modelr.jbrj.gov.br');
require_once('../classes/conexao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar(); 

$sql = 'select * from modelr.experiment left join modelr.partitiontype on
(experiment.idpartitiontype = partitiontype.idpartitiontype )
, modelr.statusexperiment 
where experiment.idstatusexperiment = statusexperiment.idstatusexperiment 
 ';

if (isset($_GET['id']))
{
	$id = intval($_GET['id']);
	$sql.=' and experiment.idexperiment = '.$id;
}

$res = pg_exec($conn,$sql);
$qtd = pg_num_rows($res);

$json_str = '{"experiment":[';
$c = 0;
while ($row = pg_fetch_array($res))
{
	$c++;
	$sql2 = 'select * from modelr.occurrence where idexperiment = '.$row['idexperiment'];
	$res2 = pg_exec($conn,$sql2);
	$qtd2 = pg_num_rows($res2);
	$c2 = 0;
	$json_str2='[';
	while ($row2 = pg_fetch_array($res2))
	{
		$c2++;
		if ($c2<$qtd2)
		{	
			$json_str2.='{"taxon":"'.$row2['taxon'].'", "lat":"'.$row2['lat'].'", "long": "'.$row2['long'].'", "idstatusoccurrence": "'.$row2['idstatusoccurrence'].'"},';
		}
		else
		{
				$json_str2.='{"taxon":"'.$row2['taxon'].'", "lat":"'.$row2['lat'].'", "long": "'.$row2['long'].'", "idstatusoccurrence": "'.$row2['idstatusoccurrence'].'"}';
		}
		
	}
	$json_str2 .=']';
	
	if ($c<$qtd)
	{	
		$json_str.='{"idexperiment":"'.md5($row['idexperiment']).'", "name":"'.$row['name'].'", "description": "'.$row['name'].'", "num_partition": "'.$row['num_partition'].'", "extent_model": "'.$row['extent_model'].'", "buffer": "'.$row['buffer'].'", "num_points": "'.$row['num_points'].'",  "tss": "'.$row['tss'].'", "statusexperiment": "'.$row['statusexperiment'].'","partitiontype": "'.$row['partitiontype'].'", "occurence": '.$json_str2.'},';
	}
	else
	{
		$json_str.='{"idexperiment":"'.md5($row['idexperiment']).'", "name":"'.$row['name'].'", "description": "'.$row['name'].'", "num_partition": "'.$row['num_partition'].'", "extent_model": "'.$row['extent_model'].'", "buffer": "'.$row['buffer'].'", "num_points": "'.$row['num_points'].'",  "tss": "'.$row['tss'].'", "statusexperiment": "'.$row['statusexperiment'].'","partitiontype": "'.$row['partitiontype'].'", "occurence": '.$json_str2.'}';
	}
}
$json_str .=']}';
echo $json_str;
?>