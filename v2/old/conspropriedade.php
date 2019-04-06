<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
	  require_once('classes/programa.class.php');
	  
	  $FORM_ACTION = 'propriedade';

	  $tipofiltro = $_REQUEST['cmboxtipofiltro'];
	  	  if (empty($tipofiltro))
	  {
		  $tipofiltro = 'NOME';
	  }

	  $valorfiltro = $_REQUEST['edtvalorfiltro'];
	  $ordenapor = $_REQUEST['cmboxordenar']; 
	  $ativo = $_REQUEST['chkboxativo'];
	  
	 // print_r($_REQUEST);
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
                                                <th class="column-title">Nome </th>
                                                <th class="column-title">Produtor </th>
                                                <th class="column-title">Município </th>
                                                <th class="column-title">Programa </th>
                                                <th class="column-title">Situação </th>
                                                <th class="column-title">Técnico </th>
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
			$html = '<td class="a-center "><input type="checkbox" class="flat" name="id_propriedade[]" id="id_propriedade" value="'.$row["idpropriedade"].'" ></td>
                                    <td class=" ">'.$row['nomepropriedade'].'</td>
                                    <td class=" ">'.$row['nomeprodutor'].'</td>
                                    <td class=" ">'.$row['municipio'].'</td>
                                    <td class=" ">'.$row['programa'].'</td>
                                    <td class=" ">'.$row['situacaopropriedade'].'<br>
									<td class=" ">'.$row['nometecnico'].'</td>
                                    <td class=" last"><a href="cadpropriedade.php?op=A&id='.$row['idpropriedade'].'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
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



if ($tipofiltro=='NOME')
{
   $sql= "
   select * from propriedade prop left join programa p on
prop.idprograma = p.idprograma
left join tecnico t on
prop.idtecnico = t.idtecnico
left join situacaopropriedade sp on
prop.idsituacaopropriedade = sp.idsituacaopropriedade,

 produtor prod
where
prop.idprodutor = prod.idprodutor and
 prop.nomepropriedade ilike '%".$valorfiltro."%'";	
}

if ($tipofiltro=='PRODUTOR')
{
   $sql= "
   select * from propriedade prop left join programa p on
prop.idprograma = p.idprograma
left join tecnico t on
prop.idtecnico = t.idtecnico
left join situacaopropriedade sp on
prop.idsituacaopropriedade = sp.idsituacaopropriedade,

 produtor prod
where
prop.idprodutor = prod.idprodutor and
 prod.nomeprodutor ilike '%".$valorfiltro."%'";	
}


if ($tipofiltro=='PROGRAMA')
{
$sql="
   select * from propriedade prop inner join programa p on
prop.idprograma = p.idprograma
left join tecnico t on
prop.idtecnico = t.idtecnico
left join situacaopropriedade sp on
prop.idsituacaopropriedade = sp.idsituacaopropriedade,

 produtor prod
where
prop.idprodutor = prod.idprodutor and
 p.programa ilike '%".$valorfiltro."%'";	
	
}

if ($tipofiltro=='TECNICO')
{
$sql="
   select * from propriedade prop left join programa p on
prop.idprograma = p.idprograma
inner join tecnico t on
prop.idtecnico = t.idtecnico
left join situacaopropriedade sp on
prop.idsituacaopropriedade = sp.idsituacaopropriedade,

 produtor prod
where
prop.idprodutor = prod.idprodutor and
 t.nometecnico ilike '%".$valorfiltro."%'";	
 
	
}
if ($ativo=='S')
{
	$sql.=" and prop.idsituacaopropriedade = 1";
}

if (
										(in_array('ADMINISTRADOR',$_SESSION['s_papel']))
										|| (in_array('AUDITOR',$_SESSION['s_papel']))
										|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
										|| (in_array('OPERADOR',$_SESSION['s_papel']))
										)
										{
										}
										else
										{
										$sql.= ' and t.idtecnico = '.$_SESSION['s_idtecnico'];
										}										
											
//echo $sql;										
//$sql.=' group by 1,2,3,4,5,6 ,7';

if ($ordenapor=='NOME')
{
   $sql.= " order by upper(sem_acentos(prop.nomepropriedade))";	
}

if ($ordenapor=='PRODUTOR')
{
   $sql.= " order by upper(sem_acentos(prod.nomeprodutor))";	
}

if ($ordenapor=='TECNICO')
{
   $sql.= " order by upper(sem_acentos(t.nometecnico))";	
}

echo $sql;

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
                                    <h2>Consulta Propriedade <small>Propriedades cadastrados no sistema</small></h2>
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
											<li role="presentation"><a role="menuitem" tabindex="-1" href="cadpropriedade.php?op=I">Novo</a>
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
                                    <div class="clearfix"></div>
                                </div>
<form class="form-inline" name="frm" id="frm" method="post">
                                <div class="x_content">
                                   
                                <p>
								<div class="form-group">
                                    <label for="cmboxtipofiltro">Filtro</label>
                                    <select id="cmboxtipofiltro" name="cmboxtipofiltro" class="form-control">
                                                    <option value="NOME" <?php if ($tipofiltro=='NOME') echo "selected";?>>Propriedade</option>
                                                    <option value="PRODUTOR" <?php if ($tipofiltro=='PRODUTOR') echo "selected";?>>Produtor</option>
                                                    <option value="PROGRAMA" <?php if ($tipofiltro=='PROGRAMA') echo "selected";?>>Programa</option>
                                                    <option value="TECNICO" <?php if ($tipofiltro=='TECNICO') echo "selected";?>>Técnico</option>
                                                </select>
                                </div>
                                <div class="form-group">
                                    <label for="edtvalorfiltro">Filtro</label>
                                    <input id="edtvalorfiltro" name="edtvalorfiltro" class="form-control" placeholder="Filtro" value="<?php echo $valorfiltro;?>">
                                </div>
                                <input type="checkbox" class="flat" name="chkboxativo" id="chkboxativo" value="S" <?php if ($ativo=='S') {echo 'checked';}?>> Ativos
								
								<button type="button" class="btn btn-success" onClick='filterApply()'>Filtrar</button>
								<div class="form-group">
                                    <label for="cmboxordenar">Ordenar por</label>
                                    <select id="cmboxordenar" name="cmboxordenar" class="form-control">
                                                    <option value="NOME" <?php if ($ordenapor=='NOME') echo "selected";?>>Propriedade</option>
                                                    <option value="TECNICO" <?php if ($ordenapor=='TECNICO') echo "selected";?>>Técnico</option>
                                                    <option value="PRODUTOR" <?php if ($ordenapor=='PRODUTOR') echo "selected";?>>Produtor</option>
                                                </select>
                                </div>
                            </p>
							    
								<?php $Paginacao->paginar();?>
                              </div>
								</form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- footer content -->
                <footer>
                    <div class="">
                        
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
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}

	function filterApply()
	{
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
	}

	function imprimir(tipo)
	{
		if (tipo=='xls')
		{
			window.location.href = 'rel<?php echo strtolower($FORM_ACTION);?>excel.php';
		}
		if (tipo=='pdf')
		{
			window.location.href = 'rel<?php echo strtolower($FORM_ACTION);?>.php';
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
//		showalert("Deleted","alert-error");
		document.getElementById('frm').action='exec.<?php echo strtolower($FORM_ACTION);?>.php?op=E';
  			document.getElementById('frm').submit();
	  	//$('#myModal').modal();
	}	
	
	
	</script>

</body>

</html>