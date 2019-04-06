<?php 
session_start();
include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/configuracao.class.php');
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();
   $funcao = new Funcao();
   $funcao->conn = $conn;

   $Configuracao = new Configuracao();
   $Configuracao->conn = $conn;
   $Configuracao->getConfiguracao();
   $anoreferencia = $Configuracao->anoreferencia;
   if ((empty($_REQUEST['edtfiltro'])) && ($_REQUEST['cmboxfiltro']=='ANO') || (empty($_REQUEST['cmboxfiltro'])))
   {
   	   $_REQUEST['edtfiltro'] = $anoreferencia;
   }
   if (empty($_REQUEST['cmboxfiltro']))
   {
   	   $_REQUEST['cmboxfiltro']='ANO';
   }

   $tipo = $_REQUEST['tipo'];
   if ($tipo=='AE'){
   	  $desctipo = 'Acompanhamento Econômico';
   }
   if ($tipo=='AZ'){
   	  $desctipo = 'Acompanhamento Zootécnico';
   }
   if ($tipo=='AM'){
   	  $desctipo = 'Acompanhamento Movimento';
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

<script>
function montapaginacao(pag,base,ordenacao)
{
	dojo.byId("pagi").innerHTML = '<img src="imagens/loading.gif"/>';
	dojo.xhrGet({
		url: "montapaginacaoacompanhamento.php?tipo=<?php echo $tipo;?>&p="+pag+"&o="+ordenacao+"&tf=<?php echo $_REQUEST['cmboxfiltro'];?>&vf=<?php echo $_REQUEST['edtfiltro'];?>",
		load: function(newContent) {
			dojo.byId("pagi").innerHTML = newContent;
		},
		error: function() {
			alert('erro');
		}
	});
}

	function preparaEnvio()
	{
	  p1 = '1';
	  p2 = '';//'<?php echo $_SESSION['codbasedados'];?>';
	  p3 = document.getElementById('cmboxordenacao').value;
	  montapaginacao(p1,p2,p3);	
	}

	function enviarFormulario()
	{
			document.getElementById('formulario').submit();
	}		

</script>	
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="claro" onLoad="preparaEnvio();">
 <span id="toolbar">
          </span>
	    <div style="width: 100%; height: 370px">
 <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $desctipo;?></strong></font> </div>
	     <div style="width: 100%; height: 100%;">
			<form action="consacompanhamento.php" method="POST" name="formulario"  id="formulario">		
        <input type="hidden" name="op" value="E">
        <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo;?>">
		<table>
			   	<tr>
				   <td>Filtro:</td>
				   <td><select name="cmboxfiltro" id="cmboxfiltro">
						 <option value="ANO" <?php if ($_REQUEST['cmboxfiltro']=='ANO'){ echo "SELECTED"; } ?>>Ano</option>
						 <option value="PROPRIEDADE" <?php if ($_REQUEST['cmboxfiltro']=='PROPRIEDADE'){ echo "SELECTED"; } ?>>Propriedade</option>
						 <option value="PRODUTOR" <?php if ($_REQUEST['cmboxfiltro']=='PRODUTOR'){ echo "SELECTED"; } ?>>Produtor</option>
						 </select>&nbsp;
						 <input name="edtfiltro" id="edtfiltro" type="text" size="30" maxlength="50" value="<?php echo $_REQUEST['edtfiltro']?>">
						 
						 <div dojoType="dijit.form.ToggleButton" id="toolbar1.filtrar" iconClass="dijitEditorIcon dijitEditorIconIndent"
							showLabel="true" onClick="enviarFormulario();">
							Filtrar
						</div>
					</td>
					<td>Ordenar por:</td>
					<td><select name="cmboxordenacao" id="cmboxordenacao" onChange="enviarFormulario();">
						 <option value="ANO" <?php if ($_REQUEST['cmboxordenacao']=='ANO'){ echo "SELECTED"; } ?>>Ano</option>
						 <option value="PROPRIEDADE" <?php if ($_REQUEST['cmboxordenacao']=='PROPRIEDADE'){ echo "SELECTED"; } ?>>Propriedade</option>
						 <option value="PRODUTOR" <?php if ($_REQUEST['cmboxordenacao']=='PRODUTOR'){ echo "SELECTED"; } ?>>Produtor</option>
						 </select>
					</td>
			   	</tr>
			   	</table>
				<div id="pagi" align="center"></div>				
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
    });

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