<!DOCTYPE html>
<html lang="pt-BR">
<?php	  
require_once('classes/conexao.class.php');
require_once('classes/tecnico.class.php');
require_once('classes/usuario.class.php');
require_once('classes/funcao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Usuario = new Usuario();
$Usuario->conn = $conn;

$Funcao = new Funcao();
$Funcao->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

if ($op=='A')
{
	$Usuario->getById($id);
}

//echo $Usuario->idtecnico.'Rafael';
//exit;

?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentallela Alela! | </title>

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


<!-- Small modal -->
                                <div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Trocar Senha</h4>
                                            </div>
											<form name="frmsenha" id="frmsenha" class="form-horizontal form-label-left" action="exec.trocarsenha.php">
                                            <div class="modal-body">
												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Senha</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='id' name='id' type="hidden" class="form-control" value="<?php echo $id;?>">
												<input id='edtsenha' name='edtsenha' type="password" class="form-control" value="">
												</div>
												</div>

												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Nova</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='edtnovasenha' name='edtnovasenha' type="password" class="form-control" value="">
												</div>
												</div>
                                                <div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Confirmar</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='edtconfirmacao' name='edtconfirmacao' type="password" class="form-control" value="">
												</div>
												</div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
											</form>

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
                                    <h2>Vídeos <small> Vídeos explicativos </small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <iframe width="300px" src="http://www.youtube.com/embed/QXLR0S_3pJQ" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                                <div class="caption">
                                                    <p>Download aplicação</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <iframe width="300" src="http://www.youtube.com/embed/HmAaxVoXac8" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                                <div class="caption">
                                                    <p>Instalação</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <iframe width="300" src="http://www.youtube.com/embed/i-1b-B2_Dkk" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                                <div class="caption">
                                                    <p>Configuração</p>
                                                </div>
                                            </div>
                                        </div>
										<div class="col-md-3">
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <iframe width="300" src="http://www.youtube.com/embed/aWiCKoC--HI" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                                <div class="caption">
                                                    <p>Desinstalar</p>
                                                </div>
                                            </div>
                                        </div>
										<div class="col-md-3">
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <iframe width="300" src="http://www.youtube.com/embed/S-uJASPBRgU" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                                <div class="caption">
                                                    <p>Primeiro acesso</p>
                                                </div>
                                            </div>
                                        </div>
										<div class="col-md-3">
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <iframe width="300" src="http://www.youtube.com/embed/I-onWiWrd_o" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                                <div class="caption">
                                                    <p>Atualizar base local</p>
                                                </div>
                                            </div>
                                        </div>
                                        

                                    </div>

                                </div>
						
                           
                                

                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- footer content -->
            <footer>
                <div class="">
                    <p class="pull-right">Gentelella Alela! a Bootstrap 3 template by <a>Kimlabs</a>. |
                        <span class="lead"> <i class="fa fa-paw"></i> Gentelella Alela!</span>
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
	
	
	
	function alterarSenha()
	{
		$('#myModal').modal({
  		keyboard: true
	})
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