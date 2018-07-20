<?php session_start();?>
<link rel="stylesheet" type="text/css" href="css/styles.css"/>
<?php 
	require_once('classes/conexao.class.php');
	require_once('classes/paginacao.jabot.class.php');

	class MyPag extends Paginacao
	{
		var $tipo;
		function desenhacabeca($row)
		{
		 	 $html = '
                     <tr valign="top" class="tab_bg_2"> 
                      <th width="3%">&nbsp;</th>
                      <th width="20%">Tipo Movimento</th>
                      <th width="20%">Código</th>
                      <th width="60%">Categoria Tipo Movimento</th>
                      <th width="15%">Unidade Medida</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			 $html = ' 
                      <td align="center"><input type="radio" name="id_tipomovimento" id="id_tipomovimento" value="'.$row["idtipomovimento"].'" /></td>
 					  <td><a href="cadtipomovimento.php?op=A&id='.$row["idtipomovimento"].'">'.$row["tipomovimento"].'</a></td>
					  <td><a href="cadtipomovimento.php?op=A&id='.$row["idtipomovimento"].'">'.$row["codigotipomovimento"].'</a></td>
 					  <td><a href="cadtipomovimento.php?op=A&id='.$row["idtipomovimento"].'">'.$row["categoriatipomovimento"].'</a></td>
                      <td>'.$row["unidade"].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select tm.codigo as codigotipomovimento,* from tipomovimento tm left join unidade u on tm.idunidade = u.idunidade, categoriatipomovimento ctm where
	tm.idcategoriatipomovimento = ctm.idcategoriatipomovimento';
	// fim ajuste no sistema
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	if ($tipofiltro == 'CODIGO')
	{
		$sql_where = ' and tm.codigo = '.$valorfiltro;
	}
	if ($tipofiltro == 'CATEGORIA')
	{
		$sql_where = ' and upper(ctm.categoriatipomovimento) ilike upper(\'%'.$valorfiltro.'%\')';
	}
	if ($tipofiltro == 'TIPO MOVIMENTO')
	{
		$sql_where = ' and upper(tm.tipomovimento) ilike upper(\'%'.$valorfiltro.'%\')';
	}


	$sql.= $sql_where;
	$sql_ordenacao = '';
	if ($o == 'CODIGO')
	{
	   $sql_ordenacao = ' order by tm.codigo';
	}
	if ($o == 'CATEGORIA')
	{
	   $sql_ordenacao = ' order by upper(ctm.categoriatipomovimento)';
	}
	if ($o == 'TIPO MOVIMENTO')
	{
	   $sql_ordenacao = ' order by upper(tm.tipomovimento)';
	}

	$sql.=$sql_ordenacao;
//	echo $sql;
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
	$paginacao->tipo = $_REQUEST['tipo'];
	$paginacao->separador = '' ; // sepador linha que separa as rows
	$paginacao->paginar();
?> 



