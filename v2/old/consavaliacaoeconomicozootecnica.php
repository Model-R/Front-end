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

	  
	  $FORM_ACTION = 'avaliacaoeconomicozootecnica';
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
	  $categoria = $_REQUEST['cmboxcategoria'];

	  $idtecnico = $_SESSION['s_idtecnico'];
	  if ( (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
		|| (in_array('AUDITOR',$_SESSION['s_papel']))
		|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
		)
	  {
		  $idtecnico = $_REQUEST['cmboxtecnico'];
	  }
	  
	  
	
	class MyPag extends Paginacao
	{
		var $financeiro_;
		function desenhacabeca($row)
		{
		 	 $html = '
			 <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">Propriedade </th>
                                                <th class="column-title">Produtor </th>
                                                <th class="column-title">Técnico </th>
                                                <th class="column-title">Data </th>
                                                <th class="column-title">Mês/Ano Ref. </th>
                                                <th class="column-title">Data Pagto </th>';
												
												if ($this->financeiro_)
												{
													$html.='
													<th class="column-title">Valor pagto</th>';
												}
												
                                                $html.='<th class="column-title no-link last"><span class="nobr">Ação</span>
                                                </th>
                                                <th class="bulk-actions" colspan="7">
                                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                </tr>
                            </thead>
                      ';
		 		echo $html;
		}

		function desenha($row){
			$datapagamento = $row['datapagamento'];
			if (!empty($datapagamento))
			{
				$datapagamento = date('d/m/Y',strtotime($datapagamento));
			}
			$row['ativo'] = false;
			if ($row['ativo']=='true')
			{
				$inativo = 'alert-danger';
			}
			else
			{
				$inativo = '';
			}
			
			if ($this->financeiro_)
			{
				$acoes = '<a target="_blank" href="exec.relvisitatecnicatecnico.php?idvisitatecnica='.$row['idvisitatecnica'].'" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>';
				$acoes.= '<a onClick="lancarPagamento('.$row['idvisitatecnica'].')" class="btn btn-success btn-xs"><i class="fa fa-money"></i></a>';
				$acoes.= '<a onClick="extornarPagamento('.$row['idvisitatecnica'].'" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>';
			}
			else
			{
				$acoes = '<a target="_blank" href="exec.relvisitatecnicatecnico.php?idvisitatecnica='.$row['idvisitatecnica'].'" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>';
			}
			
			$html = '<td class="a-center '.$inativo.'"><input type="checkbox" class="flat" name="id_visitatecnica[]" id="id_visitatecnica" value="'.$row["idvisitatecnica"].'" ></td>
                                    <td class="'.$inativo.'">'.$row['nomepropriedade'].'</td>
                                    <td class="'.$inativo.'">'.$row['nomeprodutor'].'</td>
                                    <td class="'.$inativo.'">'.$row['nometecnico'].'</td>
                                    <td class="'.$inativo.'">'.date('d/m/Y',strtotime($row['datavisita'])).'</td>
                                    <td class="'.$inativo.'">'.$row['mesreferencia'].'/'.$row['anoreferencia'].'</td>
                                    <td class="'.$inativo.'">'.$datapagamento.'</td>';
									if ($this->financeiro_)
												{
													$html.='
													<th class="'.$inativo.'">'.number_format($row['valorpago'],2,',','.').'</th>';
												}
									$html.='
                                    <td class=" last">'.$acoes.'
                                    </td>';
													
			// $date = new DateTime($row['datacadastro']);
			/*$html = ' 
                      <td align="center"><input type="checkbox" name="id_[]" id="id_" value="'.$row["iddescricao"].'" /></td>
					  <td nowrap><a href="caddescricao.php?op=A&id='.$row['iddescricao'].'">'.$row["descricao"].'</a></td>
					  ';
*/		 	

	echo $html;
				echo "";
		}// function
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
								<div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <select name="cmboxcategoria" id="cmboxcategoria" onChange="submit()" class="form-control">
				   <option value="TERRA" <?php if ($categoria=='TERRA') { echo "SELECTED";}?>>Terra</option>
				   <option value="ANIMAIS" <?php if ($categoria=='ANIMAIS') { echo "SELECTED";}?>>Animais</option>
				   <option value="MAQUINAS" <?php if ($categoria=='MAQUINAS') { echo "SELECTED";}?>>Máquinas</option>
				   <option value="INSTALACOES" <?php if ($categoria=='INSTALACOES') { echo "SELECTED";}?>>Instalações</option>
				   </select>
                                </div>
								<div class="col-md-1 col-sm-12 col-xs-12 form-group">
										
                                     <button type="button" class="btn btn-success" onClick='filterApply()'>Filtrar</button>
								</div>
							</div>
							

                        </div>
                    </div>
					
					
					
                        
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Acompanhamento Econômico Zootécnico <small></small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                                                            <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                Ação
                                <span class="caret"></span>
                            </a>
                                        <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="cadavaliacaoeconomica.php?op=I&idpropriedade=<?php echo $idpropriedade;?>">Novo</a>
                                            </li>
                                           <!--<li role="presentation"><a role="menuitem" tabindex="-1" onClick='showExcluir()'>Excluir</a>
                                            </li>-->
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
	
	if ((!empty($idpropriedade)) && (!empty($categoria)))
	{
		
if ($categoria=='TERRA')
{
	$sqlavaliacao = 'select ano from terra where idpropriedade='.$idpropriedade;  
}
if ($categoria=='ANIMAIS')
{
	$sqlavaliacao = 'select distinct(ano) from animal where idpropriedade='.$idpropriedade;  
}
if ($categoria=='MAQUINAS')
{
	$sqlavaliacao = 'select distinct(ano) from maquina where idpropriedade='.$idpropriedade;  
}
if ($categoria=='INSTALACOES')
{
	$sqlavaliacao = 'select distinct(ano) from instalacao where idpropriedade='.$idpropriedade;  
}
$sqlavaliacao.='order by ano desc';
//echo $sqlavaliacao.' categoria '.$categoria;
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

      <table class="table table-hover">
	  <thead>
        <tr > 
          <th colspan="6">
            <?php echo 'Ano '.$rowavaliacao['ano'];?>
          </th>
        </tr>
		
		<?php if ($categoria=='TERRA')
		{?>
        <tr > 
          <th></th>
          <th>Quantidade (Ha)</th>
          <th>Valor unitário (R$)</th>
          <th>Valor Total (R$)</th>
          <th>Remuneração<br>anual</th>
          <th>Remuneração<br>mensal</th>
        </tr>
		<?php } ?>

		<?php if ($categoria=='ANIMAIS')
		{?>
        <tr > 
          <th>Categoria Animal</th>
          <th>Quantidade (nº)</th>
          <th>Valor individual (R$)</th>
          <th>Valor Total (R$)</th>
          <th>Remuneração<br>anual</th>
          <th>Remuneração<br>mensal</th>
        </tr>
		<?php } ?>
		<?php if ($categoria=='MAQUINAS')
		{?>
        <tr > 
          <th>Máquinas utilizadas</th>
          <th>Vida util (anos)</th>
          <th>Valor inicial (R$)</th>
          <th>Valor <br>residual (R$)</th>
          <th>Valor <br>anual</th>
          <th>Valor <br>mensal</th>
        </tr>
		<?php } ?>
		<?php if ($categoria=='INSTALACOES')
		{?>
        <tr > 
          <th>Instalações utilizadas</th>
          <th>Vida util (anos)</th>
          <th>Valor inicial (R$)</th>
          <th>Valor <br>residual (R$)</th>
          <th>Valor <br>anual</th>
          <th>Valor <br>mensal</th>
        </tr>
		<?php } ?>	
	  </thead>
		
        <?php		
			$TTvalortotal=0;
			$TTvalorresidual=0;
			$TTremuneracaoanual=0;
			$TTremuneracaomensal=0;	
			$TTvalorunitario = 0;


/*if ($_REQUEST['cmboxcategoria']=='TERRA')
{
	$sqlavaliacao = 'select ano from terra where idpropriedade='.$idpropriedade;  
}
 			$sqltipo = "select 1,'Terras' 
union
select 2,'Animais'
union
select 3,'Máquinas'
union
select 4,'Instalações'
";
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
*/
		if ($_REQUEST['cmboxcategoria']=='TERRA')
		{
			$sql = "select * from terra where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
		}
		if ($_REQUEST['cmboxcategoria']=='ANIMAIS')
		{
			$sql = "select a.*, ca.categoriaanimal from animal a, categoriaanimal ca where a.idcategoriaanimal = ca.idcategoriaanimal and a.idpropriedade=".$idpropriedade." and a.ano = ".$rowavaliacao['ano'];
		}
		if ($_REQUEST['cmboxcategoria']=='MAQUINAS')
		{
			$sql = "select m.*,cm.categoriamaquina from maquina m, categoriamaquina cm where m.idcategoriamaquina = cm.idcategoriamaquina and m.idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
		}
		if ($_REQUEST['cmboxcategoria']=='INSTALACOES')
		{
			$sql = "select i.*,ci.categoriainstalacao from instalacao i, categoriainstalacao ci where i.idcategoriainstalacao = ci.idcategoriainstalacao and i.idpropriedade=".$idpropriedade." and i.ano = ".$rowavaliacao['ano'];
		}
		//echo $sql;
		$Tvidautil = 0;
		$Tquantidade=0; 
		$Tvalorunitario=0; 
		$Tvalortotal=0;
		$Tvalorresidual=0;
		$Tremuneracaoanual=0;
		$Tremuneracaomensal=0;
		$classificacao = '';
		$res = pg_exec($conn,$sql);
		while ($row = pg_fetch_array($res))
		{
			if ($categoria=='TERRA')
			{
				calculo('1',6,$row['quantidade'],$row['valorunitario'],1,$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$Tquantidade = $row['quantidade'];
				$Tvalorunitario = $row['valorunitario'];
			}
			if ($categoria=='ANIMAIS')
			{
				calculo('2',6,$row['quantidade'],$row['valorindividual'],1,$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$Tquantidade = $row['quantidade'];
				$Tvalorunitario = $row['valorindividual'];
				$Tvalortotal = $row['quantidade']*$row['valorindividual'];
				$classificacao = $row['categoriaanimal'];
			}
			if ($categoria=='MAQUINAS')
			{
				calculo('3',6,1,$row['valor'],$row['vidautil'],$row['valor'],$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$Tvidautil = $row['vidautil'];
				$Tquantidade = $row['quantidade'];
				$Tvalorunitario = $row['valor'];
				$Tvalortotal = $row['valor'];
				$classificacao = $row['categoriamaquina'];
			}
			if ($categoria=='INSTALACOES')
			{
				calculo('4',6,1,$row['valor'],$row['vidautil'],$row['valor'],$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$Tvidautil = $row['vidautil'];
				$Tquantidade = $row['quantidade'];
				$Tvalorunitario = $row['valor'];
				$Tvalortotal = $row['valor'];
				$classificacao = $row['categoriainstalacao'];
			}

			$Tvalortotal=$valortotal;
			
			$Tvalorresidual=$valorresidual;
			$Tremuneracaoanual=$remuneracaoanual;
			$Tremuneracaomensal=$remuneracaomensal;
			?>
        <tr > 
          <td>
            <?php echo $classificacao;?>
          </td>
          <td>
            <?php
				if ($categoria == 'ANIMAIS')
				{
			 		echo $Tquantidade;
				}
				if (($categoria == 'MAQUINAS')||($categoria == 'INSTALACOES'))
				{
			 		echo $Tvidautil;
				}
					?>
          </td>
          <td><div align="right"> 
		  <?php
				if ($categoria == 'TERRA')
				{
			 		echo number_format($Tvalorunitario, 2, ',', '.');
				}
				if ($categoria == 'ANIMAIS')
				{
			 		echo number_format($Tvalorunitario, 2, ',', '.');
				}
				if (($categoria == 'MAQUINAS')||($categoria == 'INSTALACOES'))
				{
			 		echo number_format($Tvalorunitario, 2, ',', '.');
				}
				?>
            </div></td>
          <td><div align="right"> 
		  <?php
				if ($categoria == 'TERRA')
				{
			 		echo number_format($Tvalortotal, 2, ',', '.');
				}
				if ($categoria == 'ANIMAIS')
				{
			 		echo number_format($Tvalortotal, 2, ',', '.');
				}
				if (($categoria == 'MAQUINAS')||($categoria == 'INSTALACOES'))
				{
			 		echo number_format($Tvalorresidual, 2, ',', '.');
				}
				?>
            </div></td>
          <td><div align="right"> 
            <?php echo number_format($Tremuneracaoanual, 2, ',', '.');?>
            </div></td>
          <td><div align="right"> 
            <?php echo number_format($Tremuneracaomensal, 2, ',', '.');?>
            </div></td>
        </tr>
<?php 			
		$TTvalorunitario = $TTvalorunitario + $Tvalorunitario;
		$TTvalortotal=$TTvalortotal + $Tvalortotal;
		$TTvalorresidual=$TTvalorresidual + $Tvalorresidual;
		$TTremuneracaoanual=$TTremuneracaoanual + $Tremuneracaoanual;
		$TTremuneracaomensal=$TTremuneracaomensal + $Tremuneracaomensal;				
		}
				?>
        <?php
			//}
		?>
		<tr >
          <th>
            <?php echo 'Total';?>
          </th>
          <th>
          </th>
          <th><div align="right"> 
            <?php echo number_format($TTvalorunitario, 2, ',', '.');?>
            </div></th>
          <th><div align="right"> 
            <?php echo number_format($TTvalortotal, 2, ',', '.');?>
            </div></th>
          <th><div align="right"> 
            <?php echo number_format($TTremuneracaoanual, 2, ',', '.');?>
            </div></th>
          <th><div align="right"> 
            <?php echo number_format($TTremuneracaomensal, 2, ',', '.');?>
            </div></th>
        </tr>
        
      </table>
		</td>
		</tr></table>
<?php
		}	 // if 
		}
		
	} // IF ID PROPRIEDADE
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