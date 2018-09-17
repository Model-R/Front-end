<?php
class TipoMovimento	
{
	var $conn;
	var $idtipomovimento;
	var $tipomovimento;
	var $idcategoriatipomovimento;
	var $codigo;
	var $idunidade;

	function incluir()
	{
 		$sql = "insert into tipomovimento (tipomovimento,idcategoriatipomovimento,codigo,idunidade) values (
									'".$this->tipomovimento."',".$this->idcategoriatipomovimento.",".$this->codigo.",'".$this->idunidade."')";
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
       $sql = "update tipomovimento set tipomovimento = '".$this->tipomovimento."', idcategoriatipomovimento = '".$this->idcategoriatipomovimento."'
	   , codigo = '".$this->codigo."', idunidade = '".$this->idunidade."' where idtipomovimento='".$id."' ";
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
		$sql = "delete from tipomovimento where idtipomovimento = '".$id."' ";
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
		   	$this->idtipomovimento = $row['idtipomovimento'];
		   	$this->tipomovimento = $row['tipomovimento'];
		   	$this->idcategoriatipomovimento = $row['idcategoriatipomovimento'];
		   	$this->codigo = $row['codigo'];
		   	$this->idunidade = $row['idunidade'];
	}
	
	function listaCombo($nomecombo,$id,$idcategoriatipomovimento,$refresh='N')
	{
	   	$sql = "select * from tipomovimento where idtipomovimento = idtipomovimento ";

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		if (!empty($idcategoriatipomovimento))
		{
			$sql.=' and idcategoriatipomovimento = '.$idcategoriatipomovimento;
		}
		$sql.=' order by tipomovimento ';
		$res = pg_exec($this->conn,$sql);
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 180px;'>";
		$html .= "<option value=''>Selecione a tipo movimento</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idtipomovimento'])
			{
			   $s = "selected";
			}
		      $html.="<option value='".$row['idtipomovimento']."' ".$s." >".$row['tipomovimento']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from tipomovimento where idtipomovimento = '.$id;
		
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
		$sql = "select count(*) from tipomovimento " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	
}
?>