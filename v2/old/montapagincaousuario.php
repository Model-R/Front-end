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
                      <th width="20%">Nome</th>
                      <th width="10%">Login</th>
                      <th width="30%">E-Mail</th>
                      <th width="40%">T&eacute;cnico</th>
                      <th width="10%">Situacao</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			if ($row['situacao']=='INATIVO')
			{
				$cor = '#FFA4A4';
			}
			$html = ' 
                      <td align="center" bgcolor="'.$cor.'"><input type="checkbox" name="id_usuario[]" id="id_usuario" value="'.$row["idusuario"].'" /></td>
					  <td bgcolor="'.$cor.'"><a href="cadusuario.php?op=A&id='.$row["idusuario"].'">'.$row["nome"].'</a></td>
                      <td bgcolor="'.$cor.'">'.$row["login"].'</td>
                      <td bgcolor="'.$cor.'">'.$row["email"].'</td>
					  <td bgcolor="'.$cor.'">'.$row["tecnico"].'</td>
                      <td bgcolor="'.$cor.'">'.$row['situacao'].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = " select usuario.*, tecnico.nometecnico as tecnico from usuario left join tecnico on usuario.idtecnico = tecnico.idtecnico where usuario.idusuario = usuario.idusuario ";
	
//	echo $sql;
//	exit;
	
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	if ($tipofiltro == 'NOME')
	{
		$sql_where = ' and upper(sem_acentos(usuario.nome)) like upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}
	if ($tipofiltro == 'EMAIL')
	{
		$sql_where = ' and upper(usuario.email) like upper(\'%'.$valorfiltro.'%\')';
	}
	if ($tipofiltro == 'LOGIN')
	{
		$sql_where = ' and upper(usuario.login) like upper(\'%'.$valorfiltro.'%\')';
	}

	$sql.= $sql_where;

	$sql_ordenacao = '';
	if ($o == 'NOME')
	{
	   $sql_ordenacao = ' order by upper(sem_acentos(usuario.nome))';
	}
	if ($o == 'LOGIN')
	{
	   $sql_ordenacao = ' order by usuario.login';
	}
	if ($o == 'EMAIL')
	{
	   $sql_ordenacao = ' order by usuario.email';
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
	$paginacao->codbasedados = '0';
	$paginacao->separador = '' ; // sepador linha que separa as rows
	$paginacao->paginar();
?> 



