<?php
class Funcao
{
	var $conn;
	function lista($nomecheck,$idusuario,$classe)
	{
		$html = '';
		$sql = "select * from funcao";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($this->temAcesso($idusuario,$row['idfuncao'])){
				$s = "checked";
			}
		   $html.="<input type=\"checkbox\" name='".$nomecheck."[]'  id='".$nomecheck."' value='".$row['idfuncao']."' ".$s." ".$classe.">".$row['funcao']."<br>";
		}
		return $html;
	}
	
	function removerAcesso($idusuario)
	{
	   	$sql = "delete from usuariohasfuncao where idusuario = '".$idusuario."' ";
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0){
	    	return true;
		}
		else
		{
	   		return false;
		}
	}
	function adicionarAcesso($idusuario,$idfuncao)
	{
		
	   	$sql = "insert into usuariohasfuncao (idusuariohasfuncao,idusuario,idfuncao) values ((select max(idusuariohasfuncao)+1 from usuariohasfuncao),".$idusuario.",".$idfuncao.") ";
		$res = pg_exec($this->conn,$sql);
	}

	function getFuncaoByNome($nomefuncao)
	{
		$sql = "select idfuncao from funcao where upper(funcao) = upper('".$nomefuncao."')";
		echo $sql;
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		return $row[0];
	}

	function temAcesso($idusuario,$idfuncao,$nomefuncao='')
	{
		
	    if (empty($idfuncao))
		{
			$idfuncao = $this->getFuncaoByNome($nomefuncao);
		}
	
	   	$sql = "select * from usuariohasfuncao where idusuario = '".$idusuario."' and idfuncao = '".$idfuncao."' ";
		//echo '<br/>'.$sql.'<br/>';
		//exit;
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0){
	    	return true;
		}
		else
		{
	   		return false;
		}
	}
}
?>
