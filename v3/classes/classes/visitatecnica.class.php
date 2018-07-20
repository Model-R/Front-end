<?php
class VisitaTecnica
{
	var $conn;
	var $idvisitatecnica;
	var $idpropriedade;
	var $idtecnico;
	var $datavisita;
	var $producaodia;
	var $numvacaslactacao;
	var $numvacassecas;
	
	var $dataproximavisita;
	var $relatorio;
	var $mesreferencia;
	var $anoreferencia;
	var $datapagamento;
	var $valorpago;
	var $idavaliacao;
	var $areaprojeto;
	var $idunidademedida;
	var $configuracao; // instancia da classe configuracao;
	var $horachegada;
	var $horasaida;

	var $producaoinicial;
	var $dataentradaprojeto;

	function incluir()
	{
		if (empty($this->datavisita))
		{	
			$this->datavisita = 'null';
		}
		else
		{
			$dia = substr($this->datavisita,0,2);
			$mes = substr($this->datavisita,3,2);
			$ano = substr($this->datavisita,6,4);
			$this->datavisita = "'".$mes.'-'.$dia.'-'.$ano ."'";
		}
		if (empty($this->producaodia))
		{	
			$this->producaodia = 'null';
		}
		else
		{
			$this->producaodia = str_replace(',','.',$this->producaodia);
		}
		if (empty($this->numvacaslactacao))
		{	
			$this->numvacaslactacao = 'null';
		}
		if (empty($this->numvacassecas))
		{	
			$this->numvacassecas = 'null';
		}
		if (empty($this->dataproximavisita))
		{	
			$this->dataproximavisita = 'null';
		}
		else
		{
			$dia = substr($this->dataproximavisita,0,2);
			$mes = substr($this->dataproximavisita,3,2);
			$ano = substr($this->dataproximavisita,6,4);
			
			//$this->dataproximavisita = "'".$this->dataproximavisita ."'";
			
			$this->dataproximavisita = "'".$mes.'-'.$dia.'-'.$ano ."'";

		
		}
		if (empty($this->datapagamento))
		{	
			$this->datapagamento = 'null';
		}
		else
		{
			$this->datapagamento = "'".$this->datapagamento ."'";
		}

		if (empty($this->valorpago))
		{	
			$this->valorpago = 'null';
		}
		if (empty($this->areaprojeto))
		{	
			$this->areaprojeto = 'null';
		}
		else
		{
			$this->areaprojeto = str_replace(',','.',$this->areaprojeto);
		}

		if (empty($this->idunidademedida))
		{	
			$this->idunidademedida = 'null';
		}

		if (empty($this->horachegada))
		{	
			$this->horachegada = 'null';
		}
		else
		{
			$this->horachegada = "'".$this->horachegada ."'";
		}

		if (empty($this->horasaida))
		{	
			$this->horasaida = 'null';
		}
		else
		{
			$this->horasaida = "'".$this->horasaida ."'";
		}

		$sqlproximo = 'SELECT max(idvisitatecnica) FROM visitatecnica WHERE idtecnico = '.$this->idtecnico;
//		echo $sqlproximo;
//		exit;
		$resultadoproximo = pg_exec($this->conn,$sqlproximo);
   		$rowproximo = pg_fetch_array($resultadoproximo);
		if (empty($rowproximo[0]))
		{
			$idproximo = 1 * ($this->idtecnico*100000);
		}
		else
		{
			$idproximo = $rowproximo[0]+1;
		}
//		echo $idproximo;
//		exit;

 		$sql = "insert into visitatecnica (idvisitatecnica,idpropriedade,idtecnico,datavisita,producaodia,numvacaslactacao,
		numvacassecas,dataproximavisita,relatorio,mesreferencia,anoreferencia,datapagamento,valorpago,areaprojeto,idunidademedida,horachegada,horasaida) values (
									".$idproximo.",".$this->idpropriedade.",".$this->idtecnico.",".$this->datavisita.",
									".$this->producaodia.",".$this->numvacaslactacao.",".$this->numvacassecas."
									,".$this->dataproximavisita.",'".$this->relatorio."'
									,".$this->mesreferencia.",".$this->anoreferencia."
									,".$this->datapagamento.",".$this->valorpago.",".$this->areaprojeto.",".$this->idunidademedida.",".$this->horachegada.",".$this->horasaida.")";
//		echo $sql;
//		exit;
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
//			if (!empty($this->configuracao->emailrecebimento))
//			{
//				$sql = 'select max(idvisitatecnica) from visitatecnica where idtecnico = '.$this->idtecnico;
//				$resultado = pg_exec($this->conn,$sql);
//				if (pg_numrows($resultado)>0)
//				{
//		    		$row = pg_fetch_array($resultado);
					//$this->configuracao->emailrecebimento
		   			$this->enviaAvisoRelatorio($idproximo,'rafaeloliveiralima@ibest.com.br');
			$sql = "select max(idvisitatecnica) from visitatecnica where idtecnico = ".$this->idtecnico;
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
		if (empty($this->datavisita))
		{	
			$this->datavisita = 'null';
		}
		else
		{
			$dia = substr($this->datavisita,0,2);
			$mes = substr($this->datavisita,3,2);
			$ano = substr($this->datavisita,6,4);
			$this->datavisita = "'".$mes.'-'.$dia.'-'.$ano ."'";

		}

