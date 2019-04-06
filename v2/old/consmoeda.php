<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
	  require_once('classes/moeda.class.php');
	  require_once('classes/pais.class.php');
	  require_once('classes/material.class.php');
	  require_once('classes/estadoconservacao.class.php');
	  
	  $FORM_ACTION = 'moeda';
	  $tipofiltro = $_REQUEST['cmboxtipofiltro'];
	  $ordenapor = $_REQUEST['cmboxordenar'];
	  $financeiro = false;
	  
	  
	  if (empty($tipofiltro))
	  {
		  $tipofiltro = 'NOME';
	  }
	  
	  $idpais = $_REQUEST['cmboxpais'];
	  $idestadoconservacao = $_REQUEST['cmboxestadoconservacao'];
	  $idmaterial = $_REQUEST['cmboxmaterial'];
	  $anoinicial = $_REQUEST['edtanoinicial'];
	  $anofinal = $_REQUEST['edtanofinal'];
		  
	
	class MyPag extends Paginacao
	{
		var $financeiro_;
		function desenhacabeca($row)
		{
		 	 $html = '
			 <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">Foto</th>
                                                <th class="column-title">Pais </th>
                                                <th class="column-title">Valor </th>
                                                <th class="column-title">Ano</th>
                                                <th class="column-title">Material </th>
                                                <th class="column-title">Diametro </th>
                                                <th class="column-title">Estado Conservação </th>
                                                <th class="column-title">Texto Cara/Coroa</th>
                                                ';
												
                                                $html.='<th class="column-title no-link last"><span class="nobr">Ação</span>
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
			$acoes = '<a href="cadmoeda.php?op=A&id='.$row['idmoeda'].'" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>';
			
			$html = '<td class="a-center '.$inativo.'"><input type="checkbox" class="flat" name="id_moeda[]" id="id_moeda" value="'.$row["idmoeda"].'" ></td>
                                    <td class="'.$inativo.'"><table><tr>';
			if ($handle = @opendir('uploads/'.$row['idmoeda'])) {
				while (false !== ($file = readdir($handle))) {
					if (($file!='.') && ($file!='..'))
					{
					$arquivo = 'uploads/'.$row['idmoeda'].'/'.$file;
					$html.=
					'
                                                
                                                    <td><a href="cadmoeda.php?op=A&id='.$row['idmoeda'].'" class="btn btn-primary btn-xs"><img style="width: 100px; display: block;" src="'.$arquivo.'" alt="image" /></a></td>
                                                
                                           ';
					}
				}
				closedir($handle);
			}
			$html.='</tr></table>';
									
									$html.='</td>
                                    <td class="'.$inativo.'"><a href="cadmoeda.php?op=A&id='.$row['idmoeda'].'">'.$row['pais'].'</a></td>
                                    <td class="'.$inativo.'"><a href="cadmoeda.php?op=A&id='.$row['idmoeda'].'">'.$row['valor'].' '.$row['dinheiro'].'</a></td>
                                    <td class="'.$inativo.'">'.$row['ano'].'</td>
                                    <td class="'.$inativo.'">'.$row['material'].'</td>
                                    <td class="'.$inativo.'">'.$row['diametro'].'</td>
                                    <td class="'.$inativo.'">'.$row['estadoconservacao'].'</td>
                                    <td class="'.$inativo.'">'.$row['textocara'].' | '.$row['textocoroa'].'</td>
                                    ';
									
									$html.='
                                    <td class=" last">'.$acoes.'
                                    </td>';
													

	echo $html;
				echo "";
		}// function
	}	  
	  
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Moeda = new Moeda();
$Moeda->conn = $conn;

$Pais = new Pais();
$Pais->conn = $conn;

$EstadoConservacao = new EstadoConservacao();
$EstadoConservacao->conn = $conn;

$Material = new Material();
$Material->conn = $conn;

$Paginacao = new MyPag();
$Paginacao->conn = $conn;


   $sql= "select * from moeda m, pais p, estadoconservacao ec,
