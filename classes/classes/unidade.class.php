<?php
class Unidade	
{
	var $conn;
	var $idunidade;
	var $unidade;

	function incluir()
	{
 		$sql = "insert into unidade (unidade) values (
									'".$this->unidade."')";
		$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	    	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function alterar($id)
	{
       $sql = "update unidade set unidade = '".$this->unidade."' where idunidade='".$id."' ";
	   $resultado = @pg_exec($this->conn,$sql);
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
		$sql = "delete from unidade where idunidade = '".$id."' ";
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
		   	$this->idunidade = $row['idunidade'];
		   	$this->unidade = $row['unidade'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from unidade where idunidade = idunidade ";
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by unidade';
		$res = pg_exec($this->conn,$sql);
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione a unidade</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idunidade'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idunidade']."' ".$s." >".$row['unidade']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from unidade where idunidade = '.$id;
		
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
		$sql = "select count(*) from unidade " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	
}
?>