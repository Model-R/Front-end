<?php
//error_reporting(E_ALL);
//ini_set('display_errors','1');
class Experimento	
{
	var $conn;
	var $idexperiment;
	var $name;
	var $description;
	
	var $idpartitiontype ;//integer,
	var $num_partition ;//integer,
	var $num_points ;//integer,
	var $buffer ;//numeric(10,2),
	var $extent_model;
	var $extent_projection;
	var $tss;
	
	var $iduser;
	
	function incluirRaster($id,$idraster)
	{
		$sql = 'insert into modelr.experiment_use_raster (idexperiment,idraster)
		values ('.$id.','.$idraster.')';
//		echo $sql.'<br>';
		
		$res2 = pg_exec($this->conn,$sql);
	}
	
	function incluirAlgoritmo($id,$idalgoritmos)
	{
		$sql = 'insert into modelr.experiment_use_algorithm (idexperiment,idalgorithm)
		values ('.$id.','.$idalgoritmos.')';
		$res2 = pg_exec($this->conn,$sql);
	}
	
	function usaAlgoritmo($id,$idalgoritmos)
	{
		$sql = 'select * from modelr.experiment_use_algorithm where idexperiment = '.$id.' and idalgorithm = '.$idalgoritmos.';';
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}

	function usaRaster($id,$idraster)
	{
		$sql = 'select * from modelr.experiment_use_raster where idexperiment = '.$id.' and idraster = '.$idraster.';';
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}	
	
	function marcarpontosduplicados($idexperimento)
	{
		$sql = "select * from modelr.occurrence where idexperiment = $idexperimento order by idoccurrence";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{				
			$sql2 = "update modelr.occurrence set idstatusoccurrence=18 where idexperiment = $idexperimento and
			lat = ".$row['lat']." and
			long = ".$row['long']." and
			taxon = '".$row['taxon']."' and
			collector = '".$row['collector']."' and
			collectnumber = '".$row['collectnumber']."' and
			idoccurrence > ".$row['idoccurrence'];
//			echo $sql2;
//			echo ';<br>';
			$res2 = pg_exec($this->conn,$sql2);
		}
//		exit;
	}

	
	function excluirpontosduplicados($idexperimento)
	{
		$sql = "select * from modelr.occurrence where idexperiment = $idexperimento order by idoccurrence";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{				
			$sql2 = "delete from modelr.occurrence where idexperiment = $idexperimento and
			lat = ".$row['lat']." and
			long = ".$row['long']." and
			taxon = '".$row['taxon']."' and
			collector = '".$row['collector']."' and
			collectnumber = '".$row['collectnumber']."' and
			idoccurrence > ".$row['idoccurrence'];
//			echo $sql2;
//			echo ';<br>';
			$res2 = pg_exec($this->conn,$sql2);
		}
//		exit;
	}

	function excluirPonto($idexperimento,$idponto,$idstatus,$latinf,$longinf)
	{
		if (($idstatus == '17') || ($idstatus=='4'))
		{
			$sql = "update modelr.experiment set idstatusexperiment = 2 where idexperiment = ".$idexperimento;
			$res = pg_exec($this->conn,$sql);
		}
		
		$sql = "update modelr.occurrence set idstatusoccurrence = ".$idstatus; 
		if ((!empty($latinf)) && (!empty($longinf)))
		{
			$sql.= ", lat2 = ".$latinf.", long2 = ".$longinf." ";
		}
	
		$sql.="	where idoccurrence = $idponto";
		$res = pg_exec($this->conn,$sql);
	}
	function alterarstatusponto($idexperimento,$idponto,$idstatus)
	{
		$sql = "update modelr.occurrence set idstatusoccurrence = ".$idstatus." where idoccurrence = $idponto";
		$res = pg_exec($this->conn,$sql);
//		echo $sql;
//		exit;
	}

	function adicionarOcorrencia($idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$p,$e,$m)
	{
 		$sql = "insert into modelr.occurrence (idexperiment,
		iddatasource,
		lat,
		long,
		taxon,
		collector,
		collectnumber,
		server,
		path,
		file,
		idstatusoccurrence,
		country,
		majorarea,
		minorarea
		) values (
		'".$idexperimento."',
		'".$idfontedados."',
		".$lat.",
		".$long.",
		'".$taxon."',
		'".$coletor."',
		'".$numcoleta."',
		'".$imagemservidor."',
		'".$imagemcaminho."',
		'".$imagemarquivo."',
		8,
		'".$p."',
		'".$e."',
		'".$m."'
		)";
		// 8 status occurrence = OK
		$resultado = pg_exec($this->conn,$sql);
		
//		echo $sql;
//		exit;
		
		if ($resultado){

	   	}
	}
	
	function limparDados($idexperimento)
	{
		
 		$sql = "
		update modelr.experiment set idstatusexperiment = 1 where idexperiment = ".$idexperimento.";
		delete from modelr.occurrence where idexperiment = ".$idexperimento;
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	
	function incluir()
	{
		
 		$sql = "insert into modelr.experiment (name,description,iduser,idstatusexperiment
		) values (
		'".$this->name."',
		'".$this->description."',
		'".$this->iduser."',1
		)";
		
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idexperiment) from modelr.experiment";
			$res = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($res);
			return $row[0];
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function alterar($id)
	{
		//name  = '".$this->name."', 
	   //description = '".$this->description."' ,
	   
		//idpartitiontype = '".$this->idpartitiontype."',
//	   num_points = '".$this->num_points."',
	   
		
       $sql = "update modelr.experiment set 
	   num_partition = '".$this->num_partition."',
	   buffer = '".$this->buffer."',
	   extent_model = '".$this->extent_model."',
       idpartitiontype = '".$this->idpartitiontype."',
	   num_points = '".$this->num_points."',
	   tss = '".$this->tss."',
	   extent_projection = '".$this->extent_projection."'
	   where idexperiment='".$id."' ";
	   
	   $resultado = pg_exec($this->conn,$sql);
       
	   echo $sql;
	   exit;
	   if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	}

	function excluir($id)
	{
		$sql = "delete from modelr.experiment where idexperiment = '".$id."' ";
		
	   	$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	
	function getDados($row)
	{
	   	$this->idexperiment = $row['idexperiment'];
	   	//$this->idproject = $row['idproject'];
	   	$this->name = $row['name'];
	   	$this->description = $row['description'];
	   	$this->idpartitiontype = $row['idpartitiontype'];
	   	$this->num_partition = $row['num_partition'];
	   	$this->numpontos = $row['numpontos'];
	   	$this->buffer = $row['buffer'];
	   	$this->tss = $row['tss'];
		$this->num_points = $row['num_points'];
		$this->iduser = $row['iduser'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe,$idusuario='')
	{
	   	$sql = "select * from modelr.experiment, modelr.project  where experiment.idexperiment = experiment.idexperiment ";
		if (!empty($idusuario))
		{
			$sql.=' and experiment.iduser = '.$idusuario;
		}
			
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by name ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o experimento</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idexperimento'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idexperimento']."' ".$s." >".$row['name']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.experiment where idexperiment = '.$id;
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
	    	$row = pg_fetch_array($result);
		   	$this->getDados($row);
			return 1;
		}
		else
		{
    		return 0;
		}
	}


	function conta()
	{
		$sql = "select count(*) from modelr.experiment" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>