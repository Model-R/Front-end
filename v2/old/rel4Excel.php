<?php
$NOMEFUNCAO = 'Rel4';
$NOMETABELA = 'Rel4';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$NOMETABELA.'.xlsx"');
header('Cache-Control: max-age=0');
require_once('classes/conexao.class.php');
require_once('classes/programa.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Programa = new Programa();
$Programa->conn = $conn;
//$sql = " select * from ".$NOMETABELA." where ".$NOMETABELA."\.id".$NOMETABELA." = ".$NOMETABELA."\.id".$NOMETABELA." order by ".$NOMETABELA;

	$datainicio = $_REQUEST['datainicio'];
	$datatermino = $_REQUEST['datatermino'];
	
	$dia = substr($datainicio,0,2);
	$mes = intval(substr($datainicio,3,2));
	$ano = substr($datainicio,6,4);
	
	if (empty($datatermino))
	{
		$datatermino = date('d/m/Y');
	}
	$diaT = substr($datatermino,0,2);
	$mesT = intval(substr($datatermino,3,2));
	$anoT = substr($datatermino,6,4);
	
$datainicio = $mes.'-'.$dia.'-'.$ano;
$datatermino = $mesT.'-'.$diaT.'-'.$anoT;

$idprograma = $_REQUEST['idprograma'];

$Programa->getById($idprograma);

//prod.idtecnico = tec.idtecnico and

$sql = "select prop.nomepropriedade as nomepropriedade,prod.nomeprodutor as nomeprodutor,tec.nometecnico as nometecnico, datavisita as datavisita,horachegada as horachegada,horasaida as horasaida,relatorio as relatorio from propriedade prop, produtor prod, tecnico tec, visitatecnica
 where
prop.idprodutor = prod.idprodutor and
visitatecnica.idtecnico = tec.idtecnico and
visitatecnica.idpropriedade = prop.idpropriedade and
nometecnico <> 'Rafael Oliveira Lima' ";
if (!empty($idprograma))
{
	$sql.=" and prop.idprograma = '".$idprograma."'";
	
}
$sql.=" and

(datavisita >= '".$datainicio."' and datavisita <='".$datatermino."')
order by tec.nometecnico,prop.nomepropriedade,datavisita, horachegada";
$res = pg_exec($conn,$sql);
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.8, 2012-10-12
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once '../PHPExcel_1.7.8/Classes/PHPExcel.php';


// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
//echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Rafael Lima")
							 ->setLastModifiedBy("Rafael Lima")
							 ->setTitle($NOMEFUNCAO)
							 ->setSubject($NOMEFUNCAO)
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");


// Add some data
//echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->getActiveSheet()->setTitle($NOMEFUNCAO);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Tecnico')
            ->setCellValue('B1', 'Propriedade / Produtor')
            ->setCellValue('C1', 'Data Visita')
            ->setCellValue('D1', 'Horário')
            ->setCellValue('E1', 'Relatório');
$c = 1;
while ($row = pg_fetch_array($res))
{
	$cel_A = 'A'.($c+1);
	$cel_B = 'B'.($c+1);
	$cel_C = 'C'.($c+1);
	$cel_D = 'D'.($c+1);
	$cel_E = 'E'.($c+1);
	$c++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_A,$row['nometecnico']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_B,$row['nomeprodutor'].' ('.$row['nomeprodutor'].')');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_C,date('d/m/Y',strtotime($row['datavisita'])));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_D,$row['horachegada'].' às '.$row['horasaida']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_E,$row['relatorio']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);

// Miscellaneous glyphs, UTF-8
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('A4', 'Miscellaneous glyphs')
//            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Técnico x Visita Técnica');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

/*$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('./imagens/logo.png');
$objDrawing->setCoordinates('A1');
$objDrawing->setOffsetX(110);
$objDrawing->setRotation(25);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
*/
// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$objWriter->save('php://output');
//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
// Save Excel5 file
//echo date('H:i:s') , " Write to Excel5 format" , EOL;
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(str_replace('.php', '.xls', __FILE__));
//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing files" , EOL;
//echo 'Files have been created in ' , getcwd() , EOL;
?>