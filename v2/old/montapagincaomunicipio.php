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
                      <th width="20%">Municipio</th>
                      <th width="10%">Estado</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			// $date = new DateTime($row['datacadastro']);
			 
			$html = ' 
                      <td align="center"><input type="checkbox" name="id_[]" id="id_" value="'.$row["idmunicipio"].'" /></td>
					  <td><a href="cadmunicipio.php?op=A&id='.$row["idmunicipio"].'">'.$row["municipio"].'</a></td>
                      <td>'.$row["estado"].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = " select * from municipio,estado where municipio.idmunicipio = municipio.idmunicipio and estado.idestado = municipio.idestado";
	
//	echo $sql;
//	exit;
	
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	if ($tipofiltro == 'MUNICIPIO')
	{
		$sql_where = ' and municipio ilike \'%'.$valorfiltro.'%\'';
	}
	$sql.= $sql_where;

	$sql_ordenacao = '';
	if ($o == 'MUNICIPIO')
	{
	   $sql_ordenacao = ' order by municipio.municipio';
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



