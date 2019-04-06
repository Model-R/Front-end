<?php 
session_start();
include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/produtor.class.php');
   require_once('classes/propriedade.class.php');
   require_once('classes/avaliacao.class.php');
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
   $Avaliacao = new Avaliacao();
   $Avaliacao->conn = $conn;

   $Programa = new Programa();
   $Programa->conn = $conn;

   $Configuracao = new Configuracao();
   $Configuracao->conn = $conn;
   $Configuracao->getConfiguracao();

   $Usuario = new Usuario();
   $Usuario->conn = $conn;

// tratamento para gardar os valores na tela

   

   $anoreferencia = $Configuracao->anoreferencia;
   $idavaliacao = $_REQUEST['cmboxavaliacao'];
   
   $idprograma = $_REQUEST['cmboxprograma'];
   $idprodutor = $_REQUEST['cmboxprodutor'];
   if (empty($idprodutor))
   {
   	$idprodutor = 0;
	if (isset($_SESSION['f_idprodutor']))
	{
		$idprodutor = $_SESSION['f_idprodutor'];
	}
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
//   echo $idtecnico;

   $datainicio = $_REQUEST['edtdatainicio'];
   $datatermino = $_REQUEST['edtdatatermino'];

   
   if ($_REQUEST['tipo']=='S')
   {
		$idprodutor = $_SESSION['f_idprodutor'];   
		$idpropriedade = $_SESSION['f_idpropriedade'];   
		$idtecnico = $_SESSION['f_idtecnico'];   
   		$datainicio = $_SESSION['f_datainicio'];
   		$datatermino = $_SESSION['f_datatermino'];
   }
   $_SESSION['f_idprodutor']=$_REQUEST['cmboxprodutor'];
   $_SESSION['f_idpropriedade']=$_REQUEST['cmboxpropriedade'];
   $_SESSION['f_idtecnico']=$_REQUEST['cmboxtecnico'];
   $_SESSION['f_datainicio']=$_REQUEST['edtdatainicio'];
   $_SESSION['f_datatermino']=$_REQUEST['edtdatatermino'];



/*   if ($idprodutor == 0)
   {
   	  unset($_SESSION['s_idprodutor']);
   }
   else
   {
   		$_SESSION['f_idprodutor']=$idprodutor;
   }
   if ($idpropriedade == 0)
   {
   	  unset($_SESSION['s_idpropriedade']);
   }
   else
   {
*/ 
 //  	$_SESSION['f_idpropriedade']=$idpropriedade;
 /*  }
   if ($idtecnico == 0)
   {
   	  unset($_SESSION['s_idtecnico']);
   }
   else
   {
       $_SESSION['f_idtecnico']=$idtecnico;
   }
   if ($datainicio == '')
   {
   	  unset($_SESSION['s_datainicio']);
   }
   else
   {
   		$_SESSION['f_datainicio']=$datainicio;
   }
   if ($datatermino=='')
   {
   	  unset($_SESSION['s_datatermino']);
   }
   else
   {
   	$_SESSION['f_datatermino']=$datatermino;
   }


   
   if ( (empty($datainicio)) && (isset($_SESSION['f_datainicio'])))
   {
   	$datainicio = $_SESSION['f_datainicio'];
   }
   if ( (empty($datatermino)) && (isset($_SESSION['f_datatermino'])))
   {
   	$datatermino = $_SESSION['f_datatermino'];
   }
   if ( ($idprodutor==0) && (isset($_SESSION['f_idprodutor'])))
   {
   	$idprodutor = $_SESSION['f_idprodutor'];
   }
   */
   //if ( ($idpropriedade==0) || (isset($_SESSION['f_idpropriedade'])))
//   {
//   		$idpropriedade = $_SESSION['f_idpropriedade'];
 //  }
//   else
//   {
//   	   $idpropriedade = '';
//   }

//	$idprodutor = $_SESSION['f_idprodutor'];

 //  	$_SESSION['f_idpropriedade']=$_REQUEST['cmboxpropriedade'];
//	$idpropriedade = $_SESSION['f_idpropriedade'];
 /*
   if ( ($idtecnico==0) && (isset($_SESSION['f_idtecnico'])))
   {
   	$idtecnico = $_SESSION['f_idtecnico'];
   }
   
*/
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
		url: "montapaginacaovisitasupervisor.php?idprograma="+document.getElementById('cmboxprograma').value+"&datainicio="+document.getElementById('edtdatainicio').value+"&datatermino="+document.getElementById('edtdatatermino').value+"&idsupervisor="+document.getElementById('cmboxusuario').value+"&idpropriedade="+document.getElementById('cmboxpropriedade').value+"&idprodutor="+document.getElementById('cmboxprodutor').value+"&p="+pag+"&base="+base+"&o="+ordenacao+"&tf=<?php echo $_REQUEST['cmboxfiltro'];?>&vf=<?php echo $_REQUEST['edtfiltro'];?>",
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
 <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Visita T&eacute;cnica</strong></font> </div>
	     <div style="width: 100%; height: 100%;">
			<form action="consvisitasupervisor.php" method="POST" name="formulario"  id="formulario">		
        <input type="hidden" name="op" id="op" value="E">
		<table>
		        <tr>
				   <td width="114">Programa:</td>
				   <td width="471"><?php echo $Programa->listaCombo('cmboxprograma',$idprograma,'S');?></td>
				</tr>
		
			   	<tr>
				   <td width="114">Produtor: <?php echo $_SESSION['f_idprodutor'];?></td>
				   <td width="471"><?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'S',$_SESSION['s_idtecnico']);?></td>
				</tr>
				<tr>
				   <td>Propriedade:</td>
				   <td><?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,$idprodutor,'S',$_SESSION['s_idtecnico']);?></td>
				</tr>

				<tr>
				   <td>Supervisor:</td>
				   
				   <td><?php 
				   //$_SESSION['s_idusuario']
				   echo $Usuario->listaCombo('cmboxusuario',$_REQUEST['cmboxusuario'],'S');?></td>
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
				if (confirm('Deseja realmente excluir as visitas selecionads?')){
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
		location.href='cadvisitasupervisor.php?op=I&cmboxpropriedade='+document.getElementById('cmboxpropriedade').value;
	}

    function excluir()
	{
		if (confirm('Deseja excluir as visitas selecionadas'))
		{
		var chks = document.getElementsByName('id_visitasupervisor[]');
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
		   alert('Selecione uma visita técnica');
		   return false;	
		}
		else
		{
			document.getElementById('op').value='E';
			document.getElementById('formulario').action='exec.visitasupervisor.php';
			document.getElementById('formulario').submit();
		}
		}
			
	}
    function imprimirFormulario()
	{
		var chks = document.getElementsByName('id_visitasupervisor[]');
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
		   alert('Selecione uma visita técnica');
		   return false;	
		}
		else
		{
			document.getElementById('formulario').action='exec.relvisitasupervisor.php';
			document.getElementById('formulario').submit();
		}
	}
	
	function imprimir()
	{
		tf = document.getElementById('cmboxfiltro').value;
		vf = document.getElementById('edtfiltro').value;
		o = document.getElementById('cmboxordenacao').value;

		location.href='relvisitasupervisor.php?tf='+tf+'&vf='+vf+'&o='+o;
	}

	
	function gerarExcel()
	{
		location.href='relvisitasupervisorExcel.php';
	}

	function relProdutividade()
	{
		location.href='relprodutividade.php?datafim='+document.getElementById('edtdatatermino').value+'&datainicio='+document.getElementById('edtdatainicio').value+'&idtecnico='+document.getElementById('cmboxtecnico').value+'&idprodutor='+document.getElementById('cmboxprodutor').value+'&idpropriedade='+document.getElementById('cmboxpropriedade').value;
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
						disabled: <?php if ((in_array("ADMINISTRADOR", $_SESSION['s_papel'])) )
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,
						onClick: function()
						{
							novo();
						},
                        iconClass: "dijitEditorIcon dijitEditorIconNewPage"
                    });
                    toolbar.addChild(button);


					var buttonExc = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Excluir',
                        showLabel: false,
						disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])))
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,						
						onClick: function()
						{
							excluir();
						},
                        iconClass: "dijitEditorIcon dijitEditorIconDelete"
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