<?php
require "../FPDF/fpdf.php";
class FormularioVisitaTecnica extends FPDF
{
var $res ;
var $conn; 

function Justify($text, $w, $h)
{
    $tab_paragraphe = explode("\n", $text);
    $nb_paragraphe = count($tab_paragraphe);
    $j = 0;

    while ($j<$nb_paragraphe) {

        $paragraphe = $tab_paragraphe[$j];
        $tab_mot = explode(' ', $paragraphe);
        $nb_mot = count($tab_mot);

        // Handle strings longer than paragraph width
        $k=0;
        $l=0;
        while ($k<$nb_mot) {

            $len_mot = strlen ($tab_mot[$k]);
            if ($len_mot<($w-5) )
            {
                $tab_mot2[$l] = $tab_mot[$k];
                $l++;    
            } else {
                $m=0;
                $chaine_lettre='';
                while ($m<$len_mot) {

                    $lettre = substr($tab_mot[$k], $m, 1);
                    $len_chaine_lettre = $this->GetStringWidth($chaine_lettre.$lettre);

                    if ($len_chaine_lettre>($w-7)) {
                        $tab_mot2[$l] = $chaine_lettre . '-';
                        $chaine_lettre = $lettre;
                        $l++;
                    } else {
                        $chaine_lettre .= $lettre;
                    }
                    $m++;
                }
                if ($chaine_lettre) {
                    $tab_mot2[$l] = $chaine_lettre;
                    $l++;
                }

            }
            $k++;
        }

        // Justified lines
        $nb_mot = count($tab_mot2);
        $i=0;
        $ligne = '';
        while ($i<$nb_mot) {

            $mot = $tab_mot2[$i];
            $len_ligne = $this->GetStringWidth($ligne . ' ' . $mot);

            if ($len_ligne>($w-5)) {

                $len_ligne = $this->GetStringWidth($ligne);
                $nb_carac = strlen ($ligne);
                $ecart = (($w-2) - $len_ligne) / $nb_carac;
                $this->_out(sprintf('BT %.3F Tc ET',$ecart*$this->k));
                $this->MultiCell($w,$h,$ligne);
                $ligne = $mot;

            } else {

                if ($ligne)
                {
                    $ligne .= ' ' . $mot;
                } else {
                    $ligne = $mot;
                }

            }
            $i++;
        }

        // Last line
        $this->_out('BT 0 Tc ET');
        $this->MultiCell($w,$h,$ligne);
        $tab_mot = '';
        $tab_mot2 = '';
        $j++;
    }
}

function i25($xpos, $ypos, $code, $basewidth=1, $height=10){

    $wide = $basewidth;
    $narrow = $basewidth / 3 ;

    // wide/narrow codes for the digits
    $barChar['0'] = 'nnwwn';
    $barChar['1'] = 'wnnnw';
    $barChar['2'] = 'nwnnw';
    $barChar['3'] = 'wwnnn';
    $barChar['4'] = 'nnwnw';
    $barChar['5'] = 'wnwnn';
    $barChar['6'] = 'nwwnn';
    $barChar['7'] = 'nnnww';
    $barChar['8'] = 'wnnwn';
    $barChar['9'] = 'nwnwn';
    $barChar['A'] = 'nn';
    $barChar['Z'] = 'wn';

    // add leading zero if code-length is odd
    if(strlen($code) % 2 != 0){
        $code = '0' . $code;
    }

    $this->SetFont('Arial','',10);
    //$this->Text($xpos, $ypos + $height + 4, $code);
    $this->SetFillColor(0);

    // add start and stop codes
    $code = 'AA'.strtolower($code).'ZA';

    for($i=0; $i<strlen($code); $i=$i+2){
        // choose next pair of digits
        $charBar = $code[$i];
        $charSpace = $code[$i+1];
        // check whether it is a valid digit
        if(!isset($barChar[$charBar])){
            $this->Error('Invalid character in barcode: '.$charBar);
        }
        if(!isset($barChar[$charSpace])){
            $this->Error('Invalid character in barcode: '.$charSpace);
        }
        // create a wide/narrow-sequence (first digit=bars, second digit=spaces)
        $seq = '';
        for($s=0; $s<strlen($barChar[$charBar]); $s++){
            $seq .= $barChar[$charBar][$s] . $barChar[$charSpace][$s];
        }
        for($bar=0; $bar<strlen($seq); $bar++){
            // set lineWidth depending on value
            if($seq[$bar] == 'n'){
                $lineWidth = $narrow;
            }else{
                $lineWidth = $wide;
            }
            // draw every second value, because the second digit of the pair is represented by the spaces
            if($bar % 2 == 0){
                $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
            }
            $xpos += $lineWidth;
        }
    }
} // funcion


function Header()
{
    // Logo
//    $this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
//    $this->Cell(80);
    // Title
//    $this->Cell(30,10,'Title',1,0,'C');
    // Line break
 //   $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
   /* $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	*/
}

