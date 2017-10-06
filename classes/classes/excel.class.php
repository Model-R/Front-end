<?php
class Excel
{
	var $conn;
	var $sql;
	var $arquivo;
	var $campos;
	var $coluna;

	function imprime()
	{
		$html = '';
		$html .= '<table>';
	
	
			$html .= "<tr>";
			for ($c = 0; $c < count($this->coluna); $c++)
			{
				$valor = $this->coluna[$c];
				$html.="<td valign='top'>".$valor."</td>"; 
			}
			$html .= "</tr>";

		$res = pg_query($this->conn,$this->sql);
		while ($row = pg_fetch_array($res))
		{
			$html .= "<tr>";
			for ($c = 0; $c < count($this->campos); $c++)
			{
				$valor = $row[$this->campos[$c]];
				$html.="<td valign='top'>".utf8_decode($valor)."</td>"; 
			}
			$html .= "</tr>";
	    }
		$html .= '</table>';
		
		header ("Expires: Mon, 12 Jun 2011 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"".$this->arquivo."\"" );
		header ("Content-Description: PHP Generated Data" );
		echo $html;
		
		exit;

	}
}
?>
