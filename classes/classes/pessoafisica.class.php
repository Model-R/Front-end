<?php
class PessoaFisica
{
	var $conn;
	var $idpessoafisica;
	var $nome;
	var $apelido;
	var $nomemae;
	var $cpf;
	var $escolaridade;
	var $identidade;
	var $orgaoemissor;
	var $datanascimento;
	var $inss;
	var $profissao;
	var $documentoprofissional;
	var $email;
	var $telefone;
	var $celular;
	var $fax;
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
	var $empresaempregadora;
	var $telefoneempresaempregadora;
	var $tipoempresaempregadora;
	
	var $naturalidade;
	var $sexo;
	var $certidaonascimento;
	var $idmunicipio;
	var $estadocivil;
	var $idsituacaotrabalhador;
	var $idracacor;
	var $idfaixaetaria;
	var $idrendafamiliar;
	var $idtipodocumento;
	var $aludocprincipal;
	
	
	

	// papel = Aluno, instrutor, supervisor mobilizador
	var $idpapel;

	function incluir()
	{
		if (empty($this->escolaridade))
		{
			$this->escolaridade = 'null';
		}	
		if (empty($this->profissao))
		{
			$this->profissao = 'null';
		}
		if (empty($this->estado))
		{
			$this->estado = 'null';
		}
		if (empty($this->idbanco))
		{
			$this->idbanco = 'null';
		}		
		if (empty($this->datanascimento))
		{
			$this->datanascimento = 'null';
		}
				
		if (empty($this->idmunicipio))
		{
			$this->idmunicipio = 'null';
		}
		
		if (empty($this->idsituacaotrabalhador))
		{
			$this->idsituacaotrabalhador = 'null';
		}
				
		if (empty($this->idracacor))
		{
			$this->idracacor = 'null';
		}
		if (empty($this->idfaixaetaria))
		{
			$this->idfaixaetaria = 'null';
		}		
		if (empty($this->idrendafamiliar))
		{
			$this->idrendafamiliar = 'null';
		}
		if (empty($this->idtipodocumento))
		{
			$this->idtipodocumento = 'null';
		}


		$r = true;
 		$sql = "insert into pessoafisica (nome,apelido,nomemae,cpf,idescolaridade,identidade,orgaoemissor,datanascimento,
		inss,idprofissao,documentoprofissional,email,telefone,celular,fax,
		endereco,municipio,bairro,idestado,cep,idbanco,
		codagencia,agenciadv,contacorrente,contacorrentedv,empresaempregadora,telefoneempresaempregadora,tipoempresaempregadora,
		naturalidade,sexo,certidaonascimento,idmunicipio,estadocivil,
		idsituacaotrabalhador,idracacor,idfaixaetaria,
		idrendafamiliar,idtipodocumento,aludocprincipal
		
		) values ('".$this->nome."','".$this->apelido."','".$this->nomemae."','".$this->cpf."',".$this->escolaridade.",'".$this->identidade."','".$this->orgaoemissor."',".$this->datanascimento.",
		'".$this->inss."',".$this->profissao.",'".$this->documentoprofissional."','".$this->email."','".$this->telefone."','".$this->celular."','".$this->fax."',
		'".$this->endereco."','".$this->municipio."','".$this->bairro."',".$this->estado.",'".$this->cep."',".$this->idbanco.",

		'".$this->codagencia."','".$this->agenciadv."','".$this->contacorrente."','".$this->contacorrentedv."','".$this->empresaempregadora."','".$this->telefoneempresaempregadora."','".$this->tipoempresaempregadora."',
		'".$this->naturalidade."','".$this->sexo."','".$this->certidaonascimento."',".$this->idmunicipio.",'".$this->estadocivil."',
		".$this->idsituacaotrabalhador.",".$this->idracacor.",".$this->idfaixaetaria.",
		".$this->idrendafamiliar.",".$this->idtipodocumento.",'".$this->aludocprincipal."'
		);";
	//	echo $sql;
	//	exit;
		$resultado = pg_exec($this->conn,$sql);
		if (!$resultado)
		{
			$r = false;
		}
		
		$sql3 = "select currval('pessoafisica_idpessoafisica_seq'); ";
		$res3 = pg_exec($this->conn,$sql3);
		$row3 = pg_fetch_array($res3);

