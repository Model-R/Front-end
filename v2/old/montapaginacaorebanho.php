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
                      <th width="3%">Ano</th>
                      <th width="5%">N&uacute;mero</th>
                      <th width="15%">Categoria</th>
                      <th width="30%">Nome</th>
                      <th width="15%">Data Nasc</th>
                      <th width="20%">M&atilde;e</th>
                      <th width="20%">Pai</th>
                      <th width="15%">Porte</th>
                      <th width="15%">Est. Reprod</th>
                      </tr>
                      ';
		 		echo $html;
		}

		function desenha($row){
			 $data = '';
			 if ((empty($row["datanascimento"])) || ($row["datanascimento"]=='1899-12-30'))
			 {
			 	$data = '';
			 }
			 else
			 {
				$data = date('d/m/Y', strtotime($row["datanascimento"]));
			 }
			 $html = ' 
					  <td><a href="controle.php?cmboxprodutor='.$row['idprodutor'].'&cmboxpropriedade='.$row['idpropriedade'].'&ano='.$row["ano"].'&numero='.$row["numero"].'">'.$row["ano"].'</a></td>
					  <td>'.$row["numero"].'</td>
					  <td>'.$row["categoriaanimal"].'</td>
					  <td>'.$row["nome"].'</td>
					  <td>'.$data.'</td>
					  <td>'.$row["nomemae"].'</td>
					  <td>'.$row["nomepai"].'</td>
					  <td>'.$row["porte"].'</td>
					  <td>'.$row["estadoreprodutivo"].'</td>
                      ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
    $sql = ' select r.*,ca.*,prop.idprodutor from rebanho r, categoriaanimal ca, propriedade prop, produtor prod where 
	r.idcategoriaanimal = ca.idcategoriaanimal and 
	r.idpropriedade = prop.idpropriedade and 
	prop.idprodutor = prod.idprodutor
	';
	$o = $_REQUEST['o'];
	$tipofiltro = $_REQUEST['tf'];
	$valorfiltro = $_REQUEST['vf'];

	$idprodutor = $_REQUEST['idprodutor'];
	$idpropriedade = $_REQUEST['idpropriedade'];
	if (empty($idpropriedade)){
		$idpropriedade = 0;
	}
	
	$sql_where = '';
	$sql_where .= ' and r.idpropriedade = '.$idpropriedade;

	$sql.= $sql_where;
	$sql_ordenacao = '';
	if ($o == 'ANO')
	{
	   $sql_ordenacao = ' order by r.ano';
	}
	if ($o == 'NUMERO')
	{
	   $sql_ordenacao = ' order by r.numero';
	}
	if ($o == 'NOME')
	{
	   $sql_ordenacao = ' order by sem_acentos(r.nome)';
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



