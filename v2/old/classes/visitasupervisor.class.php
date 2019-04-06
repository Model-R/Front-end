<?php
class VisitaSupervisor
{
	var $conn;
	var $idvisitasupervisor;
	var $idpropriedade;
	var $idsupervisor;
	var $datavisita;
	var $producaodia;
	var $nunvacaslactacao;
	var $numvacassecas;
	var $dataproximavisita;
	var $relatorio;
	var $configuracao; // instancia da classe configuracao;
	var $producaoinicial;
	var $dataentradaprojeto;

	function incluir()
	{
		if (empty($this->datavisita))
		{	
			$this->datavisita = 'null';
		}
		else
		{
			$this->datavisita = "'".$this->datavisita ."'";
		}
		if (empty($this->producaodia))
		{	
			$this->producaodia = 'null';
		}
		if (empty($this->nunvacaslactacao))
		{	
			$this->nunvacaslactacao = 'null';
		}
		if (empty($this->numvacassecas))
		{	
			$this->numvacassecas = 'null';
		}
		if (empty($this->dataproximavisita))
		{	
			$this->dataproximavisita = 'null';
		}
		else
		{
			$this->dataproximavisita = "'".$this->dataproximavisita ."'";
		}


 		$sql = "insert into visitasupervisor (idpropriedade,idsupervisor,datavisita,producaodia,numvacaslactacao,
		numvacassecas,dataproximavisita,relatorio) values (
									".$this->idpropriedade.",".$this->idsupervisor.",".$this->datavisita.",
									".$this->producaodia.",".$this->nunvacaslactacao.",".$this->numvacassecas."
									,date ".$this->datavisita." + integer '120','".$this->relatorio."')";
	//	echo $sql;
		$resultado = pg_exec($this->conn,$sql);
//		exit;
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
		if (empty($this->datavisita))
		{	
			$this->datavisita = 'null';
		}
		else
		{
			$this->datavisita = "'".$this->datavisita ."'";
		}

		if (empty($this->producaodia))
		{	
			$this->producaodia = 'null';
		}
		if (empty($this->nunvacaslactacao))
		{	
			$this->nunvacaslactacao = 'null';
		}
		if (empty($this->numvacassecas))
		{	
			$this->numvacassecas = 'null';
		}
		if (empty($this->dataproximavisita))
		{	
			$this->dataproximavisita = 'null';
		}
		else
		{
			$this->dataproximavisita = "'".$this->dataproximavisita."'";
		}

       $sql = "update visitasupervisor set idpropriedade = ".$this->idpropriedade.",idsupervisor= ".$this->idsupervisor.",datavisita = ".$this->datavisita.",
	   producaodia = ".$this->producaodia.",numvacaslactacao = ".$this->nunvacaslactacao.",numvacassecas = ".$this->numvacassecas."
	   ,dataproximavisita = date ".$this->datavisita." + integer '120',relatorio = '".$this->relatorio."' where idvisitasupervisor=".$id." ";
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
		$sql = "delete from visitasupervisor where idvisitasupervisor = '".$id."' ";
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
		   	$this->idvisitasupervisor = $row['idvisitasupervisor'];
		   	$this->idpropriedade = $row['idpropriedade'];
		   	$this->idsupervisor = $row['idsupervisor'];
		   	$this->datavisita = $row['datavisita'];
		   	$this->producaodia = $row['producaodia'];
		   	$this->numvacaslactacao = $row['numvacaslactacao'];
		   	$this->numvacassecas = $row['numvacassecas'];
		   	$this->dataproximavisita = $row['dataproximavisita'];
		   	$this->relatorio = $row['relatorio'];
		   	if (!empty($row['dataentradaprojeto']))
			{
		   		$this->dataentradaprojeto = date('d/m/Y',strtotime($row['dataentradaprojeto']));
			}
			else
			{		   	
				$this->dataentradaprojeto = '';//$row['dataentradaprojeto'];
			}
		   	$this->producaoinicial = number_format($row['producaoinicial'],2,',','.');
	}
	

	function getVisitaById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from visitasupervisor, propriedade  where 
			visitasupervisor.idpropriedade = propriedade.idpropriedade and visitasupervisor.idvisitasupervisor = '.$id;
		
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
		$sql = "select count(*) from visitasupervisor " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>