<?php
class Movimento
{
	var $conn;
	var $idmovimento;
	var $idtipomovimento;
	var $idavaliacao;
	var $ano;
	var $mes;
	var $valor;

	function incluir()
	{
		if (empty($this->valor))
		{
			$this->valor = 'null';
		}
		else
		{
			$this->valor = str_replace(',','.',$this->valor);
		}
 		$sql = "insert into movimento (idtipomovimento,idavaliacao,ano,mes,valor) 
		values (".$this->idtipomovimento.",".$this->idavaliacao.",".$this->ano.",".$this->mes.",".$this->valor.")";
		//echo $sql;
		//exit;
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
		if (empty($this->valor))
		{
			$this->valor = 'null';
		}
       $sql = "update movimento set valor = ".$this->valor." where idmovimento=".$id." ";
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
		$sql = "delete from movimento where idmovimento = '".$id."' ";
	   	$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	function excluirAno($ano,$idavaliacao,$idtipomovimento)
	{
		$sql = "delete from movimento where ano = '".$ano."' and idavaliacao = '".$idavaliacao."' and idtipomovimento = '".$idtipomovimento."'";
	   	$resultado = pg_exec($this->conn,$sql);
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
		   	$this->idmovimento = $row['idmovimento'];
		   	$this->idtipomovimento = $row['idtipomovimento'];
		   	$this->idavaliacao = $row['idavaliacao'];
		   	$this->ano = $row['ano'];
		   	$this->mes = $row['mes'];
		   	$this->valor = $row['valor'];
	}

	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from movimento where idmovimento= '.$id;
		
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
		$sql = "select count(*) from movimento " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>