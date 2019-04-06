<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
//	  require_once('classes/categoira.class.php');
	  
	  $FORM_ACTION = 'sindicato';
	  $tipofiltro = $_REQUEST['cmboxtipofiltro'];
	  $valorfiltro = $_REQUEST['edtvalorfiltro'];
	  $ordenapor = $_REQUEST['cmboxordenar'];
	  
	  //print_r($_REQUEST);
	class MyPag extends Paginacao
	{
		function desenhacabeca($row)
		{
		 	 $html = '
			 <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">Sindicato </th>
                                                <th class="column-title no-link last"><span class="nobr">Ação</span>
                                                </th>
                                                <th class="bulk-actions" colspan="7">
                                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                </tr>
                            </thead>
                      ';
		 		echo $html;
		}

		function desenha($row){
			$resumida = '';
			if ($row['resumida']=='t')
			{
				$resumida = 'checked';
			}
			$html = '<td class="a-center "><input type="checkbox" class="flat" name="id_sindicato[]" id="id_sindicato" value="'.$row["idsindicato"].'" ></td>
                                    <td class=" ">'.$row['sindicato'].'</td>
                                    <td class=" last"><a href="cadsindicato.php?op=A&id='.$row['idsindicato'].'" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>
                                                    </td>';
													
			// $date = new DateTime($row['datacadastro']);
			/*$html = ' 
                      <td align="center"><input type="checkbox" name="id_[]" id="id_" value="'.$row["iddescricao"].'" /></td>
					  <td nowrap><a href="caddescricao.php?op=A&id='.$row['iddescricao'].'">'.$row["descricao"].'</a></td>
					  ';
*/		 	

	echo $html;
				echo "";
		}// function
	}	  
	  
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Paginacao = new MyPag();
$Paginacao->conn = $conn;
$sql = 'select * from sindicato where idsindicato = idsindicato
 ';

if ($tipofiltro=='NOME')
{
   $sql.= " and sindicato ilike '%".$valorfiltro."%'";	
}



if (($ordenapor=='NOME') || ($ordenapor==''))
{
   $sql.= " order by sindicato";	
}

//echo $sql;

    $Paginacao->sql = $sql; // a  sem o filtro
	$Paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$Paginacao->order = $_REQUEST['o']; // como serᡯrdenado o resultado
	$Paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1  que  por linha
	$Paginacao->numero_linhas = $_REQUEST['nr']; // quantidade de linhas por p⨩nas
	$Paginacao->quadro = ''; // conte򤯠em a ser exibido
	$Paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$Paginacao->largura_coluna = '100%';
	$Paginacao->mostra_informe = 'T';//
	$Paginacao->pagina = $_REQUEST['p'];//$_REQUEST['p']; // p⨩na que est኉$paginacao->tamanho_imagem = '60';
	$Paginacao->separador = '' ; // sepador linha que separa as rows
	  
?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Balde Cheio</title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir todos o(s) registros(s)? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>


    <div class="container body">


        <div class="main_container">

           
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    
					<?php require "menu.php";?>
                </div>
            </div>

            <!-- top navigation -->
			<?php require "menutop.php";?>


            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="clearfix"></div>


                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Consulta Sindicato <small>Sindicatos cadastrados no sistema</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                                                            <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                Ação
                                <span class="caret"></span>
                            </a>
                                         <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
										<?php
										if (
										(in_array('ADMINISTRADOR',$_SESSION['s_papel']))
										|| (in_array('AUDITOR',$_SESSION['s_papel']))
										|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
										)
										{
											?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick='showExcluir()'>Excluir</a>
                                            </li>
										<?php } ?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="cadsindicato.php?op=I">Novo</a>
                                            </li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="imprimir('pdf')">Imprimir</a>
                                            </li>
                                            <li role="presentation" class="divider"></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="imprimir('xls')">Gerar XLS</a>
                                            </li>
                                        </ul>
                                    </li>
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    </li>
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
								<form class="form-inline" name="frm" id="frm" method="post">
								<input type="hidden" name="sql" id="sql" value="<?php echo $Paginacao->sql;?>">
                                <div class="x_content">
                                   
                                <p>
								<div class="form-group">
                                    <label for="cmboxtipofiltro">Filtro</label>
                                    <select id="cmboxtipofiltro" name="cmboxtipofiltro" class="form-control">
                                                    <option value="NOME" <?php if ($tipofiltro=='NOME') echo "selected";?>>Nome</option>
                                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edtvalorfiltro">Filtro</label>
                                    <input id="edtvalorfiltro" name="edtvalorfiltro" class="form-control" placeholder="Filtro" value="<?php echo $valorfiltro;?>">
                                </div>
                                <div class="form-group">
                                    <label for="cmboxordenar">Ordenar por</label>
                                    <select id="cmboxordenar" name="cmboxordenar" class="form-control">
                                                    <option value="NOME" <?php if ($ordenapor=='NOME') echo "selected";?>>Nome</option>
                                                    </select>
                                </div>
								<button type="button" class="btn btn-success" onClick='filterApply()'>Filtrar</button>
								
                            </p>
							    <div style="overflow:auto;"> 
                <div class="table-responsive"> 
								<?php $Paginacao->paginar();?>
								</div>
								</div>
                              </div>
								</form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- footer content -->
                <footer>
                    <div class="">
                        <p class="pull-right"> 
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>

    <script src="js/custom.js"></script>
	
	<script>
	
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').target = '_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}

	function filterApply()
	{
		document.getElementById('frm').target = '_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
	}

	function imprimir(tipo)
	{
		alert(tipo);
		document.getElementById('frm').target="_blank";//"'cons<?php echo strtolower($FORM_ACTION);?>.php';
		if (tipo=='pdf')
		{
			document.getElementById('frm').action='relsindicato.php';
			document.getElementById('frm').submit();
		}
		if (tipo=='xls')
		{
			document.getElementById('frm').action='relsindicatoExcel.php';
			document.getElementById('frm').submit();
		}
	}

	function novo()
	{
		window.location.href = 'cad<?php echo strtolower($FORM_ACTION);?>.php?op=I';
	}

	
	function removeFilter()
	{
		window.location.href = 'cons<?php echo strtolower($FORM_ACTION);?>.php';
	}

	function showExcluir()
	{
		$('#myModal').modal({
  		keyboard: true
	})
	}
	
	function excluir()
	{
		$('#myModal').modal('hide');
		document.getElementById('frm').action='exec.<?php echo strtolower($FORM_ACTION);?>.php?op=E';
  			document.getElementById('frm').submit();
	}	
	
	</script>

</body>

</html>