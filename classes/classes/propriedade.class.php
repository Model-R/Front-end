<?php
class Propriedade
{
	var $conn;
	var $idpropriedade;
	var $nomepropriedade;
	var $inscricaoestadual;
	var $idprodutor;
	var $tecnicoresponsavel;
	var $tamanho;
	var $idunidademedida;
	var $endereco;
	var $municipio;
	var $uf;
	var $latitude;
	var $longitude;
	var $idsituacaopropriedade;
	var $idtipoconsultoria;
	var $idtecnico;
	var $dataentradaprojeto;
	var $empresacompradoraleite;
	var $producaoinicial;
	var $idprograma;

	function incluir()
	{
		$this->idtecnico;
		
	   $sql = 'select max(idpropriedade)+1 from propriedade where idtecnico = '.$this->idtecnico;
	   $res = pg_exec($this->conn,$sql);
	   $row = pg_fetch_array($res);
	   if (!empty($row[0]))
	   {
			$idpropriedade = $row[0];
	   }
	   else
	   {
		   	$idpropriedade = ($this->idtecnico * 1000) + 1;
	   }
		

		if (empty($this->idprodutor))
		{	
			$this->idprodutor = 'null';
		}
		if (empty($this->latitude))
		{	
			$this->latitude = 'null';
		}
		else
		{
			$this->latitude = str_replace(',','.',$this->latitude);
		}
		if (empty($this->longitude))
		{	
			$this->longitude = 'null';
		}
		else
		{
			$this->longitude = str_replace(',','.',$this->longitude);
		}

		if (empty($this->idtipoconsultoria))
		{	
			$this->idtipoconsultoria = 'null';
		}
		if (empty($this->idsituacaopropriedade))
		{	
			$this->idsituacaopropriedade = 'null';
		}
		if (empty($this->tamanho))
		{	
			$this->tamanho= 'null';
		}
		else
		{
			$this->tamanho = str_replace(',','.',$this->tamanho);
		}


		if (empty($this->idunidademedida))
		{	
			$this->idunidademedida= 'null';
		}
		
		if (empty($this->dataentradaprojeto))
		{
			$this->dataentradaprojeto = 'null';
		}
		else
		{
			$dia = substr($this->dataentradaprojeto,0,2);
			$mes = substr($this->dataentradaprojeto,3,2);
			$ano = substr($this->dataentradaprojeto,6,4);
			$this->dataentradaprojeto = "'".$mes.'-'.$dia.'-'.$ano ."'";
			
		}
		
		

		if (empty($this->producaoinicial))
		{	
			$this->producaoinicial= 'null';
		}
		else
		{
			$this->producaoinicial = str_replace(',','.',$this->producaoinicial);
		}

		if (empty($this->idprograma))
		{	
			$this->idprograma= 'null';
		}
		if (empty($this->idsituacaopropriedade))
		{	
			$this->idsituacaopropriedade= 'null';
		}



 		$sql = "insert into propriedade (idpropriedade,nomepropriedade,inscricaoestadual,idprodutor,tecnicoresponsavel,tamanho,
		idunidademedida,endereco,municipio,uf,latitude,longitude,idtipoconsultoria,idtecnico,dataentradaprojeto,empresacompradoraleite,producaoinicial,idprograma,idsituacaopropriedade) values (
									'".$idpropriedade."'
									,'".$this->nomepropriedade."'
									,'".$this->inscricaoestadual."'
									,".$this->idprodutor."
									,'".$this->tecnicoresponsavel."'
									,".$this->tamanho."
									,".$this->idunidademedida."
									,'".$this->endereco."'
									,'".$this->municipio."'
									,'".$this->uf."'
									,".$this->latitude."
									,".$this->longitude."
									,".$this->idtipoconsultoria."
									,".$this->idtecnico."
									,".$this->dataentradaprojeto."
									,'".$this->empresacompradoraleite."'
									,".$this->producaoinicial."
									,".$this->idprograma."
									,".$this->idsituacaopropriedade."
									)";
								
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idpropriedade) from propriedade where idtecnico = ".$this->idtecnico;
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
		if (empty($this->idtecnico))
		{	
			$this->idtecnico = 'null';
		}

		if (empty($this->idprodutor))
		{	
			$this->idprodutor = 'null';
		}
		if (empty($this->latitude))
		{	
			$this->latitude = 'null';
		}
		else
		{
			$this->latitude = str_replace(',','.',$this->latitude);
		}


		if (empty($this->longitude))
		{	
			$this->longitude = 'null';
		}
		else
		{
			$this->longitude = str_replace(',','.',$this->longitude);
		}

		if (empty($this->idtipoconsultoria))
		{	
			$this->idtipoconsultoria = 'null';
		}
		if (empty($this->idsituacaopropriedade))
		{	
			$this->idsituacaopropriedade = 'null';
		}

		if (empty($this->tamanho))
		{	
			$this->tamanho= 'null';
		}
		else
		{
			$this->tamanho = str_replace(',','.',$this->tamanho);
		}

		if (empty($this->idunidademedida))
		{	
			$this->idunidademedida= 'null';
		}
		if (empty($this->dataentradaprojeto))
		{
			$this->dataentradaprojeto = 'null';
		}
		else
		{
			$dia = substr($this->dataentradaprojeto,0,2);
			$mes = substr($this->dataentradaprojeto,3,2);
			$ano = substr($this->dataentradaprojeto,6,4);
			$this->dataentradaprojeto = "'".$mes.'-'.$dia.'-'.$ano ."'";
//			$this->dataentradaprojeto = "'".$this->dataentradaprojeto."'";
		}

		if (empty($this->producaoinicial))
		{	
			$this->producaoinicial= 'null';
		}
		else
		{
			$this->producaoinicial = str_replace(',','.',$this->producaoinicial);
		}

		if (empty($this->idprograma))
		{	
			$this->idprograma= 'null';
		}

		if (empty($this->idsituacaopropriedade))
		{	
			$this->idsituacaopropriedade= 'null';
		}


       $sql = "update propriedade set nomepropriedade = '".$this->nomepropriedade."'
	   				,inscricaoestadual = '".$this->inscricaoestadual."'
					,idprodutor = ".$this->idprodutor."
					,tecnicoresponsavel = '".$this->tecnicoresponsavel."'
					,tamanho= ".$this->tamanho."
					,idunidademedida = ".$this->idunidademedida."
					,endereco = '".$this->endereco."'
					,municipio = '".$this->municipio."'
					,uf = '".$this->uf."'
					,latitude = ".$this->latitude."
					,longitude = ".$this->longitude."
					,idsituacaopropriedade = ".$this->idsituacaopropriedade."
					,idtipoconsultoria = ".$this->idtipoconsultoria."
					,idtecnico = ".$this->idtecnico."
					,dataentradaprojeto = ".$this->dataentradaprojeto."
					,empresacompradoraleite= '".$this->empresacompradoraleite."'
					,producaoinicial= ".$this->producaoinicial."
					,idprograma= ".$this->idprograma."
					
					 where idpropriedade='".$id."' ";
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
		$sql = "delete from propriedade where idpropriedade = '".$id."' ";
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
			
		   	$this->idpropriedade = $row['idpropriedade'];
		   	$this->nomepropriedade = $row['nomepropriedade'];
		   	$this->inscricaoestadual = $row['inscricaoestadual'];
		   	$this->idprodutor = $row['idprodutor'];
		   	$this->tecnicoresponsavel = $row['tecnicoresponsavel'];
		   	$this->tamanho = $row['tamanho'];
		   	$this->idunidademedida = $row['idunidademedida'];
		   	$this->endereco = $row['endereco'];
		   	$this->municipio = $row['municipio'];
		   	$this->uf = $row['uf'];
		   	$this->latitude = $row['latitude'];
		   	$this->longitude = $row['longitude'];
		   	$this->idsituacaopropriedade = $row['idsituacaopropriedade'];
		   	$this->idtipoconsultoria = $row['idtipoconsultoria'];
			$this->idtecnico = $row['idtecnico'];
			$this->dataentradaprojeto = $row['dataentradaprojeto'];
			$this->empresacompradoraleite = $row['empresacompradoraleite'];
			$this->producaoinicial = $row['producaoinicial'];
			$this->idprograma= $row['idprograma'];
			
	}
	
	
	function listaCombo($nomecombo,$id,$idprodutor,$refresh,$idtecnico='',$classe,$idsindicato='')
	{
	   	$sql = "select * from propriedade,produtor where propriedade.idprodutor = produtor.idprodutor ";
		if (!empty($idprodutor))
		{
			$sql.=' and propriedade.idprodutor = '.$idprodutor;
		}
		if (!empty($idtecnico))
		{
			$sql.=' and propriedade.idtecnico = '.$idtecnico;
		}
		
		if (!empty($idsindicato))
		{
			$sql = "select prop.*, produtor.* from propriedade prop,produtor, sindicatohastecnico sht where
			prop.idprodutor = produtor.idprodutor and
sht.idtecnico = prop.idtecnico and
			sht.idsindicato = $idsindicato ";
		}
		
		
		$sql.=' order by upper(sem_acentos(nomepropriedade)) ';
		$res = pg_exec($this->conn,$sql);
		$s = '';
		//echo $sql;
		
		
		
		
		
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o propriedade</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idpropriedade'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idpropriedade']."' ".$s." >".$row['nomepropriedade'].' ('.$row['nomeprodutor'].")</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	

	function listaPropriedadesComProblema($idtecnico)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = "select * from propriedade p where
