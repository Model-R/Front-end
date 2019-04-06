<?php
class Lactacao
{
	var $conn;
	var $idlactacao;
	var $idanimal;
	var $datacontrole;
	var $qtdlitros;
	var $periodo;
	
	function incluir()
	{
 		$sql = "insert into lactacao (idanimal,datacontrole,qtdlitros,periodo) values (
									'".$this->idanimal."','".$this->datacontrole."','".$this->qtdlitros."','".$this->periodo."')";
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
       $sql = "update lactacao set periodo = '".$this->periodo."', datacontrole = '".$this->datacontrole."',qtdlitros = '".$this->qtdlitros."' where idlactacao='".$id."' ";
	   $resultado = pg_exec($this->conn,$sql);
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
		$sql = "delete from lactacao where idlactacao = '".$id."' ";
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
		   	$this->idlactacao = $row['idlactacao'];
		   	$this->idanimal = $row['idanimal'];
		   	$this->datacontrole = $row['datacontrole'];
		   	$this->qtdlitros = $row["qtdlitros"];
		   	$this->periodo = $row["periodo"];
		   	
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
	   	$sql = 'select * from lactacao where idlactacao = '.$id;
		
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

	function ultimaLactacao($idanimal)
	{
		if (empty($idanimal)){
	    	$idanimal = 0;
	   	}
	   	$sql = 'select max(periodo) from lactacao where idanimal = '.$idanimal;
		$result = pg_exec($this->conn,$sql);
	    $row = pg_fetch_array($result);
		if (empty($row[0]))
		{
		   	return '1';//$row['periodo'];
		}
		else
		{
    		return $row[0];
		}
	}


	function conta()
	{
		$sql = "select count(*) from lactacao " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>