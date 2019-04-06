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
                      <th width="20%">Unidade de Medida</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			 $html = ' 
                      <td align="center"><input type="radio" name="id_unidade" id="id_unidade" value="'.$row["idunidade"].'" /></td>
					  <td><a href="cadunidade.php?op=A&id='.$row["idunidade"].'">'.$row["unidade"].'</a></td>
 					  ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select * from unidade where
	idunidade = idunidade';
	// fim ajuste no sistema
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	if ($tipofiltro == 'UNIDADE')
	{
		$sql_where = ' and upper(unidade) ilike upper(\'%'.$valorfiltro.'%\')';
	}


	$sql.= $sql_where;
	$sql_ordenacao = '';
	if ($o == 'UNIDADE')
	{
	   $sql_ordenacao = ' order by upper(unidade)';
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



