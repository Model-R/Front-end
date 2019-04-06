<?php
class Funcionario		
{
	var $conn;
	var $idfuncionario;
	var $idsitio;
	var $iddepartamento;
	var $nome;
	var $idtitulo;
	var $numero;
	var $endereco;
	var $cep;
	var $telefone;
	var $celular;
	var $rg;
	var $foto;
	var $fotosrc;
	var $rgimagem;
	var $rgimagemsrc;
	
	var $dicionario;
	var $lang;

	function incluir()
	{
 		$sql = "insert into funcionario (idsitio,iddepartamento,nome,idtitulo,numero,endereco,cep,telefone,celular,rg,foto,fotosrc,rgimagem,rgimagemsrc) values (
									".$this->idsitio.",".$this->iddepartamento.",'".$this->nome."',".$this->idtitulo.",
									'".$this->numero."','".$this->endereco."','".$this->cep."','".$this->telefone."',
									'".$this->celular."','".$this->rg."','".$this->foto."','".$this->fotosrc."','".$this->rgimagem."','".$this->rgimagemsrc."')";
	

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
       $sql = "update funcionario set iddepartamento = ".$this->iddepartamento.",nome = '".$this->nome."',idtitulo= ".$this->idtitulo.",
	   numero= '".$this->numero."', endereco = '".$this->endereco."',cep= '".$this->cep."',telefone= '".$this->telefone."',celular= '".$this->celular."',
	   rg = '".$this->rg."', foto= '".$this->foto."',fotosrc='".$this->fotosrc."',rgimagem='".$this->rgimagem."',rgimagemsrc='".$this->rgimagemsrc."' where idfuncionario='".$id."';";
	   if (!empty($this->foto))
	   {
	   	  $sql.=" update funcionario set foto= '".$this->foto."',fotosrc='".$this->fotosrc."' where idfuncionario = '".$id."';";
	   }
	   if (!empty($this->rgimagem))
	   {
	   	  $sql.=" update funcionario set rgimagem='".$this->rgimagem."',rgimagemsrc='".$this->rgimagemsrc."' where idfuncionario = '".$id."';";
	   }

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
		$sql = "delete from funcionario where idfuncionario = '".$id."'; ";
//		$sql = "delete from subgrupo where idgrupo = '".$id."'; ";
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
		   	$this->idfuncionario = $row['idfuncionario'];
		   	$this->nome = $row['nome'];
		   	$this->idtitulo = $row['idtitulo'];
		   	$this->numero = $row['numero'];
		   	$this->endereco = $row['endereco'];
		   	$this->cep = $row['cep'];
		   	$this->telefone = $row['telefone'];
		   	$this->celular= $row['celular'];
		   	$this->rg = $row['rg'];
		   	$this->iddepartamento = $row['iddepartamento'];
		   	$this->idsitio = $row['idsitio'];
		   	$this->foto= $row['foto'];
		   	$this->fotosrc = $row['fotosrc'];
		   	$this->rgimagem = $row['rgimagem'];
		   	$this->rgimagemsrc = $row['rgimagemsrc'];
	}
		
		
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from funcionario where idfuncionario = '.$id;
		
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
		$sql = "select count(*) from funcionario " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>