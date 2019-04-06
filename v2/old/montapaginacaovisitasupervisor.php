<link rel="stylesheet" type="text/css" href="css/styles.css"/>
<?php 
	require_once('classes/conexao.class.php');
	require_once('classes/paginacao.jabot.class.php');

	class MyPag extends Paginacao
	{
		function desenhacabeca($row)
		{
		 	 $html = '
                     <tr valign="top" class="tab_bg_2"> 
                      <th width="3%">&nbsp;</th>
                      <th width="40%">Propriedade</th>
                      <th width="40%">Produtor</th>
                      <th width="30%">Supervisor</th>
                      <th width="10%">Data Visita</th>
                      <th width="10%">Pr&oacute;xima Visita</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 $html = ' 
                      <td align="center"><input type="checkbox" name="id_visitasupervisor[]" id="id_visitasupervisor" value="'.$row["idvisitasupervisor"].'" /></td>
					  <td><a href="cadvisitasupervisor.php?op=A&id='.$row["idvisitasupervisor"].'">'.$row["nomepropriedade"].'</a></td>
					  <td>'.$row["nomeprodutor"].'</td>
					  <td>'.$row["nome"].'</td>
					  <td>'.date('d/m/Y', strtotime($row["datavisita"])).' '.$hora.'</td>
					  <td>'.date('d/m/Y', strtotime($row["dataproximavisita"])).' '.$hora.'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select visitasupervisor.*,propriedade.*,usuario.nome as nome,produtor.*  from visitasupervisor, propriedade, usuario,produtor where
propriedade.idprodutor = produtor.idprodutor and
visitasupervisor.idpropriedade = propriedade.idpropriedade and
visitasupervisor.idsupervisor = usuario.idusuario ';
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];
	$datainicio = $_REQUEST['datainicio'];
	if (!empty($datainicio))
	{
		$datainicio = substr($datainicio,6,4).'-'.substr($datainicio,3,2).'-'.substr($datainicio,0,2);
	}
	$datatermino = $_REQUEST['datatermino'];
	if (!empty($datatermino))
	{
		$datatermino = substr($datatermino,6,4).'-'.substr($datatermino,3,2).'-'.substr($datatermino,0,2);
	}

	$idprodutor = $_REQUEST['idprodutor'];
	$idpropriedade = $_REQUEST['idpropriedade'];
	$idsupervisor = $_REQUEST['idsupervisor'];
	$idprograma = $_REQUEST['idprograma'];
	
	
	$sql_where = '';
	if (!empty($idsupervisor))
	{
		$sql_where .= ' and visitasupervisor.idsupervisor = '.$idsupervisor;
	}

	if (!empty($idprograma))
	{
		$sql_where .= ' and propriedade.idprograma = '.$idprograma;
	}

	if (!empty($idpropriedade))
	{
		$sql_where .= ' and visitasupervisor.idpropriedade = '.$idpropriedade;
	}
   if (!empty($datainicio))
	{
		$sql_where .= " and (visitasupervisor.datavisita >= '".$datainicio."'";
		if (!empty($datatermino))
		{
			$sql_where .= " and visitasupervisor.datavisita <='".$datatermino."'";
		}
		$sql_where.=') ';
	}
	else
	{
		if (!empty($datatermino))
		{
			$sql_where .= " and visitasupervisor.datavisita <='".$datatermino."'";
		}
	}


	if ($tipofiltro == 'PROPRIEDADE')
	{
		$sql_where .= ' and upper(sem_acentos(propriedade.nomepropriedade)) like upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}

	if ($tipofiltro == 'SUPERVISOR')
	{
		$sql_where .= ' and upper(sem_acentos(usuario.nome)) like upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}

	$sql.= $sql_where;
	$sql_ordenacao = '';
	if ($o == 'DATA')
	{
	   $sql_ordenacao = ' order by visitasupervisor.datavisita desc';
	}
	if ($o == 'PROPRIEDADE')
	{
	   $sql_ordenacao = ' order by sem_acentos(propriedade.nomepropriedade)';
	}
	if ($o == 'SUPERVISOR')
	{
	   $sql_ordenacao = ' order by sem_acentos(usuario.nome)';
	}

	
	$sql.=$sql_ordenacao;
    //echo $sql;
	
	$paginacao->sql = $sql; // a sele��o sem o filtro
	$paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$paginacao->order = $_REQUEST['o']; // como ser� ordenado o resultado
	$paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1 � sinal que � listagem por linha
	$paginacao->numero_linhas = 10; // quantidade de linhas por p�ginas
	$paginacao->quadro = ''; // conte�do em a ser exibido
	$paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$paginacao->largura_coluna = '100%';
	$paginacao->mostra_informe = 'T';//
	$paginacao->pagina = $_REQUEST['p']; // p�gina que est�
	$paginacao->tamanho_imagem = '60';
	$paginacao->codbasedados = $rafael;
	$paginacao->separador = '' ; // sepador linha que separa as rows
	$paginacao->paginar();
?> 



