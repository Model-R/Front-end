<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php
require_once('classes/conexao.class.php');
require_once('classes/produtor.class.php');
require_once('classes/estado.class.php');
require_once('classes/tecnico.class.php');
	  require_once('classes/produtor.class.php');
	  require_once('classes/propriedade.class.php');
	  require_once('classes/categoriaanimal.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Produtor = new Produtor();
$Produtor->conn = $conn;

$CategoriaAnimal = new CategoriaAnimal();
$CategoriaAnimal->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$Estado = new Estado();
$Estado->conn = $conn;


$Produtor = new Produtor();
$Produtor->conn = $conn;

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;


$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$idprodutor=$_REQUEST['idprodutor'];
$idpropriedade=$_REQUEST['idpropriedade'];
$ano=$_REQUEST['ano'];
$numero=$_REQUEST['numero'];

if ($op=='A')
{
	$Produtor->getById($id);
	

	$idprodutor = $Produtor->idprodutor;
		   	$nomeprodutor = $Produtor->nomeprodutor;
		   	$cpfcnpj = $Produtor->cpfcnpj;
		   	$rg = $Produtor->rg;
		   	$orgaoexpedidor= $Produtor->orgaoexpedidor;
		   	$rguf = $Produtor->rguf;
		   	$endereco = $Produtor->endereco;
		   	$municipio = $Produtor->municipio;
		   	$uf = $Produtor->uf;
		   	$cep = $Produtor->cep;
		   	$telefone = $Produtor->telefone;
		   	$celular = $Produtor->celular;
		   	$email = $Produtor->email;
			$idtecnico = $Produtor->idtecnico;	
	
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
                                    <h2>Rebanho <small>Cadastro de Rebanho</small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form name='frm' id='frm' action='exec.rebanho.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                                        <input id="idprodutor" value="<?php echo $idprodutor;?>" name="idprodutor" type="hidden">
                                        <input id="idpropriedade" value="<?php echo $idpropriedade;?>" name="idpropriedade" type="hidden">
                                        <input id="ano" value="<?php echo $ano;?>" name="ano" type="hidden">

                                   
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Produtor <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'S',$idtecnico,'class="form-control"','');?>
											</div>
										</div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Propriedade <span class="required">*</span>
                                            </label>
                                           <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,$idprodutor,'S','','class="form-control"');?>
											</div>
										</div>
										 <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ano<span class="required">*</span>
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12"><select name="cmboxano" id="cmboxano" onChange="submit()" class="form-control">
									<?php for ($c=2000;$c<=date('Y');$c++)
									{?>
										<option value="<?php echo $c;?>" <?php if ($ano==$c) { echo "SELECTED";}?>><?php echo $c;?></option>
									<?php } ?>
											</select>
											</div>
										</div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Número<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtnumero" value="<?php echo $numero;?>" class="form-control col-md-7 col-xs-12" name="edtnumero" placeholder="" required="required" type="text">
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Categoria Animal <span class="required">*</span>
                                            </label>
                                           <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $CategoriaAnimal->listaCombo('cmboxcategoriaanimal',$idcategoriaanimal,'N','class="form-control"');?>
											</div>
										</div>
										
										
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtnome" value="<?php echo $nome;?>" class="form-control col-md-7 col-xs-12" name="edtnome" placeholder=""  type="text">
                                            </div>
                                        </div>
                                        
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Data Nascimento <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<input id="edtdatanascimento" name="edtdatanascimento" value="<?php 
												if (!empty($datanascimento))
												{
												echo date('d/m/Y',strtotime($datanascimento));
												}
												?>" class="date-picker form-control col-md-7 col-xs-12" type="text" >
                                            </div>
                                        </div>
										 <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome Mãe<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtnomemae" value="<?php echo $nome;?>" class="form-control col-md-7 col-xs-12" name="edtnomemae" placeholder=""  type="text">
                                            </div>
                                        </div>
										 <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome Pai<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtnomepai" value="<?php echo $nome;?>" class="form-control col-md-7 col-xs-12" name="edtnomepai" placeholder=""  type="text">
                                            </div>
                                        </div>										

										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Porte<span class="required">*</span>
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12"><select name="cmboxporte" id="cmboxporte" class="form-control">
												<option value="" <?php if ($porte=='') { echo "SELECTED";}?>></option>
												<option value="Grande" <?php if ($porte=='Grande') { echo "SELECTED";}?>>Grande</option>
												<option value="Médio" <?php if ($porte=='Médio') { echo "SELECTED";}?>>Médio</option>
												<option value="Pequeno" <?php if ($porte=='Pequeno') { echo "SELECTED";}?>>Pequeno</option>
											</select>
											</div>
										</div>
										
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Estado Reprodutivo<span class="required">*</span>
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12"><select name="cmboxestadoreprodutivo" id="cmboxestadoreprodutivo" class="form-control">
												<option value="" <?php if ($porte=='') { echo "SELECTED";}?>></option>
												<option value="Vazia" <?php if ($porte=='Vazia') { echo "SELECTED";}?>>Vazia</option>
												<option value="Preenhe" <?php if ($porte=='Preenhe') { echo "SELECTED";}?>>Preenhe</option>
											</select>
											</div>
										</div>
										
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button onClick="enviar()" type="button" class="btn btn-success">Enviar</button>
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
			(document.getElementById('edtnomeprodutor').value=='') ||
			(document.getElementById('edtcpfcnpj').value=='') ||
			(document.getElementById('edtmunicipio').value=='') ||
			(document.getElementById('cmboxtecnico').value=='') ||
			(document.getElementById('cmboxestado2').value=='')
			)
			{
				criarNotificacao('Atenção','Verifique o preenchimento','warning');
			}
			else
			{
				document.getElementById('frm').submit();
			}
		}
	
        // initialize the validator function
		$(document).ready(function () {
                            $('#edtdatanascimento').daterangepicker({
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