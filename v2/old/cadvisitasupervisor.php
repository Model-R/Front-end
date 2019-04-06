<?php session_start();
   include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/propriedade.class.php');
   require_once('classes/produtor.class.php');
   require_once('classes/tecnico.class.php');
   require_once('classes/visitasupervisor.class.php');
   require_once('classes/usuario.class.php');
   require_once('classes/avaliacao.class.php');
   require_once('classes/unidademedida.class.php');
   
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();

   $Propriedade = new Propriedade();
   $Propriedade->conn = $conn;

   $Produtor = new Produtor();
   $Produtor->conn = $conn;

   $Tecnico = new Tecnico();
   $Tecnico->conn = $conn;

   $Avaliacao = new Avaliacao();
   $Avaliacao->conn = $conn;

   $UnidadeMedida = new UnidadeMedida();
   $UnidadeMedida->conn = $conn;
   
   $Usuario = new Usuario();
   $Usuario->conn = $conn;
   $Usuario->getUsuarioById($_SESSION['s_idusuario']);

   $VisitaSupervisor = new VisitaSupervisor();
   $VisitaSupervisor->conn = $conn;


   $funcao = new Funcao();
   $funcao->conn = $conn;
   $operacao = $_REQUEST['op'];
   
   $idvisitatecnica = $_REQUEST['cmboxvisitatecnica'];
   $idpropriedade = $_REQUEST['cmboxpropriedade'];
   $idavaliacao = $_REQUEST['cmboxavaliacao'];
   $idtecnico = $_REQUEST['cmboxtecnico'];
   if (in_array("TECNICO", $_SESSION['s_papel'])) 
   {
   	  $idtecnico2 = $Usuario->idtecnico;
	  if (!empty($idtecnico2))
	  {
	  	$idtecnico = $idtecnico2;
	  	$Tecnico->getTecnicoById($idtecnico);
	  	if (!empty($idtecnico))
	  	{
	  		$trocacombo = '<input type="hidden" id="cmboxtecnico" name="cmboxtecnico" value="'.$idtecnico.'">'.$Tecnico->nometecnico;
   	  	}
	  }
   }
   
 
	$idmunicipio = $_REQUEST['idmunicipio'];
	if (empty($operacao)){
	    header('Location: consvisitasupervisor.php?mensagem=Erro');
	}
	else
	{
	   if ($operacao=='A') 
	   {
    	  $id = $_REQUEST['id'];
		  if (($id == '0') || (empty($id)))
		  {
		      header('Location: consvisitasupervisor.php?mensagem=Selecione a visita que deseja alterar');
		  } 
		  else
		  {
		  		$VisitaSupervisor->getVisitaById($id);
				$idvisitasupervisor = $VisitaSupervisor->idvisitasupervisor;
				$idpropriedade = $VisitaSupervisor->idpropriedade;
				$idsupervisor = $VisitaSupervisor->idsupervisor;
			    $datavisita = $VisitaSupervisor->datavisita;
			    $producaodia = $VisitaSupervisor->producaodia;
			    $numvacaslactacao = $VisitaSupervisor->numvacaslactacao;
			    $numvacassecas = $VisitaSupervisor->numvacassecas;
			    $dataproximavisita = $VisitaSupervisor->dataproximavisita;
			    $relatorio = $VisitaSupervisor->relatorio;
			    $areaprojeto = $VisitaSupervisor->areaprojeto;
				$idunidademedida = $VisitaSupervisor->idunidademedida;
				$dataentradaprojeto= $VisitaSupervisor->dataentradaprojeto;
				$producaoinicial= $VisitaSupervisor->producaoinicial;
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
		dojo.require("dijit.form.TimeTextBox");
		

	function validaForm()
	{
	   r = true;
	   m = '';
	   if ((document.getElementById('cmboxpropriedade').value == '') ||
	   (document.getElementById('cmboxusuario').value == '') || 
	   (document.getElementById('edtrelatorio').value == '') || 
	   (document.getElementById('edtdatavisita').value == '') 
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
    	   document.getElementById('formulario').action="exec.visitasupervisor.php";
  		   document.getElementById('formulario').submit();
	   }

	}


	function voltar()
	{
    	location.href='consvisitasupervisor.php?tipo=S';
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
					var button = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        id: "toolbar1.SaveContinue2",
						label: 'Salvar',
                        showLabel: true,
						disabled: <?php if (in_array("ADMINISTRADOR", $_SESSION['s_papel']))
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
                    toolbar.addChild(button);				
				
				
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
    de Visita Supervisor</strong></font> </div>
	
	<form action="cadvisitasupervisor.php" method="POST" name="formulario" id="formulario">
  	  
    <table class="tab_cadrehov">
      <tr class="tab_bg_2"> 
        <th colspan="2">Cadastro de Visita Supervisor</th>
      </tr>
      <?php if ($operacao=='A'){?>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">ID:</td>
        <td width="315"><input name="edtidvisitasupervisor" type="text" id="edtidvisitasupervisor" readonly="true" value="<?php echo $idvisitasupervisor;?>"> 
        </td>
      </tr>
      <?php } ?>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Propriedade:</td>
        <td width="315"> 
          <?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,'','S','');?>
          <input name="fechar" type="hidden" id="fechar" value="s"> <input name="op" type="hidden" id="operacao" value="<?php echo $operacao;?>"> 
          <input name="codigo" type="hidden" id="codigo" value="<?php echo $id;?>"> 
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Supervisor</td>
        <td width="315"> 
          <?php 
		  	if ($operacao=='A')
			{
		  		echo $Usuario->listaCombo('cmboxusuario',$idsupervisor,'N');
			}
			else
			{
		  		echo $Usuario->listaCombo('cmboxusuario',$_SESSION['s_idusuario'],'N');
			 
			}
			?>
        </td>
      </tr>
      <tr class="tab_bg_1">
        <td valign="top">Produção Inicial</td>
        <td><strong><?php echo $producaoinicial;?></strong></td>
      </tr>
      <tr class="tab_bg_1">
        <td valign="top">Data entrada no projeto</td>
        <td><strong><?php echo $dataentradaprojeto;?></strong></td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Data Visita</td>
        <td width="315"><input name="edtdatavisita" type="text" id="edtdatavisita" value="<?php echo $datavisita;?>" dojoType="dijit.form.DateTextBox"> 
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Produ&ccedil;&atilde;o dia</td>
        <td width="315"><input name="edtproducaodia" type="text" id="edtproducaodia" value="<?php echo $producaodia;?>" size="5">
          litros</td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Vacas em Lacta&ccedil;&atilde;o</td>
        <td width="315"><input name="edtnumvacaslactacao" type="text" id="edtnumvacaslactacao"  value="<?php echo $numvacaslactacao;?>" size="5"> 
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Vacas secas</td>
        <td width="315"><input name="edtnumvacassecas" type="text" id="edtnumvacassecas"  value="<?php echo $numvacassecas;?>" size="5"> 
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Relat&oacute;rio</td>
        <td width="315"><textarea name="edtrelatorio" cols="60" rows="5" id="edtrelatorio"  style="width:400px;height:100px"><?php echo $relatorio;?></textarea> 
        </td>
      </tr>
    </table>
        </form>
</center>
</div>
    </body>

</html>