	function FormularioVisitaTecnica($orientation='P',$unit='mm',$format='A4')
	{
    //Call parent constructor
    	$this->FPDF('P',$unit,$format);
		$this->SetMargins(10,10,10);
		//$this->montaCorpo();
    //Initialization
	}

	function montaCorpo()
	{
		while ($row = pg_fetch_array($this->res))
		{
			$this->AddPage();

			$idvisitatecnica = $row['idvisitatecnica'];
			if (!empty($idvisitatecnica)){
				$idvisitatecnica = str_pad($idvisitatecnica, 6, "0", STR_PAD_LEFT);
			}
		$datavisita = date('d/m/Y', strtotime($row['datavisita']));
		$nometecnico = utf8_decode($row['nometecnico']);
		$nomeprodutor = utf8_decode($row['nomeprodutor']);
		$nomepropriedade = utf8_decode($row['nomepropriedade']);
		$municipio = utf8_decode($row['municipio']);
		$areatotal = $row['tamanho'].' '.$row['siglaunidademedida'];
		$areaprojeto = $row['areaprojeto'].' '.$row['siglaunidademedidaprojeto'];;
		$producaodia = $row['producaodia'];
		$numvacaslactacao = $row['numvacaslactacao'];
		$numvacassecas = $row['numvacassecas'];
		$relatorio = utf8_decode($row['relatorio']);
		if (!empty($dataproximavisita))
		{
			$dataproximavisita = date('d/m/Y', strtotime($row['dataproximavisita']));
		}
		else
		{
		$dataproximavisita = '';
		}
		$horachegada = substr($row['horachegada'],0,5);
		$horasaida = substr($row['horasaida'],0,5);




    	$this->Image('./imagens/logo_baldecheio.jpg',10,10,30);
		$this->SetX(170);
		$this->i25(174,10,str_pad($row['idvisitatecnica'], 6, "0", STR_PAD_LEFT));		
		$this->SetFont('Arial','B',9);
		$this->SetXY(170,22);
    	$this->Cell(30,10,$idvisitatecnica,1,1,'C');
    	$this->SetFont('Arial','',7);
		$this->Text(172,24,'ID');
		$this->SetY(50);
		$y = 0;
/*
*/
//    	$this->Image('./imagens/logocarteira.JPG',10,6+$y,0,20);
		
		$this->SetDrawColor(0,0,255);	
		$y=$y+10;
    	$this->SetXY(5,15+$y);
    	$this->SetFont('Arial','B',14);
    	$this->Cell(195,8,'Relatório de Visita Técnica',0,1,'C');
		$y=$y+5;
		$this->SetDrawColor(0,0,0);	
//		$this->Cell(200,170,'',1,0,'C');

		$this->SetXY(10,20+$y);
    	$this->Cell(20,10,'',1,0,'C');
		$this->SetFont('Arial','',7);
		$this->Text(12,23+$y,'Data da Visita');
    	$this->SetFont('Arial','B',9);
		$this->Text(12,27+$y,$datavisita);

//		$this->SetXY(10,20+$y);
    	$this->Cell(20,10,'',1,0,'C');
		$this->SetFont('Arial','',7);
		$this->Text(32,23+$y,'Hora Chegada');
    	$this->SetFont('Arial','B',9);
		$this->Text(32,27+$y,$horachegada);

//		$this->SetXY(10,20+$y);
    	$this->Cell(20,10,'',1,0,'C');
		$this->SetFont('Arial','',7);
		$this->Text(52,23+$y,'Hora Saída');
    	$this->SetFont('Arial','B',9);
		$this->Text(52,27+$y,$horasaida);



//		$this->SetXY(10,30+$y);
    	$this->Cell(130,10,'',1,1,'C');
    	$this->SetFont('Arial','',7);
		$this->Text(72,23+$y,'Técnico');
    	$this->SetFont('Arial','B',9);
		$this->Text(72,27+$y,$nometecnico);

		$this->SetXY(10,30+$y);
    	$this->Cell(190,10,'',1,1,'C');
		$this->SetFont('Arial','',7);
		$this->Text(12,33+$y,'Produtor');
    	$this->SetFont('Arial','B',9);
		$this->Text(12,37+$y,$nomeprodutor);

		$this->SetXY(10,40+$y);
    	$this->Cell(160,10,'',1,0,'C');
		$this->SetFont('Arial','',7);
		$this->Text(12,43+$y,'Propriedade');
    	$this->SetFont('Arial','B',9);
		$this->Text(12,47+$y,$nomepropriedade);

    	$this->Cell(30,10,'',1,1,'C');
    	$this->SetFont('Arial','',7);
		$this->Text(172,43+$y,'Município');
    	$this->SetFont('Arial','B',9);
		$this->Text(172,47+$y,$municipio);

		$this->SetXY(10,50+$y);
    	$this->Cell(95,10,'',1,0,'C');
		$this->SetFont('Arial','',7);
		$this->Text(12,53+$y,'Área Total');
    	$this->SetFont('Arial','B',9);
		$this->Text(12,57+$y,$areatotal);

    	$this->Cell(95,10,'',1,1,'C');
    	$this->SetFont('Arial','',7);
		$this->Text(107,53+$y,'Área Projeto');
    	$this->SetFont('Arial','B',9);
		$this->Text(107,57+$y,$areaprojeto);

		$this->SetXY(10,60+$y);
    	$this->Cell(60,10,'',1,0,'C');
		$this->SetFont('Arial','',7);
		$this->Text(12,63+$y,'Produção Dia');
    	$this->SetFont('Arial','B',9);
	    $s = 'litro';
		if ($producaodia>1){
			$s = 'litros';
		}
		$this->Text(12,67+$y,$producaodia.' '.$s);

    	$this->Cell(60,10,'',1,0,'C');
    	$this->SetFont('Arial','',7);
		$this->Text(72,63+$y,'Vacas em Lactação');
    	$this->SetFont('Arial','B',9);
		$this->Text(72,67+$y,$numvacaslactacao);

    	$this->Cell(70,10,'',1,1,'C');
    	$this->SetFont('Arial','',7);
		$this->Text(132,63+$y,'Vacas Secas');
    	$this->SetFont('Arial','B',9);
		$this->Text(132,67+$y,$numvacassecas);

		$this->SetXY(10,75+$y);
    	$this->SetFont('Arial','',9);
		$this->Justify($relatorio,85,4);
//		$this->MultiCell(190, 180, $relatorio.'Afael', '1', 'J',false,0);		
		// rodape
		$this->SetXY(10,250+$y);
    	$this->Cell(60,10,'',1,0,'C');
		$this->SetFont('Arial','',7);
		$this->Text(12,253+$y,'´Data Próxima Visita');
    	$this->SetFont('Arial','B',9);
		$this->Text(12,257+$y,$dataproximavisita);

    	$this->Cell(70,10,'',1,0,'C');
    	$this->SetFont('Arial','',7);
		$this->Text(72,253+$y,'Assinatura Produtor');
    	$this->SetFont('Arial','B',9);
//		$this->Text(72,67+$y,$areaprojeto);

    	$this->Cell(60,10,'',1,1,'C');
    	$this->SetFont('Arial','',7);
		$this->Text(142,253+$y,'Assinatura Técnico');
    	$this->SetFont('Arial','B',9);
//		$this->Text(132,67+$y,$areaprojeto);

		} // while

	} // monta corpo
} // classe

?>
