<?php
class CategoriaTipoCapital	
{
	var $conn;
	var $idcategoriatipocapital;
	var $idtipocapital;
	var $categoriatipocapital;
	var $idunidademedida;

	function incluir()
	{
		if (empty($this->idunidademedida))
		{
			$this->idunidademedida = 'null';
		}
 		$sql = "insert into categoriatipocapital (categoriatipocapital,idtipocapital,idunidademedida) values (
									'".$this->categoriatipocapital."',".$this->idtipocapital.",".$this->idunidademedida.")";
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
		if (empty($this->idunidademedida))
		{
			$this->idunidademedida = 'null';
		}

       $sql = "update categoriatipocapital set categoriatipocapital = '".$this->categoriatipocapital."', idtipocapital = '".$this->idtipocapital."'
	   , idunidademedida = ".$this->idunidademedida." where idcategoriatipocapital='".$id."' ";
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
		$sql = "delete from categoriatipocapital where idcategoriatipocapital = '".$id."' ";
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
	   	$this->idcategoriatipocapital = $row['idcategoriatipocapital'];
	   	$this->idtipocapital = $row['idtipocapital'];
	   	$this->categoriatipocapital = $row['categoriatipocapital'];
	   	$this->idunidademedida = $row['idunidademedida'];
	}
	
	function listaCombo($nomecombo,$id,$idtipocapital,$refresh='N',$classe)
	{
	   	$sql = "select * from categoriatipocapital  ";
		if (!empty($idtipocapital))
		{
			$sql.=' where idtipocapital = '.$idtipocapital;
		}
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by categoriatipocapital ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione a categoria tipo capital</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idcategoriatipocapital'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idcategoriatipocapital']."' ".$s." >".$row['categoriatipocapital']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from categoriatipocapital where idcategoriatipocapital = '.$id;
		
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
		$sql = "select count(*) from categoriatipocapital" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>