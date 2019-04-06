<?php
class Municipio	
{
	var $conn;
	var $idmunicipio;
	var $municipio;
	var $idestado;

	function incluir()
	{
 		$sql = "insert into municipio (municipio,idestado) values (
									'".$this->municipio."','".$this->idestado."')";
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
       $sql = "update municipio set municipio = '".$this->municipio."', idestado = '".$this->idestado."' where idmunicipio='".$id."' ";
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
		$sql = "delete from municipio where idmunicipio = '".$id."' ";
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
		   	$this->idmunicipio = $row['idmunicipio'];
		   	$this->municipio = $row['municipio'];
		   	$this->idestado = $row['idestado'];
	}
	
	
	function listaCombo($nomecombo,$id,$refresh)
	{
	   	$sql = "select * from municipio order by municipio ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione a municipio</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idmunicipio'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idmunicipio']."' ".$s." >".$row['municipio']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from municipio where idmunicipio = '.$id;
		
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
		$sql = "select count(*) from municipio " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>