<?php
class Estado	
{
	var $conn;
	var $idestado;
	var $estado;
	var $uf;

	function incluir()
	{
 		$sql = "insert into escolaridade (estado,uf) values (
									'".$this->estado."','".$this->uf."')";
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
       $sql = "update estado set estado = '".$this->estado."', uf = '".$this->uf."' where idestado='".$id."' ";
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
		$sql = "delete from estado where idestado = '".$id."' ";
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
		   	$this->idestado = $row['idestado'];
		   	$this->estado = $row['estado'];
		   	$this->uf = $row['uf'];
	}
	
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from estado order by estado ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classe.">";
		$html .= "<option value=''>Selecione a estado</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idestado'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idestado']."' ".$s." >".$row['estado']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	function listaComboUF($nomecombo,$UF,$refresh='N',$classe)
	{
	   	$sql = "select * from estado order by estado ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione a estado</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($UF == $row['uf'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['uf']."' ".$s." >".$row['estado']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}

	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from estado where idestado = '.$id;
		
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
		$sql = "select count(*) from estado " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>