<?php
class PessoaJuridica
{
	var $conn;
	var $idpessoajuridica;

	var $nome;
	var $cnpj;
	var $sigla;
	var $idtipoparceiro;
	var $pessoacontato;
	var $cargocontato;
	var $tratamento;
	var $email;
	var $telefone;
	var $endereco;
	var $municipio;
	var $bairro;
	var $estado;
	var $cep;
	var $idbanco;
	var $codagencia;
	var $agenciadv;
	var $contacorrente;
	var $contacorrentedv;
	// papel = parceiro, patrocinador
	var $idpapel;

	function incluir()
	{
		if (empty($this->idtipoparceiro))
		{
			$this->idtipoparceiro = 'null';
		}
		if (empty($this->idbanco))
		{
			$this->idbanco= 'null';
		}
		if (empty($this->estado))
		{
			$this->estado= 'null';
		}
		$r = true;
 		$sql = "insert into pessoajuridica (nome,cnpj,sigla,pessoacontato,cargocontato,tratamento,email,
		telefone,endereco,municipio,bairro,estado,cep,codbanco,codagencia,agenciadv,contacorrente,contacorrentedv,idtipoparceiro) values (
									'".$this->nome."','".$this->cnpj."','".$this->sigla."','".$this->pessoacontato."','".$this->cargocontato."','".$this->tratamento."','".$this->email."',
									'".$this->telefone."','".$this->endereco."','".$this->municipio."','".$this->bairro."',".$this->estado.",'".$this->cep."',".$this->idbanco.",
									'".$this->codagencia."','".$this->agenciadv."','".$this->contacorrente."','".$this->contacorrentedv."',".$this->idtipoparceiro."
									);";
	//	echo $sql;
//		exit;
		$resultado = pg_exec($this->conn,$sql);
		if (!$resultado)
		{
			$r = false;
		}
		
		$sql3 = "select currval('pessoajuridica_idpessoajuridica_seq'); ";
		$res3 = pg_exec($this->conn,$sql3);
		$row3 = pg_fetch_array($res3);

		$sql3 = "insert into pessoajuridicapapel(idpessoajuridica,idclassificacaopessoajuridica) values (".$row3[0].",".$this->idpapel.");";
		$resultado3 = pg_exec($this->conn,$sql3);
		if (!$resultado3)
		{
			$r = false;
		}
    	return $r;
	}
	
	function alterar($id)
	{
		if (empty($this->idtipoparceiro))
		{
			$this->idtipoparceiro = 'null';
		}
		if (empty($this->idbanco))
		{
			$this->idbanco= 'null';
		}
		if (empty($this->estado))
		{
			$this->estado= 'null';
		}		
		$sql = "delete from pessoajuridicapapel where idpessoajuridica = '".$id."' and idclassificacaopessoajuridica = '".$this->idpapel."'";
		$resultado = pg_exec($this->conn,$sql);

		$sql3 = "insert into pessoajuridicapapel(idpessoajuridica,idclassificacaopessoajuridica) values (".$id.",".$this->idpapel.");";
		$resultado3 = pg_exec($this->conn,$sql3);

 		$sql = "insert into pessoajuridica (nome,cnpj,sigla,pessoacontato,cargocontato,tratamento,email,
		telefone,endereco,municipio,bairro,estado,cep,codbanco,codagencia,agenciadv,contacorrente,contacorrentedv,idtipoparceiro) values (
									'".$this->nome."','".$this->cnpj."','".$this->sigla."','".$this->pessoacontato."','".$this->cargocontato."','".$this->tratamento."','".$this->email."',
									'".$this->telefone."','".$this->endereco."','".$this->municipio."','".$this->bairro."',".$this->estado.",'".$this->cep."',".$this->idbanco.",
									'".$this->codagencia."','".$this->agenciadv."','".$this->contacorrente."','".$this->contacorrentedv."',".$this->idtipoparceiro."
									);";


       $sql = "update pessoajuridica set nome = '".$this->nome."', cnpj = '".$this->cnpj."', sigla = '".$this->sigla."', pessoacontato = '".$this->pessoacontato."',cargocontato = '".$this->cargocontato."', tratamento = '".$this->tratamento."',email = '".$this->email."',
	   telefone = '".$this->telefone."', endereco = '".$this->endereco."', municipio = '".$this->municipio."', bairro = '".$this->bairro."',estado = '".$this->estado."', cep = '".$this->cep."',codbanco = '".$this->idbanco."',
	   codagencia = '".$this->codagencia."', agenciadv = '".$this->agenciadv."', contacorrente = '".$this->contacorrente."', contacorrentedv = '".$this->contacorrentedv."',idtipoparceiro = '".$this->idtipoparceiro."' 
	   where idpessoajuridica='".$id."' ";
