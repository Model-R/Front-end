<?php session_start();
   include "paths.inc";
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

   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/avaliacao.class.php');
   require_once('classes/tipocapital.class.php');
   require_once('classes/categoriatipocapital.class.php');
   require_once('classes/unidademedida.class.php');
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();

   $Avaliacao = new Avaliacao();
   $Avaliacao->conn = $conn;

   $TipoCapital = new TipoCapital();
   $TipoCapital->conn = $conn;

   $CategoriaTipoCapital = new CategoriaTipoCapital();
   $CategoriaTipoCapital->conn = $conn;

   $UnidadeMedida = new UnidadeMedida();
   $UnidadeMedida->conn = $conn;

   $funcao = new Funcao();
   $funcao->conn = $conn;
   $operacao = $_REQUEST['op'];
   
   $taxajuros = 6;
   if (!empty($_REQUEST[id]))
   {
   		$_REQUEST['cmboxavaliacao'] = $id;
   }
   $idavaliacao = $_REQUEST['cmboxavaliacao'];
   $idtipocapital = $_REQUEST['cmboxtipocapital'];
   if (isset($_REQUEST['idtipocapital']))
   {
   	  $idtipocapital = $_REQUEST['idtipocapital'];
   }
   if (empty($idtipocapital))
   {
   	  $idtipocapital = 1;
   }
   $idcategoriatipocapital = $_REQUEST['cmboxcategoriatipocapital'];
   if (isset($_REQUEST['idcategoriatipocapital']))
   {
   		$idcategoriatipocapital = $_REQUEST['idcategoriatipocapital'];
   }
   
   $Avaliacao->getById($idavaliacao);
   $ano = $Avaliacao->anoreferencia;
   
   $CategoriaTipoCapital->getById($idcategoriatipocapital);
   
   $UnidadeMedida->getById($CategoriaTipoCapital->idunidademedida);
   $siglaunidademedida = $UnidadeMedida->siglaunidademedida;
   
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $DOJO_PATH;?>/dijit/themes/claro/claro.css"/>
  <link rel="stylesheet" type="text/css" href="css/styles.css"/>
        <style type="text/css">
            body, html { font-family:helvetica,arial,sans-serif; font-size:90%; }
        </style>

    <script type="text/javascript" src="<?php echo $DOJO_PATH;?>/dojo/dojo.js" djConfig="parseOnLoad: true"></script>
	<script type="text/javascript" src="verificaajax.js"></script>
    <script type="text/javascript">
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
		dojo.require("dijit.TitlePane");
	  dojo.require("dijit.form.DateTextBox");
		dojo.require("dijit.layout.TabContainer");
		dojo.require("dijit.layout.ContentPane");
		dojo.require("dijit.layout.AccordionContainer");


	function editarItem(id)
	{
		alert('Em desenvolvimento');
    	//location.href='cadremuneracaocapital.php?op=A&iditem='+id+'&idavaliacao=<?php echo $idavaliacao;?>&idtipocapital=<?php echo $idtipocapital;?>';
	}

	function excluirItem(id)
	{
	  if (confirm('Realmente deseja excluir o item')){
    	location.href='exec.remuneracaocapital.php?op=E&id='+id+'&idavaliacao=<?php echo $idavaliacao;?>&idtipocapital=<?php echo $idtipocapital;?>';
      }
	}

	function validaForm()
	{
	   r = true;
	   m = '';
	   if (
	   (document.getElementById('cmboxavaliacao').value == '') ||
	   (document.getElementById('cmboxcategoriatipocapital').value == '') || 
	   (document.getElementById('edtquantidade').value == '') || 
	   (document.getElementById('edtvalorunitario').value == '') || 
	   (document.getElementById('edttaxajuros').value == '') 
		  )
	   { 
	      r = false;
		  m = 'Verifique o preenchimento dos campos. \r\n';
	   }
	   else
	   {
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

	function salvar()
	{
	   if (validaForm()==true){
			document.getElementById('formulario').action="exec.remuneracaocapital.php";
   			document.getElementById('formulario').submit();
	   }
	}

	function voltar()
	{
    	location.href='consavaliacao.php';
	}
	
	function calcula(pvalorunitario)
	{
		var quantidade;
		var valorunitario;
		var taxajuros;
		var remuneracaoanual;
		var remuneracaomensal;
		var valorinicial;
	    var valorresidual;
		var valoranual;
		var valormensal;
		var vidautil;
		var tipo;
		
		tipo = document.getElementById('cmboxtipocapital').value;
		taxajuros = document.getElementById('edttaxajuros').value;
		quantidade = document.getElementById('edtquantidade').value;
		valorunitario = document.getElementById('edtvalorunitario').value;
		if ((tipo==1)||(tipo==2))
		{
		   valortotal = quantidade * valorunitario;
		   remuneracaoanual = (quantidade * valorunitario * taxajuros)/100;
		   remuneracaomensal = ((quantidade * valorunitario * taxajuros)/100)/12;
		   document.getElementById('edtvalortotal').value = valortotal;
		   document.getElementById('edtremuneracaoanual').value = remuneracaoanual;
		   document.getElementById('edtremuneracaomensal').value = remuneracaomensal;
		}
		else
		{
		   valorinicial = document.getElementById('edtvalorunitario').value;
		   vidautil = document.getElementById('edtvidautil').value;
		   if (tipo==3){
		   	  valorresidual = valorinicial*0.1;
		   }
		   if (tipo==4){
		      valorresidual = valorinicial*0.2; 
		   }
		   valorresidual = 0;

        	juros = taxajuros/100;
			prestacoes = vidautil;
			valor = valorinicial-valorresidual;
			cont = 1;
			E = 1;
			for (k=1; k<=prestacoes;k++)
        	{
            	cont = cont * (1 + juros);
				E = E + cont;
			}
			E = E - cont;
        	valor = valor * cont;
        	valoranual = valor/E;



//		   valoranual = (valorinicial-valorresidual)+((valorinicial*taxajuros)/100)
		   valormensal = valoranual/12;
		   document.getElementById('edtvalortotal').value = valorresidual;
		   document.getElementById('edtremuneracaoanual').value = valoranual;
		   document.getElementById('edtremuneracaomensal').value = valormensal;
		}
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
					var button4 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Voltar',
                        showLabel: false,
						onClick: function()
						{
							voltar();
						},
                        iconClass: "dijitEditorIcon dijitEditorIconRedo"
                    });
                    toolbar.addChild(button4);
                //});
            });
        
