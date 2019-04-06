<?php 
session_start();
include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();
   $funcao = new Funcao();
   $funcao->conn = $conn;
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
		url: "montapaginacaotipocapital.php?p="+pag+"&base="+base+"&o="+ordenacao+"&tf=<?php echo $_REQUEST['cmboxfiltro'];?>&vf=<?php echo $_REQUEST['edtfiltro'];?>",
		load: function(newContent) {
			dojo.byId("pagi").innerHTML = newContent;
		},
		error: function() {
		   alert('erro');
		}
	});
}
</script>	
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="claro" onLoad="preparaEnvio();">
 <span id="toolbar">
          </span>
 
<div dojoType="dijit.layout.ContentPane" region="top" splitter="false">
<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Tipo Capital</strong></font> 
  <div style="width: 100%; height: 100%;">
			<form action="constipocapital.php" method="POST" name="formulario"  id="formulario">		
        <input type="hidden" name="op" value="E">
		<table>
			   	<tr>
				   <td>Filtro:</td>
				   <td><select name="cmboxfiltro" id="cmboxfiltro">
						 <option value="TIPOCAPITAL" <?php if ($_REQUEST['cmboxfiltro']=='TIPOCAPITAL'){ echo "SELECTED"; } ?>>Tipo capital</option>
						 </select>&nbsp;
						 <input name="edtfiltro" id="edtfiltro" type="text" size="30" maxlength="50" value="<?php echo $_REQUEST['edtfiltro']?>">
						 
						 <div dojoType="dijit.form.ToggleButton" id="toolbar1.filtrar" iconClass="dijitEditorIcon dijitEditorIconIndent"
							showLabel="true" onClick="enviarFormulario();">
							Filtrar
						</div>
					</td>
					<td>Ordenar por:</td>
					<td><select name="cmboxordenacao" id="cmboxordenacao" onChange="enviarFormulario();">
						 <option value="TIPOCAPITAL" <?php if ($_REQUEST['cmboxordenacao']=='TIPOCAPITAL'){ echo "SELECTED"; } ?>>Tipo capital</option>
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

	function checkdata() {
		with(document.formulario) {
			if(id_usuario.checked == false) {
				alert("Nenhum tipo capital selecionado!");
				return false;
			}else{
				if (confirm('Deseja realmente excluir o tipo de capital selecionadas?')){
					document.getElementById('formulario').submit();
				}
			}
		}
	}
		
	function preparaEnvio()
	{
	  p1 = '1';
	  p2 = '';//'<?php echo $_SESSION['codbasedados'];?>';
	  p3 = document.getElementById('cmboxordenacao').value;
	  montapaginacao(p1,p2,p3);	
	}

	
	function novo()
	{
		location.href='cadtipocapital.php?op=I';
	}

    function verificaSelecao()
	{
		var chks = document.getElementsByName('id_tipocapital[]');
		var hasChecked = false;
		var valor;
		valor = 0;
		var c;
		c = 0;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				c = c + 1;
				valor = chks[i].value;
			}
		}
		if (c>1)
		{
		   alert('Selecione apenas um tipo capital');
		   return 0;	
		}
		else
		{
			if (c<1)
			{
				alert('Selecione uma tipo capital');
				return 0;
			}
			else
			{
				return valor;
			}
		}
			
	}
	

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
                    var button = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        id: "toolbar1.SaveContinue2",
						label: 'Novo',
                        showLabel: true,
						onClick: function()
						{
							novo();
						},
                        iconClass: "dijitEditorIcon dijitEditorIconNewPage"
                    });
                    toolbar.addChild(button);
					
					var button_excluir = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        id: "toolbar1.Excluir",
						label: 'Excluir itens selecionados',
                        showLabel: false,
						onClick: function()
						{
							excluir();
						},
                        iconClass: "dijitEditorIcon dijitEditorIconDelete"
                    });
                    toolbar.addChild(button_excluir);
                    
					var button2 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Imprimir',
                        showLabel: false,
						onClick: function()
						{
							imprimir()
						},
                        iconClass: "dijitEditorIcon dijitEditorIconPrint"
                    });
                    toolbar.addChild(button2);
		
					var buttonExc = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Gerar Excel',
                        showLabel: false,
						onClick: function()
						{
							gerarExcel()
						},
                        iconClass: "dijitEditorIcon dijitEditorIconInsertTable"
                    });
                    toolbar.addChild(buttonExc);
 	
					var button3 = new dijit.ToolbarSeparator({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally                        
                    });
                    toolbar.addChild(button3);
					
					var button4 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Consulta',
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