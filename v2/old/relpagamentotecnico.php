<?php
$NOMEFUNCAO = 'RelFinanceiroPagamento';
$NOMETABELA = 'RelFinanceiroPagamento';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$NOMETABELA.'.xlsx"');
header('Cache-Control: max-age=0');
require_once('classes/conexao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();
//$sql = " select * from ".$NOMETABELA." where ".$NOMETABELA."\.id".$NOMETABELA." = ".$NOMETABELA."\.id".$NOMETABELA." order by ".$NOMETABELA;
$sql = 'select tec.nometecnico,prod.nomeprodutor,
(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2013 and vt.mesreferencia = 6)
) as "06/2013"
,
(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2013 and vt.mesreferencia = 7)
) as "07/2013"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2013 and vt.mesreferencia = 8)
) as "08/2013"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2013 and vt.mesreferencia = 9)
) as "09/2013"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2013 and vt.mesreferencia = 10)
) as "10/2013"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2013 and vt.mesreferencia = 11)
) as "11/2013"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2013 and vt.mesreferencia = 12)
) as "12/2013"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2014 and vt.mesreferencia = 1)
) as "01/2014"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2014 and vt.mesreferencia = 2)
) as "02/2014"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2014 and vt.mesreferencia = 3)
) as "03/2014"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2014 and vt.mesreferencia = 4)
) as "04/2014"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and (vt.anoreferencia = 2014 and vt.mesreferencia = 5)
) as "05/2013"
,(select sum(vt.valorpago) from visitatecnica vt where
vt.idpropriedade = prop.idpropriedade 
 and ((vt.anoreferencia = 2013 and vt.mesreferencia >= 6)
 or (vt.anoreferencia = 2014 and vt.mesreferencia < 6))
) as "TOTAL"
 from propriedade prop, produtor prod, 
tecnico tec 
where
prop.idprodutor = prod.idprodutor and
prod.idtecnico = tec.idtecnico and
prop.idsituacaopropriedade = 1
order by tec.nometecnico, prod.nomeprodutor';
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
            ->setCellValue('A1', 'Técnico')
            ->setCellValue('B1', 'Produtor')
            ->setCellValue('C1', '06/2013')
            ->setCellValue('D1', '07/2013')
            ->setCellValue('E1', '08/2013')
            ->setCellValue('F1', '09/2013')
            ->setCellValue('G1', '10/2013')
            ->setCellValue('H1', '11/2013')
            ->setCellValue('I1', '12/2013')
            ->setCellValue('J1', '01/2014')
            ->setCellValue('K1', '02/2014')
            ->setCellValue('L1', '03/2014')
            ->setCellValue('M1', '04/2014')
            ->setCellValue('N1', '05/2014')
            ->setCellValue('O1', 'TOTAL');
$c = 1;
while ($row = pg_fetch_array($res))
{
	$cel_A = 'A'.($c+1);
	$cel_B = 'B'.($c+1);
	$cel_C = 'C'.($c+1);
	$cel_D = 'D'.($c+1);
	$cel_E = 'E'.($c+1);
	$cel_F = 'F'.($c+1);
	$cel_G = 'G'.($c+1);
	$cel_H = 'H'.($c+1);
	$cel_I = 'I'.($c+1);
	$cel_J = 'J'.($c+1);
	$cel_K = 'K'.($c+1);
	$cel_L = 'L'.($c+1);
	$cel_M = 'M'.($c+1);
	$cel_N = 'N'.($c+1);
	$cel_O = 'O'.($c+1);
	$c++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_A,$row['nometecnico']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_B,$row['nomeprodutor']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_C,$row[2]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_D,$row[3]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_E,$row[4]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_F,$row[5]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_G,$row[6]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_H,$row[7]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_I,$row[8]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_J,$row[9]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_K,$row[10]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_L,$row[11]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_M,$row[12]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_N,$row[13]);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_O,$row[14]);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);

// Miscellaneous glyphs, UTF-8
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('A4', 'Miscellaneous glyphs')
//            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Pagamentos Técnicos');


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