</script>		
</head>
  
    <body class="claro" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		  <span id="toolbar">
          </span>   	
  <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Cadastro 
    de Remuneração de Capital</strong></font> </div>
	<form action="cadremuneracaocapital.php" method="POST" name="formulario" id="formulario">
  	  
    <table class="tab_cadrehov">
      <tr class="tab_bg_2"> 
        <th colspan="2">Cadastro de Remuneração de Capital</th>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Avaliação</td>
        <td width="315"><?php echo $Avaliacao->listaCombo('cmboxavaliacao',$idavaliacao,$idpropriedade,'N');?> 
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Tipo Capital</td>
        <td width="315"><?php echo $TipoCapital->listaCombo('cmboxtipocapital',$idtipocapital,'S');?> 
        </td>
      </tr>
    </table>
		
    <table class="tab_cadrehov">
      <tr class="tab_bg_2">
	  <?php if (($idtipocapital==1) || ($idtipocapital==2)){
	  	  $colspan = 6;
	  } 
	  else
	  {
	  	$colspan = 7;
	  }
	  ?>
        <th colspan="<?php echo $colspan;?>">Tipo Capital: 
          <?php echo $tipocapital;?>
        </th>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="37" height="16" valign="top">Ano</td>
        <td width="53" valign="top">Tx Juros</td>
        <td width="306" valign="top">Tipo Capital</td>
        <td width="85"> Quantidade</td>
	  <?php if (($idtipocapital==1) || ($idtipocapital==2)){
		}
		else
		{?>
        <td width="102">Vida Util (Anos)</td>
        <?php } ?>
		<td width="124">Valor Unitário (R$)</td>
        <td width="50">&nbsp;</td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="37" valign="top"> 
          <?php echo $ano;?>
        </td>
        <td width="53" valign="top"><input name="edttaxajuros" id="edttaxajuros" value="<?php echo $taxajuros;?>" type="text" size="1" maxlength="3">
          %</td>
        <td width="306" valign="top"> 
          <?php echo $CategoriaTipoCapital->listaCombo('cmboxcategoriatipocapital',$idcategoriatipocapital,$idtipocapital,'S');?>
        </td>
