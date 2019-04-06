<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php
require_once('classes/conexao.class.php');
require_once('classes/produtor.class.php');
require_once('classes/propriedade.class.php');
require_once('classes/estado.class.php');
require_once('classes/tecnico.class.php');
require_once('classes/unidademedida.class.php');
require_once('classes/situacaopropriedade.class.php');
require_once('classes/programa.class.php');
require_once('classes/visitatecnica.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$UnidadeMedida = new UnidadeMedida();
$UnidadeMedida->conn = $conn;

$SituacaoPropriedade = new SituacaoPropriedade();
$SituacaoPropriedade->conn = $conn;

$Estado = new Estado();
$Estado->conn = $conn;

$Programa = new Programa();
$Programa->conn = $conn;

$VisitaTecnica = new VisitaTecnica();
$VisitaTecnica->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$anoreferencia = date('Y');
$mesreferencia = date('m');

if ($op=='A')
{
	$VisitaTecnica->getById($id);
	
	$idpropriedade = $VisitaTecnica->idpropriedade;// = $row['idpropriedade'];
	$idtecnico = $VisitaTecnica->idtecnico ;//= $row['nomepropriedade'];
	$datavisita = $VisitaTecnica->datavisita ;//= $row['inscricaoestadual'];
	$relatorio = $VisitaTecnica->relatorio ;//= $row['tecnicoresponsavel'];
	$horachegada = $VisitaTecnica->horachegada;// = $row['tamanho'];
	$horasaida = $VisitaTecnica->horasaida;// = $row['tamanho'];
	$mesreferencia = $VisitaTecnica->mesreferencia;// = $row['idunidademedida'];
	$anoreferencia = $VisitaTecnica->anoreferencia ;//= $row['endereco'];
	$areaprojeto = $VisitaTecnica->areaprojeto;// = $row['municipio'];
	$producaodia = $VisitaTecnica->producaodia ;//= $row['uf'];
	$idunidademedida = $VisitaTecnica->idunidademedida ;//= $row['latitude'];
   	$vacaslactacao = $VisitaTecnica->numvacaslactacao;// = $row['longitude'];
   	$vacassecas = $VisitaTecnica->numvacassecas ;//= $row['idsituacaopropriedade'];
   	$dataproximavisita = $VisitaTecnica->dataproximavisita ;//= $row['idtipoconsultoria'];
	echo $idtecnico;
}

$filtrotecnico = $_SESSION['s_idtecnico'];
if (
	(in_array('ADMINISTRADOR',$_SESSION['s_papel']))
	|| (in_array('AUDITOR',$_SESSION['s_papel']))
	|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
	|| (in_array('OPERADOR',$_SESSION['s_papel']))
	)
{
	$filtrotecnico = '';
}
?>
<head>
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

    <div class="container body">


        <div class="main_container">


            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <!--<div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Balde Cheio</span></a>
                    </div>
                    -->
					<div class="clearfix"></div>
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
                                    <h2>Visita Técnica <small>Cadastro de visita técnica</small></h2>                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form name='frm' id='frm' action='exec.visitatecnica.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                                        
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Propriedade<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,'','N',$filtrotecnico,'class="form-control"');?>
											</div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Data Visita <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<input id="edtdatavisita" name="edtdatavisita" value="<?php 
												if (!empty($datavisita))
												{
												echo date('d/m/Y',strtotime($datavisita));
												}
												?>" class="date-picker form-control col-md-7 col-xs-12" type="text" >
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Hora Chegada / Saída<span class="required"></span>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input type="text" id="edthorachegada" name="edthorachegada" value="<?php echo $horachegada;?>" class="form-control" data-inputmask="'mask': '99:99'">
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input type="text" id="edthorasaida" name="edthorasaida" value="<?php echo $horachegada;?>" class="form-control" data-inputmask="'mask': '99:99'">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mês/Ano Referência<span class="required"></span>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input id="edtmesreferencia" value="<?php echo $mesreferencia;?>" class="form-control col-md-7 col-xs-12" name="edtmesreferencia" placeholder="mes referencia" type="text">
                                            </div>
											<div class="col-md-3 col-sm-3 col-xs-2">
                                                <input id="edtanoreferencia" value="<?php echo $anoreferencia;?>" class="form-control col-md-7 col-xs-12" name="edtanoreferencia" placeholder="ano referencia" type="text">
                                            </div>

                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Area Projeto<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input id="edtareaprojeto" value="<?php echo $areaprojeto;?>" class="form-control col-md-7 col-xs-12" name="edtareaprojeto" placeholder="" type="text">
                                            </div>
											<div class="col-md-2 col-sm-2 col-xs-12">
                                                <?php echo $UnidadeMedida->listaCombo('cmboxunidademedida',$idunidademedida,'A','S','N','class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Produção Dia (litros)<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-2">
                                                <input id="edtproducaodia" value="<?php echo number_format($producaodia,2,',','');?>" class="form-control col-md-7 col-xs-12" name="edtproducaodia" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Vacas Lactação<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-2">
                                                <input id="edtvacaslactacao" value="<?php echo number_format($vacaslactacao,0,',','');?>" class="form-control col-md-7 col-xs-12" name="edtvacaslactacao" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Vacas Secas<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-2">
                                                <input id="edtvacassecas" value="<?php echo number_format($vacassecas,0,',','');?>" class="form-control col-md-7 col-xs-12" name="edtvacassecas" placeholder="" type="text">
                                            </div>
                                        </div>
                                        
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Relatório <span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea id="edtrelatorio"  name="edtrelatorio" class="form-control col-md-7 col-xs-12"><?php echo $relatorio;?></textarea>
                                            </div>
                                        </div>										
                                        	
																				
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Data próxima visita<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<input id="edtdataproximavisita" name="edtdataproximavisita" value="<?php 
												if (!empty($dataproximavisita))
												{
												echo date('d/m/Y',strtotime($dataproximavisita));
												}
												?>" class="date-picker form-control col-md-7 col-xs-12" type="text" >
                                            </div>
                                        </div>
                                       
									    <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Técnico<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php 
												if (
										(in_array('ADMINISTRADOR',$_SESSION['s_papel']))
										|| (in_array('AUDITOR',$_SESSION['s_papel']))
										|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
										|| (in_array('OPERADOR',$_SESSION['s_papel']))
										)
										{
												echo $Tecnico->listaCombo('cmboxtecnico',$idtecnico,'N','N','class="form-control"');
										}
										else
										{?>
											<input type="hidden" value="<?php echo $_SESSION['s_idtecnico'];?>" id="cmboxtecnico" name="cmboxtecnico">
											<input  class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $_SESSION['s_nome'];?>" id="edtnometecnico" name="edtnometecnico" disabled>
											<?php 
										}
										?>		    
											</div>
                                        </div>

                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button id="send" type="button" onclick="enviar()" class="btn btn-success">Enviar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
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
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>

<!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>		
 <!-- input mask -->
    <script src="js/input_mask/jquery.inputmask.js"></script>	

    <script>
	
		
<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
?>
		$(document).ready(function () {
            $(":input").inputmask();
        });		
		
function enviar()
		{
			if (
			(document.getElementById('cmboxpropriedade').value=='') ||
			(document.getElementById('edtdatavisita').value=='')
			)
			{
				criarNotificacao('Atenção','Verifique o preenchimento','warning');
			}
			else
			{
				document.getElementById('frm').submit();
			}
		}		
	
	$(document).ready(function () {
                            $('#edtdataproximavisita').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
							$('#edtdatavisita').daterangepicker({
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