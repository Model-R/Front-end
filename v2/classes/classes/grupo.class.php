<?php
class Grupo	
{
	var $conn;
	var $idgrupo;
	var $grupo;

	function incluir()
	{
 		$sql = "insert into grupo (idgrupo,grupo) values (
									'".$this->idgrupo."','".$this->grupo."')";
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
       $sql = "update grupo set grupo = '".$this->grupo."' where idgrupo='".$id."' ";
	   $resultado =pg_exec($this->conn,$sql);
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
		$sql = "delete from grupo where idgrupo = '".$id."' ";
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
		   	$this->idgrupo = $row['idgrupo'];
		   	$this->grupo = $row['grupo'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from grupo where idgrupo = idgrupo ";
		$res = pg_exec($this->conn,$sql);
		
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by grupo ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o grupo</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idgrupo'])
			{
			   $s = "selected";
			}
		      $html.="<option value='".$row['idgrupo']."' ".$s." >".$row['grupo']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from grupo where idgrupo = '.$id;
		
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
		$sql = "select count(*) from grupo " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	
}
?>