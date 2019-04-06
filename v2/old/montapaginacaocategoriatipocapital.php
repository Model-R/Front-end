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
                      <th width="20%">Tipo Capital</th>
                      <th width="60%">Categoria Tipo Capital</th>
                      <th width="15%">Unidade Medida</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			 $html = ' 
                      <td align="center"><input type="radio" name="id_categoriatipocapital" id="id_categoriatipocapital" value="'.$row["idcategoriatipocapital"].'" /></td>
					  <td><a href="cadcategoriatipocapital.php?op=A&id='.$row["idcategoriatipocapital"].'">'.$row["tipocapital"].'</a></td>
 					  <td><a href="cadcategoriatipocapital.php?op=A&id='.$row["idcategoriatipocapital"].'">'.$row["categoriatipocapital"].'</a></td>
                      <td>'.$row["unidademedida"].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select * from categoriatipocapital ctc left join unidademedida um on ctc.idunidademedida = um.idunidademedida, tipocapital tc where
	ctc.idtipocapital = tc.idtipocapital';
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
	$paginacao->tipo = $_REQUEST['tipo'];
	$paginacao->separador = '' ; // sepador linha que separa as rows
	$paginacao->paginar();
?> 



