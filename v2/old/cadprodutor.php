<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php
require_once('classes/conexao.class.php');
require_once('classes/produtor.class.php');
require_once('classes/estado.class.php');
require_once('classes/tecnico.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$Estado = new Estado();
$Estado->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

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
                                    <h2>Produtor <small>Cadastro do produtor</small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form name='frm' id='frm' action='exec.produtor.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Produtor <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtnomeprodutor" value="<?php echo $nomeprodutor;?>" class="form-control col-md-7 col-xs-12" name="edtnomeprodutor" placeholder="" required="required" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">CPF/CNPJ <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtcpfcnpj" value="<?php echo $cpfcnpj;?>" class="form-control col-md-7 col-xs-12" name="edtcpfcnpj" placeholder="" required="required" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">RG<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtrg" value="<?php echo $rg;?>" class="form-control col-md-7 col-xs-12" name="edtrg" placeholder=""  type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Orgão Expedidor<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtorgaoexpedidor" value="<?php echo $orgaoexpedidor;?>" class="form-control col-md-7 col-xs-12" name="edtorgaoexpedidor" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">UF<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Estado->listaComboUF('cmboxestado',$rguf,'N','class="form-control require" data-validate-length-range="4"');?>
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Endereço <span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea id="edtendereco" required="required" name="edtendereco" class="form-control col-md-7 col-xs-12"><?php echo $endereco;?></textarea>
                                            </div>
                                        </div>										
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Município<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtmunicipio" value="<?php echo $municipio;?>" class="form-control col-md-7 col-xs-12" name="edtmunicipio" placeholder="" required="required" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Estado<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Estado->listaComboUF('cmboxestado2',$uf,'N','class="form-control"');?>
                                            </div>
                                        </div>

 <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">CEP<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtcep" value="<?php echo $cep;?>" class="form-control col-md-7 col-xs-12"  name="edtcep" placeholder=""  type="text">
                                            </div>
                                        </div>
										 <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Telefone<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edttelefone" value="<?php echo $telefone;?>" class="form-control col-md-7 col-xs-12" name="edttelefone" placeholder="" type="text">
                                            </div>
                                        </div>
										 <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Celular<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtcelular" value="<?php echo $celular;?>" class="form-control col-md-7 col-xs-12" name="edtcelular" placeholder="" type="text">
                                            </div>
                                        </div>

										
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="edtemail" value="<?php echo $email;?>" id="edtemail" name="edtemail"  class="form-control col-md-7 col-xs-12">
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

    <script src="js/bootstrap.min.js"></script>

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

        $('frm').submit(function (e) {
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