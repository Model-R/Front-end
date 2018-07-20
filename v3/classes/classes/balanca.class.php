<?php
class Balanca
{
	var $conn;
	var $idbalanca;
	var $idanimal;
	var $datapesagem;
	var $peso;
	
	function incluir()
	{
		$this->peso = str_replace(',','.',$this->peso);
 		$sql = "insert into balanca (idanimal,datapesagem,peso) values (
									'".$this->idanimal."','".$this->datapesagem."','".$this->peso."')";
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
    	$this->peso = str_replace(',','.',$this->peso);
       $sql = "update balanca set idanimal = '".$this->idanimal."', datapesagem = '".$this->datapesagem."',peso = '".$this->peso."' where idbalanca='".$id."' ";
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
		$sql = "delete from balanca where idbalanca = '".$id."' ";
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
		   	$this->idbalanca = $row['idbalanca'];
		   	$this->idanimal = $row['idanimal'];
		   	$this->datapesagem = $row['datapesagem'];
		   	$this->peso = $row["peso"];
		   	
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
	   	$sql = 'select * from balanca where idbalanca = '.$id;
		
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
		$sql = "select count(*) from balanca " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>