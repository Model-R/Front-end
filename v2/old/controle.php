<?php 
session_start();
include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/produtor.class.php');
   require_once('classes/propriedade.class.php');
   require_once('classes/avaliacao.class.php');
   require_once('classes/tecnico.class.php');
   require_once('classes/usuario.class.php');
   require_once('classes/configuracao.class.php');
   require_once('classes/animal.class.php');

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

   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();
   $funcao = new Funcao();
   $funcao->conn = $conn;
   $Produtor = new Produtor();
   $Produtor->conn = $conn;
   $Propriedade = new Propriedade();
   $Propriedade->conn = $conn;
   $Tecnico = new Tecnico();
   $Tecnico->conn = $conn;
   
   $Configuracao = new Configuracao();
   $Configuracao->conn = $conn;
   $Configuracao->getConfiguracao();

   $Usuario = new Usuario();
   $Usuario->conn = $conn;

   $Animal = new Animal();
   $Animal->conn = $conn;


   $idprodutor = $_REQUEST['cmboxprodutor'];
   if (empty($idprodutor))
   {
   	$idprodutor = 0;
   }

   $idpropriedade = $_REQUEST['cmboxpropriedade'];
   if (empty($idpropriedade))
   {
   	$idpropriedade = 0;
   }
   
   $ano = $_REQUEST['ano'];
   $numero = $_REQUEST['numero'];

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo $DOJO_PATH;?>/dijit/themes/claro/claro.css"/>
		<link rel="stylesheet" type="text/css" href="css/styles.css"/>
        <style type="text/css">
            body, html { font-family:helvetica,arial,sans-serif; font-size:90%; }
        </style>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <script type="text/javascript" src="<?php echo $DOJO_PATH;?>/dojo/dojo.js" djConfig="parseOnLoad: true">
    </script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="claro" onLoad="preparaEnvio();">
 <span id="toolbar">
          </span>
	    <div style="width: 100%; height: 370px">
 <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Controle</strong></font> </div>
	     <div style="width: 100%; height: 100%;">
			<form action="controle.php" method="POST" name="formulario"  id="formulario">		
        <input type="hidden" name="op" value="E">
		 <input type="hidden" name="ano" value="<?php echo $ano;?>" id="ano">
		<table>
			   	<tr>
				   <td width="114">Produtor:</td>
				   <td width="471"><?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'S',$_SESSION['s_idtecnico']);?></td>
				</tr>
				<tr>
				   <td>Propriedade:</td>
				   <td><?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,$idprodutor,'S',$_SESSION['s_idtecnico']);?></td>
				</tr>
				<tr>
				   <td>Animal:</td>
				   <td><?php echo $Animal->listaCombo('numero',$numero,$idpropriedade,$ano,'S');?></td>
				</tr>
			   	</table>
				
				<table width="70%" class="tab_cadrehov">
				<tr class="tab_bg_2"><th colspan="4">Controle de Lactação</th></tr>
	        	<tr class="tab_bg_2"><th>Lactação</th><th>Data</th><th>Litros</th><th>Gráfico</th></tr>
				<?php 
				$sqllactacao = 'select * from lactacao where idpropriedade='.$idpropriedade.' and ano='.$ano.' and numero='.$numero.' order by lactacao ';
				$reslactacao = pg_exec($conn,$sqllactacao);
				$t = pg_numrows($reslactacao);
				$c=0;
				while ($rowlactacao = pg_fetch_array($reslactacao))
				{
				$c++;
				?>

        <tr class="tab_bg_1" > 
          <td><div align="right"> 
            <?php echo $rowlactacao['lactacao'];?>
            </div></td>
          <td><div align="right"> 
            <?php echo date('d/m/Y',strtotime($rowlactacao['data']));?>
            </div></td>
          <td><div align="right"> 
            <?php echo number_format($rowlactacao['litros'],'2',',','');?>
            </div></td>
			<?php if ($c<=1) {?>
           <td rowspan="<?php echo $t;?>"><img src="graf_lactacao.php?idpropriedade=<?php echo $idpropriedade;?>&lactacao=<?php echo $lactacao;?>&ano=<?php echo $ano;?>&numero=<?php echo $numero;?>"></td>
		   <?php } ?>
        </tr>
        <?php
			}
		?>
      </table>
	  <br>
	  <table width="70%" class="tab_cadrehov">
				<tr class="tab_bg_2"><th colspan="3">Controle de Cobertura/Inseminação</th></tr>
	        	<tr class="tab_bg_2"><th>Data</th><th>Touro</th><th>Observação</th></tr>
				<?php 
				$sqlcobertura = 'select * from cobertura where idpropriedade='.$idpropriedade.' and ano='.$ano.' and numero='.$numero.' order by data desc ';
				$rescobertura = pg_exec($conn,$sqlcobertura);
				while ($rowcobertura = pg_fetch_array($rescobertura))
				{
				?>

        <tr class="tab_bg_1" > 
          <td><div align="left"> 
            <?php echo date('d/m/Y',strtotime($rowcobertura['data']));?>
            </div></td>
          <td><div align="left"> 
            <?php echo $rowcobertura['touro'];?>
            </div></td>
          <td><div align="left"> 
            <?php echo $rowcobertura['obs'];?>
            </div></td>
        </tr>
        <?php
			}
		?>
      </table>
	  <br>
	  <table width="70%" class="tab_cadrehov">
				<tr class="tab_bg_2"><th colspan="3">Controle de Parto</th></tr>
	        	<tr class="tab_bg_2"><th>Data Parto</th><th>Lactação</th><th>Sexo Bezerro</th></tr>
				<?php 
				$sqlparto = 'select * from parto where idpropriedade='.$idpropriedade.' and ano='.$ano.' and numero='.$numero.' order by dataparto desc ';
				$resparto = pg_exec($conn,$sqlparto);
				while ($rowparto = pg_fetch_array($resparto))
				{
				?>

        <tr class="tab_bg_1" > 
          <td><div align="left"> 
            <?php echo date('d/m/Y',strtotime($rowparto['dataparto']));?>
            </div></td>
          <td><div align="left"> 
            <?php echo $rowparto['lactacao'];?>
            </div></td>
          <td><div align="left"> 
            <?php echo $rowparto['sexobezerro'];?>
            </div></td>
        </tr>
        <?php
			}
		?>
      </table>
	  <br>
	  				<table width="70%" class="tab_cadrehov">
				<tr class="tab_bg_2"><th colspan="4">Controle de Crescimento Bezerra</th></tr>
	        	<tr class="tab_bg_2"><th>Data Controle</th><th>Peso (kg)</th></tr>
				<?php 
				$sqllactacao = 'select * from balanca where idpropriedade='.$idpropriedade.' and ano='.$ano.' and numero='.$numero.' order by data ';
				$reslactacao = pg_exec($conn,$sqllactacao);
				$t = pg_numrows($reslactacao);
				$c=0;
				while ($rowlactacao = pg_fetch_array($reslactacao))
				{
				$c++;
				?>

        <tr class="tab_bg_1" > 
          <td><div align="right"> 
            <?php echo date('d/m/Y',strtotime($rowlactacao['data']));?>
            </div></td>
          <td><div align="right"> 
            <?php echo number_format($rowlactacao['peso'],'2',',','');?>
            </div></td>
			<?php if ($c<=1) {?>
           <td rowspan="<?php echo $t;?>"><img src="graf_crescimento.php?idpropriedade=<?php echo $idpropriedade;?>&ano=<?php echo $ano;?>&numero=<?php echo $numero;?>"></td>
		   <?php } ?>
        </tr>
        <?php
			}
		?>
      </table>

	  
        </form>		
    		</div>
		</div>
    </body>
    <script type="text/javascript">

    dojo.addOnLoad(function() {
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
		dojo.require("dijit.TitlePane");
		dojo.require("dijit.form.DateTextBox");
    });

	function enviarFormulario()
	{
			document.getElementById('formulario').submit();
	}		
    </script>
    <script type="text/javascript">
        dojo.addOnLoad(function() {
            if (document.pub) {
                document.pub();
            }
        });
    </script>
    <script type="text/javascript">
           var toolbar;
            dojo.addOnLoad(function() {
                toolbar = new dijit.Toolbar({},"toolbar");
                //dojo.forEach(["Cut", "Copy", "Paste"], function(label) {
					
					var button2 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Imprimir',
                        showLabel: true,
						onClick: function()
						{
							window.print()
						},
                        iconClass: "dijitEditorIcon dijitEditorIconPrint"
                    });
                    toolbar.addChild(button2);
					
					var button3 = new dijit.ToolbarSeparator({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally                        
                    });
                    toolbar.addChild(button3);

					var button4 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Voltar',
                        showLabel: false,
						onClick: function()
						{
							parent.corpo.location.href='home.php';
						},
                        iconClass: "dijitEditorIcon dijitEditorIconRedo"
                    });
                    toolbar.addChild(button4);
                //});
            });        
</script>
</html>