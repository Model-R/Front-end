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
                                    <h2>Downloads <small> Download de ferramentas e programas </small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 50%">Ferramenta/Programa</th>
                                                <th style="width: 20%">Tamanho</th>
                                                <th style="width: 15%">Últimos atualização</th>
                                                <th style="width: 15%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>0</td>
                                                <td>
                                                    <a>Manual do sistema Balde Cheio</a>
                                                    <br />
                                                    <small></small>
                                                </td>
                                                
                                                <td class="project_progress">
                                                    <div class="progress progress_sm">
                                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo ((filesize('download/Instalacao_Balde_Cheio_Passo_a_Passo.pdf')/1024/12000)*100);?>"></div>
                                                    </div>
                                                    <small><?php echo number_format(filesize('download/Instalacao_Balde_Cheio_Passo_a_Passo.pdf')/1024/1024,2,',','.')."Mb";?></small>
                                                </td>
                                                <td>
                                                    <?php echo date ("d/m/Y", filemtime('download/Instalacao_Balde_Cheio_Passo_a_Passo.pdf'));?>
                                                </td>
                                                <td>
                                                    <a href="download/Instalacao_Balde_Cheio_Passo_a_Passo.pdf" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Download </a>
                                                </td>
                                            </tr>
											<tr>
                                                <td>1</td>
                                                <td>
                                                    <a> Balde Cheio - Instalador </a>
                                                    <br />
                                                    <small>Para quem NÃO possui o Balde Cheio instalado. (Instalação do sistema e do banco de dados Firebord)</small>
                                                </td>
                                                
                                                <td class="project_progress">
                                                    <div class="progress progress_sm">
                                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo ((filesize('download/BaldeCheioSetup.exe')/1024/12000)*100);?>"></div>
                                                    </div>
                                                    <small><?php echo number_format(filesize('download/BaldeCheioSetup.exe')/1024/1024,2,',','.')."Mb";?></small>
                                                </td>
                                                <td>
                                                    <?php echo date ("d/m/Y", filemtime('download/BaldeCheioSetup.exe'));?>
                                                </td>
                                                <td>
                                                    <a href="download/BaldeCheioSetup.exe" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Download </a>
                                                </td>
                                            </tr>
											<tr>
                                                <td>2</td>
                                                <td>
                                                    <a> Balde Cheio - Atualização </a>
                                                    <br />
                                                    <small>Para quem possui o Balde Cheio instalado.  (Atualização do sistema e do banco de dados)</small>
                                                </td>
                                                
                                                <td class="project_progress">
                                                    <div class="progress progress_sm">
                                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo ((filesize('download/BaldeCheioAtualizacaoSetup.exe')/1024/12000)*100);?>"></div>
                                                    </div>
                                                    <small><?php echo number_format(filesize('download/BaldeCheioAtualizacaoSetup.exe')/1024/1024,2,',','.')."Mb";?></small>
                                                </td>
                                                <td>
                                                    <?php echo date ("d/m/Y", filemtime('download/BaldeCheioAtualizacaoSetup.exe'));?>
                                                </td>
                                                <td>
                                                    <a href="download/BaldeCheioAtualizacaoSetup.exe" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Download </a>
                                                </td>
                                            </tr>
                                           <tr>
                                                <td>3</td>
                                                <td>
                                                    <a> Balde Cheio - Executável </a>
                                                    <br />
                                                    <small>Para quem possui o Balde Cheio instalado  
													e deseja atualizar a executável.<br>Após o download, copiar o arquivo para a pasta [C:\Arquivos de Programas\BaldeCheio\](Atualização do sistema e do banco de dados)</small>
                                                </td>
                                                
                                                <td class="project_progress">
                                                    <div class="progress progress_sm">
                                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo ((filesize('download/PRBaldeCheio.exe')/1024/12000)*100);?>"></div>
                                                    </div>
                                                    <small><?php echo number_format(filesize('download/PRBaldeCheio.exe')/1024/1024,2,',','.')."Mb";?></small>
                                                </td>
                                                <td>
                                                    <?php echo date ("d/m/Y", filemtime('download/PRBaldeCheio.exe'));?>
                                                </td>
                                                <td>
                                                    <a href="download/PRBaldeCheio.exe" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Download </a>
                                                </td>
                                            </tr>
											 <tr>
                                                <td>4</td>
                                                <td>
                                                    <a> Suporte Remoto  </a>
                                                    <br />
                                                    <small>
												</td>
                                                
                                                <td class="project_progress">
                                                    <div class="progress progress_sm">
                                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo ((filesize('download/PRBaldeCheio.exe')/1024/12000)*100);?>"></div>
                                                    </div>
                                                    <small><?php echo number_format(filesize('download/TeamViewerQS_pt.exe')/1024/1024,2,',','.')."Mb";?></small>
                                                </td>
                                                <td>
                                                    <?php echo date ("d/m/Y", filemtime('download/TeamViewerQS_pt.exe'));?>
                                                </td>
                                                <td>
                                                    <a href="download/TeamViewerQS_pt.exe" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Download </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- end project list -->

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