<?php if ($idtipocapital == 4)
	{
		$qtd = 1;
		$readonly = 'readonly="true"';
	}
	else
	{
		$readonly = '';
	}
	?>
        <td width="85"> <input name="edtquantidade"  type="text" id="edtquantidade" size="4" maxlength="4" value="<?php echo $qtd;?>" <?php echo $readonly;?> onkeypress='return SomenteNumeroDecimais(event)'> 
          <?php echo $siglaunidademedida;?>
        </td>
	  <?php if (($idtipocapital==1) || ($idtipocapital==2)){
		}
		else
		{?>
        <td width="102"><input name="edtvidautil" type="text" id="edtvidautil" size="4" maxlength="4" value="" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <?php } ?>

        <td width="124"><input name="edtvalorunitario" type="text" id="edtvalorunitario" size="8" value="" maxlength="8" onkeypress='return SomenteNumeroDecimais(event)' ></td>
        <td width="100"><div dojoType="dijit.form.ToggleButton" id="toolbar1.Salvar" iconClass="dijitEditorIcon dijitEditorIconSave"
							showLabel="false" onClick="salvar();"> Salvar </div></td>
      </tr>
    </table>
		<center>
<div style="width: 95%; height: 450px" >
  <div data-dojo-type="dijit.layout.AccordionContainer" style="height: 400px;">
