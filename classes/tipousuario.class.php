<?php
class TipoUsuario	
{
	var $conn;
	var $idtipousuario;
	var $tipousuario;

	function incluir()
	{
 		$sql = "insert into modelr.tipousuario (tipousuario
		) values (
		'".$this->tipousuario."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idtipousuario) from modelr.tipousuario ";
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
		
       $sql = "update modelr.tipousuario set 
	   tipousuario  = '".$this->tipousuario."' 
	   where idtipousuario='".$id."' ";
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
		$sql = "delete from modelr.tipousuario where idtipousuario = '".$id."' ";
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
	   	$this->idtipousuario = $row['idtipousuario'];
	   	$this->tipousuario = $row['tipousuario'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.usertype  ";
		
		$res = pg_exec($this->conn,$sql);
		
		$s = '';
		if (!empty($refresh))
		{
			if ($refresh == 'S')
			{
				$s = " onChange='submit();'";
			}
			else
			{
				$s = $refresh;
			}
		}
		$sql.=' order by usertype ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o tipo de usuário</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idtipousuario'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idusertype']."' ".$s." >".$row['usertype']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.tipousuario where idtipousuario = '.$id;
		
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
		$sql = "select count(*) from modelr.tipousuario" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>