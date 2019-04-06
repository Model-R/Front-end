<?php
class SubGrupo	
{
	var $conn;
	var $idgrupo;
	var $idsubgrupo;
	var $subgrupo;

	function incluir()
	{
 		$sql = "insert into grupo (idsubgrupo,idgrupo,subgrupo) values (
									'".$this->idsubgrupo."','".$this->idgrupo."','".$this->subgrupo."')";
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
       $sql = "update subgrupo set subgrupo = '".$this->subgrupo."',idgrupo = '".$this->idgrupo."' where idsubgrupo='".$id."' ";
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
		$sql = "delete from subgrupo where idsubgrupo = '".$id."' ";
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
		   	$this->idsubgrupo = $row['idsubgrupo'];
		   	$this->idgrupo = $row['idgrupo'];
		   	$this->subgrupo = $row['subgrupo'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from subgrupo where idsubgrupo = idsubgrupo ";
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by subgrupo ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o subgrupo</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idsubgrupo'])
			{
			   $s = "selected";
			}
		      $html.="<option value='".$row['idsubgrupo']."' ".$s." >".$row['subgrupo']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from subgrupo where idsubgrupo = '.$id;
		
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
		$sql = "select count(*) from subgrupo " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	
}
?>