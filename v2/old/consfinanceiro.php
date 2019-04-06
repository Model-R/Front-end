<?php 
session_start();
include "paths.inc";
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

   $Usuario->getUsuarioById($_SESSION['s_idusuario']);
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
   	//$ano = $Configuracao->anoreferencia;
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
		url: "montapaginacaofinanceiro.php?pagto="+document.getElementById('chkboxpagto').checked+"&ativa="+document.getElementById('chkboxativa').checked+"&ano="+document.getElementById('cmboxano').value+"&mes="+document.getElementById('cmboxmes').value+"&idprograma="+document.getElementById('cmboxprograma').value+"&datainicio="+document.getElementById('edtdatainicio').value+"&datatermino="+document.getElementById('edtdatatermino').value+"&idtecnico="+document.getElementById('cmboxtecnico').value+"&idpropriedade="+document.getElementById('cmboxpropriedade').value+"&idprodutor="+document.getElementById('cmboxprodutor').value+"&p="+pag+"&base="+base+"&o="+ordenacao+"&tf=<?php echo $_REQUEST['cmboxfiltro'];?>&vf=<?php echo $_REQUEST['edtfiltro'];?>",
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
 		<form action="consfinanceiro.php" method="POST" name="formulario"  id="formulario">		
	<span id="toolbar"></span>
	    <div style="width: 100%; height: 370px">
 <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Financeiro</strong></font> </div>
	     <div style="width: 100%; height: 100%;">
        <input type="hidden" name="op" value="E">
		<input type="button" onClick="alert()">
		<table>
			   	<tr>
				   <td width="114">Programa:</td>
				   <td width="471"><?php echo $Programa->listaCombo('cmboxprograma',$idprograma,'S');?></td>
				</tr>
			   	<tr>
				   <td width="114">Produtor:</td>
				   <td width="471"><?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'S');?></td>
				</tr>
				<tr>
				   <td>Propriedade:</td>
				   
          <td>
            <?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,$idprodutor,'S');?>
            ativas 
            <input name="chkboxativa" id="chkboxativa" type="checkbox" value="S" <?php if ($ativa=='S') echo "checked";?>></td>
				</tr>
				<tr>
				   <td>Técnico:</td>
				   <td><?php echo $Tecnico->listaCombo('cmboxtecnico',$idtecnico,'S');?></td>
				</tr>
				<tr>
				   <td>Referência:</td>
				   <td><select name="cmboxmes" id="cmboxmes">
				   		<option value="">Mês</option>
				   		<option value="1" <?php if ($mes=='1') echo "SELECTED";?>>01</option>
				   		<option value="2" <?php if ($mes=='2') echo "SELECTED";?>>02</option>
				   		<option value="3" <?php if ($mes=='3') echo "SELECTED";?>>03</option>
				   		<option value="4" <?php if ($mes=='4') echo "SELECTED";?>>04</option>
				   		<option value="5" <?php if ($mes=='5') echo "SELECTED";?>>05</option>
				   		<option value="6" <?php if ($mes=='6') echo "SELECTED";?>>06</option>
				   		<option value="7" <?php if ($mes=='7') echo "SELECTED";?>>07</option>
				   		<option value="8" <?php if ($mes=='8') echo "SELECTED";?>>08</option>
				   		<option value="9" <?php if ($mes=='9') echo "SELECTED";?>>09</option>
				   		<option value="10" <?php if ($mes=='10') echo "SELECTED";?>>10</option>
				   		<option value="11" <?php if ($mes=='11') echo "SELECTED";?>>11</option>
				   		<option value="12" <?php if ($mes=='12') echo "SELECTED";?>>12</option>
				   </select>/
				   <select name="cmboxano" id="cmboxano">
				   		<option value="">Ano</option>
				   		<option value="2010" <?php if ($ano=='2010') echo "SELECTED";?>>2010</option>
				   		<option value="2011" <?php if ($ano=='2011') echo "SELECTED";?>>2011</option>
				   		<option value="2012" <?php if ($ano=='2012') echo "SELECTED";?>>2012</option>
				   		<option value="2013" <?php if ($ano=='2013') echo "SELECTED";?>>2013</option>
				   		<option value="2014" <?php if ($ano=='2014') echo "SELECTED";?>>2014</option>
				   		<option value="2015" <?php if ($ano=='2015') echo "SELECTED";?>>2015</option>
					</select> Pagto NÃO realizado <input name="chkboxpagto" id="chkboxpagto" type="checkbox" value="S" <?php if ($pagto=='S') echo "checked";?>>
				   </td>
				</tr>
				<tr>
				   <td>Período:</td>
				   <td>
				   <input name="edtdatainicio" type="text" id="edtdatainicio" value="<?php echo $datainicio;?>" dojoType="dijit.form.DateTextBox" > a 
				   <input name="edtdatatermino" type="text" id="edtdatatermino" value="<?php echo $datatermino;?>" dojoType="dijit.form.DateTextBox"></td>
				 </tr>
				<tr>
					<td>Ordenar por:</td>
					<td><select name="cmboxordenacao" id="cmboxordenacao" onChange="enviarFormulario();">
						 <option value="DATA" <?php if ($_REQUEST['cmboxordenacao']=='DATA'){ echo "SELECTED"; } ?>>Data</option>
						 <option value="PROPRIEDADE" <?php if ($_REQUEST['cmboxordenacao']=='PROPRIEDADE'){ echo "SELECTED"; } ?>>Propriedade</option>
						 <option value="TECNICO" <?php if ($_REQUEST['cmboxordenacao']=='TECNICO'){ echo "SELECTED"; } ?>>Técnico</option>
						 
						 </select>				    <div dojoType="dijit.form.ToggleButton" id="toolbar1.filtrar" iconClass="dijitEditorIcon dijitEditorIconIndent"
							showLabel="true" onClick="enviarFormulario();">
							Filtrar
						</div>
					</td>
				</tr>
			   	</table>
				<div id="pagi" align="center"></div>				
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

	function lancarPagamento()
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
			document.getElementById('formulario').action='exec.lancarpagamento.php?datapagamento='+document.getElementById('edtdatapagamento').value+'&valorpago='+document.getElementById('edtvalorpago').value;
			document.getElementById('formulario').submit();
		}

	}


	function estornarPagamento()
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
			document.getElementById('formulario').action='exec.estornarpagamento.php?motivo='+document.getElementById('edtmotivo').value;
			document.getElementById('formulario').submit();
		}

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
	function relPagamentosNoPeriodoXls()
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
			location.href='relpagamentosnoperiodoxls.php?idprograma='+idprograma+'&anoreferencia='+anoreferencia+'&mesreferencia='+mesreferencia+'&ordenadopor='+ordenadopor+'&idtecnico='+idtecnico+'&datainicio='+datainicio+'&datatermino='+datatermino;
		}
	}
	
	function relPagamentosTecnico()
	{
		location.href='relpagamentotecnico.php';
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
	
					var buttonPagto = new dijit.form.DropDownButton({
						label: "Lançar Pagamentos",
						dropDown: dialog,
						disabled: <?php if ((in_array("OPERADOR FINANCEIRO", $_SESSION['s_papel'])))
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,

                        iconClass: "dijitEditorIcon dijitEditorIconNewPage"
					});
					dojo.byId("toolbar").appendChild(buttonPagto.domNode);

					var buttonEstorno = new dijit.form.DropDownButton({
						label: "Estornar Pagamento",
						disabled: <?php if ((in_array("OPERADOR FINANCEIRO", $_SESSION['s_papel'])))
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,
						dropDown: dialogEstornarPagamento,
                        iconClass: "dijitEditorIcon dijitEditorIconDelete"
					});
					dojo.byId("toolbar").appendChild(buttonEstorno.domNode);


                var menux = new dijit.Menu({
                    style: "display: none;"
                });

                var menuItem2 = new dijit.MenuItem({
                    label: "Pagamentos no período",
                    //iconClass: "dijitEditorIcon dijitEditorIconSave",
						disabled: <?php if (in_array("OPERADOR FINANCEIRO", $_SESSION['s_papel'])) 
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,
                    onClick: function() {
                        relPagamentosNoPeriodo();
                    }
                });
                menux.addChild(menuItem2);

                var menuItem2 = new dijit.MenuItem({
                    label: "Pagamentos no período (xls)",
                    //iconClass: "dijitEditorIcon dijitEditorIconSave",
						disabled: <?php if (in_array("OPERADOR FINANCEIRO", $_SESSION['s_papel'])) 
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,
                    onClick: function() {
                        relPagamentosNoPeriodoXls();
                    }
                });
                menux.addChild(menuItem2);

                var menuItem2 = new dijit.MenuItem({
                    label: "Pagamentos 06/13 a 05/14",
                    //iconClass: "dijitEditorIcon dijitEditorIconSave",
						disabled: <?php if (in_array("OPERADOR FINANCEIRO", $_SESSION['s_papel'])) 
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,
                    onClick: function() {
                        relPagamentosTecnico();
                    }
                });
                menux.addChild(menuItem2);





                var buttonx = new dijit.form.DropDownButton({
                    label: "Imprimir",
                    name: "programmatic2",
                    dropDown: menux,
                    id: "progButton",
    				iconClass: "dijitEditorIcon dijitEditorIconPrint"
                });
                toolbar.addChild(buttonx);



/*					var button2 = new dijit.form.Button({
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
 */	
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