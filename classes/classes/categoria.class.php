<?php
class Categoria	
{
	var $conn;
	var $idcategoria;
	var $idgrupo;
	var $idsubgrupo;
	var $idunidade;
	var $categoria;
	var $codigo;
	var $tipo;
	var $resumida;

	function incluir()
	{
		if (empty($this->idunidademedida))
		{
			$this->idunidademedida = 'null';
		}
		$sql = "select max(idcategoria)+1 from categoria ";
	   	$resultado = @pg_exec($this->conn,$sql);
		$row = pg_fetch_array($resultado);
		$idcategoria = $row[0];
 		$sql = "insert into categoria (idcategoria,
		idgrupo,
		idsubgrupo,
		idunidade,
		categoria,
		tipo,
		codigo,
		resumida) values (
		'".$idcategoria."',
		'".$this->idgrupo."',
		'".$this->idsubgrupo."',
		'".$this->idunidade."',
		'".$this->categoria."',
		'".$this->tipo."',
		'".$this->codigo."',
		'".$this->resumida."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idprodutor) from produtor where idtecnico = ".$this->idtecnico;
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
		if (empty($this->idunidade))
		{
			$this->idunidade = 'null';
		}

       $sql = "update categoria set 
	   categoria = '".$this->categoria."', 
	   idgrupo = '".$this->idgrupo."', 
	   idsubgrupo = '".$this->idsubgrupo."', 
	   idunidade = '".$this->idunidade."', 
	   tipo = '".$this->tipo."', 
	   codigo = '".$this->codigo."' 
	   resumida = '".$this->resumida."' 
	   where idcategoria='".$id."' ";
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
		$sql = "delete from categoria where idcategoria = '".$id."' ";
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
	   	$this->idcategoria = $row['idcategoria'];
	   	$this->idgrupo = $row['idgrupo'];
	   	$this->idsubgrupo = $row['idsubgrupo'];
	   	$this->idunidade = $row['idunidade'];
	   	$this->categoria = $row['categoria'];
	   	$this->codigo = $row['codigo'];
	   	$this->tipo = $row['tipo'];
	   	$this->resumida = $row['resumida'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from categoria  ";
		if (!empty($idtipocapital))
		{
			$sql.=' where idcategoria = '.$idtipocapital;
		}
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by categoria ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione a categoria</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idcategoria'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idcategoria']."' ".$s." >".$row['categoria']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from categoria where idcategoria = '.$id;
		
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
		$sql = "select count(*) from categoria" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>