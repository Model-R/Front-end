<?php
class Animal
{
	var $conn;
	var $idavaliacao;
	var $idanimal;
	var $nome;
	var $tipoanimal;
	var $datanascimento;
	var $nomemae;
	var $nomepai;
	var $idporteanimal;
	var $idpai;
	var $idmae;
	
	function incluir()
	{
		if (!empty($this->datanascimento))
		{
			$this->datanascimento = "'".$this->datanascimento."'";
		}
		else
		{
			$this->datanascimento = '';
		}
		if (empty($this->idporteanimal))
		{
			$this->idporteanimal = 'null';
		}
		if (empty($this->idpai))
		{
			$this->idpai = 'null';
		}
		if (empty($this->idmae))
		{
			$this->idmae = 'null';
		}
		
 		$sql = "
		insert into animal (nome,idtipoanimal,idavaliacao,datanascimento,nomemae,nomepai,idporteanimal,idpai,idmae) values (
									'".$this->nome."',".$this->idtipoanimal.",".$this->idavaliacao.",".$this->datanascimento.",'".$this->nomemae."','".$this->nomepai."',".$this->idporteanimal.",".$this->idpai.",".$this->idmae.")";
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
		if (!empty($this->datanascimento))
		{
			$this->datanascimento = "'".$this->datanascimento."'";
		}
		else
		{
			$this->datanascimento = '';
		}
		if (empty($this->idporteanimal))
		{
			$this->idporteanimal = 'null';
		}
		if (empty($this->idpai))
		{
			$this->idpai = 'null';
		}
		if (empty($this->idmae))
		{
			$this->idmae = 'null';
		}
       $sql = "update animal set idporteanimal = ".$this->idporteanimal.",idmae=".$this->idmae.",
	   idpai=".$this->idpai.",nomepai='".$this->nomepai."',nomemae='".$this->nomemae."',datanascimento=".$this->datanascimento.",
	   nome = '".$this->nome."',idtipoanimal= '".$this->idtipoanimal."' where idanimal='".$id."' ";
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
		$sql = "delete from animal where idanimal = '".$id."' ";
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
		   	$this->idanimal = $row['idanimal'];
		   	$this->idtipoanimal = $row['idtipoanimal'];
		   	$this->nome = $row['nome'];
		   	$this->idavaliacao = $row['idavaliacao'];
		   	$this->datanascimento = $row['datanascimento'];
		   	$this->nomemae= $row['nomemae'];
		   	$this->nomepai = $row['nomepai'];
		   	$this->idporteanimal = $row['idporteanimal'];
		   	$this->idpai = $row['idpai'];
		   	$this->idmae = $row['idmae'];
	}
	
	
	function listaComboReprodutor($nomecombo,$id,$refresh)
	{
	   	$sql = "select * from animal ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione o reprodutor</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idanimal'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idanimal']."' ".$s." >".$row['nome']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}

	function listaCombo($nomecombo,$id,$idpropriedade,$ano,$refresh)
	{
	   	$sql = "select * from rebanho where idpropriedade=".$idpropriedade." and ano=".$ano;
//		echo $sql;
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione a animal</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['numero'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['numero']."' ".$s.">".$row['numero']." - ".$row['nome']."</option>";
	    }
		$html .= '</select>';
		return $html;	
	}


	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from animal where idanimal = '.$id;
		
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
		$sql = "select count(*) from animal " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>