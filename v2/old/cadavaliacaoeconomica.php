<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php
require_once('classes/conexao.class.php');
require_once('classes/produtor.class.php');
require_once('classes/categoriatipocapital.class.php');
require_once('classes/propriedade.class.php');
require_once('classes/estado.class.php');
require_once('classes/tecnico.class.php');
require_once('classes/unidademedida.class.php');
require_once('classes/situacaopropriedade.class.php');
require_once('classes/programa.class.php');
require_once('classes/visitatecnica.class.php');

require_once('classes/categoriainstalacao.class.php');
require_once('classes/categoriaequipamento.class.php');
require_once('classes/categoriaanimal.class.php');


// FUNÇÕES FINANCEIRAS

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


//

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$CategoriaTipoCapital = new CategoriaTipoCapital();
$CategoriaTipoCapital->conn = $conn;

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$UnidadeMedida = new UnidadeMedida();
$UnidadeMedida->conn = $conn;

$SituacaoPropriedade = new SituacaoPropriedade();
$SituacaoPropriedade->conn = $conn;

$Estado = new Estado();
$Estado->conn = $conn;

$Programa = new Programa();
$Programa->conn = $conn;

$VisitaTecnica = new VisitaTecnica();
$VisitaTecnica->conn = $conn;

$CategoriaInstalacao = new CategoriaInstalacao();
$CategoriaInstalacao->conn = $conn;

$CategoriaEquipamento = new CategoriaEquipamento();
$CategoriaEquipamento->conn = $conn;

$CategoriaAnimal = new CategoriaAnimal();
$CategoriaAnimal->conn = $conn;


$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$ano = $_REQUEST['edtano'];
if (empty($ano))
{
	$ano = date('Y');
}
$tipo = $_REQUEST['cmboxtipo'];
if (isset($_REQUEST['cmboxpropriedade']))
{
	$idpropriedade = $_REQUEST['cmboxpropriedade'];
}
else
{
	$idpropriedade = $_REQUEST['idpropriedade'];
}
if ($op=='A')
{
	$VisitaTecnica->getById($id);
	
	$idpropriedade = $VisitaTecnica->idpropriedade;// = $row['idpropriedade'];
	$idtecnico = $VisitaTecnica->idtecnico ;//= $row['nomepropriedade'];
	$datavisita = $VisitaTecnica->datavisita ;//= $row['inscricaoestadual'];
	$relatorio = $VisitaTecnica->relatorio ;//= $row['tecnicoresponsavel'];
	$horachegada = $VisitaTecnica->horachegada;// = $row['tamanho'];
	$horasaida = $VisitaTecnica->horasaida;// = $row['tamanho'];
	$mesreferencia = $VisitaTecnica->mesreferencia;// = $row['idunidademedida'];
	$anoreferencia = $VisitaTecnica->anoreferencia ;//= $row['endereco'];
	$areaprojeto = $VisitaTecnica->areaprojeto;// = $row['municipio'];
	$producaodia = $VisitaTecnica->producaodia ;//= $row['uf'];
	$idunidademedida = $VisitaTecnica->idunidademedida ;//= $row['latitude'];
   	$vacaslactacao = $VisitaTecnica->numvacaslactacao;// = $row['longitude'];
   	$vacassecas = $VisitaTecnica->numvacassecas ;//= $row['idsituacaopropriedade'];
   	$dataproximavisita = $VisitaTecnica->dataproximavisita ;//= $row['idtipoconsultoria'];
	echo $idtecnico;
}

