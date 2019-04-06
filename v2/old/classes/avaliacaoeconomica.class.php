<?php
class AvaliacaoEconomica
{
	var $conn;

	function incluirTerra($idpropriedade,$ano,$idunidade,$quantidade,$valorunitario)
	{
		$sql = "delete from terra where idpropriedade=$idpropriedade and ano=$ano;"; 
		
		$sql.= "insert into terra (idpropriedade ,  ano ,  idunidademedida ,  quantidade ,  valorunitario )
		values ($idpropriedade ,  $ano ,  $idunidade ,  $quantidade ,  $valorunitario) ;";
		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	    	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	function incluirEquipamento($idpropriedade,$ano,$idcategoriamaquina,$vidautil,$valor)
	{
		$sql = "delete from maquina where idpropriedade=$idpropriedade and ano=$ano and idcategoriamaquina=$idcategoriamaquina;"; 

		$sql .= "insert into maquina (idpropriedade ,  ano ,  idcategoriamaquina ,  vidautil ,  valor )
		values ($idpropriedade ,  $ano ,  $idcategoriamaquina ,  $vidautil ,  $valor) ;";
		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	    	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	
	 
	function incluirInstalacao($idpropriedade,$ano,$idcategoriainstalacao,$vidautil,$valor)
	{
		$sql = "delete from instalacao where idpropriedade=$idpropriedade and ano=$ano and idcategoriainstalacao=$idcategoriainstalacao;"; 

		$sql .= "insert into instalacao (idpropriedade ,  ano ,  idcategoriainstalacao ,  vidautil ,  valor )
		values ($idpropriedade ,  $ano ,  $idcategoriainstalacao ,  $vidautil ,  $valor) ;";
		$resultado = pg_exec($this->conn,$sql);
       	
		if ($resultado){
	    	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	
	function incluirAnimal($idpropriedade,$ano,$idcategoriaanimal,$quantidade,$valorindividual)
	{
		$sql = "delete from animal where idpropriedade=$idpropriedade and ano=$ano and idcategoriaanimal=$idcategoriaanimal;"; 

		$sql .= "insert into animal (idpropriedade ,  ano ,  idcategoriaanimal ,  quantidade ,  valorindividual )
		values ($idpropriedade ,  $ano ,  $idcategoriaanimal ,  $quantidade ,  $valorindividual) ;";
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
		if (empty($this->idtecnico))
		{	
			$this->idtecnico = 'null';
		}
       $sql = "update avaliacao set avaliacao = '".$this->avaliacao."', idpropriedade = '".$this->idpropriedade."',anoreferencia = '".$this->anoreferencia."', idtecnico = ".$this->idtecnico."
	    where idavaliacao='".$id."' ";
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
		$sql = "delete from avaliacao where idavaliacao = '".$id."' ";
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
		   	$this->idavaliacao = $row['idavaliacao'];
		   	$this->avaliacao = $row['avaliacao'];
		   	$this->idpropriedade = $row['idpropriedade'];
		   	$this->idprodutor = $row['idprodutor'];
		   	$this->anoreferencia = $row["anoreferencia"];
			$this->idtecnico = $row['idtecnico'];
	}
	
	function listaAnosAnteriores($idavaliacao,$idcategoriatipomovimento,$idtipomovimento)
	{
		$sql = "select * from avaliacao where idpropriedade = (select idpropriedade from avaliacao a2 where
		a2.idavaliacao = $idavaliacao) and idavaliacao <> $idavaliacao ";
		$res = pg_exec($this->conn,$sql);
		$html = "<select name='cmboxanosanteriores' id = 'cmboxanosanteriores' onChange='carregaAnosAnteiores(".$idavaliacao.",".$idtipomovimento.",this.value);' style='width : 60px;'>";
		$html .= "<option value=''>Anos anteriores</Option>";
		while ($row = pg_fetch_array($res))
		{
		   $html.="<option value='".$row['anoreferencia']."' ".$s." >".$row['anoreferencia']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}

	function pegaAnosAnteriores($idavaliacao,$idcategoriatipomovimento,$idtipomovimento,$anoanterior)
	{
		$sql = "select * from movimento m, avaliacao a where
m.idavaliacao = a.idavaliacao and
a.idpropriedade = (select idpropriedade from avaliacao a2 where
a2.idavaliacao = $idavaliacao )
and a.idavaliacao <> $idavaliacao and
m.idtipomovimento = $idtipomovimento order by m.mes ";
		$res = pg_exec($this->conn,$sql);
		$html = "<table width='100%'><tr class='tab_bg_1'>";
		while ($row = pg_fetch_array($res))
		{
		   $html.="<td align='right' width='8%'>".number_format($row['valor'],'2',',','.')."</td> ";
	    }
		$html.="<td align='center' width='28px'>";
		$html .= '</tr></table>';
		return $html;	
	}

	
	function listaCombo($nomecombo,$id,$idpropriedade,$refresh,$idtecnico='')
	{
	   	$sql = "select * from avaliacao, propriedade, produtor where avaliacao.idpropriedade = propriedade.idpropriedade and propriedade.idprodutor = produtor.idprodutor ";
		$s = '';
		if (!empty($idpropriedade))
		{
			$sql.=' and  avaliacao.idpropriedade = '.$idpropriedade;
		}
		if (!empty($idtecnico))
		{
			$sql.=' and  avaliacao.idtecnico= '.$idtecnico;
		}

		$sql.=' order by propriedade.nomepropriedade';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$res = pg_exec($this->conn,$sql);
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione o acompanhamento</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idavaliacao'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idavaliacao']."' ".$s." >".$row['avaliacao']." (".$row['nomepropriedade']." - ".$row['anoreferencia'].") </option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	

	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from avaliacao a, propriedade p, produtor prod where
a.idpropriedade = p.idpropriedade and
p.idprodutor = prod.idprodutor and a.idavaliacao = '.$id;
		
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
		$sql = "select count(*) from avaliacao " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>