((p.tamanho is null) or
(p.endereco = '') or
(p.inscricaoestadual = '') or
(p.municipio = '') or
(p.tecnicoresponsavel = '') or
(p.producaoinicial is null)
) and idtecnico = ".$idtecnico;
		
		$result = pg_exec($this->conn,$sql);
		$tabela = 'Propriedades com dados incompletos:<br><table class="tab_cadrehov">
            <tr valign="top" class="tab_bg_2"> 
			<th width="35%">Nome Propriedade</th>
			<th width="10%">Inscrição Estadual</th>
			<th width="30%">Endereço</th>
			<th width="10%">Municipio</th>
			<th width="20%">Técnico Responsável</th>
			<th width="20%">Produção inicial<br>Projeto</th>
			</tr>';

		while ($row = pg_fetch_array($result))
		{
			$tabela .= '<tr class="tab_bg_1">
			<td><a href="cadpropriedade.php?op=A&id='.$row['idpropriedade'].'">'.utf8_decode($row['nomepropriedade']).'</a></td>
			<td>'.$row['inscricaoestadual'].'</td>
			<td>'.utf8_decode($row['endereco']).'</td>
			<td>'.utf8_decode($row['municipio']).'</td>
			<td>'.utf8_decode($row['tecnicoresponsavel']).'</td>
			<td>'.$row['producaoinicial'].' litros</td>
			</tr>'; 
		}
		$tabela.='</table>';
		echo $tabela;
	}

	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from propriedade where idpropriedade = '.$id;
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
		$sql = "select count(*) from propriedade " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>