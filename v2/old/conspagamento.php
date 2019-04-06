<?php 
session_start();
include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/produtor.class.php');
   require_once('classes/propriedade.class.php');
   require_once('classes/tecnico.class.php');
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
		url: "montapaginacaopagamento.php?p="+pag+"&base="+base+"&o="+ordenacao+"&tf=<?php echo $_REQUEST['cmboxfiltro'];?>&vf=<?php echo $_REQUEST['edtfiltro'];?>",
		load: function(newContent) {
			dojo.byId("pagi").innerHTML = newContent;
		},
		error: function() {
		}
	});
}
</script>	
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="claro" onLoad="preparaEnvio();">
 <span id="toolbar">
          </span>
	    <div style="width: 100%; height: 370px">
 <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Consulta Pagamento</strong></font> </div>
	     <div style="width: 100%; height: 100%;">
			<form action="consvisitatecnica.php" method="POST" name="formulario"  id="formulario">		
        <input type="hidden" name="op" value="E">
		<table>
			   	<tr>
				   <td width="114">Produtor:</td>
				   <td width="471"><?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'S');?></td>
				</tr>
				<tr>
				   <td>Propriedade:</td>
				   <td><?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,$idprodutor,'S');?></td>
				</tr>
				<tr>
				   <td>Técnico:</td>
				   <td><?php echo $Tecnico->listaCombo('cmboxtecnico',$idtecnico,'S');?></td>
				</tr>
				<tr>
				   <td>Período:</td>
				   <td>
				   <input name="edtdatainicio" type="text" id="edtdatainicio" value="<?php echo $datainicio;?>" dojoType="dijit.form.DateTextBox"> a 
				   <input name="edtdatatermino" type="text" id="edtdatatermino" value="<?php echo $datatermino;?>" dojoType="dijit.form.DateTextBox"></td>
				 </tr>
				<tr>
					<td>Ordenar por:</td>
					<td><select name="cmboxordenacao" id="cmboxordenacao" onChange="enviarFormulario();">
						 <option value="PRODUTOR" <?php if ($_REQUEST['cmboxordenacao']=='PRODUTOR'){ echo "SELECTED"; } ?>>Produtor</option>
						 <option value="PROPRIEDADE" <?php if ($_REQUEST['cmboxordenacao']=='PROPRIEDADE'){ echo "SELECTED"; } ?>>Propriedade</option>
						 <option value="TECNICO" <?php if ($_REQUEST['cmboxordenacao']=='TECNICO'){ echo "SELECTED"; } ?>>Técnico</option>
						 <option value="DATA" <?php if ($_REQUEST['cmboxordenacao']=='DATA'){ echo "SELECTED"; } ?>>Data</option>
						 </select>				    <div dojoType="dijit.form.ToggleButton" id="toolbar1.filtrar" iconClass="dijitEditorIcon dijitEditorIconIndent"
							showLabel="true" onClick="enviarFormulario();">
							Filtrar
						</div>
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
		dojo.require("dijit.form.DateTextBox");
    });

	function checkdata() {
		with(document.formulario) {
			if(id_usuario.checked == false) {
				alert("Nenhum visita t&eacute;cnica selecionada!");
				return false;
			}else{
				if (confirm('Deseja realmente excluir as visitas t&eacute;cnicas selecionads?')){
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
		location.href='cadvisitatecnica.php?op=I';
	}

    function excluir()
	{
		if (confirm('Deseja excluir as visitas t&eacute;cnicas selecionadas'))
		{
		var chks = document.getElementsByName('id_visitatecnica[]');
		var hasChecked = false;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				hasChecked = true;
				break;
			}
		
		}
		if (!hasChecked)
		{
		   alert('Selecione uma visita t&eacute;cnica');
		   return false;	
		}
		else
		{
			document.getElementById('formulario').action='exec.visitatecnica.php';
			document.getElementById('formulario').submit();
		}
		}
			
	}
    function imprimirFormulario()
	{
		var chks = document.getElementsByName('id_visitatecnica[]');
		var hasChecked = false;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				hasChecked = true;
				break;
			}
		
		}
		if (!hasChecked)
		{
		   alert('Selecione uma visita t&eacute;cnica');
		   return false;	
		}
		else
		{
			document.getElementById('formulario').action='exec.relvisitatecnicatecnico.php';
			document.getElementById('formulario').submit();
		}
	}
	
	function imprimir()
	{
		tf = document.getElementById('cmboxfiltro').value;
		vf = document.getElementById('edtfiltro').value;
		o = document.getElementById('cmboxordenacao').value;

		location.href='relvisitatecnica.php?tf='+tf+'&vf='+vf+'&o='+o;
	}

	
	function gerarExcel()
	{
		location.href='relvisitatecnicaExcel.php';
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

					var button2 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Imprimir Formulário',
                        showLabel: true,
						onClick: function()
						{
							imprimirFormulario()
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