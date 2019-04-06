<?php
class Parto
{
	var $conn;
	var $idparto;
	var $idanimal;
	var $dataparto;
	
	function incluir()
	{
 		$sql = "insert into parto (idanimal,dataparto) values (
									'".$this->idanimal."','".$this->dataparto."')";
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
       $sql = "update parto set idanimal = '".$this->idanimal."', dataparto = '".$this->dataparto."'
	    where idparto='".$id."' ";
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
		$sql = "delete from parto where idparto = '".$id."' ";
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
		   	$this->idparto = $row['idparto'];
		   	$this->idanimal = $row['idanimal'];
		   	$this->dataparto = $row['dataparto'];
		   		
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
	   	$sql = 'select * from parto where idparto = '.$id;
		
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
		$sql = "select count(*) from parto " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>