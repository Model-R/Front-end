<?php session_start();
   include "paths.inc";
   require_once('classes/conexao.class.php');
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();
   $idprodutor = $_REQUEST['idprodutor'];
   $idpropriedade = $_REQUEST['idpropriedade'];
   $datainicio = $_REQUEST['datainicio'];
   $datafim = $_REQUEST['datafim'];
   $idtecnico = $_REQUEST['idtecnico'];
   $datainicio = $_REQUEST['datainicio'];
   $datatermino = $_REQUEST['datafim'];

	$datainicio = $_REQUEST['datainicio'];
	if (!empty($datainicio))
	{
		$datainicio = substr($datainicio,6,4).'-'.substr($datainicio,3,2).'-'.substr($datainicio,0,2);
	}
	$datatermino = $_REQUEST['datafim'];
	if (!empty($datatermino))
	{
		$datatermino = substr($datatermino,6,4).'-'.substr($datatermino,3,2).'-'.substr($datatermino,0,2);
	}
	if ((!empty($datainicio)) && (!empty($datatermino)))
	{
		$sql_data = " and (datavisita >= '".$datainicio."' and datavisita <= '".$datatermino."') ";
	}
	
//	echo $sql_data;
	
	
   function calcula_relacao($v1,$v2)
   {
	   if (empty($v1) || empty($v2))
	   {
		   $porc = 0;
	   }
	   else
	   {
   	   $valor = $v2/$v1;
   	   if ($valor>0)
	   {
	   	  $porc = (100 - ($valor*100))*-1;
	   }
	   else
	   {
	   		$porc = (100-(100-($valor*100)));
	   }
	   }
   	  return $porc;
   }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $DOJO_PATH;?>/dijit/themes/claro/claro.css"/>
  <link rel="stylesheet" type="text/css" href="../senar-rjnet/css/styles.css"/>
        <style type="text/css">
            body, html { font-family:helvetica,arial,sans-serif; font-size:90%; }
        	.caixa {
				width: 95%;
				border: solid 1px #85B000;
				padding: 0.0;
				/*background-color: blue;*/
			}
			.caixa th {
				color: white;
				background-color: #85B000;
				padding: 0.5em;
/*				background-color: #99CC00;*/
			}
			.caixa td{
				padding: 0.5em;
			}
			.caixa tbody tr:nth-child(odd){
				background:#CADFB7;
			}
			
		</style>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
	
/*	function abrirrelatorio()
	{
		url = 'relatividades.php?imprimir=T&cmboxplanejamento='+document.getElementById('cmboxplanejamento').value+'&cmboxplanejamentoanterior='+document.getElementById('cmboxplanejamentoanterior').value;
		//url = 'relatividades.php?cmboxplanejamento='+plan1+'&cmboxplanejamentoanterior='+plan2;
		window.open(url);	
	}
	*/
      /*google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales'],
          ['2004',  1000 ],
          ['2005',  1170 ],
          ['2006',  660  ],
          ['2007',  1030]
        ]);

        var options = {
		  title: 'Company Performance',
          vAxis: {title: 'Ano',  titleTextStyle: {color: '#85B000'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
	*/
    </script>

<script type="text/javascript" src="../senar-rjnet/verificaajax.js"></script>

    <script type="text/javascript" src="<?php echo $DOJO_PATH;?>/dojo/dojo.js" djConfig="parseOnLoad: true"></script>

    <script type="text/javascript">
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.PopupMenuBarItem");
        dojo.require("dijit.layout.TabContainer");
        dojo.require("dijit.layout.ContentPane");
	 dojo.require("dijit.TitlePane");
	 dojo.require("dijit.form.DateTextBox");

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
        
	function voltar()
	{
    	location.href='consvisitatecnica.php';
	}

</script>		
</head>
   
    <body class="claro" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		  <span id="toolbar">
          </span>
		  <form action="relprodutividade.php" method="POST" name="formulario" id="formulario">
  <div dojoType="dijit.layout.ContentPane" region="top" splitter="false"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Relatório de Produtividade</strong></font></div>
<?php  
	
	$sql = 'select prop.nomepropriedade,prod.nomeprodutor,tec.nometecnico,
