<?php
class Tecnico
{
	var $conn;
	var $idtecnico;
	var $nometecnico;
	var $matricula;
	var $email;
	var $telefone;
	var $celular;
	var $endereco;

	function incluir()
	{
 		$sql = "insert into tecnico (idtecnico,nometecnico,matricula,email,telefone,celular,endereco) values (
									(select max(idtecnico)+1 from tecnico),'".$this->nometecnico."','".$this->matricula."','".$this->email."','".$this->telefone."','".$this->celular."','".$this->endereco."')";
		$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	    	$sql = "select max(idtecnico) from tecnico";
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
       $sql = "update tecnico set nometecnico = '".$this->nometecnico."', matricula = '".$this->matricula."',email = '".$this->email."', telefone = '".$this->telefone."',celular = '".$this->celular."',endereco = '".$this->endereco."' where idtecnico='".$id."' ";
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
		$sql = "delete from tecnico where idtecnico = '".$id."' ";
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
		   	$this->idtecnico = $row['idtecnico'];
		   	$this->nometecnico = $row['nometecnico'];
		   	$this->matricula = $row['matricula'];
		   	$this->email = $row["email"];
		   	$this->telefone = $row['telefone'];
		   	$this->celular = $row['celular'];
		   	$this->endereco = $row['endereco'];
	}
	
	
	function listaCombo($nomecombo,$id,$refresh,$readonly='N',$classe,$idsindicato = '')
	{
	   	$sql = "select * from tecnico order by nometecnico ";
		
		if (!empty($idsindicato))
		{
			$sql = "select t.* from tecnico t,sindicatohastecnico sht where sht.idtecnico = t.idtecnico and
			sht.idsindicato = $idsindicato ";
		}
		
		
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o t&eacute;cnico</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idtecnico'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idtecnico']."' ".$s." >".$row['nometecnico']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getTecnicoByMatricula($matricula){
	   	$sql = "select * from tecnico where matricula = '".$matricula."'";
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

	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from tecnico where idtecnico = '.$id;
		
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

	function existeMatricula($matricula)
	{
		$sql = "select matricula from tecnico where matricula = '".$matricula."'" ;
		$result = pg_query($this->conn,$sql);
		if (pg_num_rows($result)>0)
		{
		 return true;
   		}
		else
		{
			return false;
		}
	}

	function conta()
	{
		$sql = "select count(*) from tecnico " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>