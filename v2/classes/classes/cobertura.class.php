<?php
class Cobertura
{
	var $conn;
	var $idcobertura;
	var $idanimal;
	var $datacobertura;
	var $idreprodutor;
	
	function incluir()
	{
 		$sql = "insert into cobertura (idanimal,datacobertura,idreprodutor) values (
									'".$this->idanimal."',".$this->datacobertura.",'".$this->idreprodutor."')";
		$resultado = pg_exec($this->conn,$sql);
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
       $sql = "update cobertura set idanimal = '".$this->idanimal."', datacobertura = ".$this->datacobertura.",idreprodutor = '".$this->idreprodutor."' where idcobertura='".$id."' ";
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
		$sql = "delete from cobertura where idcobertura = '".$id."' ";
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
		   	$this->idcobertura = $row['idcobertura'];
		   	$this->idanimal = $row['idanimal'];
		   	$this->datacobertura = $row['datacobertura'];
		   	$this->idreprodutor = $row["idreprodutor"];
		   	
	}
	
	
/*	function listaCombo($nomecombo,$id,$refresh)
	{
	   	$sql = "select * from tecnico order by nometecnico ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione o t&eacute;cnico</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idtecnico'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idtecnico']."' ".$s." >".$row['nometecnico']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
*/	

	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from cobertura where idcobertura = '.$id;
		
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
		$sql = "select count(*) from cobertura " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>