( 
select min(datavisita) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select min(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "Data inicial"
,
( 
select max(datavisita) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select max(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "Data final"
,
(select min(producaodia) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select min(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "producao_inicial"
,
(select max(producaodia) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select max(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "producao_final"

,
(select min(producaodia)/(case when min(numvacaslactacao)=0 then
			    	1 else
			    	min(numvacaslactacao)
			    	end) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select min(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "produtividade_inicial"

,
(select min(producaodia)/(case when min(numvacaslactacao)=0 then
			    	1 else
			    	min(numvacaslactacao)
			    	end) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select max(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "produtividade_final"

,
(select sum(numvacaslactacao) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select min(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "lactacao_A"
,
(select sum(numvacassecas) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select min(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "secas_A"
,
(select sum(numvacaslactacao) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select max(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "lactacao_B"
,
(select sum(numvacassecas) from visitatecnica vt, propriedade prop2 where
vt.idpropriedade = prop2.idpropriedade and prop2.idpropriedade = prop.idpropriedade 
and vt.datavisita = (select max(datavisita) from visitatecnica where idpropriedade = prop.idpropriedade '.$sql_data.') ) as "secas_B"

from propriedade prop, produtor prod, tecnico tec where prop.idsituacaopropriedade = 1 and
prop.idprodutor = prod.idprodutor and
prop.idtecnico = tec.idtecnico ';
if (!empty($idtecnico))
{
	$sql.=' and prop.idtecnico = '.$idtecnico;
}
if (!empty($idprodutor))
{
	$sql.=' and prop.idprodutor = '.$idprodutor;
}
if (!empty($idpropriedade))
{
	$sql.=' and prop.idpropriedade = '.$idpropriedade;
}
$sql.= '
order by upper(prop.nomepropriedade)';
//echo $sql;
//exit;

	$res = pg_exec($conn,$sql);?>
			<table width="95%" class="caixa" align="center">
			<tr>
			<th colspan="13">RESULTADOS OBTIDOS PROGRAMA BALDE CHEIO</th>
			</tr>
			<tr>
			<th width="20%">Propriedade</th>
			<th width="20%">Produtor</th>
			<th width="20%">Técnico</th>
			<th width="5%">Data (A)</th>
			<th width="5%">Data (B)</th>
			<th width="5%">Produção (A)</th>
			<th width="5%">Produção (B)</th>
			<th width="5%">A/B (%)</th>
			<th width="5%">Prod. (A)</th>
			<th width="5%">Prod. (B)</th>
			<th width="5%">Prod. A/B(%)</th>
			<th width="5%">Lactação (A)</th>
			<th width="5%">Lactação (B)</th>
			</tr>
<?php	
	$c = 0;
	$rowanterior = array();
	$row2 = array();
 	while ($row = pg_fetch_array($res))
		{
		$dataA = $row[3];
		$dataB = $row[4];
		$prodA = $row['producao_inicial'];
		$prodB = $row['producao_final'];
		$produtivA = $row['produtividade_inicial'];
		$produtivB = $row['produtividade_final'];
		$lactacaoA = $row['lactacao_A'];
		$lactacaoB = $row['lactacao_B'];
		$secasA = $row['secas_A'];
		$secasB = $row['secas_B'];
		
		if ((!empty($prodA)) && (!empty($prodB)))
		{
			$prod_variacao = calcula_relacao($prodA,$prodB);
		}
		else
		{
			$prod_variacao = '?';
		}

		if ((!empty($produtivA)) && (!empty($produtivB)))
		{
			$produtividade_variacao = calcula_relacao($produtivA,$produtivB);
		}
		else
		{
			$produtividade_variacao  = '?';
		}

		if ((!empty($lactacaoA)) && (!empty($secasA)))
		{
			$porc=(($lactacaoA/($lactacaoA+$secasA))*100);
			$lactacaoA_variacao = 'L('.$lactacaoA.') S('.$secasA.')<br> '.number_format($porc,2,',','');//calcula_relacao($lactacaoA,$lactacaoB);
		}
		else
		{
			$lactacaoA_variacao = '?';
		}

		if ((!empty($lactacaoB)) && (!empty($secasB)))
		{
			$porc=(($lactacaoB/($lactacaoB+$secasB))*100);
			$lactacaoB_variacao = 'L('.$lactacaoB.') S('.$secasB.')<br> '.number_format($porc,2,',','');//calcula_relacao($lactacaoA,$lactacaoB);
		}
		else
		{
			$lactacaoB_variacao = '?';
		}


		if (empty($dataA)){
			$dataA = '';
		}
		else
		{
			$dataA = date('d/m/Y',strtotime($row[3]));
		}
		if (empty($dataB)){
			$dataB = '';
		}
		else
		{
			$dataB = date('d/m/Y',strtotime($row[4]));
		}

			if ($c==0)
			{
				$totalanterior = $row[1]+$row[2]+$row[3]+$row[4]+$row[5]+$row[6];
				$rowanterior = $row;
				$c++;
			}
			else
			{
				$row2 = $row;
			}
		$total = $row[1]+$row[2]+$row[3]+$row[4]+$row[5]+$row[6];
		?>
		
		<tr >
		<td align="left"><?php echo $row['nomepropriedade'];?></td>
		<td align="left"><?php echo $row['nomeprodutor'];?></td>
		<td align="left"><?php echo $row['nometecnico'];?></td>
		<td align="right"><?php echo $dataA;?></td>
		<td align="right"><?php echo $dataB;?></td>
		<td align="right"><?php echo $row[5];?></td>
		<td align="right"><?php echo $row[6];?></td>
		<td align="right"><?php 
		if ($prod_variacao=='?')
		{
			echo $prod_variacao;
		}
		else
		{
			echo number_format($prod_variacao,2,',','.');
		}
		?></td>
		<td align="right"><?php echo $row[7];?></td>
		<td align="right"><?php echo $row[8];?></td>
		<td align="right"><?php 
		if ($produtividade_variacao=='?')
		{
			echo $produtividade_variacao;
		}
		else
		{
			echo number_format($produtividade_variacao,2,',','.');
		}
		?>
</td>
		<td align="right"><?php echo $lactacaoA_variacao;?></td>
		<td align="right"><?php echo $lactacaoB_variacao;?></td>
		</tr>
 <?php
		}
?>
			</table>

			

        </form>
</body>
</html>