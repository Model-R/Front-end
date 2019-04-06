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


   $anoreferencia = $Configuracao->anoreferencia;
   $idavaliacao = $_REQUEST['cmboxavaliacao'];
   
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
   $idtecnico = $_REQUEST['cmboxtecnico'];
   if ((in_array('TECNICO', $_SESSION['s_papel'])) && (!in_array('ADMINISTRADOR', $_SESSION['s_papel']))) 
   {
   	   if ($Usuario->getUsuarioById($_SESSION['s_idusuario']));
   	   {
   	      $idtecnico = $Usuario->idtecnico;
   	   }
   }
   
   $categoria = $_REQUEST['cmboxcategoria'];
   if (empty($categoria))
   {
   	$categoria = 'TERRA';
   } 

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
 <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Cálculo da Remuneração de Capital Investido em <?php 
 if ($categoria=='TERRA')
{
	echo "TERRA";  
}
if ($categoria=='ANIMAIS')
{
	echo "ANIMAIS";  
}
if ($categoria=='MAQUINAS')
{
	echo "MÁQUINAS";  
}
if ($categoria=='INSTALACOES')
{
	echo "INSTALAÇÕES";  
}

?></strong></font> </div>
	     <div style="width: 100%; height: 100%;">
			<form action="conseconomicozootecnica.php" method="POST" name="formulario"  id="formulario">		
        <input type="hidden" name="op" value="E">
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
				   <td>Categoria:</td>
				   <td><select name="cmboxcategoria" id="cmboxcategoria" onChange="submit()">
				   <option value="TERRA" <?php if ($categoria=='TERRA') { echo "SELECTED";}?>>Terra</option>
				   <option value="ANIMAIS" <?php if ($categoria=='ANIMAIS') { echo "SELECTED";}?>>Animais</option>
				   <option value="MAQUINAS" <?php if ($categoria=='MAQUINAS') { echo "SELECTED";}?>>Máquinas</option>
				   <option value="INSTALACOES" <?php if ($categoria=='INSTALACOES') { echo "SELECTED";}?>>Instalações</option>
				   </select></td>
				</tr>
			   	</table>
				<?php 

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

      <table class="tab_cadrehov">
        <tr class="tab_bg_2"> 
          <th colspan="6">
            <?php echo 'Ano '.$rowavaliacao['ano'];?>
          </th>
        </tr>
		
		<?php if ($categoria=='TERRA')
		{?>
        <tr class="tab_bg_2"> 
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
        <tr class="tab_bg_2"> 
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
        <tr class="tab_bg_2"> 
          <th>Máquinas utilizadas</th>
          <th>Vida util (anos)</th>
          <th>Valor inicial (R$)</th>
          <th>Valor <br>residual (R$)</th>
          <th>Valor <br>anual</th>
          <th>Valor<br>mensal</th>
        </tr>
		<?php } ?>
		<?php if ($categoria=='INSTALACOES')
		{?>
        <tr class="tab_bg_2"> 
          <th>Instalações utilizadas</th>
          <th>Vida util (anos)</th>
          <th>Valor inicial (R$)</th>
          <th>Valor <br>residual (R$)</th>
          <th>Valor <br>anual</th>
          <th>Valor<br>mensal</th>
        </tr>
		<?php } ?>		
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
        <tr class="tab_bg_1"> 
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
        <tr class="tab_bg_2"> 
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

			?>
	  
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