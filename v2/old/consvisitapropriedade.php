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
   $mesinicial = $_REQUEST['cmboxmesinicial'];
   $mesfinal = $_REQUEST['cmboxmesfinal'];
   $anoinicial = $_REQUEST['cmboxanoinicial'];
   $anofinal = $_REQUEST['cmboxanofinal'];
   $idtecnico = $_REQUEST['cmboxtecnico'];
   
   function pegaMes($mes)
   {
	  if ($mes==1) return "Jan";
	  if ($mes==2) return "Fev";
	  if ($mes==3) return "Mar";
	  if ($mes==4) return "Abr";
	  if ($mes==5) return "Mai";
	  if ($mes==6) return "Jun";
	  if ($mes==7) return "Jul";
	  if ($mes==8) return "Ago";
	  if ($mes==9) return "Set";
	  if ($mes==10) return "Out";
	  if ($mes==11) return "Nov";
	  if ($mes==12) return "Dez";
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
 		<form action="consvisitapropriedade.php" method="POST" name="formulario"  id="formulario">		
	<span id="toolbar"></span>
	    <div style="width: 100%; height: 370px">
 <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Número de Visitas por Propriedade</strong></font> </div>
	     <div style="width: 100%; height: 100%;">
        <input type="hidden" name="op" value="E">
		<input type="button" onClick="alert()">
		<table>

				<tr>
				   <td>Início:</td>
				   <td><select name="cmboxmesinicial" id="cmboxmesinicial">
				   		<option value="">Mês</option>
				   		<option value="1" <?php if ($mesinicial=='1') echo "SELECTED";?>>01</option>
				   		<option value="2" <?php if ($mesinicial=='2') echo "SELECTED";?>>02</option>
				   		<option value="3" <?php if ($mesinicial=='3') echo "SELECTED";?>>03</option>
				   		<option value="4" <?php if ($mesinicial=='4') echo "SELECTED";?>>04</option>
				   		<option value="5" <?php if ($mesinicial=='5') echo "SELECTED";?>>05</option>
				   		<option value="6" <?php if ($mesinicial=='6') echo "SELECTED";?>>06</option>
				   		<option value="7" <?php if ($mesinicial=='7') echo "SELECTED";?>>07</option>
				   		<option value="8" <?php if ($mesinicial=='8') echo "SELECTED";?>>08</option>
				   		<option value="9" <?php if ($mesinicial=='9') echo "SELECTED";?>>09</option>
				   		<option value="10" <?php if ($mesinicial=='10') echo "SELECTED";?>>10</option>
				   		<option value="11" <?php if ($mesinicial=='11') echo "SELECTED";?>>11</option>
				   		<option value="12" <?php if ($mesinicial=='12') echo "SELECTED";?>>12</option>
				   </select>/
				   <select name="cmboxanoinicial" id="cmboxanoinicial">
				   		<option value="">Ano</option>
				   		<option value="2015" <?php if ($anoinicial=='2015') echo "SELECTED";?>>2015</option>
				   		<option value="2014" <?php if ($anoinicial=='2014') echo "SELECTED";?>>2014</option>
				   		<option value="2013" <?php if ($anoinicial=='2013') echo "SELECTED";?>>2013</option>
				   		<option value="2012" <?php if ($anoinicial=='2012') echo "SELECTED";?>>2012</option>
				   		<option value="2011" <?php if ($anoinicial=='2011') echo "SELECTED";?>>2011</option>
				   		<option value="2010" <?php if ($anoinicial=='2010') echo "SELECTED";?>>2010</option>
					</select> 
				   </td>
				</tr>
				<tr>
				   <td>Término:</td>
				   <td><select name="cmboxmesfinal" id="cmboxmesfinal">
				   		<option value="">Mês</option>
				   		<option value="1" <?php if ($mesfinal=='1') echo "SELECTED";?>>01</option>
				   		<option value="2" <?php if ($mesfinal=='2') echo "SELECTED";?>>02</option>
				   		<option value="3" <?php if ($mesfinal=='3') echo "SELECTED";?>>03</option>
				   		<option value="4" <?php if ($mesfinal=='4') echo "SELECTED";?>>04</option>
				   		<option value="5" <?php if ($mesfinal=='5') echo "SELECTED";?>>05</option>
				   		<option value="6" <?php if ($mesfinal=='6') echo "SELECTED";?>>06</option>
				   		<option value="7" <?php if ($mesfinal=='7') echo "SELECTED";?>>07</option>
				   		<option value="8" <?php if ($mesfinal=='8') echo "SELECTED";?>>08</option>
				   		<option value="9" <?php if ($mesfinal=='9') echo "SELECTED";?>>09</option>
				   		<option value="10" <?php if ($mesfinal=='10') echo "SELECTED";?>>10</option>
				   		<option value="11" <?php if ($mesfinal=='11') echo "SELECTED";?>>11</option>
				   		<option value="12" <?php if ($mesfinal=='12') echo "SELECTED";?>>12</option>
				   </select>/
				   <select name="cmboxanofinal" id="cmboxanofinal">
				   		<option value="">Ano</option>
				   		<option value="2015" <?php if ($anofinal=='2015') echo "SELECTED";?>>2015</option>
				   		<option value="2014" <?php if ($anofinal=='2014') echo "SELECTED";?>>2014</option>
				   		<option value="2013" <?php if ($anofinal=='2013') echo "SELECTED";?>>2013</option>
				   		<option value="2012" <?php if ($anofinal=='2012') echo "SELECTED";?>>2012</option>
				   		<option value="2011" <?php if ($anofinal=='2011') echo "SELECTED";?>>2011</option>
				   		<option value="2010" <?php if ($anofinal=='2010') echo "SELECTED";?>>2010</option>
					</select>
					
				   </td>
				</tr>
				<tr>
				   <td>Técnico:</td>
				   <td><?php echo $Tecnico->listaCombo('cmboxtecnico',$idtecnico,'S');?></td>
				</tr>
				<tr>
				<td>					<div dojoType="dijit.form.ToggleButton" id="toolbar1.filtrar" 
							showLabel="true" onClick="enviarFormulario();">
							Enviar
						</div> 
</td>
</tr>


			   	</table>

				<?php 
				
if ((!empty($anoinicial)) && (!empty($anofinal)) && (!empty($mesinicial)) && (!empty($mesfinal)))
{				
				$sql = 'select * from propriedade, produtor, tecnico where 
propriedade.idprodutor = produtor.idprodutor and
propriedade.idtecnico = tecnico.idtecnico and
propriedade.idsituacaopropriedade = 1 ';

if (!empty($idtecnico))
{
	$sql.=' and propriedade.idtecnico = '.$idtecnico;
}

$sql.=' order by sem_acentos(upper(nomepropriedade))';

				$res = pg_exec($conn,$sql);
				
				if ($anofinal < $anoinicial)
				{
					echo "Período inválido";
				}
				else
				{
					echo "<table class='tab_cadrehov'>";
					echo "<tr class='tab_bg_2'><td class='tab_bg_1'>Propriedade (Produtor)<br>Técnico</td>'";
					if ($anofinal==$anoinicial)
					{
						for ($i = $mesinicial; $i <= $mesfinal; $i++) {
							echo "<td>".pegaMes($i).'/'.$anoinicial.'</td>';
						}
					}
					else
					{
						for ($i = $mesinicial; $i <= 12; $i++) {
							echo "<td>".pegaMes($i).'/'.$anoinicial.'</td>';
						}
						for ($i = 1; $i <= $mesfinal; $i++) {
							echo "<td>".pegaMes($i).'/'.$anofinal.'</td>';
						}
					}
					echo "<td><strong>Total</strong></td></tr>";
					
					while($row = pg_fetch_array($res))
					{
						$total = 0;
						echo "<tr class='tab_bg_2'><td ><strong>".$row['nomepropriedade'].'</strong> ('.$row['nomeprodutor'].')<br>Técnico: <i>'.$row['nometecnico'].'</i></td>';
						if ($anofinal==$anoinicial)
						{
							for ($i = $mesinicial; $i <= $mesfinal; $i++) {
								$sql_visita = 'select count(*) from visitatecnica 
											where mesreferencia = '.$i.' and anoreferencia = '.$anoinicial.' and
											idpropriedade = '.$row['idpropriedade'];
								$res_visita = pg_exec($conn,$sql_visita);
								$row_visita = pg_fetch_array($res_visita);
								$total = $total + $row_visita[0];
							//echo "<td>".pegaMes($i).'/'.$anoinicial.'</td>';
								echo "<td>".$row_visita[0].'</td>';
							}
						}
						else
						{
							for ($i = $mesinicial; $i <= 12; $i++) {
								$sql_visita = 'select count(*) from visitatecnica 
											where mesreferencia = '.$i.' and anoreferencia = '.$anoinicial.' and
											idpropriedade = '.$row['idpropriedade'];
								$res_visita = pg_exec($conn,$sql_visita);
								$row_visita = pg_fetch_array($res_visita);
								$total = $total + $row_visita[0];
								//echo "<td>".$i.'/'.$anoinicial.'</td>';
								echo "<td>".$row_visita[0].'</td>';
							}
							for ($i = 1; $i <= $mesfinal; $i++) {
								$sql_visita = 'select count(*) from visitatecnica 
											where mesreferencia = '.$i.' and anoreferencia = '.$anofinal.' and
											idpropriedade = '.$row['idpropriedade'];
								$res_visita = pg_exec($conn,$sql_visita);
								$row_visita = pg_fetch_array($res_visita);
								$total = $total + $row_visita[0];
								//echo "<td>".$i.'/'.$anofinal.'</td>';
								echo "<td>".$row_visita[0].'</td>';
							}
						}
						echo '<td><strong>'.$total.'</strong></td></tr>';
					}
					// total por mês
					$total = 0;
					echo "<tr class='tab_bg_2'><td><strong>Total Geral</strong></td>";
					if ($anofinal==$anoinicial)
					{
						for ($i = $mesinicial; $i <= $mesfinal; $i++) 
						{
							$sql_visita = 'select count(*) from visitatecnica, propriedade  
											where mesreferencia = '.$i.' and anoreferencia = '.$anoinicial.' and
											visitatecnica.idpropriedade = propriedade.idpropriedade and 
											propriedade.idsituacaopropriedade = 1 ';
							
							if (!empty($idtecnico))
							{
								$sql_visita.=' and propriedade.idtecnico = '.$idtecnico;
							}
							//echo $sql_visita;
							$res_visita = pg_exec($conn,$sql_visita);
							$row_visita = pg_fetch_array($res_visita);
							$total = $total + $row_visita[0];
							//echo "<td>".pegaMes($i).'/'.$anoinicial.'</td>';
							echo "<td>".$row_visita[0].'</td>';
						}
					}
					else
					{
						for ($i = $mesinicial; $i <= 12; $i++) 
						{
							$sql_visita = 'select count(*) from visitatecnica, propriedade  
											where mesreferencia = '.$i.' and anoreferencia = '.$anoinicial.' and
											visitatecnica.idpropriedade = propriedade.idpropriedade and 
											propriedade.idsituacaopropriedade = 1 ';
							if (!empty($idtecnico))
							{
								$sql_visita.=' and propriedade.idtecnico = '.$idtecnico;
							}
							
							$res_visita = pg_exec($conn,$sql_visita);
							$row_visita = pg_fetch_array($res_visita);
							$total = $total + $row_visita[0];
							//echo "<td>".$i.'/'.$anoinicial.'</td>';
							echo "<td>".$row_visita[0].'</td>';
						}
						for ($i = 1; $i <= $mesfinal; $i++) 
						{
							$sql_visita = 'select count(*) from visitatecnica, propriedade  
											where mesreferencia = '.$i.' and anoreferencia = '.$anofinal.' and
											visitatecnica.idpropriedade = propriedade.idpropriedade and 
											propriedade.idsituacaopropriedade = 1 ';
							if (!empty($idtecnico))
							{
								$sql_visita.=' and propriedade.idtecnico = '.$idtecnico;
							}
							
							$res_visita = pg_exec($conn,$sql_visita);
							$row_visita = pg_fetch_array($res_visita);
							$total = $total + $row_visita[0];
							//echo "<td>".$i.'/'.$anofinal.'</td>';
							echo "<td>".$row_visita[0].'</td>';
						}
					}
					echo '<td><strong>'.$total.'</strong></td></tr>';
					echo "</table>";
				}
}
				?>
				
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
			
		
                toolbar = new dijit.Toolbar({},"toolbar");
                //dojo.forEach(["Cut", "Copy", "Paste"], function(label) {
	

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