<?php session_start();
   include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/propriedade.class.php');
   require_once('classes/produtor.class.php');
   require_once('classes/avaliacao.class.php');
   require_once('classes/tipocapital.class.php');
   require_once('classes/categoriatipocapital.class.php');
   require_once('classes/unidademedida.class.php');
   require_once('classes/unidade.class.php');
   require_once('classes/tipomovimento.class.php');
   require_once('classes/categoriatipomovimento.class.php');
   require_once('classes/movimento.class.php');

	function retornaValorMes($conn,$idavaliacao,$mes,$idtipomovimento)
	{
		$sql2 = 'select * from movimento where mes='.$mes.' and idavaliacao = '.$idavaliacao.' and idtipomovimento = '.$idtipomovimento;
		$res2 = @pg_exec($conn,$sql2);
		$row2 = @pg_fetch_array($res2);
		$valor = $row2['valor'];
		return $valor;
	}

   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();

   $Propriedade = new Propriedade();
   $Propriedade->conn = $conn;

   $Produtor = new Produtor();
   $Produtor->conn = $conn;

   $Avaliacao = new Avaliacao();
   $Avaliacao->conn = $conn;

   $Unidade = new Unidade();
   $Unidade->conn = $conn;

   $TipoMovimento = new TipoMovimento();
   $TipoMovimento->conn = $conn;

   $CategoriaTipoMovimento = new CategoriaTipoMovimento();
   $CategoriaTipoMovimento->conn = $conn;

   $Movimento = new Movimento();
   $Movimento->conn = $conn;

   $funcao = new Funcao();
   $funcao->conn = $conn;
   $operacao = $_REQUEST['op'];
   
   $taxajuros = 6;
   $idprodutor = $_REQUEST['cmboxprodutor'];
   $idpropriedade = $_REQUEST['cmboxpropriedade'];
   if (!empty($_REQUEST[id]))
   {
   		$_REQUEST['cmboxavaliacao'] = $id;
   }
   $idavaliacao = $_REQUEST['cmboxavaliacao'];
   $idcategoriatipomovimento = $_REQUEST['cmboxcategoriatipomovimento'];
   $idtipomovimento = $_REQUEST['cmboxtipomovimento'];
   
   $Avaliacao->getById($idavaliacao);
   $ano = $Avaliacao->anoreferencia;

   $TipoMovimento->getById($idtipomovimento);

   $Unidade->getById($TipoMovimento->idunidade);

   $ano = $Avaliacao->anoreferencia;
   $unidade = $Unidade->unidade;

	if (empty($idavaliacao))
	{
		$idavalicao = 0;
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
	<script type="text/javascript" src="verificaajax.js"></script>
    <script type="text/javascript">
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
		dojo.require("dijit.TitlePane");
	  dojo.require("dijit.form.DateTextBox");
	  dojo.require("dijit.layout.TabContainer");
	dojo.require("dijit.layout.ContentPane");
		dojo.require("dijit.layout.AccordionContainer");

function carregaAnosAnteiores(idavaliacao,idtipomovimento,anoanterior)
{
	dojo.byId("div_anosanteriores").innerHTML = '<img src="imagens/loading.gif"/>';
	dojo.xhrGet({
//		url: "pegamovimentoanosanteriores.php?idavaliacao="+idavaliacao+"&idcategoriatipomovimento="+idcategoriatipomovimento+"&idtipomovimento="+idtipomovimento+"&anoanterior="+anoanterior,
		url: "pegamovimentoanosanteriores.php?idavaliacao="+idavaliacao+"&idtipomovimento="+idtipomovimento+"&anoanterior="+anoanterior,
		load: function(newContent) {
			dojo.byId("div_anosanteriores").innerHTML = newContent;
		},
		error: function() {
			alert('erro');
		}
	});
}


		
	function alterarItem(id,valor)
	{
	  if (confirm('Realmente deseja alterar o item')){
    	location.href='exec.movimento.php?op=A&id='+id+'&valor='+valor;
      }
	}


	function validaForm()
	{
	   r = true;
	   m = '';
	   if (
	   (document.getElementById('cmboxavaliacao').value == '') ||
	   (document.getElementById('cmboxtipomovimento').value == '')  
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
			document.getElementById('formulario').action="exec.movimento.php";
   			document.getElementById('formulario').submit();
	   }
	}
	function voltar()
	{
    	location.href='consavaliacao.php';
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
    Movimento</strong></font> </div>
	
	<form action="cadmovimento.php" method="POST" name="formulario" id="formulario">
  <input type="hidden" name="edtano" id="edtano" value="<?php echo $ano;?>">
    <table class="tab_cadrehov">
      <tr class="tab_bg_2"> 
        <th colspan="2">Cadastro Movimento</th>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Avaliação</td>
        <td width="315"><?php echo $Avaliacao->listaCombo('cmboxavaliacao',$idavaliacao,$idpropriedade,'N');?> 
        </td>
      </tr>
    </table>
		
    <table class="tab_cadrehov">
      <tr class="tab_bg_2"> 
        <th colspan="15">Tipo Capital: 
          <?php echo $tipocapital;?>
        </th>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="15%" rowspan="2" valign="center"><?php echo $CategoriaTipoMovimento->listaCombo('cmboxcategoriatipomovimento',$idcategoriatipomovimento,'S');?><br>
          <?php echo $TipoMovimento->listaCombo('cmboxtipomovimento',$idtipomovimento,$idcategoriatipomovimento,'S');?></td>
        <td width="3%" height="16" valign="center">Unid.</td>
        <td width="5%">Jan/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Fev/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Mar/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Abr/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Mai/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Jun/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Jul/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Ago/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Set/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Out/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Nov/ 
          <?php echo $ano;?>
        </td>
        <td width="5%">Dez/ 
          <?php echo $ano;?>
        </td>
        <td width="3%">&nbsp; 
          
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="306" valign="center"> 
          <?php echo $unidade;?>
        </td>
        <td width=""><input name="edtjan" type="text" id="edtjan" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'1',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtfev" type="text" id="edtfev" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'2',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtmar" type="text" id="edtmar" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'3',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtabr" type="text" id="edtabr" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'4',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtmai" type="text" id="edtmai" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'5',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtjun" type="text" id="edtjun" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'6',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtjul" type="text" id="edtjul" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'7',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtago" type="text" id="edtago" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'8',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtset" type="text" id="edtset" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'9',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtout" type="text" id="edtout" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'10',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtnov" type="text" id="edtnov" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'11',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><input name="edtdez" type="text" id="edtdez" size="6" value="<?php echo number_format(retornaValorMes($conn,$idavaliacao,'12',$idtipomovimento),2,',','');?>" onkeypress='return SomenteNumeroDecimais(event)'></td>
        <td width=""><div dojoType="dijit.form.ToggleButton" id="toolbar1.Salvar" iconClass="dijitEditorIcon dijitEditorIconSave"
							showLabel="false" onClick="salvar();"> Salvar </div></td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="306" valign="center"> 
          Anos anteriores: <?php echo $Avaliacao->listaAnosAnteriores($idavaliacao,$idcategoriatipomovimento,$idtipomovimento);?>
        </td>
		<td ></td>
		<td colspan="13"><div id="div_anosanteriores"></div></td>
      </tr>

    </table>


    <br/>
        </form>
<center>
<div style="width: 95%; height: 450px" >
  <div data-dojo-type="dijit.layout.AccordionContainer" style="height: 400px;">
<?php $sqltipo = 'select * from categoriatipomovimento';
		$restipo = pg_exec($conn,$sqltipo);
		while ($rowtipo = pg_fetch_array($restipo))
		{?>
    <div data-dojo-type="dijit.layout.ContentPane" data-dojo-props="title:'<?php echo $rowtipo['categoriatipomovimento'];?>'<?php if ($rowtipo['idcategoriatipomovimento']==$idcategoriatipomovimento){ echo ",selected: true";}?>">
<div dojoType="dijit.layout.ContentPane" >
  <table class="tab_cadrehov" style="width: 100%;">
    <tr class="tab_bg_2"> 
      <th width="15%"><strong></strong></th>
      <th width="3%"><strong>Unid.</strong></th>
      <th width="5%"><strong>Jan/<?php echo $ano;?></strong></th>
      <th width="5%"> <strong>Fev/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Mar/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Abr/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Mai/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Jun/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Jul/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Ago/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Set/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Out/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Nov/<?php echo $ano;?></strong></th>
      <th width="5%"><strong>Dez/<?php echo $ano;?></strong></th>
    </tr>

    <?php $sql = 'select * from tipomovimento tm,unidade u where tm.idunidade = u.idunidade and tm.idcategoriatipomovimento = '.$rowtipo['idcategoriatipomovimento'];
		$res = pg_exec($conn,$sql);
		while ($row = pg_fetch_array($res))
		{
?>
    <tr class="tab_bg_1">
      <td > 
        <a href="cadmovimento.php?cmboxavaliacao=<?php echo $idavaliacao;?>&cmboxtipomovimento=<?php echo $row['idtipomovimento'];?>&cmboxcategoriatipomovimento=<?php echo $row['idcategoriatipomovimento'];?>"><?php echo $row['tipomovimento'];?></a>
      </td>
      <td > 
        <?php echo $row['unidade'];?>
      </td>
	  <?php for ($c=1;$c<=12;$c++){?>
      <td align="right"> 
      <?php //$sql2 = 'select * from movimento where mes='.$c.' and idavaliacao = '.$idavaliacao.' and idtipomovimento = '.$row['idtipomovimento'];
		//$res2 = @pg_exec($conn,$sql2);
		//$row2 = @pg_fetch_array($res2);
		//$valor = $row2['valor'];
		//echo number_format($valor,2,',','.');
		echo number_format(retornaValorMes($conn,$idavaliacao,$c,$row['idtipomovimento']),2,',','.');
		?>
		
      </td>
		<?php } // for ?>
    </tr>
    <?php } // while ?>
  </table>
  </div>
    </div>
<?php } // while ?>
</div>
</div>
</center>
	</center>
</div>
    </body>

</html>

<!--		<input name="edt<?php echo $row['idtipomovimento'].$c;?>" type="text" id="edt<?php echo $row['idtipomovimento'].$c;?>" size="4" value="<?php echo $valor;?>" onkeypress='return SomenteNumeroDecimais(event)' onBlur="alterarItem(<?php echo $row2['idmovimento'];?>,this.value);">
-->