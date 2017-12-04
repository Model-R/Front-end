<?php session_start();
// $tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
// if ($_SESSION['donoDaSessao'] != $tokenUsuario)
// {
// 	header('Location: index.php');
// }
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?><html lang="pt-BR">

<?php

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$tab = 1;
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Model-R </title>

	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">
	
	<!-- select2 -->
    <link href="css/select/select2.min.css" rel="stylesheet">
	<!-- switchery -->
    <link rel="stylesheet" href="css/switchery/switchery.min.css" />


    <script src="js/jquery.min.js"></script>

	
</head>
<body class="nav-md">					

    <div id="loading" style="display: none;  
            background: #FFFFFF;  
            position: absolute;  
            width: 400px;  
            top: 50%;  
            left: 50%;  
            margin-left: -200px;  
            margin-top: -100px;  
            border-style: solid;  
            border-color: black;  
            border-width: 1px;  
            text-align: center;  
            text-transform: uppercase;  
            font-family: arial;  
            font-weight: bold;  
            color: black;  
            z-index: 3;">  
        <br><img alt="Loading..." src="imagens/ajax-loader.gif" width="150">  
        <br>Processando...  
        <br> 
    </div>					

	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                </div>
            </div>
            <!-- top navigation -->
			<?php require "menutop.php";?>			
				<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="clearfix">
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2><a href="consexperimento.php">Experimento <small>Cadastro experimento</small></a></h2>
									<div class="clearfix">
									</div>
								</div>
								<div class="x_content">
                                <?php 
                                        // incluir opção de tipo de projeto e filtros automáticos na hora da criação do projeto
                                        // OPÇÃO FOR ALTERAR
                                        
                                    if ($op=='I'){?>
                                        <form name='frm' id='frm' action='exec.experimento.php' method="post" class="form-horizontal form-label-left" novalidate>
                                            <input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                            <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                                            <div class="">
                                            
                                                <div>
                                                    <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtexperimento">Experimento <span class="required">*</span>
                                                    </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input id="edtexperimento" value="<?php echo $name;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtdescricao">Descrição
                                                    </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="edtdescricao" value="<?php echo $description;?>"  name="edtdescricao" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>
                                                </div>

												<div class="">
													<div class="item form-group" style="display: flex;align-items: center;">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtdescricao">Tipo do Projeto</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<div class="radio-group-new-experiment">
																<form action="">
																	<div class="radio-terrestre"><input type="radio" name="edttipo" id="edttipoterrestre" value="terrestre" checked/> Terrestre</div>
																	<div class="radio-maritimo"><input type="radio" name="edttipo" id="edttipomaritimo" value="marítimo"/> Marítimo</div>
																</form>
															</div>
														</div>
													</div>
												</div>
												<div class="">
													<div class="item form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtfiltroautomatico"></label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="checkbox" name="edtfiltroautomatico" id="edtfiltroautomatico" checked>Executar filtros automaticamente<br>
														</div>
													</div>
												</div>
											<?php } ?>
										
                                            </form>
										</div>
											<?php 
											// SO MOSTRO O BOTÃO SE FOR INCLUIR. ASSIM O BOTÃO FICA NA PARTE DE BAIXO DA TELA QUANDO A
											// OPÇÃO FOR ALTERAR
											
										if ($op=='I'){?>
										<div class="form-group">
                                            <div class="new_experiment_send_button">
                                                <button id="send" onclick="enviarExp()" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Salvar experimento">Salvar</button>
                                            </div>
										</div>
										<?php } ?>
									<!--</div>-->
										<?php if ($op=='A')
										{?>
										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
                                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                    <li role="presentation" <?php if ($tab=='1') echo 'class="active"';?>><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Informações</a>
                                                    </li>
													<li role="presentation" <?php if ($tab=='2') echo 'class="active"';?>><a href="#tab_content2" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Bióticos</a>
													</li>
													<li role="presentation" <?php if ($tab=='3') echo 'class="active"';?>><a href="#tab_content3" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Data Cleaning</a>
													</li>
												</ul>
												<div id="myTabContent" class="tab-content">
													<div class="tab-pane  <?php if ($tab=='1') echo 'in active';?>" id="tab_content1" aria-labelledby="home-tab">
                                                        <?php require "infoexperimento.php";?>
													</div> <!-- table panel -->	
													<div  class="tab-pane fade <?php if ($tab=='2') echo 'in active';?>" id="tab_content2" aria-labelledby="home-tab">
                                                        <h2>Teste2</h2>
                                                    </div> <!-- table panel -->
                                                    <div  class="tab-pane fade <?php if ($tab=='3') echo 'in active';?>" id="tab_content3" aria-labelledby="home-tab">
                                                        <h2>Teste2</h2>
                                                    </div> <!-- table panel -->
												</div> <!-- myTabContent -->
											</div> <!-- tabpanel -->
										</div>
<?php } //<?php if ($op=='A') ?>

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
	<!-- select2 -->
    <script src="js/select/select2.full.js"></script>
	
    <script src="js/custom.js"></script>
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
	
	<script src="js/loading.js"></script>	
	
<!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>		

    <script>
        function enviarExp(){
            exibe('loading');
            if ((document.getElementById('edtexperimento').value==''))
            {
                criarNotificacao('Atenção','Verifique o preenchimento','warning');
            }
            else
            {
                document.getElementById('frm').action='exec.experimento.php';
                document.getElementById('frm').submit();
            }
        }

    </script>

</body>

</html>