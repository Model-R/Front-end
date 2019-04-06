<?php session_start();?><!DOCTYPE html>
<?php
require_once('classes/tecnico.class.php');
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();
$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

//print_r($_SESSION);
$idtecnico = $_SESSION['s_idtecnico'];
if ((in_array('ADMINISTRADOR',$_SESSION['s_papel']))
	|| (in_array('AUDITOR',$_SESSION['s_papel']))
	|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
)
{
	$idtecnico = $_REQUEST['cmboxtecnico'];
}
//print_r($_SESSION);
?>
<html lang="pt-BR">


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
    <link rel="stylesheet" type="text/css" href="css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="css/icheck/flat/green.css" rel="stylesheet" />
    <link href="css/floatexamples.css" rel="stylesheet" type="text/css" />

    <link href="css/calendar/fullcalendar.css" rel="stylesheet">
    <link href="css/calendar/fullcalendar.print.css" rel="stylesheet" media="print">
		
    <script src="js/jquery.min.js"></script>
    <script src="js/nprogress.js"></script>		
		
        <!-- Custom styling plus plugins -->
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/icheck/flat/green.css" rel="stylesheet">

        <link href="css/calendar/fullcalendar.css" rel="stylesheet">
        <link href="css/calendar/fullcalendar.print.css" rel="stylesheet" media="print">

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

                    
					<?php require "menu.php";?>
                </div>
            </div>

            <!-- top navigation -->
			<?php require "menutop.php";?>


                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">

                        
                        <div class="clearfix"></div>
						<form action="agendatecnico.php" method="post" name='frm' id='frm'>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Agenda eventos </h2><?php echo $Tecnico->listaCombo('cmboxtecnico',$idtecnico,'S','N','class="form-control"',$_SESSION['s_idsindicato']);?>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                                        <div id='calendar'></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- footer content -->
                    <footer>
                        <div class="">
                            <p class="pull-right">Tempus Tecnologia
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </footer>
                    <!-- /footer content -->

                </div>


                <!-- Start Calender modal -->
                <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">New Calender Entry</h4>
                            </div>
                            <div class="modal-body">
                                <div id="testmodal" style="padding: 5px 20px;">
                                    <form id="antoform" class="form-horizontal calender" role="form">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="title" name="title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary antosubmit">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel2">Edit Calender Entry</h4>
                            </div>
                            <div class="modal-body">

                                <div id="testmodal2" style="padding: 5px 20px;">
                                    <form id="antoform2" class="form-horizontal calender" role="form">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="title2" name="title2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" style="height:55px;" id="descr2" name="descr"></textarea>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary antosubmit2">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
                <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>

                <!-- End Calender modal -->
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

        <script src="js/nprogress.js"></script>
        <!-- chart js -->
        <script src="js/chartjs/chart.min.js"></script>
        <!-- bootstrap progress js -->
        <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
        <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
        <!-- icheck -->
        <script src="js/icheck/icheck.min.js"></script>

        <script src="js/custom.js"></script>

        <script src="js/moment.min.js"></script>
		
		<link rel='stylesheet' type='text/css' href='js/fullcalendar/fullcalendar.css' />
		<!--<link rel='stylesheet' type='text/css' href='js/fullcalendar/fullcalendar.print.css' media='print' />
        <script src="js/calendar/fullcalendar.min.js"></script>-->
		<script type='text/javascript' src='js/fullcalendar/fullcalendar.min.js'></script>
		

        <script>
            $(window).load(function () {

                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var started;
                var categoryClass;

                var calendar = $('#calendar').fullCalendar({
					
					
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end, allDay) {
                        $('#fc_create').click();

                        started = start;
                        ended = end

                        $(".antosubmit").on("click", function () {
                            var title = $("#title").val();
                            if (end) {
                                ended = end
                            }
                            categoryClass = $("#event_type").val();

                            if (title) {
                                calendar.fullCalendar('renderEvent', {
                                        title: title,
                                        start: started,
                                        end: end,
                                        allDay: allDay
                                    },
                                    true // make the event "stick"
                                );
                            }
                            $('#title').val('');
                            calendar.fullCalendar('unselect');

                            $('.antoclose').click();

                            return false;
                        });
                    },
                    eventClick: function (calEvent, jsEvent, view) {
                        //alert(calEvent.title, jsEvent, view);

                        $('#fc_edit').click();
                        $('#title2').val(calEvent.title);
                        categoryClass = $("#event_type").val();

                        $(".antosubmit2").on("click", function () {
                            calEvent.title = $("#title2").val();

                            calendar.fullCalendar('updateEvent', calEvent);
                            $('.antoclose2').click();
                        });
                        calendar.fullCalendar('unselect');
                    },
                    editable: true,
					
					<?php $sql = "select tec.nometecnico,prop.nomepropriedade,prod.nomeprodutor,vt.relatorio, date_part('YEAR',dataproximavisita) as ano,
date_part('MONTH',dataproximavisita) as mes,
date_part('DAY',dataproximavisita) as dia,
 vt.idtecnico,vt.dataproximavisita,
vt.idvisitatecnica from 
visitatecnica vt,
propriedade prop,
produtor prod,
tecnico tec
where
vt.idtecnico = tec.idtecnico and
vt.idpropriedade = prop.idpropriedade and
prop.idprodutor = prod.idprodutor and
date_part('year', datavisita)=2015 and vt.dataproximavisita is not null  ";
if (!empty($idtecnico))
{
	$sql.=' and vt.idtecnico = '.$idtecnico;
}
						$res = pg_exec($conn,$sql);
						if ((pg_num_rows($res))>0)
						{
							?>
							events: [
							{
                            title: 'All Day Event',
                            start: new Date(2012,12,1)
							},
							<?php
							//
//							,
								//url: 'exec.relvisitatecnicatecnico.php?idvisitatecnica=<?php echo $row['idvisitatecnica'];'

							while ($row = pg_fetch_array($res))
							{?>
								{
								title: "<?php echo $row['nomepropriedade'];?>",
								start: new Date(<?php echo $row['ano'];?>, <?php echo $row['mes'];?>, <?php echo $row['dia'];?>),
								end: new Date(<?php echo $row['ano'];?>, <?php echo $row['mes'];?>, <?php echo $row['dia'];?>),
								allDay: true,
								url: 'exec.relvisitatecnicatecnico.php?idvisitatecnica=<?php echo $row['idvisitatecnica'];;?>'
								},
							<?php 
							}
							?>
							{
                            title: 'All Day Event',
                            start: new Date(2012,12,1)
							}
                ]
						<?php } ?>
                });
				
				
				
				
				
            });
			
			
        </script>
    </body>

</html>