<?php
class UnidadeMedida	
{
	var $conn;
	var $idunidademedida;
	var $unidademedida;
	var $siglaunidademedida;
	var $tipounidademedida;

	function incluir()
	{
 		$sql = "insert into unidademedida (unidademedida,siglaunidademedida,tipounidademedida) values (
									'".$this->unidademedida."','".$this->siglaunidademedida."','".$this->tipounidademedida."')";
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
       $sql = "update unidademedida set unidademedida = '".$this->unidademedida."', siglaunidademedida = '".$this->siglaunidademedida."'
	   , tipounidademedida = '".$this->tipounidademedida."' where idunidademedida='".$id."' ";
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
		$sql = "delete from unidademedida where idunidademedida = '".$id."' ";
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
		   	$this->idunidademedida = $row['idunidademedida'];
		   	$this->unidademedida = $row['unidademedida'];
		   	$this->siglaunidademedida = $row['siglaunidademedida'];
		   	$this->tipounidademedida = $row['tipounidademedida'];
	}
	
	function listaCombo($nomecombo,$id,$tipo,$mostrasigla='S',$refresh='N',$classe)
	{
	   	$sql = "select * from unidademedida where idunidademedida = idunidademedida ";
		$res = pg_exec($this->conn,$sql);
		if ($tipo == 'A')
		{
			//$sql .= " and tipounidademedida = 'A'";
		}

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by unidademedida ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione a unidade de medida</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idunidademedida'])
			{
			   $s = "selected";
			}
		   if ($mostrasigla=='S')
		   {
		      $html.="<option value='".$row['idunidademedida']."' ".$s." >".$row['siglaunidademedida']."</option> ";
		   }
		   else
		   {
		      $html.="<option value='".$row['idunidademedida']."' ".$s." >".$row['unidademedida']."</option> ";
           }
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from unidademedida where idunidademedida = '.$id;
		
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
		$sql = "select count(*) from unidademedida " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	
}
?>