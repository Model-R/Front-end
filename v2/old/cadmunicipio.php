<?php session_start();
$NOMETABELA = 'configuracao';
$NOMEFUNCAO = 'Configuraca&ccedil;&atilde;';
   include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/configuracao.class.php');
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();
   $Classe = new Configuracao();
   $Classe->conn = $conn;
   $Classe->getConfiguracao($id);
   $anooficio = $Classe->anooficio;
   $numoficio = $Classe->numoficio;
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
<script type="text/javascript" src="verificaajax.js"></script>

    <script type="text/javascript" src="<?php echo $DOJO_PATH;?>/dojo/dojo.js" djConfig="parseOnLoad: true"></script>

    <script type="text/javascript">
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
		dojo.require("dijit.layout.ContentPane");


	function validaForm()
	{
	   r = true;
	   m = '';
	   if ((document.getElementById('edtanooficio').value == '') || (document.getElementById('edtnumoficio').value == '')  )
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
    	   document.getElementById('fechar').value='n';
			document.getElementById('formulario').action="exec.<?php echo $NOMETABELA;?>.php";
   			document.getElementById('formulario').submit();
	   }
	}

	function salvarFechar()
	{
	   if (validaForm()==true){
	   		document.getElementById('fechar').value='s';
			document.getElementById('formulario').action="exec.<?php echo $NOMETABELA;?>.php";
	   		document.getElementById('formulario').submit();
	   }
	}

	function voltar()
	{
    	location.href='cons<?php echo $NOMETABELA;?>.php';
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
						label: 'Salvar e Fechar',
                        showLabel: true,
						onClick: function()
						{
						    <?php if ($funcao->temAcesso($_SESSION['s_idusuario'],'','Cadastrar '.$NOMEFUNCAO)){
								echo "salvarFechar();";
							}
							else
							{
								echo "alert('Acesso não permitido');";
							}
							?>
							
						},
                        iconClass: "dijitEditorIcon dijitEditorIconSave"
                    });
                    toolbar.addChild(button);
                    var button2 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Salvar',
                        showLabel: false,
						onClick: function()
						{
						    <?php if ($funcao->temAcesso($_SESSION['s_idusuario'],'','Cadastrar '.$NOMEFUNCAO)){
								echo "salvar();";
							}
							else
							{
								echo "alert('Acesso não permitido');";
							}
							?>
							
						},
                        iconClass: "dijitEditorIcon dijitEditorIconSave"
                    });
                    toolbar.addChild(button2);

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
	    <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Configura&ccedil;&atilde;o</strong></font> </div>
	<div align="center"style="width: 100%;">
	<div style="width: 50%;">
	
	<form action="exec.<?php echo $NOMETABELA;?>.php" method="POST" name="formulario" id="formulario">
  	  
    <table class="tab_cadrehov">
      <tr class="tab_bg_2"> 
        <th colspan="2"><?php echo $NOMEFUNCAO;?>
        </th>
      </tr>
      
      <tr class="tab_bg_1"> 
          <td width="164" valign="top">Ano Of&iacute;cio</td>
        <td width="359" valign="top"><input name="edtanooficio" type="text" id="edtanooficio" size="50" maxlength="20" value="<?php echo $anooficio;?>" > 
          <div id="divlogin"></div></td>
      </tr>
      <tr class="tab_bg_1"> 
          <td width="164" valign="top">N&uacute;mero Of&iacute;cio</td>
        <td width="359" valign="top"><input name="edtnumoficio" type="text" id="edtnumoficio" size="50" maxlength="20" value="<?php echo $numoficio;?>" > 
          <div id="divlogin"></div></td>
      </tr>
      <tr class="tab_bg_1"> 
        <td valign="top">Estado</td>
        <td valign="top"> 
          <input name="fechar" type="hidden" id="fechar" value="s"> <input name="op" type="hidden" id="operacao" value=""> 
          <input name="codigo" type="hidden" id="codigo" value=""> 
          <div id="divlogin"></div></td>
      </tr>
    </table>
		<br/>
        </form>
</div>
</div>
    </body>

</html>