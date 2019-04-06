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
                      <th width="25%">Nome Produtor</th>
                      <th width="15%">Endereco</th>
                      <th width="10%">Municipio</th>
                      <th width="5%">Estado</th>
                      <th width="25%">Telefone e Email</th>
                      <th width="25%">Tecnico</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			 $html = ' 
                      <td align="center"><input type="checkbox" name="id_produtor[]" id="id_produtor" value="'.$row["idprodutor"].'" /></td>
					  <td><a href="cadprodutor.php?op=A&id='.$row["idprodutor"].'">'.$row["nomeprodutor"].'</a></td>
					  <td>'.$row["endereco"].'</td>
					  <td>'.$row["municipio"].'</td>
					  <td>'.$row["uf"].'</td>
					  <td>Tel.:'.$row["telefone"].'<br>Cel: '.$row["celular"].'<br>Email: '.$row["email"].'</td>
					  <td>'.$row["nometecnico"].'</td>
					  ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select produtor.*,tecnico.nometecnico,tecnico.idtecnico from produtor,tecnico where produtor.idtecnico = tecnico.idtecnico and produtor.idprodutor = produtor.idprodutor ';
	// AJUSTE NO SISTEMA
	// AJUSTE NO SISTEMA
	if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])))
	{
	
	}
	else
	{
		if (!empty($_SESSION['s_idtecnico']))
		{
			$sql.= ' and (produtor.idtecnico = '.$_SESSION['s_idtecnico'].' or produtor.idtecnico is null ) ';
		}
	}

	// fim ajuste no sistema
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	if ($tipofiltro == 'NOME')
	{
		$sql_where = ' and upper(sem_acentos(nomeprodutor)) ilike upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}
	if ($tipofiltro == 'TECNICO')
	{
		$sql_where = ' and upper(sem_acentos(nometecnico)) ilike upper(sem_acentos(\'%'.$valorfiltro.'%\'))';
	}

	$sql.= $sql_where;
	$sql_ordenacao = '';
	if ($o == 'NOME')
	{
	   $sql_ordenacao = ' order by upper(sem_acentos(nomeprodutor))';
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



