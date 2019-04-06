<?php session_start();
include "paths.inc";
$idparceiro = $_SESSION['s_idparceiro'];
if (empty($idparceiro))
{
	$idparceiro = 0;
}

require_once('classes/conexao.class.php');
require_once('classes/visitatecnica.class.php');
require_once('classes/produtor.class.php');
require_once('classes/propriedade.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();
$Visita = new VisitaTecnica();
$Visita->conn = $conn;

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;


if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])))
	{
$sql = 'select dataproximavisita,prop.nomepropriedade,tec.nometecnico from tecnico tec , visitatecnica vt, propriedade prop where vt.idpropriedade = prop.idpropriedade and
	vt.idtecnico = tec.idtecnico and
	dataproximavisita is not null and
	dataproximavisita > \'2013-1-1\' ';
	
	}
	else
	{
		if (empty($idtecnico))
		{
			$idtecnico = $_SESSION['s_idtecnico'];
	$sql = 'select dataproximavisita,prop.nomepropriedade,tec.nometecnico from tecnico tec , visitatecnica vt, propriedade prop where vt.idpropriedade = prop.idpropriedade and
	vt.idtecnico = tec.idtecnico and
	dataproximavisita is not null and
	dataproximavisita > \'2013-1-1\' and tec.idtecnico = '.$idtecnico; 
		}
}

//$sql = "select dataproximavisita,prop.nomepropriedade from visitatecnica vt, propriedade prop where vt.idpropriedade = prop.idpropriedade and
//vt.idtecnico = ".$_SESSION['s_idtecnico'];
		$result = @pg_query($conn,$sql);
		$num = @pg_numrows($result);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel='stylesheet' type='text/css' href='fullcalendar/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='fullcalendar/fullcalendar.print.css' media='print' />
<script type='text/javascript' src='jquery/jquery-1.8.1.min.js'></script>
<script type='text/javascript' src='jquery/jquery-ui-1.8.23.custom.min.js'></script>
<script type='text/javascript' src='fullcalendar/fullcalendar.min.js'></script>
<script type='text/javascript'>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			editable: true,
			events: [
			<?php if (!empty($row['dataproximavisita']))
			{ while ($row = pg_fetch_array($result))
				{?>
				{
					title: '<?php echo $row['nomepropriedade'];?>',
					start: new Date(<?php echo date('Y',strtotime($row['dataproximavisita']));?>, <?php echo date('n',strtotime($row['dataproximavisita']));?>-1, <?php echo date('j',strtotime($row['dataproximavisita']));?>)
				},
			<?php }
			}
			 ?>
				{
					title: 'Natal',
					start: new Date(y, 12, 25),
					allDay: true
				}
			]
		});
		
	});

</script>
<style type='text/css'>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 900px;
		margin: 0 auto;
		}

</style>
</head>
<body>
<h3><?php echo utf8_encode('Próximas visitas');?></h1>
<div id='calendar'></div>
</body>
</html>
