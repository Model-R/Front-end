<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php
require_once('classes/conexao.class.php');
require_once('classes/produtor.class.php');
require_once('classes/estado.class.php');
require_once('classes/tecnico.class.php');
require_once('classes/propriedade.class.php');
require_once('classes/unidademedida.class.php');
require_once('classes/situacaopropriedade.class.php');
require_once('classes/programa.class.php');

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

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

if ($op=='A')
{
	$Propriedade->getById($id);
	
	$idpropriedade = $Propriedade->idpropriedade;// = $row['idpropriedade'];
	$idprodutor = $Propriedade->idprodutor ;//= $row['idprodutor'];
		   	$nomepropriedade = 	   	$Propriedade->nomepropriedade ;//= $row['nomepropriedade'];
		   	$inscricaoestadual = $Propriedade->inscricaoestadual ;//= $row['inscricaoestadual'];
		   	$tecnicoresponsavel = $Propriedade->tecnicoresponsavel ;//= $row['tecnicoresponsavel'];
		   	$tamanho = $Propriedade->tamanho;// = $row['tamanho'];
		   	$idunidademedida = $Propriedade->idunidademedida;// = $row['idunidademedida'];
		   	$endereco = $Propriedade->endereco ;//= $row['endereco'];
		   	$municipio = $Propriedade->municipio;// = $row['municipio'];
		   	$uf = $Propriedade->uf ;//= $row['uf'];
		   	$latitude = $Propriedade->latitude ;//= $row['latitude'];
		   	$longitude = $Propriedade->longitude;// = $row['longitude'];
		   	$idsituacaopropriedade = $Propriedade->idsituacaopropriedade ;//= $row['idsituacaopropriedade'];
		   	$idtipoconsultoria = $Propriedade->idtipoconsultoria ;//= $row['idtipoconsultoria'];
			$idtecnico = $Propriedade->idtecnico;// = $row['idtecnico'];
			$dataentradaprojeto = $Propriedade->dataentradaprojeto;// = $row['dataentradaprojeto'];
			$empresacompradoraleite = $Propriedade->empresacompradoraleite;// = $row['empresacompradoraleite'];
			$producaoinicial = $Propriedade->producaoinicial ;//= $row['producaoinicial'];
			$idprograma = $Propriedade->idprograma;//= $row['idprograma'];
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

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Balde Cheio</span></a>
                    </div>
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
                                    <h2>Propriedade <small>Cadastro de propriedade</small></h2>                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form name='frm' id='frm' action='exec.propriedade.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                                        
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Produtor<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'N',$filtrotecnico,'class="form-control"');?>
											</div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Propriedade <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtnomepropriedade" value="<?php echo $nomepropriedade;?>" class="form-control col-md-7 col-xs-12" name="edtnomepropriedade" placeholder="" required="required" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Inscrição Estadual <span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtinscricaoestadual" value="<?php echo $inscricaoestadual;?>" class="form-control col-md-7 col-xs-12" name="edtinscricaoestadual" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Técnico Responsável<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edttecnicoresponsavel" value="<?php echo $tecnicoresponsavel;?>" class="form-control col-md-7 col-xs-12" name="edttecnicoresponsavel" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tamanho<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-2">
                                                <input id="edttamanho" value="<?php echo number_format($tamanho,2,',','');?>" class="form-control col-md-7 col-xs-12" name="edttamanho" placeholder="" type="text">
                                            </div>
											<div class="col-md-2 col-sm-2 col-xs-2">
                                                <?php echo $UnidadeMedida->listaCombo('cmboxunidademedida',$idunidademedida,'','S',$refresh='N','class="form-control"');?>
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Endereço <span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea id="edtendereco"  name="edtendereco" class="form-control col-md-7 col-xs-12"><?php echo $endereco;?></textarea>
                                            </div>
                                        </div>										
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Município<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtmunicipio" name="edtmunicipio" value="<?php echo $municipio;?>" class="form-control col-md-7 col-xs-12" placeholder="" type="text">
                                            </div>
                                        </div>										
										
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Estado<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Estado->listaCombo('cmboxestado',$uf,'N','class="form-control"');?>
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Empresa compradora de leite<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="empresacompradoraleite" name="empresacompradoraleite" value="<?php echo $empresacompradoraleite;?>" class="form-control col-md-7 col-xs-12" placeholder="" type="text">
                                            </div>
                                        </div>
																				
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Data entrada no projeto<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input id="edtdataentradaprojeto" name="edtdataentradaprojeto" value="<?php 
												if (!empty($dataentradaprojeto))
												{
												echo date('d/m/Y',strtotime($dataentradaprojeto));
												}
												?>" class="date-picker form-control col-md-7 col-xs-12" type="text" >
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Produção início do projeto<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtproducaoinicial" value="<?php echo number_format($producaoinicial,2,',','');?>" class="form-control col-md-7 col-xs-12" name="edtproducaoinicial" placeholder="" type="text">
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Latitude / Lontitude<span class="required"></span>
                                            </label>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <input id="edtlatitude" value="<?php echo number_format($latitude,5,',','');?>" class="form-control col-md-7 col-xs-12" name="edtlatitude" placeholder="Latitude" type="text">
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <input id="edtlongitude"  value="<?php echo number_format($longitude,5,',','');?>" class="form-control col-md-7 col-xs-12"  name="edtlontitude" placeholder="Longitude" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Situação Propriedade<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $SituacaoPropriedade->listaCombo('cmboxsituacaopropriedade',$idsituacaopropriedade,'N','class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Programa<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Programa->listaCombo('cmboxprograma',$idprograma,'N','class="form-control"');?>
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
	

    <script>
	
		
<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
?>
		
function enviar()
		{
			if (
			(document.getElementById('cmboxprodutor').value=='') ||
			(document.getElementById('cmboxtecnico').value=='') ||
			(document.getElementById('cmboxprograma').value=='') ||
			(document.getElementById('cmboxsituacaopropriedade').value=='') ||
			(document.getElementById('edtnomepropriedade').value=='')
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
                            $('#edtdataentradaprojeto').daterangepicker({
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