<?php $sqltipo = 'select * from tipocapital';
		$restipo = pg_exec($conn,$sqltipo);
		while ($rowtipo = pg_fetch_array($restipo))
		{?>
    <div data-dojo-type="dijit.layout.ContentPane" data-dojo-props="title:'<?php echo $rowtipo['tipocapital'];?>'<?php if ($rowtipo['idtipocapital']==$idtipocapital){ echo ",selected: true";}?>">
  <table class="tab_cadrehov" style="width: 100%;">
    <?php if ($rowtipo['idtipocapital']=='1') // terras
	{?>
    <tr class="tab_bg_2" > 
      <th width="5%" height="16" ><strong>Ano</strong></th>
      <th width="5%"><strong>Tx Juros</strong></th>
      <th width="35%"><strong>Tipo Capital</strong></th>
      <th width="5%"> <strong>Quantidade</strong></th>
      <th width="10%"><strong>Valor Unitário (R$)</strong></th>
      <th width="10%"><strong>Valor Total (R$)</strong></th>
      <th width="10%"><strong>Remuneracao Anual (R$)</strong></th>
      <th width="10%"><strong>Remuneracao Mensal (R$)</strong></th>
      <th width="10%">&nbsp;</td>
    </tr>
    <?php }  ?>
    <?php if ($rowtipo['idtipocapital']=='2')
	{?>
    <tr class="tab_bg_2"> 
      <td width="5%" height="16"><strong>Ano</strong></td>
      <td width="5%"><strong>Tx Juros</strong></td>
      <td width="35%"><strong>Tipo Capital</strong></td>
      <td width="5%"><strong> Quantidade</strong></td>
      <td width="10%"><strong>Valor Individual (R$)</strong></td>
      <td width="10%"><strong>Valor Total (R$)</strong></td>
      <td width="10%"><strong>Remuneracao Anual (R$)</strong></td>
      <td width="10%"><strong>Remuneracao Mensal (R$)</strong></td>
      <td width="10%">&nbsp;</td>
    </tr>
    <?php }  ?>
    <?php if (($rowtipo['idtipocapital']=='3') ||
	($rowtipo['idtipocapital']=='4')) 
	{?>
    <tr class="tab_bg_2"> 
      <td width="5%" height="16"><strong>Ano</strong></td>
      <td width="5%"><strong>Tx Juros</strong></td>
      <td width="25%"><strong>Tipo Capital</strong></td>
      <td width="5%"><strong> Quantidade</strong></td>
      <td width="10%"><strong>Vida Util (Anos)</strong></td>
      <td width="10%"><strong>Valor Inicial (R$)</strong></td>
      <td width="10%"><strong>Valor Residual (R$)</strong></td>
      <td width="10%"><strong>Valor Anual (R$)</strong></td>
      <td width="10%"><strong>Valor Mensal (R$)</strong></td>
      <td width="10%">&nbsp;</td>
    </tr>
    <?php }  ?>
    <?php $sql = 'select * from remuneracaocapital rc, avaliacao a,
categoriatipocapital ctc left join unidademedida um on
ctc.idunidademedida = um.idunidademedida, tipocapital tc 
 where
rc.idavaliacao = a.idavaliacao and
a.idavaliacao = '.$idavaliacao.' and
rc.idcategoriacapital = ctc.idcategoriatipocapital and
ctc.idtipocapital = tc.idtipocapital and tc.idtipocapital = '.$rowtipo['idtipocapital'];
		$res = pg_exec($conn,$sql);
		while ($row = pg_fetch_array($res))
		{
		   calculo($rowtipo['idtipocapital'],$row['taxajuros'],$row['quantidade'],$row['valorunitario'],$row['vidautil'],$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
?>
    <tr class="tab_bg_1"> 
      <td > 
        <?php echo $row['anoreferencia'];?>
      </td>
      <td > 
        <?php echo $row['taxajuros'];?>
      </td>
      <td > 
        <?php echo $row['categoriatipocapital'];?>
      </td>
      <td > 
        <?php echo $row['quantidade'];?>
      </td>
	  <?php if (($rowtipo['idtipocapital']==3) || ($rowtipo['idtipocapital']==4)){
?>
      <td > 
        <?php echo $row['vidautil'];?>
      </td><?php	}
		?>

      <td ><div align="right"> 
          <?php echo number_format($row['valorunitario'], 2, ',', '.');?>
        </div></td>
      <td ><div align="right"> 
	  	<?php if (($idtipocapital==1) || ($idtipocapital==2)){
			echo number_format($valortotal, 2, ',', '.');
		}
		else
		{?>
          <?php echo number_format($valorresidual, 2, ',', '.');?>
		<?php } ?>
        </div></td>
      <td ><div align="right"> 
          <?php echo number_format($remuneracaoanual, 2, ',', '.');?>
        </div></td>
      <td ><div align="right"> 
          <?php echo number_format($remuneracaomensal, 2, ',', '.');?>
        </div></td>
      <td >
        <div dojoType="dijit.form.ToggleButton" id="toolbar2.Excluir<?php echo $row['idremuneracaocapital'];?>" iconClass="dijitEditorIcon dijitEditorIconDelete"
							showLabel="false" onClick="excluirItem(<?php echo $row['idremuneracaocapital'];?>);"> 
          Excluir </div>
		  <div dojoType="dijit.form.ToggleButton" id="toolbar2.Editar<?php echo $row['idremuneracaocapital'];?>" iconClass="dijitRtl dijitIconEdit"
							showLabel="false" onClick="editarItem(<?php echo $row['idremuneracaocapital'];?>);"> 
          Editar </div>
		  </td>
    </tr>
    <?php		} ?>
  </table>
    </div>

<?php } ?>
  </div>
</div>
	</center>
        </form>
    </body>


</html>