		$sql3 = "insert into pessoafisicapapel(idpessoafisica,idclassificacaopessoafisica) values (".$row3[0].",".$this->idpapel.");";
		$resultado3 = pg_exec($this->conn,$sql3);
		if (!$resultado3)
		{
			$r = false;
		}
    	return $r;
	}

	function incluirMobilizador()
	{
		$r = true;
 		$sql = "insert into pessoafisica (nome,apelido,cpf,email,telefone,celular
		) values ('".$this->nome."','".$this->apelido."','".$this->cpf."','".$this->email."','".$this->telefone."','".$this->celular."');";

		$resultado = pg_exec($this->conn,$sql);
		if (!$resultado)
		{
			$r = false;
		}
		
		$sql3 = "select currval('pessoafisica_idpessoafisica_seq'); ";
		$res3 = pg_exec($this->conn,$sql3);
		$row3 = pg_fetch_array($res3);

		$sql3 = "insert into pessoafisicapapel(idpessoafisica,idclassificacaopessoafisica) values (".$row3[0].",4);";
		$resultado3 = pg_exec($this->conn,$sql3);
		if (!$resultado3)
		{
			$r = false;
		}
    	return $r;
	}

	function alterarMobilizador($id)
	{
       $sql = "update pessoafisica set nome = '".$this->nome."', apelido = '".$this->apelido."',  cpf = '".$this->cpf."', email = '".$this->email."',
	   telefone = '".$this->telefone."', celular = '".$this->celular."'
	    where idpessoafisica='".$id."' ";
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
		if (empty($this->escolaridade))
		{
			$this->escolaridade = 'null';
		}	
		if (empty($this->profissao))
		{
			$this->profissao = 'null';
		}
		if (empty($this->estado))
		{
			$this->estado = 'null';
		}
		if (empty($this->idbanco))
		{
			$this->idbanco = 'null';
		}
		if (empty($this->datanascimento))
		{
			$this->datanascimento = 'null';
		}
		
		if (empty($this->idmunicipio))
		{
			$this->idmunicipio = 'null';
		}
		
		if (empty($this->idsituacaotrabalhador))
		{
			$this->idsituacaotrabalhador = 'null';
		}
				
		if (empty($this->idracacor))
		{
			$this->idracacor = 'null';
		}
		if (empty($this->idfaixaetaria))
		{
			$this->idfaixaetaria = 'null';
		}		
		if (empty($this->idrendafamiliar))
		{
			$this->idrendafamiliar = 'null';
		}
		if (empty($this->idtipodocumento))
		{
			$this->idtipodocumento = 'null';
		}		
		$sql = "delete from pessoafisicapapel where idpessoafisica = '".$id."' and idclassificacaopessoafisica = '".$this->idpapel."'";
		$resultado = pg_exec($this->conn,$sql);

		$sql3 = "insert into pessoafisicapapel(idpessoafisica,idclassificacaopessoafisica) values (".$id.",".$this->idpapel.");";
		$resultado3 = pg_exec($this->conn,$sql3);

       $sql = "update pessoafisica set nome = '".$this->nome."', apelido = '".$this->apelido."', nomemae = '".$this->nomemae."', cpf = '".$this->cpf."',idescolaridade = ".$this->escolaridade.", identidade = '".$this->identidade."',orgaoemissor = '".$this->orgaoemissor."',datanascimento = '".$this->datanascimento."',
	   inss = '".$this->inss."', idprofissao = ".$this->profissao.", documentoprofissional = '".$this->documentoprofissional."', email = '".$this->email."',telefone = '".$this->telefone."', celular = '".$this->celular."',fax = '".$this->fax."',	   
	   endereco = '".$this->endereco."', municipio = '".$this->municipio."',  bairro = '".$this->bairro."', idestado = ".$this->estado.",cep = '".$this->cep."', idbanco = ".$this->idbanco.",	   
	   codagencia = '".$this->codagencia."', agenciadv = '".$this->agenciadv."', contacorrente = '".$this->contacorrente."', contacorrentedv = '".$this->contacorrentedv."',
	   empresaempregadora = '".$this->empresaempregadora."', telefoneempresaempregadora = '".$this->telefoneempresaempregadora."', tipoempresaempregadora = '".$this->tipoempresaempregadora."',
	   naturalidade = '".$this->naturalidade."', sexo = '".$this->sexo."', certidaonascimento = '".$this->certidaonascimento."', idmunicipio = ".$this->idmunicipio.",
	   estadocivil = '".$this->idestadocivil."', idsituacaotrabalhador = ".$this->idsituacaotrabalhador.", idracacor = ".$this->idracacor.",
	   idfaixaetaria = ".$this->idfaixaetaria.", idrendafamiliar = ".$this->idrendafamiliar.", idtipodocumento = ".$this->idtipodocumento.", aludocprincipal = '".$this->aludocprincipal."'
	    where idpessoafisica='".$id."' ";
		//echo $sql;
		//exit;
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
		$sql = "delete from pessoafisicapapel where idpessoafisica = '".$id."' and idclassificacaopessoafisica = '".$idpapel."'";
		$resultado = pg_exec($this->conn,$sql);
	//	echo $sql;
	//	exit;

		$sql = "delete from pessoafisica where idpessoafisica = '".$id."' ";
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
		   	$this->idpessoafisica = $row['idpessoafisica'];
		   	$this->nome = $row['nome'];
		   	$this->apelido = $row['apelido'];
		   	$this->nomemae = $row['nomemae'];
		   	$this->cpf = $row['cpf'];
		   	$this->escolaridade = $row["idescolaridade"];
		   	$this->identidade = $row["identidade"];
		   	$this->datanascimento = $row["datanascimento"];
		   	$this->orgaoemissor = $row['orgaoemissor'];
		   	$this->inss = $row['inss'];

		   	$this->profissao = $row['idprofissao'];
		   	$this->documentoprofissional = $row['documentoprofissional'];
		   	$this->email = $row['email'];
		   	$this->telefone = $row["telefone"];
		   	$this->celular = $row['celular'];
		   	$this->endereco = $row['endereco'];
		   	$this->fax = $row['fax'];

		   	$this->municipio = $row['municipio'];
		   	$this->bairro = $row['bairro'];
		   	$this->estado = $row['idestado'];
		   	$this->cep = $row["cep"];
		   	$this->idbanco = $row['idbanco'];
		   	$this->codagencia = $row['codagencia'];

		   	$this->agenciadv = $row['agenciadv'];
		   	$this->contacorrente = $row['contacorrente'];
		   	$this->contacorrentedv = $row['contacorrentedv'];

		   	$this->empresaempregadora = $row['empresaempregadora'];
		   	$this->telefoneempresaempregadora = $row['telefoneempresaempregadora'];
		   	$this->tipoempresaempregadora = $row['tipoempresaempregadora'];

		   	$this->naturalidade = $row['naturalidade'];
		   	$this->sexo = $row['sexo'];
		   	$this->certidaonascimento = $row['certidaonascimento'];

		   	$this->idmunicipio = $row['idmunicipio'];
		   	$this->estadocivil = $row['estadocivil'];
		   	$this->idsituacaotrabalhador = $row['idsituacaotrabalhador'];

		   	$this->idracacor = $row['idracacor'];
		   	$this->idfaixaetaria = $row['idfaixaetaria'];
		   	$this->idrendafamiliar = $row['idrendafamiliar'];
		   	$this->idtipodocumento = $row['idtipodocumento'];	 
			$this->aludocprincipal = $row['aludocprincipal'];

	}
	
	

	function listaCheck($nomecheck,$tipo,$idatividade)
	{
	   	$sql = "	select * from pessoafisica pf, pessoafisicapapel pfp where
					pf.idpessoafisica = pfp.idpessoafisica
					and pfp.idclassificacaopessoafisica = $tipo limit 10
 				";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{
	   		$sql2 = "select * from eventotipopublico where idevento = $idevento and idtipopublico = ".$row['idtipopublico'];
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
		
			$html .= '<input name="'.$nomecheck.'" type="checkbox" value="'.$row['idpessoafisica'].'" '.$s.'>&nbsp;'.$row['nome'].'<br>';
	    }
		return $html;	
	}
	
	function listaCombo($nomecombo,$id,$refresh)
	{
	   	$sql = "select * from pessoafisica order by nome ";
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
			if ($id == $row['idpessoafisica'])
			{
			   $s = "selected";
			}
			$importadode = '';
		   $html.="<option value='".$row['idpessoafisica']."' ".$s." >".$row['nome']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	

	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from pessoafisica where idpessoafisica = '.$id;
		
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

	function getByCPF($cpf)
	{
		if (empty($cpf)){
	    	$cpf = 0;
	   	}
	   	$sql = 'select * from pessoafisica where cpf = \''.$cpf.'\'';
		
		
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

	function existeCPF($cpf)
	{
		$sql = "select cpf from pessoafisica where cpf = '".$cpf."'" ;
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
		$sql = "select count(*) from pessoafisica " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	function contaAluno()
	{
		$sql = "select count(*) from pessoafisica pf, pessoafisicapapel p where  pf.idpessoafisica = p.idpessoafisica and p.idclassificacaopessoafisica = 1" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	function contaMobilizador()
	{
		$sql = "select count(*) from pessoafisica pf, pessoafisicapapel p where  pf.idpessoafisica = p.idpessoafisica and p.idclassificacaopessoafisica = 4" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	function contaInstrutor()
	{
		$sql = "select count(*) from pessoafisica pf, pessoafisicapapel p where  pf.idpessoafisica = p.idpessoafisica and p.idclassificacaopessoafisica = 2" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
	function contaSupervisor()
	{
		$sql = "select count(*) from pessoafisica pf, pessoafisicapapel p where  pf.idpessoafisica = p.idpessoafisica and p.idclassificacaopessoafisica = 3" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>