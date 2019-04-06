<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
	  require_once('classes/programa.class.php');
	  require_once('classes/produtor.class.php');
	  require_once('classes/propriedade.class.php');
	  require_once('classes/tecnico.class.php');
	  	  
	  $FORM_ACTION = 'cobertura';
	  
	  
	  $idprodutor = $_REQUEST['idprodutor'];
	  $idpropriedade = $_REQUEST['idpropriedade'];
	  $numero = $_REQUEST['numero'];
	  $ano = $_REQUEST['ano'];

	  $idtecnico = $_SESSION['s_idtecnico'];
	  if ( (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
		|| (in_array('AUDITOR',$_SESSION['s_papel']))
		|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
		)
	  {
		  $idtecnico = $_REQUEST['cmboxtecnico'];
	  }
	  
	  
	
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
                                                <th class="column-title">Data </th>
                                                <th class="column-title">Peso (Kg) </th>';
                                                
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

			
			
			$acoes = '<a target="_blank" href="cadrebanho.php?&op=A&idprodutor='.$idprodutor.'&numero='.$row['numero'].'&ano='.$row['ano'].'&idpropriedade='.$row['idpropriedade'].'" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i></a>';
			$acoes .= '<a target="_blank" href="cadparto.php?idprodutor='.$idprodutor.'&numero='.$row['numero'].'&ano='.$row['ano'].'&idpropriedade='.$row['idpropriedade'].'" class="btn btn-primary btn-xs"><i class="fa fa-files-o"></i></a>';
			
			$html = '<td class="a-center '.$inativo.'"><input type="checkbox" class="flat" name="id_visitatecnica[]" id="id_visitatecnica" value="'.$row["idvisitatecnica"].'" ></td>
                                    <td class="'.$inativo.'">'.date('d/m/Y',strtotime($row['datacobertura'])).'</td>
                                    <td class="'.$inativo.'">'.$row['touro'].'</td>
                                    <td class="'.$inativo.'">'.$row['observacao'].'</td>';
									$html.='
                                    <td class=" last">'.$acoes.'
                                    </td>';
													

	echo $html;
				echo "";
		}// function
	}	  
	  
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Programa = new Programa();
$Programa->conn = $conn;

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$Paginacao = new MyPag();
$Paginacao->conn = $conn;



$sql="
select * from balanca c where idpropriedade = ".$idpropriedade." and ano = ".$ano." and numero = ".$numero."
";	
 



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
						<form name="frm" id="frm" method="post" class="form-horizontal form-label-left">
					 <div class="x_panel">
                        <div class="x_title">
                            <h2>Balança <small> </small></h2>
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

                                <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Data de Controle <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<input id="edtdatacontrole" name="edtdatacontrole" value="<?php 
												if (!empty($datacontrole))
												{
												echo date('d/m/Y',strtotime($datacontrole));
												}
												?>" class="date-picker form-control col-md-7 col-xs-12" type="text" >
                                            </div>
                                        </div>
										 <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Peso (Kg)<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtpeso" value="<?php echo $peso;?>" class="form-control col-md-7 col-xs-12" name="edtpeso" placeholder=""  type="text">
                                            </div>
                                        </div>
								<div class="col-md-1 col-sm-12 col-xs-12 form-group">
										
                                     <button type="button" class="btn btn-success" onClick='filterApply()'>Salvar</button>
								</div>
							</div>
							

                        </div>
                    </div>
					
					
					
                        
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Balança<small></small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                                                            <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                Ação
                                <span class="caret"></span>
                            </a>
                                        <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="consbalanca.php?op=I&idprodutor=<?php echo $idprodutor;?>&ano=<?php echo $ano;?>&idpropriedade=<?php echo $idpropriedade;?>">Novo</a>
                                            </li>
                                           <!--<li role="presentation"><a role="menuitem" tabindex="-1" onClick='showExcluir()'>Excluir</a>
                                            </li>-->
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
								
								<table class="table table-hover">
																<?php echo $Paginacao->sql;
																$Paginacao->paginar();?>

								<thead>
								<tr>
				<?php 
?>

                                    
                              </div>
								
                            </div>
                       
                    </div>
</form>
                </div>

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

<!-- daterangepicker -->
        <script type="text/javascript" src="js/moment.min2.js"></script>
        <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>	
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
       
	


	function filterApply()
	{
		document.getElementById('frm').target='_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
	}
	


	function imprimir(tipo)
	{
		alert(tipo);
	}


	
	function removeFilter()
	{
		window.location.href = 'cons<?php echo strtolower($FORM_ACTION);?>.php';
	}
	
	$(document).ready(function () {
                            $('#edtdatacontrole').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        });
        // initialize the validator function
        validator.message['date'] = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
            .on('keyup blur', 'input', function () {
                validator.checkField.apply($(this).siblings().last()[0]);
            });

        // bind the validation to the form submit event
        //$('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();
            return false;
        });

        /* FOR DEMO ONLY */
        $('#vfields').change(function () {
            $('form').toggleClass('mode2');
        }).prop('checked', false);

        $('#alerts').change(function () {
            validator.defaults.alerts = (this.checked) ? false : true;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);
	
	</script>

</body>

</html>