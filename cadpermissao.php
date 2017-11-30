<?php
   session_start();
   $tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}

   
header('Content-type: text/html; charset=utf-8');
   include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/usuario.class.php');
   require_once('classes/funcao.class.php');
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();
   $usuario = new Usuario();
   $usuario->conn = $conn;
   
   $funcao = new Funcao();
   $funcao->conn = $conn;
   
   if (!isset($_REQUEST['cmboxusuario']))
   {
   	  $_REQUEST['cmboxusuario'] = $_SESSION['s_idusuario'];
   }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
    <head>
      <link rel="stylesheet" type="text/css" href="<?php echo $DOJO_PATH;?>/dijit/themes/claro/claro.css"
        />
        <style type="text/css">
            body, html { font-family:helvetica,arial,sans-serif; font-size:90%; }
        </style>
    </head>
    
    <body class="claro" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<span id="toolbar"> </span> 
<!-- Tags end on line afterwards to eliminate any whitespace -->
<form action="cadpermissao.php" method="POST" name="formulario" id="formulario">
		
		<div><img width="100%" height="10" src="" border="0"></div>
        <div style="width: 100%; height: 370px">
            <div dojoType="dijit.layout.TabContainer" style="width: 100%;" doLayout="false">
                <div dojoType="dijit.layout.ContentPane" title="Cadastrar Permiss&atilde;o" >

    <div style="width: 800px; height: 100%;">
		  <table >
            <tr> 
              <td width="200" valign="top">Usu&aacute;rio:</td>
              <td width="315"> <?php echo $usuario->listaCombo('cmboxusuario',$_REQUEST['cmboxusuario'],'S');?> 
              </td>
            </tr>
            <tr> 
              <td colspan="2" valign="top"><hr></td>
            </tr>
            <tr> 
              <td width="200" valign="top">Fun&ccedil;&atilde;o:</td>
              <td width="315"> <?php echo utf8_decode ($funcao->lista('checkpermissao',$_REQUEST['cmboxusuario']));?></td>
            </tr>
            <tr> 
              <td width="200" valign="top">&nbsp;</td>
              <td width="315"> <input name="fechar" type="hidden" id="fechar" value="s"> 
                <input name="op" type="hidden" id="operacao" value="<?php echo $operacao;?>"> 
                <input name="codigo" type="hidden" id="codigo" value="<?php echo $id;?>"> 
              </td>
            </tr>
          </table>
        </div>
                </div>
             </div>
         </div>
        </form>
    </body>
<?php //    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.4/dojo/dojo.xd.js" djConfig="parseOnLoad: true">?>
    <script type="text/javascript" src="<?php echo $DOJO_PATH;?>/dojo/dojo.js" djConfig="parseOnLoad: true">
    </script>
    <script type="text/javascript">
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
   // 	dojo.require("dijit.Menu");
   // 	dojo.require("dijit.MenuItem");
  //  	dojo.require("dijit.PopupMenuItem");
        dojo.require("dijit.layout.TabContainer");
        dojo.require("dijit.layout.ContentPane");
 //       dojo.require("dijit.TitlePane");
//		dojo.require("dijit.form.TextBox");
//		dojo.require("dojox.grid.DataGrid");
 //       dojo.require("dojox.data.CsvStore");
//		dojo.require("dijit.form.ComboBox");
//		dojo.require("dojo.data.ItemFileReadStore")
//		dojo.require("dijit.Dialog");

    var tp;
	
	
	function validaForm()
	{
	   r = true;
	   m = '';
	   if (document.getElementById('cmboxusuario').value == '')
	   { 
	   	  m = 'Selecione o usuário';
	      r = false;
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
	   		document.getElementById('formulario').action='exec.cadpermissao.php';		
			document.getElementById('formulario').submit();
	   }
	}
    </script>
	
    <!-- NOTE: the following script tag is not intended for usage in real
    world!! it is part of the CodeGlass and you should just remove it when
    you use the code -->
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
                        label: 'Salvar',
                        showLabel: true,
						disabled: <?php if ( (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) )
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,						
						onClick: function()
						{
							salvar();
						},
                        iconClass: "dijitEditorIcon dijitEditorIconSave"
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