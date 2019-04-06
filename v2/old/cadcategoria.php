<html lang="pt-BR">
<?php
require_once('classes/conexao.class.php');
require_once('classes/categoria.class.php');
require_once('classes/grupo.class.php');
require_once('classes/subgrupo.class.php');
require_once('classes/unidade.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Categoria = new Categoria();
$Categoria->conn = $conn;

$Grupo = new Grupo();
$Grupo->conn = $conn;

$SubGrupo = new SubGrupo();
$SubGrupo->conn = $conn;

$Unidade = new Unidade();
$Unidade->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

if ($op=='A')
{
	$Categoria->getById($id);

			$idcategoria = 	   	$Categoria->idcategoria ;//= $row['nomepropriedade'];
		   	$idgrupo = $Categoria->idgrupo ;//= $row['inscricaoestadual'];
		   	$idsubgrupo = $Categoria->idsubgrupo ;//= $row['tecnicoresponsavel'];
		   	$idunidade = $Categoria->idunidade;// = $row['tamanho'];
		   	$categoria = $Categoria->categoria;// = $row['idunidademedida'];
		   	$codigo = $Categoria->codigo ;//= $row['endereco'];
		   	$tipo = $Categoria->tipo;// = $row['municipio'];
			$resumida = $Categoria->resumida;// = $row['municipio'];
		   	echo $resumida;
}
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Balde Cheio </title>

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
                                    <h2>Categoria <small>Cadastro categoria</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form name='frm' id='frm' action='exec.categoria.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Grupo <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Grupo->listaCombo('cmboxgrupo',$idgrupo,'N','class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Subgrupo <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $SubGrupo->listaCombo('cmboxsubgrupo',$idsubgrupo,'N','class="form-control"');?>
                                            </div>
                                        </div>
                                        
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Unidade <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Unidade->listaCombo('cmboxunidade',$idunidade,'N','class="form-control"');?>
                                            </div>
                                        </div>
										
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Categoria <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtcategoria" value="<?php echo $categoria;?>"  name="edtcategoria" class="form-control col-md-7 col-xs-12" required="required">
                                            </div>
                                        </div>

										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Código <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtcodigo" value="<?php echo $codigo;?>" name="edtcodigo" class="form-control col-md-7 col-xs-12" required="required">
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Tipo <span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edttipo" value="<?php echo $tipo;?>" name="edttipo" class="form-control col-md-7 col-xs-12" >
                                            </div>
                                        </div>										
                                        
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cmboxresumida">Resumida<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select name='cmboxresumida' id="cmboxresumida" data-validate-length-range="4"  class="form-control"  type="text">
												<option value=''></option>
												<option value='TRUE' <?php if ($Categoria->resumida=='t') echo "SELECTED";?>>Sim</option>
												<option value='FALSE' <?php if ($Categoria->resumida=='f') echo "SELECTED";?>>Não</option>
												</select>
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
			(document.getElementById('cmboxgrupo').value=='') ||
			(document.getElementById('cmboxsubgrupo').value=='') ||
			(document.getElementById('cmboxunidade').value=='') ||
			(document.getElementById('edtcategoria').value=='') ||
			(document.getElementById('edtcodigo').value=='') ||
			(document.getElementById('edttipo').value=='') 
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