<?php // content="text/plain; charset=utf-8"
require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_pie.php');
require_once ('../jpgraph/src/jpgraph_pie3d.php');
require_once ('../jpgraph/src/jpgraph_line.php');
   require_once('classes/conexao.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();
$idpropriedade = $_REQUEST['idpropriedade'];
$numero = $_REQUEST['numero'];
$ano = $_REQUEST['ano'];

	$sql2 = 'select * from balanca where idpropriedade = '.$idpropriedade.' and ano = '.$ano.' and numero = '.$numero;
	$res2 = pg_exec($conn,$sql2);
	$valor = '';
	$data = '';
	while ($row2 = pg_fetch_array($res2))
	{
		$valor.=$row2['peso'].';';
		$data.=date('d/m/Y',strtotime($row2['data'])).';';
	}				
	$datay1 = explode(';',$valor);
	$datax = explode(';',$data);
	

   
//$datay1 = array(20,15,23,15);
//$datay2 = array(12,9,42,8);
//$datay3 = array(5,17,32,24);

// Setup the graph
$graph = new Graph(500,350);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
//$graph->title->Set('Lactação');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(45);
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
//$p1->SetLegend('Lactacao '.$lactacao);

/*// Create the second line
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Line 2');

// Create the third line
$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF1493");
$p3->SetLegend('Line 3');
*/
$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();


/*
// Some data
$data = explode(';',$_REQUEST['valor']);
$legenda = explode(';',$_REQUEST['legenda']);
//$data = array(40,60,21,33);

// Create the Pie Graph. 
$graph = new PieGraph(300,220);
$theme_class= new VividTheme;
$graph->SetTheme($theme_class);

// Set A title for the plot
//$graph->title->Set("A Simple 3D Pie Plot");

// Create
$p1 = new PiePlot3D($data);
$p1->SetAngle(45);
$p1->SetCenter(0.5);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
//$p1->ExplodeSlice(1);
$p1->SetSize(90);
$graph->legend->Pos(-0.1,0.1);
//$graph->legend->Pos(0.1,0.2);
$p1->SetLegends($legenda);
//$graph->Add($p1);
$graph->Stroke();
*/
?>
