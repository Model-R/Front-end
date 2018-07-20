<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
include('security.inc');
?>
<html>
<head>
<?php

   $FORM_NAME = 'Controle Lamina (Xiloteca)';
   $FORM_ACTION = 'controlelamina.php';
   $FORM_BACK = 'controlelamina.php';
   require_once('classes/conexao.class.php');

   require_once('classes/testemunho.class.php');
   require_once('classes/lamina.class.php');

	//Conexao Multi-Instituição
	//Configuração de Session pela URL
	include('session.conf.php');
	$dbname = $_SESSION['dbname'];
	$conexao = new Conexao;
	$conn = $conexao->Conectar($dbname);
	// FIM - Conexao Multi-Instituição

   $Lamina = new Lamina();
   $Lamina->conn = $conn;
   
   $Testemunho= new Testemunho();
   $Testemunho->conn = $conn;
//----------------------------------------------------------
//print_r($_REQUEST);

if(!empty($_REQUEST['codtestemunho'])){
$codtestemunho = $_REQUEST['codtestemunho'];
}elseif($_REQUEST['te']){
$codtestemunho = $_REQUEST['te'];
}
$codlamina = $_REQUEST['codlamina'];
$nvlamina = $_REQUEST['nlamina'];
$tg = $_REQUEST['tg'];
$tr = $_REQUEST['tr'];
$lg = $_REQUEST['lg'];
//----------------------------------------------------

if($_REQUEST['op'] == 'de'){
	if(!empty($_REQUEST['cd']) && !empty($_REQUEST['te']) )
	{
		$codlamina = $_REQUEST['cd'];
		$testemunho = $_REQUEST['te'];
		$Lamina->apagarItem($codlamina,$testemunho);
	}
}

if(!empty($codtestemunho) && !empty($nvlamina))
{
	$nrlamina = $nvlamina;
	if(!empty($tg)){
		$tg =  '1';
	}else{
		$tg = '0';
	}
	if(!empty($tr)){
		$tr =  '1';
	}else{
		$tr = '0';
	}
	if(!empty($lg)){
		$lg =  '1';
	}else{
		$lg = '0';
	}
	$Lamina->incluirItem($nrlamina,$tg,$lg,$tr,$codtestemunho);
}

 if(!empty($codtestemunho)){
$codlamina = "";
 $arraylamina = $Lamina->ListaLamina($codlamina,$codtestemunho);

 }
 

 if(!empty($codlamina)){
 
  $arraylamina = $Lamina->ListaLamina($codlamina,$codtestemunho);
  $codtestemunho = $arraylamina['0']['codtestemunho'];

}
//print_r($arraylamina);
//---------------------------------------

  
?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jabot - Controle Lamina( XILOTECA )</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="media/js/demo_table.css" rel="stylesheet">
    <?php include "css.php";?>
    <link href="css/paginacaogwm.css" rel="stylesheet">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir todos os registros? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>
<div id="wrapper">
	<?php include "menu.php";?>

<div id="page-wrapper">
	<div class="row">                
	  <div class="col-md-12"> 
		<h1 class="page-header"> 
		  <?php echo $FORM_NAME;?>
		</h1>
		<div id="alert_placeholder"> </div>
	  </div>
	</div>
		<!-- /.row -->
<div class="row">                
<div class="col-md-8"> 

<div class="panel panel-default"> 
	<div class="panel-heading"> 
		<div class="btn-group">                  
		  <button type="button" class="btn btn-default" onClick="voltar();"> 
		  <span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
		</div>
	</div>
	<div class="panel-body"> 
	<form role="form" name="frm" id="frm" method="post" action="<?php echo $FORM_ACTION;?>">
	<div class="control-group"> 
	<!--<div class="alert alert-success" role="alert">--><h4> Controle de Lamina:</h4><br /> <!--</div>-->                
					
		<div class="form-group">
			<div class="row"> 
				  <div class="col-md-3"> 
					<label class="control-label" for="edtnum"> <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span>  Codigo Testemunho:</label>
					<div class="input-group"> 
					<input class="form-control" name="codtestemunho" id="codtestemunho"  value="<?php echo $codtestemunho; ?>"> <span class="input-group-btn">  
										<button  type="submit" class="btn btn-success">Buscar </button>
										</span>
				  </div>
				  </div>
				  <div class="col-md-3"> 
					<label class="control-label" for="edtano"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span>   Lamina: </label>
						<div class="input-group"> 
					<input class="form-control" name="codlamina" id="codlamina"  value="<?php echo $codlamina; ?>"> <span class="input-group-btn">  
										<button  type="submit" class="btn btn-success">Buscar </button>
										</span>
				  </div>
				</div>
				 
			</div>
		</div>
						   
		<div class="form-group">
			<div class="row"> 
				<div class="col-md-3"> 
					<label class="control-label" for="edtnum"> <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>  Lamina:</label>
					<div class="input-group"> 
					<input class="form-control" name="nlamina" id="nlamina"  value=""> 
					</div>
				</div>

				<div class="col-md-9"> 
					<label class="control-label" for="edtano"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span>   Imagens: </label>
					<div class="input-group"> 
						<div class="input-group"> 
							<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox1" value="tg" name="tg"> Tangencial
							</label>
							<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox2" value="tr" name="tr"> Transversal
							</label>
							<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox3" value="lg" name="lg"> Radial

							</label>
							<label class="checkbox-inline">
							</label>
							<button  type="submit" class="btn btn-success">Salvar </button>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	</div>
