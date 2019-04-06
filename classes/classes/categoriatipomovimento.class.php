<?php
class CategoriaTipoMovimento	
{
	var $conn;
	var $idcategoriatipomovimento;
	var $categoriatipomovimento;
	var $codigo;

	function incluir()
	{
 		$sql = "insert into categoriatipomovimento (categoriatipomovimento,codigo) values (
									'".$this->categoriatipomovimento."','".$this->codigo."')";
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
       $sql = "update categoriatipomovimento set categoriatipomovimento = '".$this->categoriatipomovimento."', codigo = '".$this->codigo."' where idcategoriatipomovimento='".$id."' ";
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
		$sql = "delete from categoriatipomovimento where idcategoriatipomovimento = '".$id."' ";
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
		   	$this->idcategoriatipomovimento = $row['idcategoriatipomovimento'];
		   	$this->categoriatipomovimento = $row['categoriatipomovimento'];
		   	$this->codigo = $row['codigo'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N')
	{
	   	$sql = "select * from categoriatipomovimento where idcategoriatipomovimento = idcategoriatipomovimento ";
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by categoriatipomovimento ';
		$res = pg_exec($this->conn,$sql);
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 180px;'>";
		$html .= "<option value=''>Selecione a categoria</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idcategoriatipomovimento'])
			{
			   $s = "selected";
			}
		      $html.="<option value='".$row['idcategoriatipomovimento']."' ".$s." >".$row['categoriatipomovimento']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from idcategoriatipomovimento where ididcategoriatipomovimento = '.$id;
		
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
		$sql = "select count(*) from idcategoriatipomovimento " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	
}
?>