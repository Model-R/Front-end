<?php session_start();?>
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
                      <th width="25%">Produtor</th>
                      <th width="25%">Munic&iacute;pio</th>
                      <th width="15%">Programa</th>
                      <th width="25%">Situa&ccedil;&atilde;o</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){

			if ($row['situacaopropriedade']=='Inativa')
			{
				$cor = '#FFA4A4';
			}			 //$date = new DateTime($row['datacadastro']);
			 $html = ' 
                      <td align="center" bgcolor="'.$cor.'"><input type="checkbox" name="id_propriedade[]" id="id_propriedade" value="'.$row["idpropriedade"].'" /></td>
					  <td bgcolor="'.$cor.'"><a href="cadpropriedade.php?op=A&id='.$row["idpropriedade"].'">'.$row["nomepropriedade"].'</a><br>('.$row["nometecnico"].')</td>
					  <td bgcolor="'.$cor.'">'.$row["nomeprodutor"].'</td>
					  <td bgcolor="'.$cor.'">'.$row["municipio"].'</td>
					  <td bgcolor="'.$cor.'">'.$row["programa"].'</td>
					  <td bgcolor="'.$cor.'">'.$row["situacaopropriedade"].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select propriedade.*,usuario.situacao as situacaousuario,programa.programa,produtor.nomeprodutor,tecnico.nometecnico,situacaopropriedade.situacaopropriedade from propriedade left join tecnico on propriedade.idtecnico = tecnico.idtecnico 
	left join programa on propriedade.idprograma=programa.idprograma
	left join situacaopropriedade on propriedade.idsituacaopropriedade=situacaopropriedade.idsituacaopropriedade
	left join usuario on usuario.idtecnico = tecnico.idtecnico
	,produtor where 
	propriedade.idprodutor = produtor.idprodutor ';

	// AJUSTE NO SISTEMA
	if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])))
	{
	
	}
	else
	{
		if (!empty($_SESSION['s_idtecnico']))
		{
			$sql.= ' and (propriedade.idtecnico = '.$_SESSION['s_idtecnico'].') ';
		}
	}
	// fim ajuste no sistema

	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	if ($tipofiltro == 'PROPRIEDADE')
	{
		$sql_where = ' and upper(sem_acentos(nomepropriedade)) like upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}
	if ($tipofiltro == 'PRODUTOR')
	{
		$sql_where = ' and upper(sem_acentos(nomeprodutor)) like upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}
	if ($tipofiltro == 'TECNICO')
	{
		$sql_where = ' and upper(sem_acentos(nometecnico)) like upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}

	$sql.= $sql_where;
	$sql_ordenacao = '';
	if ($o == 'NOME')
	{
	   $sql_ordenacao = ' order by upper(sem_acentos(propriedade.nomepropriedade))';
	}

	$sql.=$sql_ordenacao;
	//echo $sql;
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



