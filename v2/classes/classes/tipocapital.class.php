<?php
class TipoCapital	
{
	var $conn;
	var $idtipocapital;
	var $tipocapital;

	function incluir()
	{
 		$sql = "insert into tipocapital (tipocapital) values (
									'".$this->tipocapital."')";
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
       $sql = "update tipocapital set tipocapital = '".$this->tipocapital."' where idtipocapital='".$id."' ";
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
		$sql = "delete from tipocapital where idtipocapital = '".$id."' ";
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
		   	$this->idtipocapital = $row['idtipocapital'];
		   	$this->tipocapital = $row['tipocapital'];
		   
	}
	
	
	function listaCombo($nomecombo,$id,$refresh='N')
	{
	   	$sql = "select * from tipocapital  ";

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by tipocapital ';
		$res = pg_exec($this->conn,$sql);
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 200px;'>";
		$html .= "<option value=''>Selecione o tipo de capital</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idtipocapital'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idtipocapital']."' ".$s." >".$row['tipocapital']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from tipocapital where idtipocapital = '.$id;
		
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
		$sql = "select count(*) from tipocapital " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	
}
?>