<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
	  require_once('classes/programa.class.php');
	  require_once('classes/produtor.class.php');
	  require_once('classes/propriedade.class.php');
	  require_once('classes/tecnico.class.php');
	  
	  function calculo($tipocapital,$juros,$quantidade,$valorunitario,$vidautil,&$valortotal,&$valorresidual,&$remuneracaoanual,&$remuneracaomensal)
   {
   	  if (empty($vidautil))
	  {
	  	$vidautil = 1;
	  } 
   	  if (empty($juros))
	  {
	  	$juros = 6;
	  } 
      if (empty($quantidade))
	  {
	    $quantidade =1;
	  }
   	  if (($tipocapital==1) || ($tipocapital==2))
	  {
	  	$valortotal = $quantidade * $valorunitario;
		$remuneracaoanual = (($quantidade * $valorunitario * $juros)/100);
	  	$remuneracaomensal = ((($quantidade * $valorunitario * $juros)/100)/12);
	  } 
   	  if ($tipocapital==3) 
	  {
	  	$valorresidual = ($quantidade * $valorunitario)*0.1;
	  	$valortotal = ($quantidade * $valorunitario);
		$remuneracaoanual = Price2($valortotal,$valorresidual,$vidautil,$juros);
		$remuneracaomensal = (Price2($valortotal,$valorresidual,$vidautil,$juros)/12);

//	  	$valortotal = ($quantidade * $valorunitario)*0.1;
//		$remuneracaoanual = Price(5000,30,6);
//		$remuneracaomensal = (Price(5000,30,6)/12);

	  } 
   	  if ($tipocapital==4) 
	  {
	  	$valorresidual = ($quantidade * $valorunitario)*0.2;
	  	$valortotal = ($quantidade * $valorunitario);
//	  	$valortotal = ($quantidade * $valorunitario);
		$remuneracaoanual = Price2($valortotal,$valorresidual,$vidautil,$juros);
		$remuneracaomensal = (Price2($valortotal,$valorresidual,$vidautil,$juros)/12);

//		$remuneracaoanual = Price(5000,30,6);
//		$remuneracaomensal = (Price(5000,30,6)/12);
		
//		$remuneracaoanual = 5000;//Price2;
//		$remuneracaomensal = Price2;//(5000,30,6)/12);

	  } 
   }
	function Price($Valor, $Parcelas, $Juros) 
	{
//		$Juros = bcdiv($Juros,100,2);
		$Juros = $Juros/100;
		$E=0;
		$cont=1;
		for($k=1;$k<=$Parcelas;$k++)
		{
			$cont= bcmul($cont,bcadd($Juros,1,2),2);
			$E=bcadd($E,$cont,2);
		}
		$E= $E - $cont;
		$Valor = $Valor * $cont;
		return $Valor/$E;
	}
function Price2($Valor,$ValorResidual, $Parcelas, $Juros)
{
$Juros = bcdiv($Juros,100,15);
$E=1.0;
$cont=1.0;

for($k=1;$k<=$Parcelas;$k++)
{
$cont= bcmul($cont,bcadd($Juros,1,15),15);
$E=bcadd($E,$cont,15);
}
$E=bcsub($E,$cont,15);

$Valor = bcmul($Valor,$cont,15);

$Valor = $Valor-$ValorResidual;

return bcdiv($Valor,$E,15);
}