<!-- /.panel-body -->
</div> 
		
		                <div>
  <table class="table table-responsive table-bordered">
 <thead>
 <tr>
  <th >Lamina</th>
  <th >Tangencial</th>
  <th >Transversal</th>
  <th >Radial</th>
  <th ></td>
</tr>
</thead>
 
<?php  foreach($arraylamina as $value){ ?>
 <tr>
  <td ><?php echo $value['nrlamina']; ?></td>
  <td >
  <?php if($value['tg'] == 't' ){  ?>
  <label class="checkbox-inline">
 
  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
   <?php } ?>
</label></td>
  <td >  <?php if($value['tr'] == 't'){  ?>
  <label class="checkbox-inline">
 
  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
   <?php } ?>
</label></td>
  <td >  <?php if($value['lg'] == 't' ){  ?>
  <label class="checkbox-inline">
 
  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
   <?php } ?></td>
  <td >
  <a href="controlelamina.php?op=de&cd=<?php echo  $value['nrlamina']; ?>&te=<?php echo $codtestemunho; ?>"
  <button   class="btn btn-danger">Excluir </button>
  
  </td>
</tr>

  
<?php } ?>


  </table>
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>


</div>
</div>

    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
	<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.tooltip.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/bootbox.min.js"></script>
		<script type="text/javascript" charset="utf-8">

/**
  Bootstrap Alerts -
  Function Name - showalert()
  Inputs - message,alerttype
  Example - showalert("Invalid Login","alert-error")
  Types of alerts -- "alert-error","alert-success","alert-info"
  Required - You only need to add a alert_placeholder div in your html page wherever you want to display these alerts "<div id="alert_placeholder"></div>"
  Written On - 14-Jun-2013
**/
function atualizaCampos()
{
	document.getElementById('frm').action='cadguiaremessa.php';
   	document.getElementById('frm').submit();	
}

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;  
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0 || tecla==44) return true;
	else  return false;
    }
}


  function showalert(message,alerttype) {
    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' +  alerttype + '"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>');
    setTimeout(function() {
		 // this will automatically close the alert and remove this if the users doesnt close it in 5 secs
      $("#alertdiv").remove();
	  }, 3000);
  }
function validaForm()
	{
	   r = true;
	   m = '';
	   if (document.getElementById('op').value=='I')
	   {
	   		if ((document.getElementById('cmboxtiporemessa').value == '') ||
	       		(document.getElementById('edtnum').value == '') 
		   		)
	   		{ 
	      		r = false;
		  		m = 'Verifique o preenchimento dos campos. \r\n';
	   		}
		}
		else
		{
	   		if ((document.getElementById('cmboxtiporemessa').value == '') 
		   		)
	   		{ 
	      		r = false;
		  		m = 'Verifique o preenchimento dos campos. \r\n';
	   		}
		}

	   if (r == false){
	   	   alert(m);
		   return false;
	   }
	   else
	   {
	      return true;
	   }
	}


	function salvarFechar()
	{
	   if (validaForm()==true){
    	   $('#myModal').modal('hide');
				document.getElementById('fechar').value='s';
				document.getElementById('frm').submit();
	   }
	}
			function novo()
			{
			  $('#myModal').modal();
			}		


			function showExcluir()
			{
				$('#myModal').modal({
  					keyboard: true
				})
			}
			function excluir()
			{
				$('#myModal').modal('hide');
				//showalert("Deleted","alert-error");
			  	//$('#myModal').modal();
			}
			
			function voltar()
			{
				window.location.href = '<?php echo $FORM_BACK;?>';
			}		
			
	function imprimir(id)
	{
		window.location.href = 'ficharemessa.php?id='+id;
	}


	function trocarTipoPessoa(p,nr)
	{
	
		document.getElementById('frm').action='cadnota.php?op=<?php echo $op;?>';
    	document.getElementById('frm').submit();
	}			
		
			$(document).ready(function() {
			
				/* Init DataTables */
				/*$('#example').dataTable();*/
				
				$('#example').dataTable( {
					"bFilter": true,
        			"sPaginationType": "full_numbers"
    			} );
				
				/* Add events */
				$('#example tbody tr').live('dblclick', function () {
				} );
			} );
			
			


		</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
    

</body>

</html>
