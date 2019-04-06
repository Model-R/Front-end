<?php session_start();
   include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/lactacao.class.php');
   require_once('classes/animal.class.php');
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();

   $Lactacao = new Lactacao();
   $Lactacao->conn = $conn;

   $Animal = new Animal();
   $Animal->conn = $conn;

   $funcao = new Funcao();
   $funcao->conn = $conn;
   $operacao = $_REQUEST['op'];
   
   $idavaliacao = $_REQUEST['idavaliacao'];
   $idlactacao = $_REQUEST['idlactacao'];
   $idanimal = $_REQUEST['idanimal'];
   $datacontrole= $_REQUEST['datacontrole'];
   $qtdlitros= $_REQUEST['qtdlitros'];
   $periodo= $_REQUEST['periodo'];





	if (empty($operacao)){
	    header('Location: consanimal.php');
	}
	else
	{
	   if ($operacao=='A') 
	   {
    	  $id = $_REQUEST['idlactacao'];
		  if (($id == '0') || (empty($id)))
		  {
		      header('Location: consanimal.php?mensagem=Selecione o animal que deseja informar a lactação');
		  } 
		  else
		  {
		  		$Lactacao->getById($id);
				$idlactacao = $Lactacao->idlactacao;
				$idanimal = $Lactacao->idanimal;
				$datacontrole = $Lactacao->datacontrole;
				$qtdlitros = $Lactacao->qtdlitros;
				$periodo = $Lactacao->periodo;
		  }
	  }
	  if ($operacao == 'I')
	  {
		   $periodo = $Lactacao->ultimaLactacao($idanimal);
	  }
	}
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

    <script type="text/javascript">
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
		dojo.require("dijit.TitlePane");
	  dojo.require("dijit.form.DateTextBox");
	function excluirItem()
	{
	  if (confirm('Realmente deseja excluir a lactação')){
    	location.href='exec.lactacao.php?op=E&id=<?php echo $id;?>';
      }
	}

	function validaForm()
	{
	   r = true;
	   m = '';
	   if ((document.getElementById('edtdatacontrole').value == '') 
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
    	   document.getElementById('fechar').value='n';
			document.getElementById('formulario').action="exec.lactacao.php";
   			document.getElementById('formulario').submit();
	   }
	}

	function salvarFechar()
	{
	   if (validaForm()==true){
	   		document.getElementById('fechar').value='s';
			document.getElementById('formulario').action="exec.lactacao.php";
	   		document.getElementById('formulario').submit();
	   }
	}

	function voltar()
	{
    	location.href='consanimal.php';
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
							salvarFechar();
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
							salvar();
						},
                        iconClass: "dijitEditorIcon dijitEditorIconSave"
                    });
                    toolbar.addChild(button2);
		<?php if ($operacao=='A'){?>
					var buttonExc = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Excluir',
                        showLabel: false,
						onClick: function()
						{
							excluirItem();
						},
                        iconClass: "dijitEditorIcon dijitEditorIconDelete"
                    });
                    toolbar.addChild(buttonExc);
 		<?php } ?>

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
	    <div style="width: 100%; height: 370px">
  <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Cadastro 
    de Lactação</strong></font> </div>
	
	<form action="exec.lactacao.php" method="POST" name="formulario" id="formulario">
    <input name="fechar" type="hidden" id="fechar" value="s"> <input name="op" type="hidden" id="operacao" value="<?php echo $operacao;?>"> 
    <input name="codigo" type="hidden" id="codigo" value="<?php echo $id;?>"> 
    <table class="tab_cadrehov">
      <tr class="tab_bg_2"> 
        <th colspan="2">Cadastro de lactação</th>
      </tr>
      <?php if ($operacao=='A'){?>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">ID:</td>
        <td width="315"><input name="edtidlactacao" type="text" id="edtidlactacao" readonly="true" size="2" value="<?php echo $idlactacao;?>"> 
        </td>
      </tr>
      <?php } ?>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Animal:</td>
        <td width="315"> 
          <input name="edtidanimal" type="text" id="edtidanimal" value="<?php echo $idanimal;?>" size="2" readonly="true"> 
		 </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Período de Lactação</td>
        <td width="315"><input name="edtperiodo" type="text" id="edtperiodo" value="<?php echo $periodo;?>" size="2" maxlength="2">
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Data controle</td>
        <td width="315"><input name="edtdatacontrole" type="text" id="edtdatacontrole" value="<?php echo $datacontrole;?>" dojoType="dijit.form.DateTextBox"> 
        </td>
      </tr>
	<tr class="tab_bg_1"> 
        <td width="200" valign="top">Qtd Litros</td>
        <td width="315"><input name="edtqtdlitros" type="text" id="edtqtdlitros" value="<?php echo $qtdlitros;?>"> 
        </td>
      </tr>
    </table>
        </form>
</center>
</div>
    </body>

</html>