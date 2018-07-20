<?php
class RemuneracaoCapital
{
	var $conn;
	var $idremuneracaocapital;
	var $idavaliacao;
	var $idcategoriacapital;
	var $taxajuros;
	var $quantidade;
	var $valorunitario;
	var $vidautil;

	function incluir()
	{
		if (empty($this->vidautil))
		{
		$this->vidautil = 'null';
		}
		$this->quantidade = str_replace(',','.',$this->quantidade);
 		$sql = "insert into remuneracaocapital (idavaliacao,idcategoriacapital,taxajuros,quantidade,valorunitario,vidautil) 
		values (".$this->idavaliacao.",".$this->idcategoriacapital.",".$this->taxajuros.",".$this->quantidade.",".$this->valorunitario.",".$this->vidautil.")";
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
		if (empty($this->vidautil))
		{
		$this->vidautil = 'null';
		}
		$this->quantidade = str_replace(',','.',$this->quantidade);
       $sql = "update remuneracaocapital set idavalicao = ".$this->idavaliacao.",idcategoriacapital = ".$this->idcategoriacapital.",taxajuros = ".$this->taxajuros.",
	   quantidade = ".$this->quantidade.",valorunitario = ".$this->valorunitario." where idremuneracaocapital=".$id." ";
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
		$sql = "delete from remuneracaocapital where idremuneracaocapital = '".$id."' ";
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
		   	$this->idremuneracaocapital = $row['idremuneracaocapital '];
		   	$this->idavaliacao = $row['idavaliacao'];
		   	$this->idcategoriacapital = $row['idcategoriacapital'];
		   	$this->taxajuros = $row['taxajuros'];
		   	$this->quantidade = $row['quantidade'];
		   	$this->valorunitario = $row['valorunitario'];
	}
	

	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from remuneracaocapital where idremuneracaocapital= '.$id;
		
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
		$sql = "select count(*) from remuneracaocapital " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>