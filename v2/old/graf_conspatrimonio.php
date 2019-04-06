<?php // content="text/plain; charset=utf-8"
require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_pie.php');
require_once ('../jpgraph/src/jpgraph_pie3d.php');

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

?>
