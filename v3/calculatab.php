<?php 
	/*
	orgaiza as tabs
	tab é um valor de 1 a 12
	
	as tabs são dividas em tres niveis: principal, secundario e terciario
	
	principal:
		tab de 1 a 3, arquivo cadexperimento
		
	secundario:
		tab 4 e 5, arquivo pretratamentotab (fazem parte da tab 1)
		tab 6 e 7, arquivo modelagemtab (fazem parte da tab 2)
		tab 8, arquivo posprocessamentotab (fazem parte da tab 3)
		
	terciario:
		tab 9 e 10, arquivo dadosbioticostab (fazem parte da tab 1 e 4)
		tab 11 e 12, arquivo dadosabioticostab (fazem parte da tab 1 e 5)
	
	$tab=$_REQUEST['tab'];
	
	if($tab == 4 || $tab == 5){
		$stab = $tab; $tab = 1;		
	}
	if($tab == 6 || $tab == 7){
		$stab = $tab; $tab = 2;		
	}
	if($tab == 8){
		$stab = $tab; $tab = 3;		
	}
	if($tab == 9 || $tab == 10){
		$ttab = $tab; $tab = 1; $stab = 4;	
	}
	if($tab == 11 || $tab == 12){
		$ttab = $tab; $tab = 1; $stab = 5;		
	}*/
 ?>