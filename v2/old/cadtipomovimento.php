<?php session_start();
if (!isset($_SESSION['s_papel']))
{
	header('Location: login.php?m=sessão expirada');
}

   include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/categoriatipomovimento.class.php');
   require_once('classes/tipomovimento.class.php');
   require_once('classes/unidade.class.php');

   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();

   $CategoriaTipoMovimento = new CategoriaTipoMovimento();
   $CategoriaTipoMovimento->conn = $conn;

   $TipoMovimento = new TipoMovimento();
   $TipoMovimento->conn = $conn;

   $Unidade = new Unidade();
   $Unidade->conn = $conn;

   $funcao = new Funcao();
   $funcao->conn = $conn;
   
   $operacao = $_REQUEST['op'];
   
	if (empty($operacao)){
	    header('Location: constipomovimento.php?mensagem=Erro');
	}
	else
	{
	   if ($operacao=='A') 
	   {
    	  $id = $_REQUEST['id'];
		  if (($id == '0') || (empty($id)))
		  {
		      header('Location: constipomovimento.php?mensagem=Selecione a avaliação que deseja alterar');
		  } 
		  else
		  {

		  		$TipoMovimento->getById($id);
				$idtipomovimento = $TipoMovimento->idtipomovimento;
				$tipomovimento = $TipoMovimento->tipomovimento;
			    $idcategoriatipomovimento = $TipoMovimento->idcategoriatipomovimento;
			    $codigotipomovimento = $TipoMovimento->codigo;
			    $idunidade = $TipoMovimento->idunidade;
		}
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
	  if (confirm('Realmente deseja excluir a tipo movimento')){
    	location.href='exec.tipomovimento.php?op=E&id=<?php echo $id;?>';
      }
	}

	function validaForm()
	{
	   r = true;
	   m = '';
	   if ((document.getElementById('cmboxcategoriatipomovimento').value == '') ||
	   (document.getElementById('edttipomovimento').value == '')  
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
			document.getElementById('formulario').action="exec.tipomovimento.php";
   			document.getElementById('formulario').submit();
	   }
	}

	function salvarFechar()
	{
	   if (validaForm()==true){
	   		document.getElementById('fechar').value='s';
			document.getElementById('formulario').action="exec.tipomovimento.php";
	   		document.getElementById('formulario').submit();
	   }
	}

	function voltar()
	{
    	location.href='constipomovimento.php';
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
						disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,						
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
						disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
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
		<?php if ($operacao=='A'){?>
					var buttonExc = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Excluir',
                        showLabel: false,
						disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,						
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
    Tipo Movimento</strong></font> </div>
	
	<form action="exec.tipomovimento.php" method="POST" name="formulario" id="formulario">
  	  
    <table class="tab_cadrehov">
      <tr class="tab_bg_2"> 
        <th colspan="2">Cadastro Tipo Movimento</th>
      </tr>
      <?php if ($operacao=='A'){?>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">ID:</td>
        <td width="315"><input name="edtidtipomovimento" type="text" id="edtidtipomovimento" readonly="true" value="<?php echo $idtipomovimento;?>"> 
        </td>
      </tr>
      <?php } ?>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Tipo Movimento</td>
        <td width="315"><input name="edttipomovimento" type="text" id="edttipomovimento" value="<?php echo $tipomovimento;?>" size="50" > 
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Codigo</td>
        <td width="315"><input name="edtcodigotipomovimento" type="text" id="edtcodigotipomovimento" value="<?php echo $codigotipomovimento;?>" size="10" > 
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Categoria Tipo Movimento:</td>
        <td width="315"> 
          <?php echo $CategoriaTipoMovimento->listaCombo('cmboxcategoriatipomovimento',$idcategoriatipomovimento,'','N');?>
          <input name="fechar" type="hidden" id="fechar" value="s"> <input name="op" type="hidden" id="operacao" value="<?php echo $operacao;?>"> 
          <input name="codigo" type="hidden" id="codigo" value="<?php echo $id;?>"> 
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Unidade</td>
        <td width="315"><?php echo $Unidade->listaCombo('cmboxunidade',$idunidade,'','N');?>
        </td>
      </tr>
    </table>
		<br/>
        </form>
</center>
</div>
    </body>

</html>