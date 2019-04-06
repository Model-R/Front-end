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
                      <th width="30%">Animal</th>
                      <th width="30%">Produtor</th>
                      <th width="35%">Propriedade</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			 $html = ' 
                      <td align="center"><input type="checkbox" name="id_animal[]" id="id_animal" value="'.$row["idanimal"].'" /></td>
					  <td><a href="cadanimal.php?op=A&id='.$row["idanimal"].'">'.$row["nome"].'</a></td>
                      <td>'.$row["nomeprodutor"].'</td>
                      <td>'.$row["nomepropriedade"].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select * from animal where animal.idanimal = animal.idanimal ';
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

/*	if ($tipofiltro == 'NOME')
	{
		$sql_where = ' where upper(nometecnico) like upper(\'%'.$valorfiltro.'%\')';
	}
	if ($tipofiltro == 'EMAIL')
	{
		$sql_where = ' where upper(email) like upper(\'%'.$valorfiltro.'%\')';
	}
	if ($tipofiltro == 'MATRICULA')
	{
		$sql_where = ' where matricula = \''.$valorfiltro.'\'';
	}
*/

	$sql.= $sql_where;
	$sql_ordenacao = '';
/*	if ($o == 'NOME')
	{
	   $sql_ordenacao = ' order by nometecnico';
	}
	if ($o == 'MATRICULA')
	{
	   $sql_ordenacao = ' order by matricula';
	}
	if ($o == 'EMAIL')
	{
	   $sql_ordenacao = ' order by email';
	}
*/
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