		if (empty($this->producaodia))
		{	
			$this->producaodia = 'null';
		}
		else
		{
			$this->producaodia = str_replace(',','.',$this->producaodia);
		}
		if (empty($this->numvacaslactacao))
		{	
			$this->numvacaslactacao = 'null';
		}
		if (empty($this->numvacassecas))
		{	
			$this->numvacassecas = 'null';
		}
		if (empty($this->dataproximavisita))
		{	
			$this->dataproximavisita = 'null';
		}
		else
		{
			$dia = substr($this->dataproximavisita,0,2);
			$mes = substr($this->dataproximavisita,3,2);
			$ano = substr($this->dataproximavisita,6,4);
			$this->dataproximavisita = "'".$mes.'-'.$dia.'-'.$ano ."'";
		}
		if (empty($this->datapagamento))
		{	
			$this->datapagamento = 'null';
		}
		else
		{
			$dia = substr($this->datapagamento,0,2);
			$mes = substr($this->datapagamento,3,2);
			$ano = substr($this->datapagamento,6,4);
			$this->datapagamento = "'".$mes.'-'.$dia.'-'.$ano ."'";
		}
		if (empty($this->valorpago))
		{	
			$this->valorpago = 'null';
		}
		if (empty($this->areaprojeto))
		{	
			$this->areaprojeto = 'null';
		}
		else
		{
			$this->areaprojeto = str_replace(',','.',$this->areaprojeto);
		}
		if (empty($this->idunidademedida))
		{	
			$this->idunidademedida = 'null';
		}

		if (empty($this->horachegada))
		{	
			$this->horachegada = 'null';
		}
		else
		{
			$this->horachegada = "'".$this->horachegada ."'";
		}

		if (empty($this->horasaida))
		{	
			$this->horasaida = 'null';
		}
		else
		{
			$this->horasaida = "'".$this->horasaida ."'";
		}

       $sql = "update visitatecnica set idpropriedade = ".$this->idpropriedade.",idtecnico = ".$this->idtecnico.",datavisita = ".$this->datavisita.",
	   producaodia = ".$this->producaodia.",numvacaslactacao = ".$this->numvacaslactacao.",numvacassecas = ".$this->numvacassecas."
	   ,dataproximavisita = ".$this->dataproximavisita.",relatorio = '".$this->relatorio."'
	   ,mesreferencia = '".$this->mesreferencia."',anoreferencia = '".$this->anoreferencia."',datapagamento = ".$this->datapagamento.",valorpago = ".$this->valorpago."
	   ,areaprojeto = ".$this->areaprojeto.",idunidademedida = ".$this->idunidademedida.", horachegada = ".$this->horachegada.", horasaida= ".$this->horasaida."   where idvisitatecnica=".$id." ";
		
	   $resultado = pg_exec($this->conn,$sql);

