<?php 
session_start();
//include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/produtor.class.php');
   require_once('classes/propriedade.class.php');
   require_once('classes/tecnico.class.php');
   require_once('classes/usuario.class.php');
   require_once('classes/configuracao.class.php');
   require_once('classes/programa.class.php');
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
   $Usuario = new Usuario();
   $Usuario->conn = $conn;
   $Programa = new Programa();
   $Programa->conn = $conn;
   $Configuracao = new Configuracao();
   $Configuracao->conn = $conn;
   $Configuracao->getConfiguracao();

   $Usuario->getById($_SESSION['s_idusuario']);
   $idprograma = $_REQUEST['cmboxprograma'];
   $idprodutor = $_REQUEST['cmboxprodutor'];
   $pagto = $_REQUEST['chkboxpagto'];
   $ativa = $_REQUEST['chkboxativa'];
   
   if (isset($_REQUEST['ativa']))
   {
   	$ativa = 'S';
   }
   if (isset($_REQUEST['pagto']))
   {
   	$pagto = 'S';
   }
   
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
   $datainicio = $_REQUEST['edtdatainicio'];
   $datatermino = $_REQUEST['edtdatatermino'];
   
   $mes = $_REQUEST['cmboxmes'];
   $ano = $_REQUEST['cmboxano'];
   if (empty($ano))
   {
   	$ano = $Configuracao->anoreferencia;
   }
   
   // INCLUSÃO EM 8/12
   
   $tipo = $_REQUEST['tipo'];
   if ($tipo=='4')
   {
	   $titulo = 'Técnico x Propriedade x Produtor x Visita Técnica';
   }
   if ($tipo=='3')
   {
	   $titulo = 'Propriedde x Produtor x Técnico';
   }
   if ($tipo=='2')
   {
	   $titulo = 'Produtor x Propriedade x Técnico';
   }
   if ($tipo=='2')
   {
	   $titulo = 'Técnico x Produtor x Propriedade';
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="claro" >
 		<form action="consfinanceiro.php" method="POST" name="formulario"  id="formulario">		
	<span id="toolbar"></span>
	
	
	
	    <div style="width: 100%; height: 370px">
 <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $titulo;?></strong></font> </div>
	     <div style="width: 100%; height: 100%;">
        <input type="hidden" name="op" value="E">
		<table>
		        <tr>
				   <td width="114">Programa:</td>
				   <td width="471"><?php echo $Programa->listaCombo('cmboxprograma',$idprograma,'N');?></td>
				</tr>

				<tr>
				   <td>Período:</td>
				   <td>
				   <input name="edtdatainicio" type="text" id="edtdatainicio" value="<?php echo $datainicio;?>" dojoType="dijit.form.DateTextBox" > a 
				   <input name="edtdatatermino" type="text" id="edtdatatermino" value="<?php echo $datatermino;?>" dojoType="dijit.form.DateTextBox"></td>
				 </tr>
				<tr>
					<td colspan="2"><br>
					
						<div dojoType="dijit.form.ToggleButton" id="toolbar1.filtrar" iconClass="dijitEditorIcon dijitEditorIconPrint"
							showLabel="true" onClick="enviarFormulario(<?php echo $tipo;?>,'PDF');">
							Imprimir (.pdf)
						</div><br>
						<div dojoType="dijit.form.ToggleButton" id="toolbar1.filtrar2" iconClass="dijitEditorIcon dijitEditorIconPrint"
							showLabel="true" onClick="enviarFormulario(<?php echo $tipo;?>,'XLS');">
							Gerar (.xls)
						</div>
					</td>
				</tr>
			   	</table>
    		</div>
		</div>
        </form>		
    </body>
    <script type="text/javascript">

    dojo.addOnLoad(function() {
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
		dojo.require("dijit.TitlePane");
		dojo.require("dijit.form.DateTextBox");
		dojo.require("dijit.form.DropDownButton");
		dojo.require("dijit.TooltipDialog");
		dojo.require("dijit.form.TextBox");
    });


	dojo.ready(function(){
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


	function relPagamentosNoPeriodo()
	{
		idprograma = document.getElementById('cmboxprograma').value;
		idtecnico = document.getElementById('cmboxtecnico').value;
		datainicio = document.getElementById('edtdatainicio').value;
		datatermino = document.getElementById('edtdatatermino').value;
		ordenadopor = document.getElementById('cmboxordenacao').value;
		mesreferencia = document.getElementById('cmboxmes').value;
		anoreferencia = document.getElementById('cmboxano').value;
		if (datainicio=='')
		{
			alert('Informe o período');
		}
		else
		{
			location.href='relpagamentosnoperiodo.php?idprograma='+idprograma+'&anoreferencia='+anoreferencia+'&mesreferencia='+mesreferencia+'&ordenadopor='+ordenadopor+'&idtecnico='+idtecnico+'&datainicio='+datainicio+'&datatermino='+datatermino;
		}
	}
	
	function enviarFormulario(tipo,formato)
	{
		datainicio = document.getElementById('edtdatainicio').value;
		datatermino = document.getElementById('edtdatatermino').value;
		idprograma = document.getElementById('cmboxprograma').value;
		if (datainicio=='')
		{
			alert('Informe o período');
		}
		else
		{
			if ((tipo==4) && (formato=='PDF'))
			{
				location.href='relgeral.php?tipo=4&idprograma='+idprograma+'&datainicio='+datainicio+'&datatermino='+datatermino;
			}
			if ((tipo==4) && (formato=='XLS'))
			{
				location.href='rel4Excel.php?idprograma='+idprograma+'&datainicio='+datainicio+'&datatermino='+datatermino;
			}
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
			
				var dialog = new dijit.TooltipDialog({
					content:
						'<table><tr><td><label for="name">Data Pagamento:</label></td><td><input data-dojo-type="dijit.form.DateTextBox" id="edtdatapagamento" name="edtdatapagamento"></td></tr>' +
						'<tr><td><label for="hobby">Valor:</label></td><td><input data-dojo-type="dijit.form.TextBox" id="edtvalorpago" name="edtvalorpago"></td></tr>' +
						'<tr><td colspan=2><button onClick="lancarPagamento();">Salvar</button><td><tr>'
				});
				var dialogEstornarPagamento = new dijit.TooltipDialog({
					content:
						'<table><tr><td><label for="name">Motivo:</label></td><td><input data-dojo-type="dijit.form.TextBox" id="edtmotivo" name="edtmotivo"></td></tr>' +
						'<tr><td colspan=2><button onClick="estornarPagamento();">Salvar</button><td><tr>'
				});
			
                toolbar = new dijit.Toolbar({},"toolbar");
                //dojo.forEach(["Cut", "Copy", "Paste"], function(label) {
	
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