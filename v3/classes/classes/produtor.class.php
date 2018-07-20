<?php
class Produtor
{
	var $conn;
	var $idprodutor;
	var $nomeprodutor;
	var $cpfcnpj;
	var $rg;
	var $orgamexpedidor;
	var $rguf;
	var $endereco;
	var $municipio;
	var $uf;
	var $cep;
	var $telefone;
	var $celular;
	var $email;
	var $idtecnico;

	function incluir()
	{
	   if (!empty($this->idtecnico))
	   {
	   
	   $sql = 'select max(idprodutor)+1 from produtor where idtecnico = '.$this->idtecnico;
	   $res = pg_exec($this->conn,$sql);
	   $row = pg_fetch_array($res);
	   if (!empty($row[0]))
	   {
			$idprodutor = $row[0];
	   }
	   else
	   {
		   	$idprodutor = ($this->idtecnico * 1000) + 1;
	   }
	   
 		$sql = "insert into produtor (idprodutor,nomeprodutor,cpfcnpj,rg,orgaoexpedidor,rguf,endereco,municipio,uf,cep,telefone,celular,email,datacadastro,idtecnico) values (
									'".$idprodutor."'
									,'".$this->nomeprodutor."'
									,'".$this->cpfcnpj."'
									,'".$this->rg."'
									,'".$this->orgaoexpedidor."'
									,'".$this->rguf."'
									,'".$this->endereco."'
									,'".$this->municipio."'
									,'".$this->uf."'
									,'".$this->cep."'
									,'".$this->telefone."'
									,'".$this->celular."'
									,'".$this->email."',
									now()
									,".$this->idtecnico."
									)";
//									echo $sql;
		$resultado = pg_exec($this->conn,$sql);
	    } // if existe idtecnco
		if ($resultado){
			$sql = "select max(idprodutor) from produtor where idtecnico = ".$this->idtecnico;
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
	   
       $sql = "update produtor set nomeprodutor = '".$this->nomeprodutor."'
	   							,cpfcnpj = '".$this->cpfcnpj."'
	   							,rg = '".$this->rg."'
	   							,orgaoexpedidor = '".$this->orgaoexpedidor."'
	   							,rguf = '".$this->rguf."'
	   							,endereco = '".$this->endereco."'
	   							,municipio = '".$this->municipio."'
	   							,uf = '".$this->uf."'
	   							,cep = '".$this->cep."'
	   							,telefone = '".$this->telefone."'
	   							,celular = '".$this->celular."'
	   							,email = '".$this->email."'
								,dataultimaalteracao = now()
								,idtecnico = ".$this->idtecnico." 
								
	    where idprodutor='".$id."' ";
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
		$sql = "delete from produtor where idprodutor = '".$id."' ";
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
		   	$this->idprodutor = $row['idprodutor'];
		   	$this->nomeprodutor = $row['nomeprodutor'];
		   	$this->cpfcnpj = $row['cpfcnpj'];
		   	$this->rg = $row['rg'];
		   	$this->orgaoexpedidor= $row['orgaoexpedidor'];
		   	$this->rguf = $row['rguf'];
		   	$this->endereco = $row['endereco'];
		   	$this->municipio = $row['municipio'];
		   	$this->uf = $row['uf'];
		   	$this->cep = $row['cep'];
		   	$this->telefone = $row['telefone'];
		   	$this->celular = $row['celular'];
		   	$this->email = $row['email'];
			$this->idtecnico = $row['idtecnico'];
	}
	
	
	function listaCombo($nomecombo,$id,$refresh,$idtecnico = '',$classe,$idsindicato)
	{
	   	$sql = "select * from produtor where idprodutor = idprodutor ";
		if (!empty($idtecnico))
		{
			$sql.=' and idtecnico = '.$idtecnico;
		}

		if (!empty($idsindicato))
		{
			$sql = "select prod.* from produtor prod, sindicatohastecnico sht where prod.idprodutor = prod.idprodutor and
sht.idtecnico = prod.idtecnico and
			sht.idsindicato = $idsindicato ";
		}
		


		$sql.= "order by nomeprodutor ";
		
		//echo $sql;
		
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o Produtor</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idprodutor'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idprodutor']."' ".$s." >".$row['nomeprodutor']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	

	function getProdutorById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from produtor where idprodutor = '.$id;
		
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
	   	$sql = 'select * from produtor where idprodutor = '.$id;
		
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

	function listaProdutoresComProblema($idtecnico)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = "select * from produtor p where
((p.cpfcnpj = '' or
p.endereco = '' or
p.municipio = '' or
p.uf = '') or
(p.telefone = '' and p.celular='') ) and idtecnico = ".$idtecnico;
		
		$result = pg_exec($this->conn,$sql);
		$tabela = 'Produtores com dados incompletos:<br><table class="tab_cadrehov">
            <tr valign="top" class="tab_bg_2"> 
			<th width="35%">Nome Produtor</th>
			<th width="10%">CPF/CNPJ</th>
			<th width="30%">Endereço</th>
			<th width="10%">Municipio</th>
			<th width="20%">Telefone</th>
			</tr>';

		while ($row = pg_fetch_array($result))
		{
			$tabela .= '<tr class="tab_bg_1">
			<td><a href="cadprodutor.php?op=A&id='.$row['idprodutor'].'">'.utf8_decode($row['nomeprodutor']).'</a></td>
			<td>'.$row['cpfcnpj'].'</td>
			<td>'.utf8_decode($row['endereco']).'</td>
			<td>'.utf8_decode($row['municipio']).'</td>
			<td>'.$row['telefone'].'</td>
			</tr>'; 
		}
		$tabela.='</table>';
		echo $tabela;
	}


	function conta()
	{
		$sql = "select count(*) from produtor " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>