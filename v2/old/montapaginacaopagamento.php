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
                      <th width="25%">Propriedade</th>
                      <th width="25%">T&eacute;cnico</th>
                      <th width="25%">Mes/Ano Ref.</th>
                      <th width="25%">Qtd. visitas</th>
                      <th width="25%">Data Pagto</th>
                      <th width="25%">Valor</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 //$date = new DateTime($row['datacadastro']);
			 $data = $row['datapagamento'];
			 if (!empty($data))
			 {
			 	$data = date('d/m/Y', strtotime($row["datapagamento"]));
			 }
			 $html = ' 
                      <td align="center"><input type="checkbox" name="id_visitatecnica[]" id="id_visitatecnica" value="'.$row["idvisitatecnica"].'" /></td>
					  <td><a href="cadvisitatecnica.php?op=A&id='.$row["idvisitatecnica"].'">'.$row["nomepropriedade"].'</a></td>
					  <td>'.$row["nometecnico"].'</td>
					  <td>'.$row["mesreferencia"].'/'.$row["anoreferencia"].'</td>
					  <td>'.$row['qtd'].'</td>
					  <td>'.$data.'</td>
					  <td>'.$row["valor"].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select visitatecnica.mesreferencia,
visitatecnica.anoreferencia,
tecnico.nometecnico,
propriedade.nomepropriedade,
visitatecnica.datapagamento,
visitatecnica.valorpago,
count(*) as qtd
  from visitatecnica, propriedade, tecnico where
visitatecnica.idpropriedade = propriedade.idpropriedade and
visitatecnica.idtecnico = tecnico.idtecnico
group by 1,2,3,4,5,6 ';
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	if ($tipofiltro == 'PROPRIEDADE')
	{
		$sql_where = ' and upper(propriedade.nomepropriedade) like upper(\'%'.$valorfiltro.'%\')';
	}

	if ($tipofiltro == 'TECNICO')
	{
		$sql_where = ' and upper(tecnico.nometecnico) like upper(\'%'.$valorfiltro.'%\')';
	}

	$sql.= $sql_where;
	$sql_ordenacao = '';
	if ($o == 'DATA')
	{
	   $sql_ordenacao = ' order by visitatecnica.datavisita';
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



