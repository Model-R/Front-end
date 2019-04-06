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
                      <th width="30%">Propriedade</th>
                      <th width="30%">Produtor</th>
                      <th width="20%">T&eacute;cnico</th>
                      <th width="15%">Data</th>
                      <th width="15%">Mes/Ano Ref.</th>
                      <th width="15%">Data Pagto</th>
                      <th width="15%">Valor Pagto</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			 $data = $row['datapagamento'];
			 if (!empty($data))
			 {
			 	$data = date('d/m/Y', strtotime($row["datapagamento"]));
			 }
			 if ($row['idsituacaopropriedade']==1)
			 {
			 	// ativas
			 	$html = ' 
                      <td align="center"><input type="checkbox" name="id_visitatecnica[]" id="id_visitatecnica" value="'.$row["idvisitatecnica"].'" /></td>
					  <td><a href="cadvisitatecnica.php?op=A&id='.$row["idvisitatecnica"].'">'.$row["nomepropriedade"].'</a></td>
					  <td>'.$row["nomeprodutor"].'</td>
					  <td>'.$row["tecnico"].'</td>
					  <td>'.date('d/m/Y', strtotime($row["datavisita"])).'</td>
					  <td>'.$row["mesreferencia"].'/'.$row["anoreferencia"].'</td>
					  <td>'.$data.'</td>
					  <td align="right"> '.number_format($row['valorpago'], 2, ',', '').'</td>
                      ';
			}
			else
			{
			 	$html = ' 
                      <td align="center"><input type="checkbox" name="id_visitatecnica[]" id="id_visitatecnica" value="'.$row["idvisitatecnica"].'" disabled /></td>
					  <td>'.$row["nomepropriedade"].'</td>
					  <td>'.$row["nomeprodutor"].'</td>
					  <td>'.$row["tecnico"].'</td>
					  <td>'.date('d/m/Y', strtotime($row["datavisita"])).'</td>
					  <td>'.$row["mesreferencia"].'/'.$row["anoreferencia"].'</td>
					  <td>'.$data.'</td>
					  <td align="right"> '.number_format($row['valorpago'], 2, ',', '').'</td>
                      ';
			}
		 		echo $html;
				echo "";
		}// function
	}
	

	
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select visitatecnica.*,propriedade.*,tecnico.nometecnico as tecnico,produtor.*  from visitatecnica, propriedade, tecnico,produtor where
propriedade.idprodutor = produtor.idprodutor and
visitatecnica.idpropriedade = propriedade.idpropriedade and
visitatecnica.idtecnico = tecnico.idtecnico ';
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

	$idprograma = $_REQUEST['idprograma'];
	$idprodutor = $_REQUEST['idprodutor'];
	$idpropriedade = $_REQUEST['idpropriedade'];
	$idtecnico = $_REQUEST['idtecnico'];
	$ano = $_REQUEST['ano'];
	$mes = $_REQUEST['mes'];

	$pagto = $_REQUEST['pagto'];
	$ativa = $_REQUEST['ativa'];
	$sql_where = '';
	if (!empty($idtecnico))
	{
		$sql_where .= ' and visitatecnica.idtecnico = '.$idtecnico;
	}

	if (!empty($idpropriedade))
	{
		$sql_where .= ' and visitatecnica.idpropriedade = '.$idpropriedade;
	}
   if (!empty($datainicio))
	{
		$sql_where .= " and (visitatecnica.datavisita >= '".$datainicio."'";
		if (!empty($datatermino))
		{
			$sql_where .= " and visitatecnica.datavisita <='".$datatermino."'";
		}
		$sql_where.=') ';
	}
	else
	{
		if (!empty($datatermino))
		{
			$sql_where .= " and visitatecnica.datavisita <='".$datatermino."'";
		}
	}
	if (!empty($mes))
	{
		$sql_where .= " and visitatecnica.mesreferencia = '".$mes."'";
	}
	if (!empty($ano))
	{
		$sql_where .= " and visitatecnica.anoreferencia = '".$ano."'";
	}


	if ($tipofiltro == 'PROPRIEDADE')
	{
		$sql_where .= ' and upper(sem_acentos(propriedade.nomepropriedade)) like upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}

	if ($tipofiltro == 'TECNICO')
	{
		$sql_where .= ' and upper(sem_acentos(tecnico.nometecnico)) like upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}
	
	if (!empty($idprograma))
	{
		$sql_where .= ' and propriedade.idprograma = '.$idprograma;
	}
	
	if ($ativa=='true')
	{
		$sql_where .= ' and propriedade.idsituacaopropriedade = 1';
	}
	if ($pagto=='false')
	{
		$sql_where.= ' and visitatecnica.datapagamento is not null ';
	}
	else
	{
		$sql_where.= ' and visitatecnica.datapagamento is null ';
	}
	
//	echo $sql_where . 'pagto'.$pagto.'ativa'.$ativa.'rafael';

	$sql.= $sql_where;
	$sql_ordenacao = '';
	if ($o == 'DATA')
	{
	   $sql_ordenacao = ' order by visitatecnica.datavisita desc';
	}
	if ($o == 'PROPRIEDADE')
	{
	   $sql_ordenacao = ' order by sem_acentos(propriedade.nomepropriedade)';
	}
	if ($o == 'TECNICO')
	{
	   $sql_ordenacao = ' order by sem_acentos(tecnico.nometecnico)';
	}


	$sql.=$sql_ordenacao;
    $paginacao->sql = $sql; // a seleção sem o filtro
	$paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$paginacao->order = $_REQUEST['o']; // como será ordenado o resultado
	$paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1 é sinal que é listagem por linha
	$paginacao->numero_linhas = 10; // quantidade de linhas por páginas
	$paginacao->quadro = ''; // conteúdo em a ser exibido
	$paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$paginacao->largura_coluna = '100%';
	$paginacao->mostra_informe = 'T';//
	$paginacao->pagina = $_REQUEST['p']; // página que está
	$paginacao->tamanho_imagem = '60';
	$paginacao->codbasedados = $rafael;
	$paginacao->separador = '' ; // sepador linha que separa as rows
	$paginacao->paginar();
?> 