$filtrotecnico = $_SESSION['s_idtecnico'];
if (
	(in_array('ADMINISTRADOR',$_SESSION['s_papel']))
	|| (in_array('AUDITOR',$_SESSION['s_papel']))
	|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
	|| (in_array('OPERADOR',$_SESSION['s_papel']))
	)
{
	$filtrotecnico = '';
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
                                    <h2>Avaliação Econômica <small>Cadastro de avaliação econômica</small></h2>                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form name='frm' id='frm' action='cadavaliacaoeconomica.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                                        
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Propriedade<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,'','S',$filtrotecnico,'class="form-control"');?>
											</div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ano<span class="required">*</span>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input type="text" id="edtano" name="edtano" value="<?php echo $ano;?>" class="form-control" data-inputmask="'mask': '9999'">
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tipo<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<select name="cmboxtipo" id="cmboxtipo" class="form-control" onChange="submit()">
												<option value="" <?php if ($tipo=='') echo "selected";?>>Selecione a categoria</option>
												<option value="T" <?php if ($tipo=='T') echo "selected";?>>Terra</option>
												<option value="A" <?php if ($tipo=='A') echo "selected";?>>Animais</option>
												<option value="E" <?php if ($tipo=='E') echo "selected";?>>Equipamento</option>
												<option value="I" <?php if ($tipo=='I') echo "selected";?>>Instalações</option>
												</select>
                                            </div>
                                        </div>
										<?php if ($tipo=='T')
										{?>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Quantidade<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input id="edtquantidade" value="<?php echo $quantidade;?>" class="form-control col-md-7 col-xs-12" name="edtquantidade" placeholder="" type="text">
                                            </div>
											<div class="col-md-2 col-sm-2 col-xs-12">
                                                <?php echo $UnidadeMedida->listaCombo('cmboxunidademedida',$idunidademedida,'A','S','N','class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Valor unitário<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input id="edtvalorunitario" value="<?php echo $valorunitario;?>" class="form-control col-md-7 col-xs-12" name="edtvalorunitario" placeholder="" type="text">
                                            </div>
                                        </div>
										<?php } ?>
										<?php if ($tipo=='A')
										{?>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Categoria Animal<span class="required"></span>
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $CategoriaAnimal->listaCombo('cmboxcategoriatipocapital',$idcategoriatipocapital,'N','class="form-control"');?>
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Quantidade<span class="required"></span>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input id="edtquantidade" value="<?php echo $quantidade;?>" class="form-control col-md-7 col-xs-12" name="edtquantidade" placeholder="" type="text">
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Valor individual<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input id="edtvalorindividual" value="<?php echo $valorindividual;?>" class="form-control col-md-7 col-xs-12" name="edtvalorindividual" placeholder="" type="text">
                                            </div>
                                        </div>
										<?php } ?>
										<?php if (($tipo=='E') || ($tipo=='I'))
										{
												if ($tipo=='E') $v = '3';
												if ($tipo=='I') $v = '4';
										?>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tipo Máquina/Equipamento<span class="required"></span>
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php 
												if ($tipo=='I')
												{
													echo $CategoriaInstalacao->listaCombo('cmboxcategoriatipocapital',$idcategoriatipocapital,$refresh='N','class="form-control"');
												}
												if ($tipo=='E')
												{
													echo $CategoriaEquipamento->listaCombo('cmboxcategoriatipocapital',$idcategoriatipocapital,$refresh='N','class="form-control"');
												}
												?>
                                            </div>
                                        </div>
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Vida útil<span class="required"></span>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input id="edtvidautil" value="<?php echo $vidautil;?>" class="form-control col-md-7 col-xs-12" name="edtvidautil" placeholder="" type="text">
                                            </div>
                                        </div>
										
										<div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Valor unitário<span class="required"></span>
                                            </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input id="edtvalorunitario" value="<?php echo $valorunitario;?>" class="form-control col-md-7 col-xs-12" name="edtvalorunitario" placeholder="" type="text">
                                            </div>
                                        </div>
										<?php } ?>										
                                       
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button id="send" type="button" onclick="enviar()" class="btn btn-success">Enviar</button>
                                            </div>
                                        </div>
                                    </form>
									
									
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
                                            <?php if (!$financeiro)
											{
												if ((in_array('ADMINISTRADOR',$_SESSION['s_papel']))
												|| (in_array('AUDITOR',$_SESSION['s_papel']))
												|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
												)
												{
												
												?>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="cadavaliacaoeconomica.php?op=I">Novo</a>
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
	
	if ((!empty($idpropriedade)) && (!empty($tipo)))
	{
		
if ($tipo=='T')
{
	$sqlavaliacao = 'select ano from terra where idpropriedade='.$idpropriedade;  
}
if ($tipo=='A')
{
	$sqlavaliacao = 'select distinct(ano) from animal where idpropriedade='.$idpropriedade;  
}
if ($tipo=='E')
{
	$sqlavaliacao = 'select distinct(ano) from maquina where idpropriedade='.$idpropriedade;  
}
if ($tipo=='I')
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
		
		<?php if ($tipo=='T')
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

		<?php if ($tipo=='A')
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
		<?php if ($tipo=='E')
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
		<?php if ($tipo=='I')
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
		if ($tipo=='T')
		{
			$sql = "select * from terra where idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
		}
		if ($tipo=='A')
		{
			$sql = "select a.*, ca.categoriaanimal from animal a, categoriaanimal ca where a.idcategoriaanimal = ca.idcategoriaanimal and a.idpropriedade=".$idpropriedade." and a.ano = ".$rowavaliacao['ano'];
		}
		if ($tipo=='E')
		{
			$sql = "select m.*,cm.categoriamaquina from maquina m, categoriamaquina cm where m.idcategoriamaquina = cm.idcategoriamaquina and m.idpropriedade=".$idpropriedade." and ano = ".$rowavaliacao['ano'];
		}
		if ($tipo=='I')
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
			if ($tipo=='T')
			{
				calculo('1',6,$row['quantidade'],$row['valorunitario'],1,$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$Tquantidade = $row['quantidade'];
				$Tvalorunitario = $row['valorunitario'];
			}
			if ($tipo=='A')
			{
				calculo('2',6,$row['quantidade'],$row['valorindividual'],1,$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$Tquantidade = $row['quantidade'];
				$Tvalorunitario = $row['valorindividual'];
				$Tvalortotal = $row['quantidade']*$row['valorindividual'];
				$classificacao = $row['categoriaanimal'];
			}
			if ($tipo=='E')
			{
				calculo('3',6,1,$row['valor'],$row['vidautil'],$row['valor'],$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$Tvidautil = $row['vidautil'];
				$Tquantidade = $row['quantidade'];
				$Tvalorunitario = $row['valor'];
				$Tvalortotal = $row['valor'];
				$classificacao = $row['categoriamaquina'];
			}
			if ($tipo=='I')
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
				if ($tipo == 'A')
				{
			 		echo $Tquantidade;
				}
				if (($tipo == 'E')||($tipo == 'I'))
				{
			 		echo $Tvidautil;
				}
					?>
          </td>
          <td><div align="right"> 
		  <?php
				if ($tipo == 'T')
				{
			 		echo number_format($Tvalorunitario, 2, ',', '.');
				}
				if ($tipo == 'A')
				{
			 		echo number_format($Tvalorunitario, 2, ',', '.');
				}
				if (($tipo == 'E')||($tipo == 'I'))
				{
			 		echo number_format($Tvalorunitario, 2, ',', '.');
				}
				?>
            </div></td>
          <td><div align="right"> 
		  <?php
				if ($tipo == 'T')
				{
			 		echo number_format($Tvalortotal, 2, ',', '.');
				}
				if ($tipo == 'A')
				{
			 		echo number_format($Tvalortotal, 2, ',', '.');
				}
				if (($tipo == 'E')||($tipo == 'I'))
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

 <!-- daterangepicker -->
        <script type="text/javascript" src="js/moment.min2.js"></script>
        <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>	
	
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
 <!-- input mask -->
    <script src="js/input_mask/jquery.inputmask.js"></script>	

    <script>
	
		
<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
?>
		$(document).ready(function () {
            $(":input").inputmask();
        });		
		
function enviar()
		{
			if (
			(document.getElementById('cmboxpropriedade').value=='') ||
			(document.getElementById('edtano').value=='')
			)
			{
				criarNotificacao('Atenção','Verifique o preenchimento','warning');
			}
			else
			{
				document.getElementById('frm').action='exec.avaliacaoeconomica.php';
				document.getElementById('frm').submit();
			}
		}		
	
	$(document).ready(function () {
                            $('#edtdataproximavisita').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
							$('#edtdatavisita').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        });
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