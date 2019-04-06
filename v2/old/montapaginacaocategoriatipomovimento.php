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
                      <th width="85%">Categoria Tipo Movimento</th>
                      <th width="15%">Codigo</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			 $html = ' 
                      <td align="center"><input type="radio" name="id_categoriatipomovimento" id="id_categoriatipomovimento" value="'.$row["idcategoriatipomovimento"].'" /></td>
					  <td><a href="cadcategoriatipomovimento.php?op=A&id='.$row["idcategoriatipomovimento"].'">'.$row["categoriatipomovimento"].'</a></td>
 					  <td><a href="cadcategoriatipomovimento.php?op=A&id='.$row["idcategoriatipomovimento"].'">'.$row["codigo"].'</a></td>                     
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select * from categoriatipomovimento where
	categoriatipomovimento = categoriatipomovimento';
	// fim ajuste no sistema
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

/*	if ($tipofiltro == 'ANO')
	{
		if (!empty($valorfiltro))
		{
			$sql_where = ' and avaliacao.anoreferencia = '.$valorfiltro;
		}
	}
	if ($tipofiltro == 'PROPRIEDADE')
	{
		$sql_where = ' and upper(propriedade.nomepropriedade) ilike upper(\'%'.$valorfiltro.'%\')';
	}
	if ($tipofiltro == 'PRODUTOR')
	{
		$sql_where = ' and upper(produtor.nomeprodutor) ilike upper(\'%'.$valorfiltro.'%\')';
	}
*/

	$sql.= $sql_where;
	$sql_ordenacao = '';
/*	if ($o == 'ANO')
	{
	   $sql_ordenacao = ' order by avaliacao.anoreferencia';
	}
	if ($o == 'PROPRIEDADE')
	{
	   $sql_ordenacao = ' order by upper(propriedade.nomepropriedade)';
	}
	if ($o == 'PRODUTOR')
	{
	   $sql_ordenacao = ' order by upper(produtor.nomeprodutor)';
	}
*/
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



