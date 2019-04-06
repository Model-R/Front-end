<?php
class StatusOccurrence	
{
	var $conn;
	var $idstatusoccurrence;
	var $statusoccurrence;
	var $usefull;

	function incluir()
	{
 		/*$sql = "insert into modelr.source (source
		) values (
		'".$this->source."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idsource) from modelr.source ";
			$res = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($res);
			return $row[0];
	   	}
	   	else
	   	{
	    	return false;
	   	}
		*/
	}
	
	function alterar($id)
	{
		/*
       $sql = "update modelr.source set 
	   source  = '".$this->source."' 
	   where idsource='".$id."' ";
	   $resultado = @pg_exec($this->conn,$sql);
       if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	   */
	}

	function excluir($id)
	{
		/*$sql = "delete from modelr.source where idsource = '".$id."' ";
	   	$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
		*/
	}
	
	
	function getDados($row)
	{
	   	$this->idstatusoccurrence = $row['idstatusoccurrence'];
	   	$this->statusoccurrence = $row['statusoccurrence'];
	   	$this->usefull = $row['usefull'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe,$filtro='')
	{
	   	$sql = "select * from modelr.statusoccurrence where idstatusoccurrence = idstatusoccurrence ";
		
		if (!empty($filtro))
		{
		 $sql.=" and idstatusoccurrence in (".$filtro.")  ";
		}
		$sql.=' order by statusoccurrence.statusoccurrence ';
		$res = pg_exec($this->conn,$sql);
		
		$s = '';
		if (!empty($refresh))
		{
			if ($refresh == 'S')
			{
				$s = " onChange='submit();'";
			}
			else
			{
				$s = $refresh;
			}
		}
		
		//echo $sql;
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Todos os registros</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idstatusoccurence'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idstatusoccurrence']."' ".$s." >".$row['statusoccurrence']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.statusoccurrence where idstatusoccurrence = '.$id;
		
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
		$sql = "select count(*) from modelr.statusoccurrence" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>