       if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	}

	function pagar($id,$datapagamento,$valorpago)
	{
		$valorpago = str_replace(',','.',$valorpago);
		$sql = "update visitatecnica set datapagamento = '".$datapagamento."', valorpago = ".$valorpago." where idvisitatecnica = '".$id."' ";
//	   	echo $sql;
//		exit;
		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	function estornarPagamento($id,$motivo)
	{
		$sql = "update visitatecnica set datapagamento = null, valorpago = null where idvisitatecnica = '".$id."' ";
	   	
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
		$sql = "delete from visitatecnica where idvisitatecnica = '".$id."' and datapagamento is null ";
	   	$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	function jaPaga($id)
	{
		$sql = "select * from visitatecnica, propriedade where 
			visitatecnica.idpropriedade = propriedade.idpropriedade and visitatecnica.idvisitatecnica = '".$id."' and visitatecnica.datapagamento is null";
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
	    	return false;
		}
		else
		{
			return true;
		}
	}

	
	function getDados($row)
	{
		   	$this->idvisitatecnica = $row['idvisitatecnica'];
		   	$this->idpropriedade = $row['idpropriedade'];
		   	$this->idtecnico = $row['idtecnico'];
		   	$this->datavisita = $row['datavisita'];
		   	$this->producaodia = $row['producaodia'];
		   	$this->numvacaslactacao = $row['numvacaslactacao'];
		   	$this->numvacassecas = $row['numvacassecas'];
		   	$this->dataproximavisita = $row['dataproximavisita'];
		   	$this->relatorio = $row['relatorio'];
		   	$this->mesreferencia = $row['mesreferencia'];
		   	$this->anoreferencia = $row['anoreferencia'];
		   	$this->datapagamento = $row['datapagamento'];
		   	$this->valorpago = $row['valorpago'];
		   	$this->idavaliacao = $row['idavaliacao'];
		   	$this->areaprojeto = $row['areaprojeto'];
		   	$this->idunidademedida = $row['idunidademedida'];
		   	$this->horachegada = $row['horachegada'];
		   	$this->horasaida = $row['horasaida'];
			if (!empty($row['dataentradaprojeto']))
			{
		   		$this->dataentradaprojeto = date('d/m/Y',strtotime($row['dataentradaprojeto']));
			}
			else
			{		   	
				$this->dataentradaprojeto = '';//$row['dataentradaprojeto'];
			}
		   	$this->producaoinicial = number_format($row['producaoinicial'],2,',','.');
	}
	
	
	function listaCombo($nomecombo,$id,$refresh)
	{
	   	$sql = "select * from visitatecnica order by datavisita desc ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione o Visita Técnica</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idvisitatecnica'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idvisitatecnica']."' ".$s." >".$row['datavisita']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	

	function getVisitaTecnicaById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select visitatecnica.idunidademedida as "idunidademedidavisitatecnica",* from visitatecnica, propriedade  where 
			visitatecnica.idpropriedade = propriedade.idpropriedade and visitatecnica.idvisitatecnica = '.$id;
		
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
	   	$sql = 'select * from visitatecnica where idvisitatecnica = '.$id;
		
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

	function enviaAvisoRelatorio($idvisitatecnica,$email)
	{
		$sql = "select datavisita,idvisitatecnica,nomepropriedade,nomeprodutor,
	nometecnico,anoreferencia,mesreferencia,
	relatorio
	 from visitatecnica vt, propriedade prop, tecnico t, produtor p
	where
	vt.idtecnico = t.idtecnico and
	vt.idpropriedade = prop.idpropriedade and
	prop.idprodutor = p.idprodutor
	and idvisitatecnica = ".$idvisitatecnica;
//	echo $sql;
	//echo 'email:'.$email;	
		$resultado = pg_exec($this->conn,$sql);
		if (pg_numrows($resultado)>0)
		{
        	$row = pg_fetch_array($resultado);
			$destinatario = $email;
			$assunto= 'Aviso - Novo Relatório';
			$corpo = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<title>:.. BALDE CHEIO ..:</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<style type="text/css">
			<!--
			.style2 {font-size: 24px}
			-->
			</style>
			</head>
			<body bgcolor="#ffffff">
			<center>
			<table border=0 width="100%">
			<tr>
			<td width="10%"><div align="center"><img src="http://www.tempustecnologia.com/baldecheio/imagens/baldecheio2.JPG" height="50px" /></div></td>
			<td width="90%" align="left" class="style2" style="color:#93989E">Balde - Cheio</td>
			</tr>
			<tr>
				<td colspan="2" align="justify">
				<br/>
				<b>T&eacute;cnico:</b> '.$row['nometecnico'].'<br/>
				<b>Propriedade:</b> '.$row['nomepropriedade'].'('.$row['nomeprodutor'].')<br/>
				<b>M&ecirc;s/Ano refer&ecirc;ncia:</b> '.$row['mesreferencia'].'/'.$row['anoreferencia'].'<br/>
				<b>Data visita:</b> '.date('d/m/Y', strtotime($row["datavisita"])).'<br/>
				<b>Relat&oacute;rio:</b><br/>
				'.$row['relatorio'].'<br/>
				<br/>
			</td>
			</tr>
			</table>
			</center>
			</font>
			</body>
			</html>
			'; 
			//para o envio em formato HTML
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html;charset=iso-8859-1\r\n";
			
			//endereo do remitente
//			$email = 'rafaeloliveiralima@ibest.com.br';
//			$headers .= "From: BALDE CHEIO <".$email."> \r\n";
			$headers .= "From: BALDE CHEIO <contato@senar.com.br> \r\n";
			
			//endereo de resposta, se queremos que seja diferente a do remitente
			//$headers .= "Reply-To: thiagoluna@ig.com.br\r\n";
			
			//endereos que recebero uma copia 
			//$headers .= "Cc: thiagoluna@ig.com.br\r\n"; 
			//endereos que recebero uma copia oculta
			//$headers .= "Bcc: thiagoluna2@gmail.com\r\n";
//			echo $corpo;
//			echo $headers;

			if (mail($destinatario,$assunto,$corpo,$headers) ) {
			   //echo "<br/>Email enviado com um sucesso!!!<br/>Em breve o responderemos."; 
			   return true;
			} else {
			   //echo "<br/>Erro no envio do email!<br/>Por Favor, <a href='contato.php'>tente</a> novamente!";
			   return false;
			} 
//			exit;
		}
		else
		{
			return false;
		}
	}

	function conta()
	{
		$sql = "select count(*) from visitatecnica " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>