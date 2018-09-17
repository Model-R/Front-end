<?php
class Sindicato	
{
	var $conn;
	var $idsindicato;
	var $sindicato;

	function incluir()
	{
 		$sql = "insert into sindicato (sindicato) values (
		'".$this->sindicato."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idsindicato) from sindicato ";
			$res = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($res);
			return $row[0];
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function alterar($id)
	{

       $sql = "update sindicato set 
	   sindicato = '".$this->sindicato."' 
	   where idsindicato='".$id."' ";
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
		$sql = "delete from sindicato where idsindicato = '".$id."' ";
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
	   	$this->idsindicato = $row['idsindicato'];
	   	$this->sindicato = $row['sindicato'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from sindicato  ";
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by sindicato ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o sindicato</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idsindicato'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idsindicato']."' ".$s." >".$row['sindicato']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from sindicato where idsindicato = '.$id;
		
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
		$sql = "select count(*) from sindicato" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>