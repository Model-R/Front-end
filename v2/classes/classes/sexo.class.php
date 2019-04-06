<?php
class Sexo	
{
	var $conn;
	var $idsexo;
	var $sexo;

/*	function incluir()
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
*/	
	
	function getDados($row)
	{
		   	$this->idsexo = $row['idsexo'];
		   	$this->sexo = $row['sexo'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N')
	{
	   	$sql = "select * from sexo where idsexo = idsexo ";
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by sexo';
		$res = pg_exec($this->conn,$sql);
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 100px;'>";
		$html .= "<option value=''>Selecione o sexo</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idsexo'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idsexo']."' ".$s." >".$row['sexo']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from sexo where idsexo = '.$id;
		
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
		$sql = "select count(*) from sexo " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	
}
?>