material mat
   where m.idmoeda = m.idmoeda
   and m.idpais = p.idpais 
   and m.idestadoconservacao = ec.idestadoconservacao
   and m.idmaterial = mat.idmaterial
";


if (!empty($idpais))
{
   $sql.= " and m.idpais = ".$idpais;
}
if (!empty($idestadoconservacao))
{
   $sql.= " and m.idestadoconservacao = ".$idestadoconservacao;
}
if (!empty($idmaterial))
{
   $sql.= " and m.idmaterial = ".$idmaterial;
}
if (!empty($anoinicial))
{
	$sql.=' and (ano >= '.$anoinicial;
	if (!empty($anofinal))
	{
		$sql.=' and ano <= '.$anofinal;
	}
	$sql.=')';
}
else
{
	if (!empty($anofinal))
	{
		$sql.=' and ano <= '.$anofinal;
	}
}

//$sql.=' group by 1,2,3,4,5,6 ,7';

if ($ordenapor=='ANO')
{
   $sql.= " order by ano";	
}

if ($ordenapor=='PAIS')
{
   $sql.= " order by upper(p.pais)";	
}

//echo $sql;

    $Paginacao->sql = $sql; // a  sem o filtro
	$Paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$Paginacao->order = $_REQUEST['o']; // como será¡¯rdenado o resultado
	$Paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1  que  por linha
	$Paginacao->numero_linhas = $_REQUEST['nr']; // quantidade de linhas por pâ¨©nas
	$Paginacao->quadro = ''; // conteò¤¯ em a ser exibido
	$Paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$Paginacao->largura_coluna = '100%';
	$Paginacao->mostra_informe = 'T';//
	$Paginacao->pagina = $_REQUEST['p'];//$_REQUEST['p']; // pâ¨©na que estáŠ‰$paginacao->tamanho_imagem = '60';
	$Paginacao->separador = '' ; // sepador linha que separa as rows
	$Paginacao->financeiro_ = $financeiro;  
?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Moeda</title>

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
						<form name="frm" id="frm" method="post" class="form-horizontal form-label-left">

								<div id="myModalEstorno" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Estornar Pagamento</h4>
                                            </div>
                                            <div class="modal-body">
												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Motivo</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='id' name='id' type="hidden" class="form-control" value="<?php echo $id;?>">
												<textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
												</div>
												</div>                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                <button type="button" class="btn btn-primary" onClick="execEstornarPagamento()" >Salvar</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
						
								<div id="myModalPagamento" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Lançar Pagamento</h4>
                                            </div>
                                            <div class="modal-body">
												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Data pagto</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='id' name='id' type="hidden" class="form-control" value="<?php echo $id;?>">
												<input id='edtdatapagamento' name='edtdatapagamento' type="text" class="form-control" data-inputmask="'mask': '99/99/9999'">
												</div>
												</div>

												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Valor</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='edtvalorpago' name='edtvalorpago' type="text" class="form-control" value="">
												</div>
												</div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                <button type="button" class="btn btn-primary" onClick="execLancarPagamento()" >Salvar</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

					 <input type="hidden" name="FINANC" value="<?php echo $_REQUEST['FINANC'];?>">
					 <input type="hidden" name="datainicio" value="<?php echo $datainicio;?>">
					 <input type="hidden" name="datafim" value="<?php echo $datafim;?>">
					 <div class="x_panel">
                        <div class="x_title">
                            <h2>Filtros <small>Utilize os filtros abaixo para realizar a consulta </small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="row">

                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Pais->listaCombo('cmboxpais',$idpais,'S','class="form-control"');?>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Material->listaCombo('cmboxmaterial',$idmaterial,'S','class="form-control"');?>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <?php echo $EstadoConservacao->listaCombo('cmboxestadoconservacao',$idestadoconservacao,'S','class="form-control"');?>
                                </div>
							</div>
							<div class="row">	
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
										<select id="cmboxordenar" name="cmboxordenar" class="form-control">
                                                    <option value="ANO" <?php if ($ordenapor=='ANO') echo "selected";?>>Ordenar por ano</option>
                                                    <option value="PAIS" <?php if ($ordenapor=='PAIS') echo "selected";?>>Ordenar por país</option>
                                                </select>
								</div>

                               <div class="col-md-1 col-sm-12 col-xs-12 form-group">
										
                                     <button type="button" class="btn btn-success" onClick='filterApply()'>Filtrar</button>
								</div>
                            </div>

                        </div>
                    </div>
					
					
					
                        
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Consulta Moedas <small>Moedas cadastradas no sistema</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                                                            <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                Ação
                                <span class="caret"></span>
                            </a>
                                        <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
											<li role="presentation"><a role="menuitem" tabindex="-1" href="cadmoeda.php?op=I">Novo</a>
                                            </li>
                                           <li role="presentation"><a role="menuitem" tabindex="-1" onClick='showExcluir()'>Excluir</a>
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

                                <div class="x_content">
								<div style="overflow:auto;"> 
                <div class="table-responsive"> 
								<?php $Paginacao->paginar();?>
								</div>
								</div>
                              </div>
								
                            </div>
                       
                    </div>
