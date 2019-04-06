<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
	  require_once('classes/programa.class.php');
	  require_once('classes/produtor.class.php');
	  require_once('classes/propriedade.class.php');
	  require_once('classes/tecnico.class.php');
	  
 function calculo($tipocapital,$juros,$quantidade,$valorunitario,$vidautil,&$valortotal,&$valorresidual,&$remuneracaoanual,&$remuneracaomensal)
   {
   	  if (empty($vidautil))
	  {
	  	$vidautil = 1;
	  } 
   	  if (empty($juros))
	  {
	  	$juros = 6;
	  } 
      if (empty($quantidade))
	  {
	    $quantidade =1;
	  }
   	  if (($tipocapital==1) || ($tipocapital==2))
	  {
	  	$valortotal = $quantidade * $valorunitario;
		$remuneracaoanual = (($quantidade * $valorunitario * $juros)/100);
	  	$remuneracaomensal = ((($quantidade * $valorunitario * $juros)/100)/12);
	  } 
   	  if ($tipocapital==3) 
	  {
	  	$valorresidual = ($quantidade * $valorunitario)*0.1;
	  	$valortotal = ($quantidade * $valorunitario);
		$remuneracaoanual = Price2($valortotal,$valorresidual,$vidautil,$juros);
		$remuneracaomensal = (Price2($valortotal,$valorresidual,$vidautil,$juros)/12);

//	  	$valortotal = ($quantidade * $valorunitario)*0.1;
//		$remuneracaoanual = Price(5000,30,6);
//		$remuneracaomensal = (Price(5000,30,6)/12);

	  } 
   	  if ($tipocapital==4) 
	  {
	  	$valorresidual = ($quantidade * $valorunitario)*0.2;
	  	$valortotal = ($quantidade * $valorunitario);
//	  	$valortotal = ($quantidade * $valorunitario);
		$remuneracaoanual = Price2($valortotal,$valorresidual,$vidautil,$juros);
		$remuneracaomensal = (Price2($valortotal,$valorresidual,$vidautil,$juros)/12);

//		$remuneracaoanual = Price(5000,30,6);
//		$remuneracaomensal = (Price(5000,30,6)/12);
		
//		$remuneracaoanual = 5000;//Price2;
//		$remuneracaomensal = Price2;//(5000,30,6)/12);

	  } 
   }
	function Price($Valor, $Parcelas, $Juros) 
	{
//		$Juros = bcdiv($Juros,100,2);
		$Juros = $Juros/100;
		$E=0;
		$cont=1;
		for($k=1;$k<=$Parcelas;$k++)
		{
			$cont= bcmul($cont,bcadd($Juros,1,2),2);
			$E=bcadd($E,$cont,2);
		}
		$E= $E - $cont;
		$Valor = $Valor * $cont;
		return $Valor/$E;
	}
