<?php session_start();
   include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/propriedade.class.php');
   require_once('classes/produtor.class.php');
   require_once('classes/avaliacao.class.php');
   require_once('classes/sexo.class.php');
   require_once('classes/animal.class.php');
   require_once('classes/tipoanimal.class.php');
   require_once('classes/porteanimal.class.php');

   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();

   $Propriedade = new Propriedade();
   $Propriedade->conn = $conn;

   $Produtor = new Produtor();
   $Produtor->conn = $conn;

   $Avaliacao = new Avaliacao();
   $Avaliacao->conn = $conn;

   $Animal = new Animal();
   $Animal->conn = $conn;

   $TipoAnimal = new TipoAnimal();
   $TipoAnimal->conn = $conn;

   $PorteAnimal = new PorteAnimal();
   $PorteAnimal->conn = $conn;

   $Sexo = new Sexo();
   $Sexo->conn = $conn;

   $funcao = new Funcao();
   $funcao->conn = $conn;
   $operacao = $_REQUEST['op'];
   $idavaliacao = $_REQUEST['idavaliacao'];
   if (empty($operacao)){
	    header('Location: consanimal.php?mensagem=Erro');
	}
	else
	{
	   if ($operacao=='A') 
	   {
    	  $id = $_REQUEST['id'];
		  if (($id == '0') || (empty($id)))
		  {
		      header('Location: consavaliacao.php?mensagem=Selecione a avaliação que deseja alterar');
		  } 
		  else
		  {
		  		$Animal->getById($id);
				$idanimal = $Animal->idanimal;
				$nome = $Animal->nome;
			    $idavaliacao = $Animal->idavaliacao;
			    $idtipoanimal = $Animal->idtipoanimal;
				$datanascimento = $Animal->datanascimento;
				$nomemae = $Animal->nomemae;
				$nomepai = $Animal->nomepai;
				$idporteanimal = $Animal->idporteanimal;
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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Meses', 'Peso'],
          ['1',  5],
          ['2',  6],
          ['3',  9],
          ['4',  10]
        ]);

        var data2 = google.visualization.arrayToDataTable([
          ['Data Controle', 'Litros'],
          ['1',  5],
          ['2',  6],
          ['3',  9],
          ['4',  10]
        ]);

        var options = {
          title: 'Idade (meses)'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        var options = {
          title: 'Produção de Leite (litros)'
        };

        var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div'));
        chart2.draw(data2, options);


      }
    </script>
	
    <script type="text/javascript">
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
		dojo.require("dijit.TitlePane");
	  	dojo.require("dijit.form.DateTextBox");
	  	dojo.require("dijit.layout.AccordionContainer");
		dojo.require("dijit.layout.ContentPane");


var s2 = "<table width='100%'><tr><td width='40%' align='left'><b>Data cobertura</b></td><td width='60%' align='left'><b>Reprodutor</b></td></tr>";
	<?php
	   	if (!empty($idanimal))
		{
		$sql = "select * from cobertura where cobertura.idanimal = $idanimal ";
		$res = pg_exec($conn,$sql);
		$c=0;
		?>
		<?php
		while ($row = pg_fetch_array($res))
		{?>
     	  	  s2 = s2 + "<tr class='tab_bg_1'>";
		   	  s2 = s2 + "<td><?php echo date('d/m/Y', strtotime($row['datacobertura']));?></td>";
		   	  s2 = s2 + "<td><?php echo $row['idreprodutor'];?></td>";
		   	  s2 = s2 + "</tr>";
		  <?php 
		}
		}
		?>
		s2 = s2 + '</table>';

var s3 = "<table width='100%'><tr><td width='50%'><table width='100%'><tr><td width='100%' align='left'><b>Data Parto</b></td></tr>";
	<?php
	   	if (!empty($idanimal))
		{
	   	$sql = "select * from parto where parto.idanimal = $idanimal ";
		$res = pg_exec($conn,$sql);
		$c=0;
		?>
		<?php
		while ($row = pg_fetch_array($res))
		{?>
     	  	  s3 = s3 + "<tr class='tab_bg_1'>";
		   	  s3 = s3 + "<td><?php echo date('d/m/Y', strtotime($row['dataparto']));?></td>";
		   	  s3 = s3 + "</tr>";
		  <?php 
		}
		}
		?>
		s3 = s3 + "</table></td><td width='50%'></tr></table>";

var s4 = "<table width='100%'><tr valign='top'><td width='50%'><table width='100%'><tr valign='top'><td width='50%' align='left' ><b>Data Pesagem</b></td><td width='50%' align='rigth'><b>Peso</b></td></tr>";
	<?php
	   	if (!empty($idanimal))
		{
	   	$sql = "select * from balanca where balanca.idanimal = $idanimal order by datapesagem ";
		$res = pg_exec($conn,$sql);
		$c=0;
		?>
		<?php
		while ($row = pg_fetch_array($res))
		{?>
     	  	  s4 = s4 + "<tr class='tab_bg_1'>";
		   	  s4 = s4 + "<td><a href='cadcrescimento.php?op=A&idavaliacao=<?php echo $idavaliacao;?>&idbalanca=<?php echo $row['idbalanca'];?>'><?php echo date('d/m/Y', strtotime($row['datapesagem']));?></a></td>";
		   	  s4 = s4 + "<td><?php echo $row['peso'];?> kg</td>";
		   	  s4 = s4 + "</tr>";
		  <?php 
		}
		}
		?>
		s4 = s4 + "</table></td><td width='50%'><div id='chart_div' style='width: 100%; height: 300px;'></div></td></tr></table>";

var s5 = "<table width='100%'><tr valign='top'><td width='50%'><table width='100%'><tr valign='top'><td width='10%' align='left' ><b>Periodo</b></td><td width='50%' align='left' ><b>Data Controle</b></td><td width='50%' align='rigth'><b>Litros</b></td></tr>";
	<?php
	   	if (!empty($idanimal))
		{
	   	$sql = "select * from lactacao where lactacao.idanimal = $idanimal order by periodo,datacontrole ";
		$res = pg_exec($conn,$sql);
		$c=0;
		?>
		<?php
		while ($row = pg_fetch_array($res))
		{?>
     	  	  s5 = s5 + "<tr class='tab_bg_1'>";
		   	  s5 = s5 + "<td><?php echo $row['periodo'];?></td>";
		   	  s5 = s5 + "<td><a href='cadlactacao.php?op=A&idavaliacao=<?php echo $idavaliacao;?>&idlactacao=<?php echo $row['idlactacao'];?>'><?php echo date('d/m/Y', strtotime($row['datacontrole']));?></a></td>";
		   	  s5 = s5 + "<td><?php echo $row['qtdlitros'];?> Litros</td>";
		   	  s5 = s5 + "</tr>";
		  <?php 
		}
		}
		?>

		s5 = s5 + "</table></td><td width='50%'><div id='chart2_div' style='width: 100%; height: 300px;'></div></td></tr></table>";




dojo.ready(function(){
    var aContainer = new dijit.layout.AccordionContainer({style:"width: 100%; height: 350px"}, "markup");

    aContainer.addChild(new dijit.layout.ContentPane({
        title:"Cobertura",
        content: s2
    }));
    aContainer.addChild(new dijit.layout.ContentPane({
        title:"Parto",
        content: s3
    }));
    aContainer.addChild(new dijit.layout.ContentPane({
        title:"Crescimento",
        content: s4
    }));
    aContainer.addChild(new dijit.layout.ContentPane({
        title:"Lactação",
        content: s5
    }));

    aContainer.startup();
});




	function excluirItem()
	{
	  if (confirm('Realmente deseja excluir o Animal')){
    	location.href='exec.animal.php?op=E&id=<?php echo $id;?>';
      }
	}

	function validaForm()
	{
	   r = true;
	   m = '';
	   if (   (document.getElementById('edtnome').value == '') || 
	   (document.getElementById('cmboxtipoanimal').value == '') 
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
			document.getElementById('formulario').action="exec.animal.php";
   			document.getElementById('formulario').submit();
	   }
	}

	function salvarFechar()
	{
	   if (validaForm()==true){
	   		document.getElementById('fechar').value='s';
			document.getElementById('formulario').action="exec.animal.php";
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

					var button4 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Cobertura',
                        showLabel: true,
						onClick: function()
						{
							parent.corpo.location.href='cadcobertura.php?op=I&idanimal=<?php echo $idanimal;?>';
						},
                        iconClass:  "dijitIconError dijitIconTable"
                    });
                    toolbar.addChild(button4);

					var button4 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Parto',
                        showLabel: true,
						onClick: function()
						{
							parent.corpo.location.href='cadparto.php?op=I&idanimal=<?php echo $idanimal;?>';
						},
                        iconClass:  "dijitIconError dijitIconTable"
                    });
                    toolbar.addChild(button4);

					var button4 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Crescimento',
                        showLabel: true,
						onClick: function()
						{
							parent.corpo.location.href='cadcrescimento.php?op=I&idanimal=<?php echo $idanimal;?>';
						},
                        iconClass:  "dijitIconError dijitIconChart"
                    });
                    toolbar.addChild(button4);

					var button4 = new dijit.form.Button({
                        // note: should always specify a label, for accessibility reasons.
                        // Just set showLabel=false if you don't want it to be displayed normally
                        label: 'Lacta&ccedil;&atilde;o',
                        showLabel: true,
						onClick: function()
						{
							parent.corpo.location.href='cadlactacao.php?op=I&idanimal=<?php echo $idanimal;?>';
						},
                        iconClass:  "dijitIconError dijitIconTable"
                    });
                    toolbar.addChild(button4);

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
    de Animal</strong></font> </div>
	
	<form action="exec.animal.php" method="POST" name="formulario" id="formulario">
    <input name="fechar" type="hidden" id="fechar" value="s"> <input name="op" type="hidden" id="operacao" value="<?php echo $operacao;?>"> 
    <input name="codigo" type="hidden" id="codigo" value="<?php echo $id;?>"> 
    <table class="tab_cadrehov">
      <tr class="tab_bg_2" > 
        <th colspan="2">Cadastro de Animal</th>
      </tr>
      <?php if ($operacao=='A'){?>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">ID:</td>
        <td width="315"><input name="edtidanimal" type="text" id="edtidanimal" readonly="true" value="<?php echo $idanimal;?>"> 
        </td>
      </tr>
      <?php } ?>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Avaliação <?php echo $idavaliacao;?></td>
        <td width="315"><?php echo $Avaliacao->listaCombo('cmboxavaliacao',$idavaliacao,$idpropriedade,'N');?> 
        </td>
      </tr>
      <tr class="tab_bg_1"> 
        <td width="200" valign="top">Nome</td>
        <td width="315"><input name="edtnome" type="text" id="edtnome" value="<?php echo $nome;?>" > 
        </td>
      </tr><tr class="tab_bg_1"> 
        <td width="200" valign="top">Tipo de animal</td>
        <td width="315"><?php echo $TipoAnimal->listaCombo('cmboxtipoanimal',$idtipoanimal,'','N');?>
        </td>
      </tr>
      </tr><tr class="tab_bg_1"> 
        <td width="200" valign="top">Data nascimento</td>
        <td width="315"><input name="edtdatanascimento" type="text" id="edtdatanascimento" value="<?php echo $datanascimento;?>" dojoType="dijit.form.DateTextBox" >
        </td>
      </tr>
      </tr><tr class="tab_bg_1"> 
        <td width="200" valign="top">Nome da mãe</td>
        <td width="315"><input name="edtnomemae" type="text" id="edtnomemae" value="<?php echo $nomemae;?>"><?php //echo $TipoAnimal->listaCombo('cmboxtipoanimal',$idtipoanimal,'','N');?>
        </td>
      </tr>
      </tr><tr class="tab_bg_1"> 
        <td width="200" valign="top">Nome do pai</td>
        <td width="315"><input name="edtnomepai" type="text" id="edtnomepai" value="<?php echo $nomepai;?>"><?php //echo $TipoAnimal->listaCombo('cmboxtipoanimal',$idtipoanimal,'','N');?>
        </td>
      </tr>
      </tr><tr class="tab_bg_1"> 
        <td width="200" valign="top">Porte do animal</td>
        <td width="315"><?php echo $PorteAnimal->listaCombo('cmboxporteanimal',$idporteanimal,'','N');?>
        </td>
      </tr>

    </table>
    <table width="95%">
      <tr >
	  <td>
			<div id="markup" style="height: 300px"></div>
      </td>
	  </tr>
	</table>
		</form>
</center>
</div>
    </body>

</html>