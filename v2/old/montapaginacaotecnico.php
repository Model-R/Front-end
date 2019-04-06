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
                      <th width="25%">Nome</th>
                      <th width="5%">Matr&iacute;cula</th>
                      <th width="20%">E-Mail</th>
                      <th width="20%">Endere&ccedil;o</th>
                      <th width="15%">Telefone</th>
                      <th width="15%">Celular</th>
                      <th width="15%">Situacao</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			if ($row['situacao']=='INATIVO')
			{
				$cor = '#FFA4A4';
			}			 
			 $html = ' 
                      <td align="center" bgcolor="'.$cor.'"><input type="checkbox" name="id_tecnico[]" id="id_tecnico" value="'.$row["idtecnico"].'" /></td>
					  <td bgcolor="'.$cor.'"><a href="cadtecnico.php?op=A&id='.$row["idtecnico"].'">'.$row["nometecnico"].'</a></td>
                      <td bgcolor="'.$cor.'">'.$row["matricula"].'</td>
                      <td bgcolor="'.$cor.'">'.$row["email"].'</td>
                      <td bgcolor="'.$cor.'">'.$row["endereco"].'</td>
                      <td bgcolor="'.$cor.'">'.$row["telefone"].'</td>
					  <td bgcolor="'.$cor.'">'.$row["celular"].'</td>
					  <td bgcolor="'.$cor.'">'.$row["situacao"].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select tecnico.*,usuario.situacao from tecnico left join usuario on tecnico.idtecnico = usuario.idtecnico where tecnico.idtecnico = tecnico.idtecnico  ';
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	if ($tipofiltro == 'NOME')
	{
		$sql_where = ' and  upper(sem_acentos(nometecnico)) ilike upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}
	if ($tipofiltro == 'EMAIL')
	{
		$sql_where = ' and upper(tecnico.email) like upper(\'%'.$valorfiltro.'%\')';
	}
	if ($tipofiltro == 'MATRICULA')
	{
		$sql_where = ' and  matricula = \''.$valorfiltro.'\'';
	}

	

	$sql.= $sql_where;
	//echo $sql;

	$sql_ordenacao = '';
	if ($o == 'NOME')
	{
	   $sql_ordenacao = ' order by upper(sem_acentos(nometecnico))';
	}
	if ($o == 'MATRICULA')
	{
	   $sql_ordenacao = ' order by matricula';
	}
	if ($o == 'EMAIL')
	{
	   $sql_ordenacao = ' order by email';
	}

	//echo $sql;
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