function Price2($Valor,$ValorResidual, $Parcelas, $Juros)
{
$Juros = bcdiv($Juros,100,15);
$E=1.0;
$cont=1.0;

for($k=1;$k<=$Parcelas;$k++)
{
$cont= bcmul($cont,bcadd($Juros,1,15),15);
$E=bcadd($E,$cont,15);
}
$E=bcsub($E,$cont,15);

$Valor = bcmul($Valor,$cont,15);

$Valor = $Valor-$ValorResidual;

return bcdiv($Valor,$E,15);
}


	  
	  $FORM_ACTION = 'patrimonio';
	  $tipofiltro = $_REQUEST['cmboxtipofiltro'];
	  $ordenapor = $_REQUEST['cmboxordenar'];
	  $financeiro = false;
	  if ($_REQUEST['FINANC']=='T')
	  {
		  $financeiro = true;
	  }
	  
	  if (empty($tipofiltro))
	  {
		  $tipofiltro = 'NOME';
	  }
	  
	  $ano = $_REQUEST['cmboxano'];
	  $idprodutor = $_REQUEST['cmboxprodutor'];
	  $idpropriedade = $_REQUEST['cmboxpropriedade'];
	  
	  $idtecnico = $_SESSION['s_idtecnico'];
	  if ( (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
		|| (in_array('AUDITOR',$_SESSION['s_papel']))
		|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
		)
	  {
		  $idtecnico = $_REQUEST['cmboxtecnico'];
	  }
	  
	  
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Programa = new Programa();
$Programa->conn = $conn;

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

?>
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

<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir todos o(s) registros(s)? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
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
						<form name="frm" id="frm" method="post" class="form-horizontal form-label-left">
					 <div class="x_panel">
                        <div class="x_title">
                            <h2>Filtros <small>Utilize os filtros abaixo para realizar a consulta </small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="row">

                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'S',$idtecnico,'class="form-control"','');?>
                                </div>
								<div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,$idprodutor,'S','','class="form-control"');?>
                                </div>
                               <div class="col-md-1 col-sm-12 col-xs-12 form-group">
										
                                     <button type="button" class="btn btn-success" onClick='filterApply()'>Filtrar</button>
								</div>
							</div>

                        </div>
                    </div>
					
					
					
                        
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Patrimônio <small></small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                                                            <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                Ação
                                <span class="caret"></span>
                            </a>
                                        <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                            <?php if (!$financeiro)
											{
												if ((in_array('ADMINISTRADOR',$_SESSION['s_papel']))
												|| (in_array('AUDITOR',$_SESSION['s_papel']))
												|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
												)
												{
												
												?>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="https://twitter.com/fat">Novo</a>
                                            </li>
                                           <li role="presentation"><a role="menuitem" tabindex="-1" onClick='showExcluir()'>Excluir</a>
                                            </li>
												<?php }
											
											} ?>
 											<?php if ($financeiro)
											{
												if (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
												{
												?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="lancarPagamento()">Lançar Pagamentos</a>
                                            </li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="estornarPagamento()">Estornar Pagamentos</a>
                                            </li>
											<?php }
												if (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
												{
												?>

                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="relPagamentosPeriodo('xls')">Pagamentos no período</a>
                                            </li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="relPagamentosPeriodo('pdf')">Pagamentos no período</a>
                                            </li>
											

											
												<?php }
												} ?>
                                        </ul>
                                    </li>
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
								
								<table class="table table-hover">
								<thead>
								<tr>
				<?php 
				
				if (!empty($idpropriedade))
				{
				
	$sqlavaliacao = 'select ano from animal where idpropriedade='.$idpropriedade.'  
union
select ano from instalacao where idpropriedade='.$idpropriedade.'
union
select ano from terra where idpropriedade='.$idpropriedade.'
union
select ano from maquina where idpropriedade='.$idpropriedade.'
order by ano desc ';
		$resavaliacao = pg_exec($conn,$sqlavaliacao);
		
		while ($rowavaliacao = pg_fetch_array($resavaliacao))
		{


//			$sqltotal = '	select sum(rc.valorunitario*rc.quantidade) from remuneracaocapital rc where
//rc.idavaliacao in (select idavaliacao from avaliacao where
//idpropriedade = '.$idpropriedade.' and anoreferencia = '.$rowavaliacao['anoreferencia'].')';
//		$restotal = pg_exec($conn,$sqltotal);
//		$rowtotal = pg_fetch_array($restotal);
		$total = $rowtotal[0];
		$total = 100;
		if ($total>0){
		?>
		<table>
		<tr>
		<td width="70%">

      <table class="table table-hover" >
        <tr class="tab_bg_2"> 
          <th colspan="5">
            <?php echo 'Ano '.$rowavaliacao['ano'];?>
          </th>
        </tr>
        <tr > 
          <th>Patrimonio<br>utilizado</th>
          <th>Valor total (R$)</th>
          <th>Remuneração<br>anual</th>
          <th>Remuneração<br>mensal</th>
          <th>% do<br> patrimônio</th>
        </tr>
        <?php		
			$TTvalortotal=0;
			$TTvalorresidual=0;
			$TTremuneracaoanual=0;
			$TTremuneracaomensal=0;

 			$sqltipo = "select 1,'Terras' 
union
select 2,'Animais'
union
select 3,'Máquinas'
union
select 4,'Instalações'
";
// RAFAEL INICIO 
			$restipo = pg_exec($conn,$sqltipo);
			$graf_legenda = '';
			$graf_valor = '';
			$TTvalortotalfinal = 0;
			while ($rowtipo = pg_fetch_array($restipo))
			{
				$graf_legenda.=$rowtipo[1].';';
    			if ($rowtipo[0]==1)
				{
					$sql = "select quantidade,valorunitario,'1' as vidautil from terra where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
				}
    			if ($rowtipo[0]==2)
				{
					$sql = "select quantidade,valorindividual as valorunitario,'1' as vidautil from animal where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
				}
    			if ($rowtipo[0]==3)
				{
					$sql = "select '1' as quantidade,valor as valorunitario,vidautil from maquina where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
				}
    			if ($rowtipo[0]==4)
				{
					$sql = "select '1' as quantidade,valor as valorunitario,vidautil from instalacao where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
				}
//				echo $sql;
				$Tvalortotal=0;
				$Tvalorresidual=0;
				$Tremuneracaoanual=0;
				$Tremuneracaomensal=0;
				$res = pg_exec($conn,$sql);
				while ($row = pg_fetch_array($res))
				{
					calculo($rowtipo[0],6,$row['quantidade'],$row['valorunitario'],$row['vidautil'],$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
					$Tvalortotal=$Tvalortotal + $valortotal;
					$Tvalorresidual=$Tvalorresidual + $valorresidual;
					$Tremuneracaoanual=$Tremuneracaoanual + $remuneracaoanual;
					$Tremuneracaomensal=$Tremuneracaomensal + $remuneracaomensal;
				}
				$TTvalortotalfinal=$TTvalortotalfinal + $Tvalortotal;
				?>
        <?php
			}


// RAFAEL FINAL



			$restipo = pg_exec($conn,$sqltipo);
			$graf_legenda = '';
			$graf_valor = '';
			
			while ($rowtipo = pg_fetch_array($restipo))
			{
				$graf_legenda.=$rowtipo[1].';';
    			if ($rowtipo[0]==1)
				{
					$sql = "select quantidade,valorunitario,'1' as vidautil from terra where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
				}
    			if ($rowtipo[0]==2)
				{
					$sql = "select quantidade,valorindividual as valorunitario,'1' as vidautil from animal where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
				}
    			if ($rowtipo[0]==3)
				{
					$sql = "select '1' as quantidade,valor as valorunitario,vidautil from maquina where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
				}
    			if ($rowtipo[0]==4)
				{
					$sql = "select '1' as quantidade,valor as valorunitario,vidautil from instalacao where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
				}
//				echo $sql;
				$Tvalortotal=0;
				$Tvalorresidual=0;
				$Tremuneracaoanual=0;
				$Tremuneracaomensal=0;
				$res = pg_exec($conn,$sql);
				while ($row = pg_fetch_array($res))
				{
					calculo($rowtipo[0],6,$row['quantidade'],$row['valorunitario'],$row['vidautil'],$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
					$Tvalortotal=$Tvalortotal + $valortotal;
					$Tvalorresidual=$Tvalorresidual + $valorresidual;
					$Tremuneracaoanual=$Tremuneracaoanual + $remuneracaoanual;
					$Tremuneracaomensal=$Tremuneracaomensal + $remuneracaomensal;
				}
				$TTvalortotal=$TTvalortotal + $Tvalortotal;
				$TTvalorresidual=$TTvalorresidual + $Tvalorresidual;
				$TTremuneracaoanual=$TTremuneracaoanual + $Tremuneracaoanual;
				$TTremuneracaomensal=$TTremuneracaomensal + $Tremuneracaomensal;				
				?>
        <tr > 
          <td>
            <?php echo $rowtipo[1];?>
          </td>
          <td><div align="right"> 
            <?php echo number_format($Tvalortotal, 2, ',', '.');?>
            </div></td>
          <td><div align="right"> 
            <?php echo number_format($Tremuneracaoanual, 2, ',', '.');?>
            </div></td>
          <td><div align="right"> 
            <?php echo number_format($Tremuneracaomensal, 2, ',', '.');?>
            </div></td>
          <td><div align="right">
            <?php echo number_format((($Tvalortotal/$TTvalortotalfinal)*100), 0, ',', '.');
				$graf_valor .= number_format((($Tvalortotal/$total)*100), 0, ',', '.').';';
			?>
			</div>
          </td>
        </tr>
        <?php
			}
		?>
        <tr > 
          <th>
            <?php echo 'Total';?>
          </th>
          <th><div align="right"> 
            <?php echo number_format($TTvalortotal, 2, ',', '.');?>
            </div></th>
          <th><div align="right"> 
            <?php echo number_format($TTremuneracaoanual, 2, ',', '.');?>
            </div></th>
          <th><div align="right"> 
            <?php echo number_format($TTremuneracaomensal, 2, ',', '.');?>
            </div></th>
          <th><div align="right">
            <?php echo '100';?>
			</div>
          </th>
        </tr>
      </table>
		</td>
		<td width="30%"><?php $graf_legenda = substr($graf_legenda,0,strlen($graf_legenda)-1);
		$graf_valor = substr($graf_valor,0,strlen($graf_valor)-1);?>
		<img src="graf_conspatrimonio.php?valor=<?php echo $graf_valor;?>&legenda=<?php echo $graf_legenda;?>"></td>
		</tr></table>
<?php
		}	 // if 
		}
				}// IF ID PROPRIEDADE
?>

                                    
                              </div>
								
                            </div>
                       
                    </div>
</form>
                </div>

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
	
	<!-- daterangepicker -->
    <script type="text/javascript" src="js/moment.min2.js"></script>
    <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
    
  
	
	
	 <script type="text/javascript">
	   $(document).ready(function () {
            $('#reservation').daterangepicker(null, function (start, end, label) {
                //console.log(start, end, label);
//				start = now()
				alert(start);
				alert(end);
				console.log(start,end,label);
            });
        });
       
	


	function filterApply()
	{
		document.getElementById('frm').target='_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
	}
	


	function imprimir(tipo)
	{
		alert(tipo);
	}


	
	function removeFilter()
	{
		window.location.href = 'cons<?php echo strtolower($FORM_ACTION);?>.php';
	}
	
	
	</script>

</body>

</html>