function calcula($idpropriedade,$pcodigo,$a,$m,$conn)
 {
 		if ($pcodigo=='1.37')
		{
			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo = 1 "; 
			$restotal = pg_exec($conn,$sqltotal);
			$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='2.1.5')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
			             and ano=".$a." and mes=".$m." and idgrupo = 2 and idsubgrupo = 2 "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='2.4')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
             and ano=".$a." and mes=".$m." and idgrupo = 2 "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='3')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
		             and ano=".$a." and mes=".$m." and idgrupo in (1,2) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='4.4')
		{
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (4) and idsubgrupo in (7) and lancamento.idcategoria in (55,56,57) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='4.5.5')
		{
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (4) and idsubgrupo in (8) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='4.9')
		{
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (4) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='5.4')
		{
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (69,70,71) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='5.5')
		{
			$v = ceil(calcula($idpropriedade,'5.4',$a,$m,$conn)/31);
     	    return $v;
		}
 		if ($pcodigo=='5.8')
		{
			$v54 = calcula($idpropriedade,'5.4',$a,$m,$conn);
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (373,374) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $v54 + $rowtotal[0];
		}
 		if ($pcodigo=='5.9')
		{
			$v = ceil(calcula($idpropriedade,'5.8',$a,$m,$conn)/31);
     	    return $v;
		}
 		if ($pcodigo=='5.12')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v510 = $rowtotal[0];

		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (378) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v511 = $rowtotal[0];
			$v = 0;
			if (($v510+$v511)>0)
			{
				$v = $v510/(($v510+$v511)/100);
			}
			return $v;
		}
 		if ($pcodigo=='5.13')
		{
			$v111 = calcula($idpropriedade,'5.28',$a,$m,$conn);
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
			if ($v111>0)
			{
     	    	return round($rowtotal[0]/$v111);
			}
			else
			{
				return 0;
			}
		}

 		if ($pcodigo=='5.14')
		{
			$v59 = calcula($idpropriedade,'5.9',$a,$m,$conn);
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
			if ($rowtotal[0]>0)
			{
     	    	return $v59/$rowtotal[0];
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='5.15')
		{
			$v59 = calcula($idpropriedade,'5.9',$a,$m,$conn);
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (377,378) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
			if ($rowtotal[0]>0)
			{
     	    	return $v59/$rowtotal[0];
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='5.19')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (377,378) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
			$v1 = $rowtotal[0]; 
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (377,378,383,384,385) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
			$v2 = $rowtotal[0]; 
			
			if ($v2>0)
			{
     	    	return ($v1/$v2)*100;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='5.20')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
			$v1 = $rowtotal[0]; 
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (377,378,383,384,385) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
			$v2 = $rowtotal[0]; 
			
			if ($v2>0)
			{
     	    	return ($v1/$v2)*100;
			}
			else
			{
				return 0;
			}
		}

 		if ($pcodigo=='5.22')
		{
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (388) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
			if ($rowtotal[0]>0)
			{
     	    	return round(($v58/$rowtotal[0])/31);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='5.23')
		{
			$v455 = calcula($idpropriedade,'4.5.5',$a,$m,$conn);
			$v64 = calcula($idpropriedade,'6.4',$a,$m,$conn);
			if ($v64>0)
			{
				return round(($v455/$v64));
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='5.24')
		{
			$v1 = calcula($idpropriedade,'5.8',$a,$m,$conn);
			$v2 = calcula($idpropriedade,'5.28',$a,$m,$conn);
			if ($v2>0)
			{
				return ($v1/$v2);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='5.25')
		{
			$v1 = calcula($idpropriedade,'5.8',$a,$m,$conn);
			$v2 = calcula($idpropriedade,'5.23',$a,$m,$conn);
			$v3 = calcula($idpropriedade,'5.28',$a,$m,$conn);
			if ($v3>0) 
			{
				return ($v1+$v2)/$v3;
			}
			else
			{
				return 0;
			}
		}


 		if ($pcodigo=='5.27')
		{
		  	$sqltotal = "select quantidade from terra where idpropriedade = ".$idpropriedade." and ano=".$a; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $rowtotal[0];
		}
 		if ($pcodigo=='5.28')
		{
			$v527 = calcula($idpropriedade,'5.27',$a,$m,$conn);
				  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and idgrupo in (5) and lancamento.idcategoria in (394) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    return $v527 + $rowtotal[0];
		}
 		if ($pcodigo==='6.1')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (55) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v41 = $rowtotal[0];
			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and  lancamento.idcategoria in (69) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v51 = $rowtotal[0];
			if ($v51>0) 
			{
				return ($v41/$v51);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='6.2')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (56) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v42 = $rowtotal[0];
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (70) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v52 = $rowtotal[0];
			if ($v52>0) 
			{
				return $v42/$v52;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='6.3')
		{
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (57) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v43 = $rowtotal[0];
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (71) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v53 = $rowtotal[0];
			if ($v53>0) 
			{
				return $v43/$v53;
			}
			else
			{
				return 0;
			}
		}

 		if ($pcodigo=='6.4')
		{
			$v44 = calcula($idpropriedade,'4.4',$a,$m,$conn);
			$v54 = calcula($idpropriedade,'5.4',$a,$m,$conn);
			if ($v54>0)
			{
				return $v44/$v54;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='6.5')
		{
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
			return $v49 - $v3;
		}
 		if ($pcodigo=='6.6')
		{
			$v65 = calcula($idpropriedade,'6.5',$a,$m,$conn);
			$v528 = calcula($idpropriedade,'5.28',$a,$m,$conn);
			if ($v528>0)
			{
				return $v65/$v528;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='6.7')
		{
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v510 = $rowtotal[0];

		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (378) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v511 = $rowtotal[0];
			$v = 0;
			if (($v510+$v511)>0)
			{
				
				$v = ($v49/($v510+$v511))/30;
			}
			return $v;
		}
 		if ($pcodigo=='6.9')
		{
		  	$sqltotal = "select * from maquina where idpropriedade = ".$idpropriedade." and ano=".$a; 
		  	$restotal = pg_exec($conn,$sqltotal);
	  		$valor = 0;
			while ($rowtotal = pg_fetch_array($restotal))
			{
				calculo('4',6,1,$rowtotal['valor'],$rowtotal['vidautil'],$rowtotal['valor'],$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$valor = $valor + $remuneracaoanual;
			}

//     	    return $rowtotal[0]/12;
			return ($valor/12);
		}
 		if ($pcodigo=='6.10')
		{
		  	$sqltotal = "select * from instalacao where idpropriedade = ".$idpropriedade." and ano=".$a; 
		  	$restotal = pg_exec($conn,$sqltotal);
	  		$valor = 0;
			while ($rowtotal = pg_fetch_array($restotal))
			{
				calculo('4',6,1,$rowtotal['valor'],$rowtotal['vidautil'],$rowtotal['valor'],$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$valor = $valor + $remuneracaoanual;
			}
			
// 			function calculo($tipocapital,$juros,$quantidade,$valorunitario,$vidautil,&$valortotal,&$valorresidual,&$remuneracaoanual,&$remuneracaomensal)
//			calculo('4',6,1,$row['valor'],$row['vidautil'],$row['valor'],$valorresidual,$remuneracaoanual,$remuneracaomensal);
			
//     	    return $rowtotal[0]/12;
			return ($valor/12);
		}
 		if ($pcodigo=='6.11')
		{
		  	$sqltotal = "select * from animal where idpropriedade = ".$idpropriedade." and ano=".$a; 
		  	$restotal = pg_exec($conn,$sqltotal);
			$valor = 0;
			while ($rowtotal = pg_fetch_array($restotal))
			{
				 calculo('2',6,$rowtotal['quantidade'],$rowtotal['valorindividual'],1,$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$valor = $valor + $remuneracaoanual;
			}
//     	    return $rowtotal[0]/12;
			return ($valor/12);
		}
 		if ($pcodigo=='6.12')
		{
		  	$sqltotal = "select * from terra where idpropriedade = ".$idpropriedade." and ano=".$a; 
		  	//echo $sqltotal;
			$restotal = pg_exec($conn,$sqltotal);
		  	$valor = 0;
			while ($rowtotal = pg_fetch_array($restotal))
			{
				 calculo('1',6,$rowtotal['quantidade'],$rowtotal['valorunitario'],1,$valortotal,$valorresidual,$remuneracaoanual,$remuneracaomensal);
				$valor = $valor + $remuneracaoanual;
			}
//     	    return $rowtotal[0]/12;
			return ($valor/12);
		}
 		if ($pcodigo==='6.16')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
		  	if ($v49>0)
			{
				return ($v137/$v49)*100;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='6.17')
		{
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
		  	if ($v49>0)
			{
				return ($v3/$v49)*100;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.1')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
		  	if ($v58>0)
			{
				return ($v137/$v58);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.2')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
			$v523 = calcula($idpropriedade,'5.23',$a,$m,$conn);
		  	if (($v58+$v523)>0)
			{
				return ($v137/($v58+$v523));
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='7.3')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v510 = $rowtotal[0];

		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (378) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v511 = $rowtotal[0];
			$v = 0;
			if (($v510+$v511)>0)
			{
				
				$v = $v137/($v510+$v511);
			}
			return $v;
		}
 		if ($pcodigo==='7.4')
		{
			$v73 = calcula($idpropriedade,'7.3',$a,$m,$conn);
			$v64 = calcula($idpropriedade,'6.4',$a,$m,$conn);
		  	if ($v64>0)
			{
				return ($v73/$v64);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.5')
		{
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
		  	if ($v58>0)
			{
				return ($v3/$v58);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.6')
		{
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
			$v523 = calcula($idpropriedade,'5.23',$a,$m,$conn);
		  	if (($v58+$v523)>0)
			{
				return ($v3/($v58+$v523));
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.7')
		{
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v510 = $rowtotal[0];

		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (378) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v511 = $rowtotal[0];
		  	if (($v511+$v510)>0)
			{
				return ($v3/($v510+$v511));
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.8')
		{
			$v77 = calcula($idpropriedade,'7.7',$a,$m,$conn);
			$v64 = calcula($idpropriedade,'6.4',$a,$m,$conn);
		  	if ($v64>0)
			{
				return ($v77/$v64);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.9')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v69 = calcula($idpropriedade,'6.9',$a,$m,$conn);
		  	$v610 = calcula($idpropriedade,'6.10',$a,$m,$conn);
		  	$v611 = calcula($idpropriedade,'6.11',$a,$m,$conn);
		  	$v612 = calcula($idpropriedade,'6.12',$a,$m,$conn);
		  	$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
		  	if ($v58>0)
			{
				return (($v137+$v69+$v610+$v611+$v612)/$v58);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.10')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v69 = calcula($idpropriedade,'6.9',$a,$m,$conn);
		  	$v610 = calcula($idpropriedade,'6.10',$a,$m,$conn);
		  	$v611 = calcula($idpropriedade,'6.11',$a,$m,$conn);
		  	$v612 = calcula($idpropriedade,'6.12',$a,$m,$conn);
		  	$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
		  	$v523 = calcula($idpropriedade,'5.23',$a,$m,$conn);
		  	if (($v58+$v523)>0)
			{
				return (($v137+$v69+$v610+$v611+$v612)/($v58+$v523));
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.11')
		{
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
		  	return $v49-$v137;
		}
 		if ($pcodigo==='7.12')
		{
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v528 = calcula($idpropriedade,'5.28',$a,$m,$conn);
		  	if (($v528)>0)
			{
				return (($v49-$v137)/$v528);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.13')
		{
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v69 = calcula($idpropriedade,'6,9',$a,$m,$conn);
			$v610 = calcula($idpropriedade,'6.10',$a,$m,$conn);
			$v611 = calcula($idpropriedade,'6.11',$a,$m,$conn);
			$v612 = calcula($idpropriedade,'6.12',$a,$m,$conn);
		  	return $v49-$v137-$v69-$v610-$v611-$v612;
		}
 		if ($pcodigo==='7.14')
		{
			$v713 = calcula($idpropriedade,'7.13',$a,$m,$conn);
			$v528 = calcula($idpropriedade,'5.28',$a,$m,$conn);
		  	if (($v528)>0)
			{
				return ($v713)/$v528;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.15')
		{
			$v713 = calcula($idpropriedade,'7.13',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
		  	if (($v58)>0)
			{
				return ($v713)/$v58;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.16')
		{
			$v713 = calcula($idpropriedade,'7.13',$a,$m,$conn);
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v510 = $rowtotal[0];

		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (378) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v511 = $rowtotal[0];
		  	if (($v511+$v510)>0)
			{
				return ($v713/($v510+$v511))/31;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='7.17')
		{
			$v716 = calcula($idpropriedade,'7.16',$a,$m,$conn);
			$v64 = calcula($idpropriedade,'6.4',$a,$m,$conn);
		  	if (($v64)>0)
			{
				return ($v716)/$v64;
			}
			else
			{
				return 0;
			}
		}

 		if ($pcodigo==='8.2')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v81 = $rowtotal[0];
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
		  	if ($v58>0)
			{
				return (($v137+$v81)/$v58);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='8.3')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn); // h42
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
			$v523 = calcula($idpropriedade,'5.23',$a,$m,$conn);
		  	
			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v81 = $rowtotal[0];
		  	
			
			if (($v58+$v523)>0)
			{
				return (($v137+$v81)/($v58+$v523));
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo=='8.4')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn); //H42
			$v81 = calcula($idpropriedade,'8.1',$a,$m,$conn); 
			$v510 = calcula($idpropriedade,'5.10',$a,$m,$conn); 
			$v511 = calcula($idpropriedade,'5.11',$a,$m,$conn); 

			$v = 0;
			if (($v510+$v511)>0)
			{
				
				$v = ($v137+$v81)/($v510+$v511);
			}
			return $v;
		}
		if ($pcodigo==='8.5')
		{
			$v84 = calcula($idpropriedade,'8.4',$a,$m,$conn);
			$v64 = calcula($idpropriedade,'6.4',$a,$m,$conn);
		  	if (($v64)>0)
			{
				return ($v84)/$v64;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='8.6')
		{
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v81 = $rowtotal[0];
			

		  	if ($v58>0)
			{
				return (($v3+$v81)/$v58);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='8.7')
		{
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
			$v523 = calcula($idpropriedade,'5.23',$a,$m,$conn);

			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v81 = $rowtotal[0];



		  	if (($v58+$v523)>0)
			{
				return (($v3+$v81)/($v58+$v523));
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='8.8')
		{
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
			$v81 = calcula($idpropriedade,'8.1',$a,$m,$conn);
			$v510 = calcula($idpropriedade,'5.10',$a,$m,$conn);
			$v511 = calcula($idpropriedade,'5.11',$a,$m,$conn);
		  	
		  	if (($v511+$v510)>0)
			{
				return (($v3+$v81)/($v510+$v511));
			}
			else
			{
				return 0;
			}
		}
		if ($pcodigo==='8.9')
		{
			$v3 = calcula($idpropriedade,'3',$a,$m,$conn);
			$v81 = calcula($idpropriedade,'8.1',$a,$m,$conn);
			$v510 = calcula($idpropriedade,'5.10',$a,$m,$conn);
			$v511 = calcula($idpropriedade,'5.11',$a,$m,$conn);
			$v64 = calcula($idpropriedade,'6.4',$a,$m,$conn);
			
		  	if (($v64>0) && (($v510+$v511)>0))
			{
				return (($v3+$v81)/($v510+$v511))/$v64;
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='8.10')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v69 = calcula($idpropriedade,'6.9',$a,$m,$conn);
		  	$v610 = calcula($idpropriedade,'6.10',$a,$m,$conn);
		  	$v611 = calcula($idpropriedade,'6.11',$a,$m,$conn);
		  	$v612 = calcula($idpropriedade,'6.12',$a,$m,$conn);
		  	$v81 = calcula($idpropriedade,'8.1',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
		  	if ($v58>0)
			{
				return (($v137+$v69+$v610+$v611+$v612+$v81)/$v58);
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='8.11')
		{
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v69 = calcula($idpropriedade,'6.9',$a,$m,$conn);
		  	$v610 = calcula($idpropriedade,'6.10',$a,$m,$conn);
		  	$v611 = calcula($idpropriedade,'6.11',$a,$m,$conn);
		  	$v612 = calcula($idpropriedade,'6.12',$a,$m,$conn);
		  	$v81 = calcula($idpropriedade,'8.1',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);
		  	$v523 = calcula($idpropriedade,'5.23',$a,$m,$conn);

		  	if (($v58+$v523)>0)
			{
				return (($v137+$v69+$v610+$v611+$v612+$v81)/($v58+$v523));
			}
			else
			{
				return 0;
			}
		}
 		if ($pcodigo==='8.12')
		{
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v81 = calcula($idpropriedade,'8.1',$a,$m,$conn);
			return $v49-($v137-$v81);
		}
		if ($pcodigo==='8.13')
		{
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v528 = calcula($idpropriedade,'5.28',$a,$m,$conn);
			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v81 = $rowtotal[0];
			
		  	if (($v528)>0)
			{
				return (($v49-($v137+$v81))/$v528);
			}
			else
			{
				return 0;
			}
		}		
		if ($pcodigo==='8.14')
		{
			$v49 = calcula($idpropriedade,'4.9',$a,$m,$conn);
			$v137 = calcula($idpropriedade,'1.37',$a,$m,$conn);
			$v69 = calcula($idpropriedade,'6,9',$a,$m,$conn);
			$v610 = calcula($idpropriedade,'6.10',$a,$m,$conn);
			$v611 = calcula($idpropriedade,'6.11',$a,$m,$conn);
			$v612 = calcula($idpropriedade,'6.12',$a,$m,$conn);
			
			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v81 = $rowtotal[0];
			
		  	return $v49-($v137+$v81)-$v69-$v610-$v611-$v612;
		}
		if ($pcodigo==='8.15')
		{
			$v814 = calcula($idpropriedade,'8.14',$a,$m,$conn);
			$v528 = calcula($idpropriedade,'5.28',$a,$m,$conn);
		  	if (($v528)>0)
			{
				return ($v814)/$v528;
			}
			else
			{
				return 0;
			}
		}
		if ($pcodigo==='8.16')
		{
			$v713 = calcula($idpropriedade,'7.13',$a,$m,$conn);
			$v58 = calcula($idpropriedade,'5.8',$a,$m,$conn);

			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v81 = $rowtotal[0];

		  	if (($v58)>0)
			{
				return ($v713-$v81)/$v58;
			}
			else
			{
				return 0;
			}
		}
		if ($pcodigo==='8.17')
		{
			$v713 = calcula($idpropriedade,'7.13',$a,$m,$conn);
		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v510 = $rowtotal[0];

		  	$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (378) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v511 = $rowtotal[0];

			$sqltotal = "select sum(valor) from lancamento,categoria where lancamento.idcategoria=categoria.idcategoria and lancamento.idpropriedade=".$idpropriedade." 
					             and ano=".$a." and mes=".$m." and lancamento.idcategoria in (377) "; 
		  	$restotal = pg_exec($conn,$sqltotal);
		  	$rowtotal = pg_fetch_array($restotal);
     	    $v81 = $rowtotal[0];
			
		  	if (($v511+$v510)>0)
			{
				return (($v713-$v81)/($v510+$v511))/31;
			}
			else
			{
				return 0;
			}
		}//		=C93/(C93+C94)*100
		if ($pcodigo==='8.18')
		{
			$v817 = calcula($idpropriedade,'8.17',$a,$m,$conn);
			$v64 = calcula($idpropriedade,'6.4',$a,$m,$conn);
		  	if (($v64)>0)
			{
				return ($v817)/$v64;
			}
			else
			{
				return 0;
			}
		}
		
 }	  
	  
	  $FORM_ACTION = 'planilha';
	  $tipofiltro = $_REQUEST['cmboxtipofiltro'];
	  $ordenapor = $_REQUEST['cmboxordenar'];
	  $financeiro = false;
	  if ($_REQUEST['FINANC']=='T')
	  {
		  $financeiro = true;
	  }
	  
	  if (empty($tipofiltro))
	  {
		  $tipofiltro = 'NOME';
	  }
	  
	  $ano = $_REQUEST['cmboxano'];
	  $idprodutor = $_REQUEST['cmboxprodutor'];
	  $idpropriedade = $_REQUEST['cmboxpropriedade'];
	  $idtecnico = $_SESSION['s_idtecnico'];
	  if ( (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
		|| (in_array('AUDITOR',$_SESSION['s_papel']))
		|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
		)
	  {
		  $idtecnico = $_REQUEST['cmboxtecnico'];
	  }
	  
	
	  
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Programa = new Programa();
$Programa->conn = $conn;

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

if (isset($_REQUEST['cmboxano']))
	{
		$ano = $_REQUEST['cmboxano'];
	}
	else
	{
		$ano = date('Y');
	}

//echo $sql;
$sql = '';
    
?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Balde Cheio</title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir todos o(s) registros(s)? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>

                               


    <div class="container body">


        <div class="main_container">

           
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    
					<?php require "menu.php";?>
                </div>
            </div>

            <!-- top navigation -->
			<?php require "menutop.php";?>


            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="clearfix"></div>

                    <div class="row">
						<form name="frm" id="frm" method="post" class="form-horizontal form-label-left">
					 <div class="x_panel">
                        <div class="x_title">
                            <h2>Filtros <small>Utilize os filtros abaixo para realizar a consulta </small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="row">

                                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
									<select name="cmboxano" id="cmboxano" class="form-control" onChange="submit()">
									<?php 
									
									for ($c=2003;$c<=date('Y');$c++)
									{?>
									<option value="<?php echo $c;?>" <?php if ($c==$ano) echo "selected";?>><?php echo $c;?></option>
									<?php } ?>
									</select>
									
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'S',$idtecnico,'class="form-control"','');?>
                                </div>
								<div class="col-md-5 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,$idprodutor,'S','','class="form-control"');?>
                                </div>
                               <div class="col-md-1 col-sm-12 col-xs-12 form-group">
										
                                     <button type="button" class="btn btn-success" onClick='filterApply()'>Filtrar</button>
								</div>
							</div>
                        </div>
                    </div>
					
					
					
                        
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Planilha <small>Planilha de custos</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                                                            <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                Ação
                                <span class="caret"></span>
                            </a>
                                        <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                            <?php if (!$financeiro)
											{
												if ((in_array('ADMINISTRADOR',$_SESSION['s_papel']))
												|| (in_array('AUDITOR',$_SESSION['s_papel']))
												|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
												)
												{
												
												?>
											<!--<li role="presentation"><a role="menuitem" tabindex="-1" href="https://twitter.com/fat">Novo</a>
                                            </li>
                                           <li role="presentation"><a role="menuitem" tabindex="-1" onClick='showExcluir()'>Excluir</a>
                                            </li>-->
												<?php }
											
											} ?>
 											<?php if ($financeiro)
											{
												if (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
												{
												?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="lancarPagamento()">Lançar Pagamentos</a>
                                            </li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="estornarPagamento()">Estornar Pagamentos</a>
                                            </li>
											<?php }
												if (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
												{
												?>

                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="relPagamentosPeriodo('xls')">Pagamentos no período</a>
                                            </li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="relPagamentosPeriodo('pdf')">Pagamentos no período</a>
                                            </li>
											

											
												<?php }
												} ?>
                                        </ul>
                                    </li>
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
<div id='div_valoralterado'></div>
                                <div class="x_content">
								<div style="overflow:auto;"> 
								<div class="table-responsive"> 
								<table class="table table-hover">
								<thead>
								<tr>
				<?php 
	
	$mes = date(n);
	
	$m = array();
	$a = array();
	$nomemes = array();
		for ($d=4;$d<=15;$d++)
		{
			$m[$d] = $d-3;
			$a[$d] = $ano;
			if (($d-3)>$mes)
			{
				$nomemes[$d]=($d-3).'/'.($ano-1);
				$a[$d] = ($ano-1);
			}
			else
			{
				$nomemes[$d]=($d-3).'/'.$ano;
				$a[$d] = $ano;
			}
		}
	for ($c=1;$c<=15;$c++)
	{
	?>
	<th><?php echo $nomemes[$c];?></th>
	<?php
	}
	?>
		<th><?php echo '%';?></th>
		<th><?php echo 'Total';?></th>
		
		</tr></thead>
	<?php
	$sqlcategoria = 'select * from categoria ,unidade where categoria.idunidade = unidade.idunidade order by substring(codigo,1,1),idcategoria';  
	$rescategoria = pg_exec($conn,$sqlcategoria);
	$contaelemento = 0;

	while ($rowcategoria = pg_fetch_array($rescategoria))
	{
	   if ($rowcategoria['codigo']==='1.1')
	   {
	   		echo '<tr><td colspan="17">1. Despesas com Custeio</td></tr>';
	   }
	   if ($rowcategoria['codigo']==='2.1.1')
	   {
	   		echo '<tr ><td colspan=17>2. Despesas com Investimentos</td></tr>';
	   }
	   if ($rowcategoria['codigo']==='3')
	   {
	   		echo '<tr ><td colspan=17>3. Despesas com o Sistema</td></tr>';
	   }
	   if ($rowcategoria['codigo']==='4.1')
	   {
	   		echo '<tr ><td colspan=17>4. Receitas</td></tr>';
	   }
	   if ($rowcategoria['codigo']==='5.1')
	   {
	   		echo '<tr ><td colspan=17>5. Resultados Zootécnicos</td></tr>';
	   }
	   if ($rowcategoria['codigo']==='6.1')
	   {
	   		echo '<tr class="tab_bg_1"><td colspan=17>6 Resultados Econômicos</td></tr>';
	   }
	   if ($rowcategoria['codigo']==='7.1')
	   {
	   		echo '<tr ><td colspan=17>7 Resultados Econômicos (sem remuneração do proprietário)</td></tr>';
	   }
	   if ($rowcategoria['codigo']==='8.1')
	   {
	   		echo '<tr ><td colspan=17>8 Resultados Econômicos (com remuneração do proprietário)</td></tr>';
	   }
	
	if (!empty($idpropriedade))
	{
	?>
	
	<tr bgcolor="<?php if (($rowcategoria['tipo']=='C') || ($rowcategoria['tipo']=='T')) echo "#66CCFF";?>">
	<?php 
	for ($c=1;$c<=15;$c++)
	{
		$contaelemento++;
	?>
	<td align="<?php if ($c>3) {echo 'right';} else {echo "left";};?>">
		<?php if ($c==1) echo $rowcategoria['codigo'];
			  if ($c==2) echo $rowcategoria['categoria'];
			  if ($c==3) echo $rowcategoria['unidade'];
			  if ($c>=4)
			  {
				  $sqllancamento = 'select * from lancamento where idcategoria = '.$rowcategoria['idcategoria'].' and idpropriedade='.$idpropriedade.' and ano='.$a[$c].' and mes='.$m[$c];
				  $reslancamento = pg_exec($conn,$sqllancamento);
				  $rowlancamento = pg_fetch_array($reslancamento);
				  if (!empty($rowlancamento))
				  {
					  $v = $rowlancamento['valor'];
				  	  //echo number_format($rowlancamento['valor'],2,',','.');
				  	  echo '<input id="edt'.$contaelemento.'" type=text size = "5" value='.number_format($v,2,',','.').' onblur="alterarValorPlanilha(\''.$rowcategoria['codigo'].'\',this.id,'.$rowlancamento['idpropriedade'].','.$rowlancamento['mes'].','.$rowlancamento['ano'].','.$rowlancamento['idcategoria'].',this.value)">';
					  $TOTAL_ = $TOTAL_ + $v;
				  }
				  else
				  {
					  if (($rowcategoria['tipo']<>'T') && ($rowcategoria['tipo']<>'C'))
					  {
						echo '<input id="edt'.$contaelemento.'" type="text" size = "5" value="" onblur="alterarValorPlanilha(\''.$rowcategoria['codigo'].'\',this.id,'.$idpropriedade.','.$m[$c].','.$a[$c].','.$rowcategoria['idcategoria'].',this.value)">';
					  }
				  	//echo $m[$c].'/'.$a[$c].'/'.$rowcategoria['idcategoria'];
				  }

				  // calculo dos total
				  if ($rowcategoria['codigo']=='1.37')
				  {
					  $v = calcula($idpropriedade,'1.37',$a[$c],$m[$c],$conn);
//				  	echo number_format(calcula($idpropriedade,'1.37',$a[$c],$m[$c],$conn),2,',','.');;
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
					
				  }

				  // calculo dos total
				  if ($rowcategoria['codigo']=='2.1.5')
				  {
  				    $v = calcula($idpropriedade,'2.1.5',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
					
//				  	echo number_format(calcula($idpropriedade,'2.1.5',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  // calculo dos total
				  if ($rowcategoria['codigo']=='2.4')
				  {
					$v = calcula($idpropriedade,'2.4',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//				  	echo number_format(calcula($idpropriedade,'2.4',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']=='3')
				  {
					$v = calcula($idpropriedade,'3',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//					echo number_format(calcula($idpropriedade,'3',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']=='4.4')
				  {
					$v = calcula($idpropriedade,'4.4',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//				  	echo number_format(calcula($idpropriedade,'4.4',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']=='4.5.5')
				  {
					$v = calcula($idpropriedade,'4.5.5',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
				  	//echo number_format(calcula($idpropriedade,'4.5.5',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='4.9')
				  {
					$v = calcula($idpropriedade,'4.9',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//  				  	echo number_format(calcula($idpropriedade,'4.9',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']=='5.4')
				  {
  				  	$v = calcula($idpropriedade,'5.4',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//					echo number_format(calcula($idpropriedade,'5.4',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				   if ($rowcategoria['codigo']=='5.5')
				  {
					$v = calcula($idpropriedade,'5.5',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
 // 				  	echo number_format(calcula($idpropriedade,'5.5',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']=='5.8')
				  {
					$v = calcula($idpropriedade,'5.8',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//  				  	echo number_format(calcula($idpropriedade,'5.8',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']=='5.9')
				  {
   				    $v = calcula($idpropriedade,'5.9',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
  				  	//echo number_format(calcula($idpropriedade,'5.9',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  
				  if ($rowcategoria['codigo']=='5.12')
				  {
				    $v = calcula($idpropriedade,'5.12',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//  				  	echo number_format(calcula($idpropriedade,'5.12',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']=='5.13')
				  {
				    $v = calcula($idpropriedade,'5.13',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//  				  	echo number_format(calcula($idpropriedade,'5.13',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']=='5.14')
				  {
				    $v = calcula($idpropriedade,'5.14',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//  				  	echo number_format(calcula($idpropriedade,'5.14',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='5.15')
				  {
				    $v = calcula($idpropriedade,'5.15',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//  				  	echo number_format(calcula($idpropriedade,'5.15',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='5.19')
				  {
				    $v = calcula($idpropriedade,'5.19',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
//  				  	echo number_format(calcula($idpropriedade,'5.19',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='5.20')
				  {
				    $v = calcula($idpropriedade,'5.20',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
					  
//  				  	echo number_format(calcula($idpropriedade,'5.20',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='5.22')
				  {
				    $v = calcula($idpropriedade,'5.22',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
  				  //	echo number_format(calcula($idpropriedade,'5.22',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='5.23')
				  {
				    $v = calcula($idpropriedade,'5.23',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
  				  	//echo number_format(calcula($idpropriedade,'5.23',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='5.24')
				  {
				    $v = calcula($idpropriedade,'5.24',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
  				  	//echo number_format(calcula($idpropriedade,'5.24',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='5.25')
				  {
				    $v = calcula($idpropriedade,'5.25',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
  				  	//echo number_format(calcula($idpropriedade,'5.25',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='5.27')
				  {
				    $v = calcula($idpropriedade,'5.27',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
  				  	//echo number_format(calcula($idpropriedade,'5.27',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='5.28')
				  {
				    $v = calcula($idpropriedade,'5.28',$a[$c],$m[$c],$conn);
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
  				  	//echo number_format(calcula($idpropriedade,'5.28',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.1')
				  {
//  				  	echo number_format(calcula($idpropriedade,'6.1',$a[$c],$m[$c],$conn),2,',','.');;
  				  	echo number_format(calcula($idpropriedade,'6.1',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='6.2')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.2',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='6.3')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.3',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='6.4')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.4',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='6.5')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.5',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='6.6')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.6',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='6.7')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='6.8')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']=='6.9')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.9',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.10')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.10',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.11')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.11',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.12')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.12',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.13')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.14')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.15')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.16')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.16',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.17')
				  {
  				  	echo number_format(calcula($idpropriedade,'6.17',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.18')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='6.19')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']==='7.1')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.1',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.2')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.2',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.3')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.3',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.4')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.4',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.5')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.5',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.6')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.6',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.7')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.8')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.8',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.9')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.9',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.10')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.10',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.11')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.11',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.12')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.12',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.13')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.13',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.14')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.14',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.15')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.15',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.16')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.16',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.17')
				  {
  				  	echo number_format(calcula($idpropriedade,'7.17',$a[$c],$m[$c],$conn),2,',','.');;
				  }

				  if ($rowcategoria['codigo']==='7.18')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.19')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.20')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.21')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='7.22')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }


				  if ($rowcategoria['codigo']==='8.2')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.2',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.3')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.3',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.4')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.4',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.5')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.5',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.6')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.6',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.7')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.8')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.8',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.9')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.9',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.10')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.10',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.11')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.11',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.12')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.12',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.13')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.13',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.14')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.14',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.15')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.15',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.16')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.16',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.17')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.17',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.18')
				  {
  				  	echo number_format(calcula($idpropriedade,'8.18',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.19')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.20')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.21')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.22')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
				  if ($rowcategoria['codigo']==='8.23')
				  {
  				  	echo '--';//number_format(calcula($idpropriedade,'6.7',$a[$c],$m[$c],$conn),2,',','.');;
				  }
			  }
	//echo $c;?>
	</td>

	<?php
	}
	?>
		<td>
<!--		 $v = calcula($idpropriedade,'1.37',$a[$c],$m[$c],$conn);
//				  	echo number_format(calcula($idpropriedade,'1.37',$a[$c],$m[$c],$conn),2,',','.');;
				  	echo number_format($v,2,',','.');
					$TOTAL_ = $TOTAL_ + $v;
-->
		<!--
		Aqui preciso pegar o valor do total do item consultado;
		-->
		<?php 
		
		$TOTAL__=0;
		$grupo = substr($rowcategoria['codigo'],0,1);
		
		for ($d=4;$d<15;$d++)
		{
			if ($grupo=='1')
			{
				$codigo_ = '1.37';
			}
			if ($grupo=='2')
			{
				$codigo_ = '2.4';
			}
			if ($grupo=='3')
			{
				$codigo_ = '3';
			}
			if ($grupo=='4')
			{
				$codigo_ = '4.9';
			}
			
			if ($grupo<5)
			{
				$v = calcula($idpropriedade,$codigo_,$a[$d],$m[$d],$conn);
				$TOTAL__ = $TOTAL__ + $v;
			}
			else
			{
				$TOTAL__ = '';
			}
		}
		echo number_format((@($TOTAL_/$TOTAL__)*100),1,',','.');
		?>
		</td><td>
		<?php 
		echo number_format($TOTAL_,2,',','.');
		$TOTAL_ = 0;
		?></td></tr>
	<?php 
	} // FIM IF IDPROPRIEDADE
	
	} // fim do while categoria 
	
	?>
	</table>
	</div>
	</div>

                                    
                              </div>
								
                            </div>
                       
                    </div>
</form>
                </div>

                <!-- footer content -->
                <footer>
                    <div class="">
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>

    <script src="js/custom.js"></script>
	
	<!-- daterangepicker -->
    <script type="text/javascript" src="js/moment.min2.js"></script>
    <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
    
  <!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>		
	
	
	
	 <script type="text/javascript">
	   $(document).ready(function () {
            $('#reservation').daterangepicker(null, function (start, end, label) {
                //console.log(start, end, label);
//				start = now()
				alert(start);
				alert(end);
				console.log(start,end,label);
            });
        });
       
	var permanotice, tooltip, _alert;
	
	function criarNotificacao(titulo,texto,tipo)
	{
            new PNotify({
                title: titulo,
                type: tipo,
                text: texto,
                nonblock: {
                    nonblock: true
                },
                before_close: function (PNotify) {
                    // You can access the notice's options with this. It is read only.
                    //PNotify.options.text;

                    // You can change the notice's options after the timer like this:
                    PNotify.update({
                        title: PNotify.options.title + " - Enjoy your Stay",
                        before_close: null
                    });
                    PNotify.queueRemove();
                    return false;
                }
            });

        
	};	   
	   
	   
	function alterarValorPlanilha(categoria,idelemento,idpropriedade,mes,ano,idcategoria,valor)
	{
		//alert('Aqui');
		
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("div_valoralterado").innerHTML = 'Alterado';//xhttp.responseText;
			criarNotificacao('Sucesso','Categoria: '+categoria+' - mes/ano: '+mes+'/'+ano+' - valor: '+valor,'success');
			//document.getElementById(idelemento).='red';
//			document.getElementById("div_valoralterado").innerHTML = xhttp.responseText;
		}
		};
		xhttp.open("GET", "exec.alterarplanilha.php?idpropriedade="+idpropriedade+"&mes="+mes+"&ano="+ano+"&idcategoria="+idcategoria+"&valor="+valor, true);
		xhttp.send();
	}


	function filterApply()
	{
		document.getElementById('frm').target='_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
	}
	


	function imprimir(tipo)
	{
		alert(tipo);
	}


	
	function removeFilter()
	{
		window.location.href = 'cons<?php echo strtolower($FORM_ACTION);?>.php';
	}
	
	
	</script>

</body>

</html>