<?php
class StatusOccurrence	
{
	var $conn;
	var $idstatusoccurence;
	var $statusoccurence;
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
	   	$this->idstatusoccurence = $row['idstatusoccurence'];
	   	$this->statusoccurence = $row['statusoccurence'];
	   	$this->usefull = $row['usefull'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.statusoccurence  ";
		
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
		$sql.=' order by statusoccurence ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o status</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idstatusoccurence'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idstatusoccurence']."' ".$s." >".$row['statusoccurence']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.statusoccurence where idstatusoccurence = '.$id;
		
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
		$sql = "select count(*) from modelr.statusoccurence" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>