</form>
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
	
	<!-- daterangepicker -->
    <script type="text/javascript" src="js/moment.min2.js"></script>
    <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
    
  
	
	
	 <script type="text/javascript">
	   $(document).ready(function () {
            $('#reservation').daterangepicker(null, function (start, end, label) {
                //console.log(start, end, label);
//				start = now()
				alert(start);
				alert(end);
				console.log(start,end,label);
            });
        });
       
	
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').target='_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}

	function filterApply()
	{
		document.getElementById('frm').target='_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
	}
	
	function relPagamentosPeriodo(tipo)
	{
		document.getElementById('frm').target='_blank';
		if (tipo=='pdf')
		{
		document.getElementById('frm').action='relmoeda.php';
    	}
		else{
		document.getElementById('frm').action='relmoedaxls.php';
		}
		document.getElementById('frm').submit();
	}

	function imprimir(tipo)
	{
		alert(tipo);
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
	
	function lancarPagamento()
	{
		$('#myModalPagamento').modal({
  		keyboard: true
	})
	}
	function estornarPagamento()
	{
		$('#myModalEstorno').modal({
  		keyboard: true
	})
	}
	
	function execLancarPagamento()
	{
		var chks = document.getElementsByName('id_moeda[]');
		var hasChecked = false;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				hasChecked = true;
				break;
			}
		
		}
		if (!hasChecked)
		{
		   alert('Selecione uma Moeda');
		   return false;	
		}
		else
		{
			document.getElementById('frm').target='_self';
			document.getElementById('frm').action='exec.lancarpagamento.php';
			document.getElementById('frm').submit();
		}
	}
	
	function execEstornarPagamento()
	{
		var chks = document.getElementsByName('id_moeda[]');
		var hasChecked = false;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				hasChecked = true;
				break;
			}
		
		}
		if (!hasChecked)
		{
		   alert('Selecione uma Moeda');
		   return false;	
		}
		else
		{
			document.getElementById('frm').target='_self';
			document.getElementById('frm').action='exec.estornarpagamento.php';
			document.getElementById('frm').submit();
		}
	}
	
	function imprimirFormulario()
	{
		var chks = document.getElementsByName('id_moeda[]');
		var hasChecked = false;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				hasChecked = true;
				break;
			}
		
		}
		if (!hasChecked)
		{
		   alert('Selecione uma Moeda');
		   return false;	
		}
		else
		{
			document.getElementById('frm').target='_blank';
			document.getElementById('frm').action='exec.relvisitatecnicatecnico.php';
			document.getElementById('frm').submit();
		}
	}	
	
	
	</script>

</body>

</html>