//	   echo $sql;
//	   exit;
	   $resultado = pg_exec($this->conn,$sql);
       if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	}

	function excluir($id,$idpapel)
	{
		$sql = "delete from pessoajuridicapapel where idpessoajuridica = '".$id."' and idclassificacaopessoajuridica = '".$idpapel."'";
		$resultado = pg_exec($this->conn,$sql);
	//	echo $sql;
	//	exit;

		$sql = "delete from pessoajuridica where idpessoajuridica = '".$id."' ";
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
		   	$this->idpessoajuridica = $row['idpessoajuridica'];
		   	$this->nome = $row['nome'];
	$this->nome =  $row['nome'];
	$this->cnpj=  $row['cnpj'];
	$this->sigla=  $row['sigla'];
	$this->idtipoparceiro=  $row['idtipoparceiro'];
	$this->pessoacontato=  $row['pessoacontato'];
	$this->cargocontato=  $row['cargocontato'];
	$this->tratamento=  $row['tratamento'];
	$this->email=  $row['email'];
	$this->telefone=  $row['telefone'];
	$this->endereco=  $row['endereco'];
	$this->municipio=  $row['municipio'];
	$this->bairro=  $row['bairro'];
	$this->estado=  $row['estado'];
	$this->cep=  $row['cep'];
	$this->idbanco=  $row['codbanco'];
	$this->codagencia=  $row['codagencia'];
	$this->agenciadv=  $row['agenciadv'];
	$this->contacorrente=  $row['contacorrente'];
	$this->contacorrentedv=  $row['contacorrentedv'];
	}
	
	
	function listaCombo($nomecombo,$id,$refresh)
	{
	   	$sql = "select * from pessoajuridica order by nome ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione a pessoa</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idpessoajuridica'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idpessoajuridica']."' ".$s." >".$row['nome']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}

	function listaCheckPatrocinador($nomecheck,$idconvenio)
	{
	   	$sql = "	select * from pessoajuridica pj, pessoajuridicapapel pjp where
					pj.idpessoajuridica = pjp.idpessoajuridica and
					pjp.idclassificacaopessoajuridica = 2
 				";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{
	   		$sql2 = "select * from conveniohaspatrocinador where idconvenio = $idconvenio and idpatrocinador = ".$row['idpessoajuridica'];
			//echo $sql2;
			$res2 = @pg_exec($this->conn,$sql2);
			if ($res2)
			{
				$s = '';
				while ($row2 = pg_fetch_array($res2))
				{
					$s = 'checked';
				}
			}
		
			$html .= '<input name="'.$nomecheck.'" type="checkbox" value="'.$row['idpessoajuridica'].'" '.$s.'>&nbsp;'.$row['nome'].'<br>';
	    }
		return $html;	
	}

	function listaCheckParceiro($nomecheck,$idplanejamentohasconvenio)
	{
	   	$sql = "	select * from pessoajuridica pj, pessoajuridicapapel pjp where
					pj.idpessoajuridica = pjp.idpessoajuridica and
					pjp.idclassificacaopessoajuridica = 1
 				";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{
	   		$sql2 = "select * from planejamentohasconveniohasparceiro where idplanejamentohasconvenio = $idplanejamentohasconvenio and idparceiro = ".$row['idpessoajuridica'];
			//echo $sql2;
			$res2 = @pg_exec($this->conn,$sql2);
			if ($res2)
			{
				$s = '';
				while ($row2 = pg_fetch_array($res2))
				{
					$s = 'checked';
				}
			}
		
			$html .= '<input name="'.$nomecheck.'[]" type="checkbox" value="'.$row['idpessoajuridica'].'" '.$s.'>&nbsp;'.$row['nome'].'<br>';
	    }
		return $html;	
	}




	function listaComboParceiro($nomecombo,$id,$refresh,$ano='')
	{
	   	$sql = "select * from pessoajuridica pj, pessoajuridicapapel pjp 
where pj.idpessoajuridica = pjp.idpessoajuridica and pjp.idclassificacaopessoajuridica = 1 
order by nome ";
		if (!empty($ano))
		{
			    $sql = "select pj.idpessoajuridica,pj.nome,
date_part('year',c.datainicio),count(*) 
from pessoajuridica pj, pessoajuridicapapel pjp, 
planejamentohasconveniohasparceiro phchp, planejamento p, planejamentohasconvenio phc, convenio c 
where pj.idpessoajuridica = pjp.idpessoajuridica and pjp.idclassificacaopessoajuridica = 1 and
phchp.idparceiro = pj.idpessoajuridica and phchp.idplanejamentohasconvenio = phc.idplanejamentohasconvenio 
and phc.idplanejamento = p.idplanejamento 
and phc.idconvenio = c.idconvenio and 
date_part('year',c.datainicio)=".$ano."  
group by 1,2,3
order by 2 ";
		}

		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione o parceiro</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idpessoajuridica'])
			{
			   $s = "selected";
			}
			$importadode='';
			if ($row['importadode']=='2010'){
			  $importadode = ' (<2010)';
			}
		   $html.="<option value='".$row['idpessoajuridica']."' ".$s." >".$row['nome'].$importadode."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	

	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from pessoajuridica where idpessoajuridica = '.$id;
		
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

	function getByCNPJ($cnpj)
	{
		if (empty($cpf)){
	    	$cpf = 0;
	   	}
	   	$sql = 'select * from pessoajuridica where cnpj = \''.$cnpj.'\'';
		
		
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

	function existeCNPJ($cnpj)
	{
		$sql = "select cnpj from pessoajuridica where cnpj = '".$cnpj."'" ;
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
		$sql = "select count(*) from pessoajuridica " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	function contaAluno()
	{
		$sql = "select count(*) from pessoajuridica pf, pessoafisicapapel p where  pf.idpessoafisica = p.idpessoafisica and p.idclassificacaopessoafisica = 1" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	function contaMobilizador()
	{
		$sql = "select count(*) from pessoajuridica pf, pessoafisicapapel p where  pf.idpessoafisica = p.idpessoafisica and p.idclassificacaopessoafisica = 4" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>