<?php session_start();
header('Content-Type: text/html; charset=utf-8');
// error_reporting(E_ALL);
// ini_set('display_errors','1');
//include('classes/configuracao.class.php');

class Testemunho
{
 
	var $conn;
   	public $codtestemunho;
	public $codcolbot;
	public $codtipocolecaobotanica;
	public $codbasedados;
	public $numtombo;
	public $sufixonumtombo;
	public $tombado;
	public $numtomboformatado;
	public $siglacolecao;
	public $determinacao;
	public $determinacaohospedeiro;
	public $determinacaoHTML;
	// UTILIZADA PARA EMISSãO DE ETIQUETA
	public $linhasuperior_html;
	public $linhaespecie_html;
	public $linhainfra_html;
	public $detpor;
	public $procedenciacompleta;
	public $observacaocompleta;
	public $todoscoletores;
	public $datacoletacompleta;
	public $projetoexpedicaocompleto;
	// FIM UTILIZACAO ETIQUETA
	public $cf;
	public $aff;
	public $confirmacao;
	public $codarvtaxon;
	public $codarvtaxonhospedeiro;
	public $determinador;
	public $determinadorhospedeiro;
	public $diadeterminacao;
	public $mesdeterminacao;
	public $anodeterminacao;
	public $codcategoriatypus;
	public $notasdeterminacao;	
	
////// DADOS COLETA
	public $coletor;
	public $numerocoleta;
	public $coletoresadicionais;
	public $projetoexpedicao;
	public $numcoletaprojeto;

	public $diacoleta;
	public $mescoleta;
	public $anocoleta;
	
	public $verificado;

	public $datacoleta; // CAMPO DATA JUNTO

	public $diacoletafinal;
	public $mescoletafinal;
	public $anocoletafinal;

	public $nomesvulgares;
	public $aux_nomevulg;
	public $estado_esporifero_iii;
	public $estado_esporifero_ii;
	public $estado_esporifero_i;
	public $estado_esporifero_0;

///////////////////////////////////////////////////////
///// DADOS COLETA EM CULTIVO
//////////////////////////////////////////////////////	
	
	public $coletaemcultivo;
	public $coletorcultivo;
	public $numcoleta_cultivo;

	public $datacoleta_cultivo; 
	
	public $diacoletacultivo ; 
	public $mescoletacultivo ;
	public $anocoletacultivo ;
	
//////////////////////////////////////////////////////	
		
	public $coddetacesso;
	public $coddeterminacao;

	public $pais;
	public $estadoprovincia;
	public $cidade;
	
	public $codusuario;
	
	//geo

	public $codtipoDC;
	
	public $sugest_latmin_grau;
	public $sugest_latmin_min;
	public $sugest_latmin_seg;
	public $sugest_lesteoeste;
	public $sugest_longmin_grau;
	public $sugest_longmin_min; 
	public $sugest_longmin_seg; 
	public $sugest_nortesul;	
	public $obs_revisao_geo;
	
	public $statusDC;

	public $codunidgeo;//; = $_REQUEST['cmboxunidadegeopolitica'];
	public $unidadegeopolitica;
	public $latgrau;// = $_REQUEST['edtlatgrau'];
	public $latmin;// = $_REQUEST['edtlatmin'];
	public $latseg;// = $_REQUEST['edtlatseg'];
	public $latns;// = $_REQUEST['edtlatns'];

	public $longgrau;// = $_REQUEST['edtlonggrau'];
	public $longmin;// = $_REQUEST['edtlongmin'];
	public $longseg;// = $_REQUEST['edtlongseg'];
	public $longlo;// = $_REQUEST['edtlonglo'];

	public $latgraumaxima;// = $_REQUEST['edtlatgraumaxima'];
	public $latminmaxima;// = $_REQUEST['edtlatminmaxima'];
	public $latsegmaxima;// = $_REQUEST['edtlatsegmaxima'];
	public $latnsmaxima;// = $_REQUEST['edtedtlatnsmaxima'];

	public $longgraumaxima;// = $_REQUEST['edtlonggraumaxima'];
	public $longminmaxima;// = $_REQUEST['edtlongminmaxima'];
	public $longsegmaxima;// = $_REQUEST['edtlongsegmaxima'];
	public $longlomaxima;// = $_REQUEST['edtlonglomaxima'];

	public $latitude;
	public $longitude;
	
	public $descricaolocal;
	public $unidadeconservacao; //	aux_uc
	public $codunidadeconservacao; //	coduc

	public $elevacaoprofundidade;
	public $elevacaoprofundidademaxima;
	public $unidademedidaelevacao;
	public $descricaoambiente;
	public $tipovegetacao;

///////////////////////////////////////////////////
//  
	public $desaparecido;
	public $altura;
	public $unidademedidaaltura;
	//unidademedidaaltura

	public $dap;
	public $fuste;
	public $descricaoindividuo;
	public $habitat;
	public $habito;
	
	public $usos;
	public $frequencia;
	public $luminosidade;	
	
///////////////////////////////////////////////////
//  Sobre o esp

	public $esteril;
	public $comflor;
	public $combotao;
	public $comflorpassada;
	public $comfruto;
	public $comfrutomaduro;
	public $comfrutoimaturo;
	public $comfrutopassado;
	public $siglacolecaoorigem;
	public $duplicata;
	public $quantidadeduplicata;
	public $especimeemcolecoescorrelatas;
	public $citacoesnabibliografia;
	public $dataprep;
	public $metodoprep;
	
/////////////////////////////////////////////////////////
//  comentario
	public $observacao;
/////////////////////////////////////////////////////////


//  INDIVIDUO VIVO

	public $secao;
	public $canteiro;
	public $plantadopor;
	public $diaplantio;
	public $mesplantio;
	public $anoplantio;
	public $plaqueado;
	public $plaquear;
	public $restaurarplaca;
	
	public $nomevulgarplaca; 
	public $distribuicaogeograficaplaca;
	public $latitudeplantio;
	public $longitudeplantio;
	
	public $homenagem;

		
// FIM INDIVIDUO VIVO	
	
	public $nomevulgar;
	public $procedencia;
	
	public $codigobarras;
	
	public $emprestado; // verifique se o testemunho estão emprestado. [true,false];

	
	///////////////////////////////////////////////////
	// variaveis para verificar se tem mais informações
	///////////////////////////////////////////////////
	public $emprestado_;
	public $colecaocorrelata_;
	public $historicodeterminacao_;
	
	//////////////////////////////////////////////////////////////////////////////////////////////
	// Atributos criados para receber se deseja ou não consultar as coleções
	// correlatas e o historico de determinação. Dessa forma, ganhando velocidade na consulta.
	// Rafael em 10/08/2015
	////////////////////////////////////////////////////////////////////////////////////////////
	public $cons_colecaocorrelata;
	public $cons_historicodeterminacao;

	//statusdigitacao
	
	public $statusdigitacao; // situacao da digitação para K, P, SOF
	public $datacomplementar;// = $datacomplementar;// = $_REQUEST['edtdatacomplementar'];
	public $missao;// = $missao;// = $_REQUEST['edtmissao'];
	public $historiaexsicata;//= $
	
	
	public $idcoletor;// USADO PARA A DIGITAÇÃO DO US PELA EQUIPE DO REFLORA;
	
	
/*	public $descricaoambiente;
	
	public $descricaoindividuo;
	
	public $dap;
	public $fuste;
	public $habitat;
	public $habito;
	
	public $usos;
	public $frequencia;
	public $luminosidade;	
	
	public $nomevulgar;
	public $procedencia;
	public $observacao;
	
	public $codigobarras;
	
	public $emprestado; // verifique se o testemunho estão mprestado. [true,false];
	
	public $desaparecido;
	
	
		public $descricaolocal;
	
	public $elevacaoprofundidade;
	public $elevacaoprofundidademaxima;

	
	///////////////////////////////////////////////////
	// variaveis para verificar se tem mais informações
	///////////////////////////////////////////////////
	public $emprestado_;
	public $colecaocorrelata_;
	public $historicodeterminacao_;
*/	
	public $this;
	
	
	function formata_data($dia=0,$mes=0,$ano=0,$tipo='A')
	{
	
		$Configuracao = new Configuracao();
		$Configuracao->conn = $this->conn;

		$this->Configuracao = $Configuracao;
		$this->Configuracao->getConfiguracao();
		
		$retira_interrogacao_datadeterminacao = $this->Configuracao->etiqueta_anodetermembranco;

		if (empty($retira_interrogacao_datadeterminacao))
		{
			$retira_interrogacao_datadeterminacao = 'f';
		}
//		echo $retira_interrogacao_datadeterminacao;
////		$etiqueta_anodetermembranco = 'f';
		
		// A - algarismos arabicos
		// R - algarismos romanos
		$resultado = '';
		if (empty($dia)){
			$dia = 0;
		}
		if (empty($mes)){
			$mes = 0;
		}
	
		if (empty($ano)){
			$ano = 0;
		}
		$mes_algromano = '';
		$romanos = array('??','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
		if ($mes==0)
		{
			$mes_algromano = '??';
		}
		if ($mes==1)
		{
			$mes_algromano = 'I';
		}
		if ($mes==2)
		{
			$mes_algromano = 'II';
		}
		if ($mes==3)
		{
			$mes_algromano = 'III';
		}
		if ($mes==4)
		{
			$mes_algromano = 'IV';
		}
		if ($mes==5)
		{
			$mes_algromano = 'V';
		}
		if ($mes==6)
		{
			$mes_algromano = 'VI';
		}
		if ($mes==7)
		{
			$mes_algromano = 'VII';
		}
		if ($mes==8)
		{
			$mes_algromano = 'VIII';
		}
		if ($mes==9)
		{
			$mes_algromano = 'IX';
		}
		if ($mes==10)
		{
			$mes_algromano = 'X';
		}
		if ($mes==11)
		{
			$mes_algromano = 'XI';
		}
		if ($mes==12)
		{
			$mes_algromano = 'XII';
		}

//		$mes_algromano = $romanos[$mes];
		if ($ano>0)
		{
			if ($mes>0)
			{
				if ($dia>0)
				{
					$resultado = $dia.'-'.$mes.'-'.$ano;
					if ($tipo == 'R')
					{
						$resultado = $dia.'-'.$mes_algromano.'-'.$ano;
					} 
				}
				else
				{
					$resultado = $mes.'-'.$ano;
					if ($tipo == 'R')
					{
						$resultado = $mes_algromano.'-'.$ano;
					} 
				}
			}
			else
			{
				if ($dia>0)
				{
					$resultado = $dia.'-??-'.$ano;
				}
				else
				{
					$resultado = $ano;
				}
			}
			
		}
		else
		{
			if ($mes>0)
			{
				if ($dia>0)
				{
					$resultado = $dia.'-'.$mes.'-????';
					if ($retira_interrogacao_datadeterminacao=='t')
					{
						$resultado = $dia.'-'.$mes.'-';
					}
					if ($tipo == 'R')
					{
						$resultado = $dia.'-'.$mes_algromano.'-????';
						if ($retira_interrogacao_datadeterminacao=='t')
						{
							$resultado = $dia.'-'.$mes_algromano.'-';
						}
					} 
				}
				else
				{
					$resultado = $mes.'-????';
					if ($retira_interrogacao_datadeterminacao=='t')
					{
						$resultado = $mes.'-';
					}
					
					if ($tipo == 'R')
					{
						$resultado = $mes_algromano.'-????';
						if ($retira_interrogacao_datadeterminacao=='t')
						{
							$resultado = $mes_algromano.'-';
						}
					
					} 
				}
			}
			else
			{
				if ($dia>0)
				{
					$resultado = $dia.'-??-????';
					if ($retira_interrogacao_datadeterminacao=='t')
					{
						$resultado = $dia.'';
					}
				}
				else
				{
					$resultado = '';
				}
			}
		}
	//	echo $resultado;
		return $resultado;
	}
/*
// estou substituindo 	

	function formata_data($dia=0,$mes=0,$ano=0,$tipo='A')
	{
		// A - algarismos arabicos
		// R - algarismos romanos
		$resultado = '';
		if (empty($dia)){
			$dia = 0;
		}
		if (empty($mes)){
			$mes = 0;
		}
	
		if (empty($ano)){
			$ano = 0;
		}
		$mes_algromano = '';
		$romanos = array('??','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
		if ($mes==0)
		{
			$mes_algromano = '??';
		}
		if ($mes==1)
		{
			$mes_algromano = 'I';
		}
		if ($mes==2)
		{
			$mes_algromano = 'II';
		}
		if ($mes==3)
		{
			$mes_algromano = 'III';
		}
		if ($mes==4)
		{
			$mes_algromano = 'IV';
		}
		if ($mes==5)
		{
			$mes_algromano = 'V';
		}
		if ($mes==6)
		{
			$mes_algromano = 'VI';
		}
		if ($mes==7)
		{
			$mes_algromano = 'VII';
		}
		if ($mes==8)
		{
			$mes_algromano = 'VIII';
		}
		if ($mes==9)
		{
			$mes_algromano = 'IX';
		}
		if ($mes==10)
		{
			$mes_algromano = 'X';
		}
		if ($mes==11)
		{
			$mes_algromano = 'XI';
		}
		if ($mes==12)
		{
			$mes_algromano = 'XII';
		}

//		$mes_algromano = $romanos[$mes];
		if ($ano>0)
		{
			if ($mes>0)
			{
				if ($dia>0)
				{
					$resultado = $dia.'-'.$mes.'-'.$ano;
					if ($tipo == 'R')
					{
						$resultado = $dia.'-'.$mes_algromano.'-'.$ano;
					} 
				}
				else
				{
					$resultado = $mes.'-'.$ano;
					if ($tipo == 'R')
					{
						$resultado = $mes_algromano.'-'.$ano;
					} 
				}
			}
			else
			{
				if ($dia>0)
				{
					$resultado = $dia.'-??-'.$ano;
				}
				else
				{
					$resultado = $ano;
				}
			}
			
		}
		else
		{
			if ($mes>0)
			{
				if ($dia>0)
				{
					$resultado = $dia.'-'.$mes.'-????';
					if ($tipo == 'R')
					{
						$resultado = $dia.'-'.$mes_algromano.'-????';
					} 
				}
				else
				{
					$resultado = $mes.'-????';
					if ($tipo == 'R')
					{
						$resultado = $mes_algromano.'-????';
					} 
				}
			}
			else
			{
				if ($dia>0)
				{
					$resultado = $dia.'-??-????';
				}
				else
				{
					$resultado = '';
				}
			}
		}
		return $resultado;
	}
*/
// fim substituição
	
	public function pegaCodColetorUS($coletor)
	{
		$sql = "select idcoletor from jabot.coletor where coletor = '".$coletor."'";
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		return $row[0];
	}
	
	public function emprestado($codtestemunho)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
		$sql = 'select * from jabot.itemguiaremessa where codtestemunho = '.$codtestemunho.' and idtiporemessa = 3';
		//echo $sql;
		$res = pg_exec($this->conn,$sql);
		if (pg_numrows($res)>0)
		{
			return 0;
		}
		else
		{
			return 1; 
		}
	} 
	
	
	function getByIdRapido($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	  $sql = 'select  *
		from jabot.testemunho t 
		, jabot.colecaobotanica cb, pessoa p, pessoajuridica pj where t.codcolbot = cb.codcolecaobot 
		and 
		cb.codcolecaobot = p.codpessoa and p.codpessoa = pj.codpj and 
		t.codtestemunho = '.$id;
		
		$result = pg_exec($this->conn,$sql);
	//	$row2 = pg_fetch_array($result);
	//	print"<pre>";
	//	print_r($row2);
		//echo $result.'<br>';
	//echo pg_num_rows($result);
		//exit;

//print"result".$result;
		if (pg_num_rows($result)>0){
	    	$row2 = pg_fetch_array($result);
		   	$this->getDadosRapido($row2);
			return 1;
		}
		else
		{
    		return 0;
		}
	
	}
	
	public function getById($id,$completo=false)
	{
	
	//print"ID ".$id;

		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = "
		select 
t.codtestemunho,codcattypus,t.estado_esporifero_0,estado_esporifero_i,estado_esporifero_ii,estado_esporifero_iii, t.codcolbot, t.codtipocolbot, t.codbasedados, t.numtombo, siglapj, a.aux_nomecompltaxhtml, deta.coddetacesso, coddeterminacao, aux_coletprinc, aux_numcolprinc, 
aux_coladic, exped, expednumcol, diaacesso1, mesacesso1, anoacesso1, diaacesso2, mesacesso2, anoacesso2, a.codarvtaxon,codarvtaxon_hospedeiro, coletaemcultivo, coletorcultivo,
 numcoleta_cultivo, datacoleta_cultivo, descrlocal, descrambiente, descrindividuo, altprof, altprofmaxima, unidmedaltprof, dap, fuste, habitat, habito, 
 usos, aux_frequencia, aux_luminosidade, latmin_grau, latmin_min, latmin_seg, nortesulac, longmin_grau, longmin_min, longmin_seg, 
 lesteoesteac, esteril, comflor, comfruto, combotao, comflorpassada, comfrutoimat, comfrutomad, comfrutopassado, siglacolbotorigem, 
 aux_duplicatas, qtdestoqueduplic, colecoescorrelatas, fontebibliogr, codigobarras, desaparecido,aux_nomevulg, 
 locfisico1, locfisico2, plantadopor, diaplantio, ugp.codunidgeo, aux_nomecompunidgeo_invertido,
 datacomplementar,missao,historiaexsicata,deta.aux_uc,deta.coduc,
mesplantio, anoplantio, plaqueado, plaquear, restaurarplaca, placa_nomevulgar, placa_distribgeo, homenagem, t.observacoes, t.codtipocolbot as codtipocolecaobotanica
,sufixonumtombo,a.aux_nomecompltaxon, a2.aux_nomecompltaxon as aux_nomecompltaxonhospedeiro,altura,unidmedaltura,tombado, aff, cf, confirmacao, aux_detpor, detby_hospedeiro, diadeterm,mesdeterm,anodeterm,nslatmaxima,lolongmaxima,latmax_grau,latmax_min,latmax_seg,longmax_grau,longmax_min,longmax_seg,unidconservacao ,unidmedaltprof,aux_tipovegetacao,nota,nomepessoa as colecaobotanica,dataprep,metodoprep 
		";
		if ($completo==true)
		{
		$sql.="
		,
		( SELECT linhasuperior_html FROM jabot.nomecompletotaxon_html3linhas(det.codarvtaxon, 70)) AS linhasuperior_html, 
    
   			( SELECT CASE WHEN det.cf = 'T'::bpchar OR det.cf = 't'::bpchar THEN 
						( SELECT CASE WHEN det.aff = 'T'::bpchar OR det.aff = 't'::bpchar THEN 
										'cf./aff. ' || ( SELECT linhaespecie_html FROM jabot.nomecompletotaxon_html3linhas(det.codarvtaxon, 70) )
						ELSE 
										'cf. ' || ( SELECT linhaespecie_html FROM jabot.nomecompletotaxon_html3linhas(det.codarvtaxon, 70) )
						END)							
			ELSE 
						( SELECT CASE WHEN det.aff = 'T'::bpchar OR det.aff = 't'::bpchar THEN 
										'aff. ' || ( SELECT linhaespecie_html FROM jabot.nomecompletotaxon_html3linhas(det.codarvtaxon, 70) )
						ELSE 
										( SELECT linhaespecie_html FROM jabot.nomecompletotaxon_html3linhas(det.codarvtaxon, 70) )
						END )
			END )

    AS linhaespecie_html, 
	 ( SELECT linhainfra_html FROM  jabot.nomecompletotaxon_html3linhas(det.codarvtaxon, 70) ) AS linhainfra_html
	 ,
	 ( SELECT CASE WHEN ((aux_detpor IS NULL) OR (trim(aux_detpor) = '')) THEN
					NULL::character varying
		ELSE 
					'Det.: ' || aux_detpor ||
					( SELECT CASE WHEN (diadeterm::text IS NULL) AND (mesdeterm::text IS NULL) AND (anodeterm::text IS NULL)  THEN 
							', '
					ELSE 
							', ' || (SELECT data_mesromano FROM jabot.formata_data(diadeterm,mesdeterm,anodeterm))
					END)
		END) AS detpor ,
		
(SELECT trim(replace(replace(
    ( SELECT CASE	WHEN ((cast(deta.codunidgeo as varchar) IS NULL)  OR (trim(cast(deta.codunidgeo as varchar)) = '')) THEN 
    		''
		ELSE 
					ugp.aux_nomecompunidgeo_invertido || ' | '
		END ) 
 	||
 	
 	
 	( SELECT CASE WHEN (deta.coduc IS NOT NULL) THEN
         ( SELECT CASE WHEN (( SELECT nomepessoa FROM jabot.v_unidcons WHERE codpessoa = deta.coduc) IS NOT NULL ) THEN
                  ( SELECT nomepessoa FROM jabot.v_unidcons WHERE codpessoa = deta.coduc)	|| ' | '						
        	ELSE
        	        ( SELECT CASE WHEN ((trim(deta.aux_uc) = '') OR (deta.aux_uc IS NULL)) THEN
			            ''
                   ELSE
                           trim(deta.aux_uc) || ' | '
                   END )
         END )
	ELSE
        ( SELECT CASE WHEN ((trim(deta.aux_uc) = '') OR (deta.aux_uc IS NULL)) THEN
                  ''
         ELSE
                  trim(deta.aux_uc) || ' | '
         END )
	END )


	||
		( SELECT CASE WHEN ((descrlocal IS NULL)  OR (trim(descrlocal) = '')) THEN 
				( SELECT CASE WHEN ((aux_procedencia IS NULL)  OR (trim(aux_procedencia) = '')) THEN 
						''
				ELSE 
						aux_procedencia || ' | '
				END)
		ELSE 
				descrlocal || ' | '
		END)
	||
		(SELECT CASE WHEN ((deta.area IS NULL)  OR (trim(deta.area) = ''))  THEN
				''
		ELSE
				'Área ' || deta.area || ' | '
		END)
 || 

		(SELECT latlong_txt FROM jabot.calc_georefpt_testem2(t.codtestemunho, null)) 
	
	||
		(SELECT CASE WHEN ((aux_tipovegetacao IS NULL)  OR (trim(aux_tipovegetacao) = ''))  THEN
				''
		ELSE
				aux_tipovegetacao || ' | '
		END)
	||
	    (SELECT CASE WHEN (((altprof IS NULL) or (altprof = '')) AND (altprofmaxima IS NULL or altprofmaxima = '')) THEN
		''
		ELSE
		 
					(SELECT CASE WHEN (substring((altprof)::text from 1 for 1) = '-') THEN
		            'Prof.: '
			      ELSE
		            'Elev.: '
			      END)
		      ||
			      (SELECT CASE WHEN (altprofmaxima IS NULL or altprofmaxima = '') THEN
			            (SELECT CASE WHEN (unidmedaltprof IS NULL) THEN
			                (altprof)::text  || ' | '
			            ELSE
			                (altprof)::text || '  ' || 
							 (select case when (unidmedaltprof is null) then
							   ''
							   else
							  (SELECT siglaunidmed FROM jabot.unidmedida WHERE codunidmed = unidmedaltprof) || ' | '
							  end)
			            END)
			      ELSE
			            (SELECT CASE WHEN unidmedaltprof IS NULL  THEN
			                (SELECT CASE WHEN (altprof is null or altprof = '') THEN
							 	(altprofmaxima)::text  || ' | '
							ELSE
								(altprof)::text || '-' || (altprofmaxima)::text  || ' | '
							END)
			            ELSE
							(SELECT CASE WHEN (altprof is null or altprof = '') THEN
							 	(altprofmaxima)::text  || ' ' || (SELECT siglaunidmed FROM jabot.unidmedida WHERE codunidmed = unidmedaltprof) || ' | '
							ELSE
								(altprof)::text || '-' || (altprofmaxima)::text  || ' ' || (SELECT siglaunidmed FROM jabot.unidmedida WHERE codunidmed = unidmedaltprof) || ' | '
							END)
			            END)
			      END)
		END)	 
, '. |', ' |'), ' |', '.')))
AS procedencia		

,

(SELECT trim(replace(replace(
 (SELECT CASE WHEN ((descrambiente IS NULL) OR (trim(descrambiente) = '')) THEN
     ''
  ELSE
     descrambiente || ' | '
 END)
||
 (SELECT CASE WHEN ((trim(codindividuo) = '') OR (codindividuo IS NULL)) THEN
     ''
  ELSE";
  $sql.= "   'Indivíduo ' || codindividuo || ' | '";
 $sql.=" 
  END)
 ||
 (SELECT CASE WHEN ((trim(descrindividuo) = '') OR (descrindividuo IS NULL)) THEN
     ''
  ELSE
     descrindividuo || ' | '
 END)
||
 (SELECT CASE WHEN ((dap = 0) OR (dap IS NULL)) THEN
     ''
  ELSE
     'DAP ' || dap || ' | '
 END)
||
 (SELECT CASE WHEN ((fuste = 0) OR (fuste IS NULL)) THEN
     ''
  ELSE
     'Fuste ' || fuste || ' | '
 END)
 ||
 (SELECT CASE WHEN ((altura IS NULL) OR (trim(altura) = '')) THEN
     ''
  ELSE
      (SELECT CASE WHEN unidmedaltura IS NULL THEN
              'Altura: ' || (altura)::text || ' | '
      ELSE
              'Altura: ' || (altura)::text || ' ' || (SELECT siglaunidmed FROM jabot.unidmedida WHERE codunidmed = unidmedaltura) || ' | '
      END)
  END)
||
 (SELECT CASE WHEN ((habitat IS NULL) OR (trim(habitat) = '')) THEN
     ''
  ELSE
     'Habitat: ' || habitat || ' | '
 END)
||
 (SELECT CASE WHEN ((habito IS NULL)  OR (trim(habito) = '')) THEN
     ''
  ELSE
   ";

$sql.= "'Hábito/Forma de vida: ' || habito || ' | '";
 $sql.="
 END)
||
 (SELECT CASE WHEN ((aux_frequencia IS NULL) OR (trim(aux_frequencia) = '')) THEN
     ''
  ELSE";
$sql.= " 'Frequência: '";
$sql.= " || aux_frequencia || ' | '
 END)
||
 (SELECT CASE WHEN ((aux_luminosidade IS NULL) OR (trim(aux_luminosidade) = '')) THEN
     ''
  ELSE
     'Luminosidade: ' || aux_luminosidade || ' | '
 END)
||
 (SELECT CASE WHEN ((usos IS NULL) OR (trim(usos) = '')) THEN
     ''
  ELSE
     'Usos: ' || usos || ' | '
 END)

, '. |', ' |'), ' |', '.')))
AS observacaocompleta
,

		( SELECT CASE WHEN ((trim(( SELECT CASE WHEN (deta.codcoletor IS NOT NULL) THEN 
					( SELECT acronimo_coletor FROM jabot.v_cientista_formbras WHERE codcientista = deta.codcoletor)							
				ELSE 
					aux_coletprinc
				END )) = '') OR (aux_coletprinc IS NULL)) THEN
					NULL::character varying
		ELSE 
					( SELECT CASE WHEN ((trim(( SELECT CASE WHEN (deta.codcoletor IS NOT NULL) THEN 
					( SELECT acronimo_coletor FROM jabot.v_cientista_formbras WHERE codcientista = deta.codcoletor)							
				ELSE 
					aux_coletprinc
				END )) = '') OR (aux_numcolprinc IS NULL)) THEN 
							( SELECT CASE WHEN ((trim(aux_coladic) = '') OR (aux_coladic IS NULL)) THEN 
									( SELECT CASE WHEN (deta.codcoletor IS NOT NULL) THEN 
					( SELECT acronimo_coletor FROM jabot.v_cientista_formbras WHERE codcientista = deta.codcoletor)							
				ELSE 
					aux_coletprinc
				END ) || ' s/n.'
							ELSE 
									( SELECT CASE WHEN (deta.codcoletor IS NOT NULL) THEN 
					( SELECT acronimo_coletor FROM jabot.v_cientista_formbras WHERE codcientista = deta.codcoletor)							
				ELSE 
					aux_coletprinc
				END ) || ' s/n., ' || aux_coladic
							END)
					ELSE 
							( SELECT CASE WHEN ((trim(aux_coladic) = '') OR (aux_coladic IS NULL)) THEN 
									( SELECT CASE WHEN (deta.codcoletor IS NOT NULL) THEN 
					( SELECT acronimo_coletor FROM jabot.v_cientista_formbras WHERE codcientista = deta.codcoletor)							
				ELSE 
					aux_coletprinc
				END ) || ', ' || aux_numcolprinc
							ELSE 
									( SELECT CASE WHEN (deta.codcoletor IS NOT NULL) THEN 
					( SELECT acronimo_coletor FROM jabot.v_cientista_formbras WHERE codcientista = deta.codcoletor)							
				ELSE 
					aux_coletprinc
				END ) || ', ' || aux_numcolprinc || ', ' || aux_coladic
							END)
					END)
		END) AS todoscoletores
		,

		(
		( SELECT CASE WHEN ((diaacesso1 <> '') AND (isnumeric(diaacesso1) IS TRUE)) THEN
				( SELECT CASE WHEN ((mesacesso1 <> '') AND (isnumeric(mesacesso1) IS TRUE)) THEN
							( SELECT CASE WHEN ((anoacesso1 <> '') AND (isnumeric(anoacesso1) IS TRUE)) THEN
									(SELECT data_mesromano FROM jabot.formata_data(CAST (diaacesso1 as integer),CAST (mesacesso1 as integer),CAST (anoacesso1 as integer)) as datacol_mesrom)
							ELSE
									(SELECT data_mesromano FROM jabot.formata_data(CAST (diaacesso1 as integer),CAST (mesacesso1 as integer),null) as datacol_mesrom)
							END) 
				ELSE
							( SELECT CASE WHEN ((anoacesso1 <> '') AND (isnumeric(anoacesso1) IS TRUE)) THEN
									(SELECT data_mesromano FROM jabot.formata_data(CAST (diaacesso1 as integer),null,CAST (anoacesso1 as integer)) as datacol_mesrom)
							ELSE
									(SELECT data_mesromano FROM jabot.formata_data(CAST (diaacesso1 as integer),null,null) as datacol_mesrom)
							END) 
				END) 
		ELSE
				( SELECT CASE WHEN ((mesacesso1 <> '')  AND (isnumeric(mesacesso1) IS TRUE)) THEN
							( SELECT CASE WHEN ((anoacesso1 <> '') AND (isnumeric(anoacesso1) IS TRUE)) THEN
									(SELECT data_mesromano FROM jabot.formata_data(null,CAST (mesacesso1 as integer),CAST (anoacesso1 as integer)) as datacol_mesrom)
							ELSE
									(SELECT data_mesromano FROM jabot.formata_data(null,CAST (mesacesso1 as integer),null) as datacol_mesrom)
							END) 
				ELSE
							( SELECT CASE WHEN ((anoacesso1 <> '') AND (isnumeric(anoacesso1) IS TRUE)) THEN
									(SELECT data_mesromano FROM jabot.formata_data(null,null,CAST (anoacesso1 as integer)) as datacol_mesrom)
							ELSE
									's/data'
							END) 
				END) 
		END) 
		||
			( SELECT CASE WHEN (anoacesso2 IS NOT NULL) THEN 
					(SELECT ' a ' || (SELECT data_mesromano FROM jabot.formata_data(diaacesso2,mesacesso2,anoacesso2)) as datacol_mesrom)
			ELSE
					''
			END)
		) AS datacoletacompleta		
,
(SELECT trim(replace(replace(
 (SELECT CASE WHEN ((trim(exped) = '') OR (exped IS NULL)) THEN
     ''
  ELSE
     'Proj.: ' || exped || ' | '
 END)
, '. |', ' |'), ' |', '.')))
As projetoexpedicaocompleto 
";
}
$sql.="
 
		from jabot.testemunho t left join jabot.individuovivo iv on iv.codindividuovivo = t.codtestemunho,
	
 jabot.colecaobotanica cb, 
 pessoa p, 
 pessoajuridica pj , 
 jabot.determinacao det left join jabot.arvoretaxon a2 on det.codarvtaxon_hospedeiro = a2.codarvtaxon, 
 jabot.arvoretaxon a, 
 jabot.detacesso deta left join jabot.unidgeopolitica ugp on deta.codunidgeo = ugp.codunidgeo
 where t.codcolbot = cb.codcolecaobot and 
 cb.codcolecaobot = p.codpessoa and 
 p.codpessoa = pj.codpj and 
 t.ultimadeterm = det.coddeterminacao and 
 det.codarvtaxon = a.codarvtaxon and 
 t.codacesso = deta.coddetacesso and 
 t.codtestemunho = ".$id;

 //if($_SESSION['s_idusuario']==2209)
//	echo $sql;
//exit;
		$result = pg_exec($this->conn,$sql);
	//	$row2 = pg_fetch_array($result);
	//	print"<pre>";
	//	print_r($row2);
		//echo $result.'<br>';
	//echo pg_num_rows($result);
		//exit;

//print"result".$result;
		if (pg_num_rows($result)>0){
	    	$row2 = pg_fetch_array($result);
		   	$this->getDados($row2);
			return 1;
		}
		else
		{
    		return 0;
		}
	}
	
	public function formataDeterminadorInterno($determinador,$diadeterminacao,$mesdeterminacao,$anodeterminacao)
	{
		if (!empty($determinador))
		{
			$determinador = 'Det.: '.$determinador;
			if ((empty($anodeterminacao)) && (empty($mesdeterminacao)) && (empty($anodeterminacao)))
			{
				if($_SESSION['dbname'] != 'HUENF')
					$determinador.= ' (s/data determ.)';
			}
			else
			{
				if (empty($diadeterminacao)) {$diadeterminacao = 0;}
				if (empty($mesdeterminacao)) {$mesdeterminacao = 0;}
				if (empty($anodeterminacao)) {$anodeterminacao = 0;}
				$determinador.=  '(em '.$this->formata_data($diadeterminacao,$mesdeterminacao,$anodeterminacao,'R').')';
			}
		}
		return $determinador;
	}
	public function formataDeterminador()
	{
		if (!empty($this->determinador))
		{
			$determinador = 'Det.: '.$this->determinador;
			if ((empty($this->anodeterminacao)) && (empty($this->mesdeterminacao)) && (empty($this->anodeterminacao)))
			{
				$determinador.= ' (s/data determ.)';
			}
			else
			{
				if (empty($this->diadeterminacao)) {$this->diadeterminacao = 0;}
				if (empty($this->mesdeterminacao)) {$this->mesdeterminacao = 0;}
				if (empty($this->anodeterminacao)) {$this->anodeterminacao = 0;}
				$determinador.=  '(em '.$this->formata_data($this->diadeterminacao,$this->mesdeterminacao,$this->anodeterminacao,'R').')';
			}
		}
		return $determinador;
	}
	
	public function formataNumTombo()
	{
			$this->numtomboformatado = $this->numtombo;

			if ((empty($this->numtombo)) || ($this->numtombo == '0'))
 			{
 				if (empty($this->siglacolecao))
 				{
 					$this->numtomboformatado = 'S/n Tombo';	
 				}
 				else
 				{
					if (!empty($this->codigobarras))
					{
						$this->numtomboformatado = $this->codigobarras;//$this->siglacolecao;	
					}
					else
					{
						$this->numtomboformatado = $this->siglacolecao . ' s/n';	
					}
				}
 			}
 			else
 			{
 				if (empty($this->siglacolecao))
 				{
 					$this->numtomboformatado = 's/col. '.$this->numtomboformatado;	
 				}
 				else
 				{
					if ($this->siglacolecao=='RBfungo')
					{
						$this->numtomboformatado = 'RB'.' '.$this->numtomboformatado;
					}
					else
					{					
						$this->numtomboformatado = $this->siglacolecao.' '.$this->numtomboformatado;	
					}
				}
 			}
			
		return $this->numtomboformatado;
	}
	


	
	public function excluir($codtestemunho)
	{
		if (!empty($codtestemunho) && !empty($_SESSION['s_idusuario']))
		{
			$sql = "select t.numtombo,t.codtestemunho,a.codarvtaxon,a.aux_nomecompltaxon,
a.codarvtaxon,ugp.codunidgeo,ugp.aux_nomecomplunidgeo
 from jabot.testemunho t, jabot.determinacao det,
jabot.arvoretaxon a, jabot.unidgeopolitica ugp,
jabot.detacesso deta
where
t.codtestemunho = t.codtestemunho and
t.ultimadeterm = det.coddeterminacao and
det.codarvtaxon = a.codarvtaxon and
t.codacesso = deta.coddetacesso and
deta.codunidgeo = ugp.codunidgeo and
 t.codtestemunho = ".$codtestemunho;
			$res = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($res);
			$sqlexcluir = "insert into jabot.log_testemunho (op,login,ip,codtestemunho,taxon,unidadegeopolitica,codunidgeo,codarvtaxon,numtombo)
			values ('E','".$_SESSION['s_idusuario']."','".$_SERVER["REMOTE_ADDR"]."',".$codtestemunho.",'".$row['aux_nomecompltaxon']."',
			'".$row['aux_nomecomplunidgeo']."',".$row['codunidgeo'].",".$row['codarvtaxon'].",'".$row['numtombo']."');";
	
			//$transaction = pg_exec($this->conn,"BEGIN TRANSACTION;");
			$sql_excluitest = $sqlexcluir;
			$sql_excluitest .= " DELETE FROM jabot.testemunho WHERE codtestemunho = ".$codtestemunho.";";
			//echo $sql_excluitest;
			//exit;
			$result_excluitest = pg_exec($this->conn, $sql_excluitest);
			//$result_excluitest = false;
			if (!$result_excluitest)
			{
				$transaction = pg_exec($this->conn,"ROLLBACK;");
				return false;
			}
			else
			{
				$transaction = pg_exec($this->conn,"COMMIT;");
				return true;
			}
			//return 0;
		}
		else
		{
			return false;
		}
		
	}
	
	
	function listaComboRefloraOrigem($nomecombo,$origem,$refresh,$classes)
	{
	   	$sql = "select origem from jabot.reflora_imagem r
				group by origem ";
		$sql.=" order by 1 ";
		//print $sql;
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Selecione </option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($origem == $row['origem'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['origem']."' ".$s." >".$row['origem']."</option> ";
	    }

		$html .= '</select>';

		return $html;	

	}
	function listaComboRefloraBatch($nomecombo,$origem,$refresh,$classes,$batch)
	{
	   	$sql = "select distinct ri.batch, ri.path from jabot.testemunho t, usuario u, jabot.reflora_imagem ri 
				where ri.digitadopor = u.codusuario and (ri.origem = '$origem' ) 
				and t.codigobarras = ri.codigobarra order by 1; ";
		//$sql.=" order by 1 ";
		//print $sql;
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Selecione </option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($batch == $row['batch'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['batch']."' ".$s." >".$row['batch'].' - '.$row['path']."</option> ";
	    }

		$html .= '</select>';

		return $html;	

	}
	
	

	public function alterarRBD($codtestemunho,$codusuario)
	{
		if (empty($this->unidademedidaaltura))
		{
			$this->unidademedidaaltura = 'null';
		}
		
		if (empty($this->diacoleta))
		{
			$this->diacoleta = 'null';
		}
		if (empty($this->mescoleta))
		{
			$this->mescoleta = 'null';
		}
		if (empty($this->anocoleta))
		{
			$this->anocoleta = 'null';
		}	
		if (empty($this->diacoletafinal))
		{
			$this->diacoletafinal = 'null';
		}
		if (empty($this->mescoletafinal))
		{
			$this->mescoletafinal = 'null';
		}
		if (empty($this->anocoletafinal))
		{
			$this->anocoletafinal = 'null';
		}	


		if (empty($this->latgrau))
		{
			$this->latgrau = 'null';
		}	
		if (empty($this->latmin))
		{
			$this->latmin = 'null';
		}	
		if (empty($this->latseg))
		{
			$this->latseg = 'null';
		}	
		if (empty($this->latgraumaxima))
		{
			$this->latgraumaxima = 'null';
		}	
		if (empty($this->latminmaxima))
		{
			$this->latminmaxima = 'null';
		}	
		if (empty($this->latsegmaxima))
		{
			$this->latsegmaxima = 'null';
		}	

		
		if (empty($this->longgrau))
		{
			$this->longgrau = 'null';
		}	
		if (empty($this->longmin))
		{
			$this->longmin = 'null';
		}	
		if (empty($this->longseg))
		{
			$this->longseg = 'null';
		}	

		if (empty($this->longgraumaxima))
		{
			$this->longgraumaxima = 'null';
		}	
		if (empty($this->longminmaxima))
		{
			$this->longminmaxima = 'null';
		}	
		if (empty($this->longsegmaxima))
		{
			$this->longsegmaxima = 'null';
		}			
		
		
		if (empty($this->diadeterminacao))
		{
			$this->diadeterminacao = 'null';
		}	

		if (empty($this->mesdeterminacao))
		{
			$this->mesdeterminacao = 'null';
		}	
				
		if (empty($this->anodeterminacao))
		{
			$this->anodeterminacao = 'null';
		}	
		

		if (empty($this->codcategoriatypus))
		{
			$this->codcategoriatypus = 'null';
		}	
		
		if (empty($this->cf))
		{
			$this->cf = 'F';
		}	
		
		if (empty($this->aff))
		{
			$this->aff = 'F';
		}	
		
		if (empty($this->codtipocolecaobotanica))
		{
			$this->codtipocolecaobotanica = 1;
		}		 
		
		
		if (empty($this->idcoletor))
		{
			$this->idcoletor = 0;
		}
		//echo 'DiaAcesso1'.$this->diaacesso1;
		
		
	   $sql = 'select * from jabot.testemunho t, jabot.detacesso deta,
jabot.determinacao det
where
t.codacesso = deta.coddetacesso and
t.ultimadeterm = det.coddeterminacao 
and t.codtestemunho = '.$codtestemunho;
	   $restestemunho = pg_exec($this->conn,$sql);
	   $rowtestemunho = pg_fetch_array($restestemunho);
	   
	  $sql = "update jabot.detacesso set unidmedaltprof = ".$this->unidademedidaaltura.",missao='".$this->missao."', datacomplementar='".$this->datacomplementar."', 
	  aux_coletprinc='".$this->coletor."', 
	  aux_coladic='".$this->coletoresadicionais."', diaacesso1=".$this->diacoleta.", mesacesso1=".$this->mescoleta.", 
	  anoacesso1=".$this->anocoleta.",
diaacesso2=".$this->diacoletafinal.", mesacesso2=".$this->mescoletafinal.", 
	  anoacesso2=".$this->anocoletafinal.",
  	  habito='".$this->habito."',
	  aux_nomevulg='".$this->nomesvulgares."', aux_numcolprinc='".$this->numerocoleta."', 
	  codunidgeo=".$this->codunidgeo.", descrlocal='".$this->descricaolocal."', descrambiente='".$this->descricaoambiente."',
	  latmin_grau=".$this->latgrau.", latmin_min=".$this->latmin.", latmin_seg=".$this->latseg.",
	  nortesulac='".$this->latns."', 
	  longmin_grau=".$this->longgrau.",  longmin_min=".$this->longmin.", longmin_seg=".$this->longseg.", 
	  lesteoesteac='".$this->longlo."',

	  latmax_grau=".$this->latgraumaxima.", latmax_min=".$this->latminmaxima.", latmax_seg=".$this->latsegmaxima.",
	  nslatmaxima='".$this->latnsmaxima."', 
	  longmax_grau=".$this->longgraumaxima.",  longmax_min=".$this->longminmaxima.", longmax_seg=".$this->longsegmaxima.", 
	  lolongmaxima='".$this->longlomaxima."',
	  

	  altprof='".$this->elevacaoprofundidade."', altprofmaxima='".$this->elevacaoprofundidademaxima."', descrindividuo='".$this->descricaoindividuo."' 
	  where coddetacesso = ".$rowtestemunho['coddetacesso'].";
	  update jabot.testemunho set historiaexsicata = '".$this->historiaexsicata."', codtipocolbot = ".$this->codtipocolecaobotanica.", alteradopor=".$_SESSION['s_idusuario'].", 
	  observacoes='".$this->observacao."', aux_duplicatas='".$this->duplicata."', siglacolbotorigem='".$this->siglacolecaoorigem."', qtdinicialduplic=null    
	  where codtestemunho = ".$rowtestemunho['codtestemunho']."; 
	  update jabot.determinacao set cf='".$this->cf."', aff='".$this->aff."', codarvtaxon=".$this->codarvtaxon.", 
	  aux_detpor='".$this->determinador."', diadeterm=".$this->diadeterminacao.", mesdeterm=".$this->mesdeterminacao.", 
	  anodeterm=".$this->anodeterminacao.", codcattypus=".$this->codcategoriatypus.", nota='".$this->notasdeterminacao."' 
	  where coddeterminacao = ".$rowtestemunho['coddeterminacao'].";
	  update jabot.reflora_imagem set idcoletor=".$this->idcoletor.", digitadopor=".$codusuario.", status = ".$this->statusdigitacao." where codigobarra = '".$rowtestemunho['codigobarras']."';"; 
	 
	//Rafael, ver o motivo de ter comentado essa linha.
	if ($this->statusdigitacao!='1')
	{
		  $sql.=" update jabot.reflora_imagem set fimdigitacao = now()  where codigobarra = '".$rowtestemunho['codigobarras']."';";
	}

//	 echo $sql;
//	   exit; 

	  $transaction = pg_exec($this->conn,"BEGIN TRANSACTION;");
	   $result = pg_exec($this->conn,$sql);
	    
	   if (!$result)
	   {
			$transaction = pg_exec($this->conn,"ROLLBACK;");
			return 0;
		}
		else
		{
			$transaction = pg_exec($this->conn,"COMMIT;");
			return $codtestemunho;
		}
	
	}

	
	public function alterarManejoColecaoViva($codtestemunho,$morto,$secao,$canteiro,$plantadopor,
	$diaplantio,$mesplantio,$anoplantio,$nomevulgarplaca,$distribuicaogeograficaplaca,
	$placacomemorativa,$plaqueado,$plaquear,$restaurarplaca,$observacao)
	{
		
		$sql = "update jabot.testemunho set 
		desaparecido = '".$morto."',
		locfisico1 = '".$secao."',
		locfisico2 = '".$canteiro."',
		observacoes = '".$observacao."'
		where codtestemunho = ".$codtestemunho.";";
		
		$sql.="	update jabot.individuovivo set 
		homenagem = '".$placacomemorativa."',
		plaquear='".$plaquear."',
		plaqueado='".$plaqueado."',
		restaurarplaca='".$restaurarplaca."',
		plantadopor='".$plantadopor."',
		diaplantio='".$diaplantio."',
		mesplantio='".$mesplantio."',
		anoplantio='".$anoplantio."',
		placa_nomevulgar='".$nomevulgarplaca."',
		placa_distribgeo='".$distribuicaogeograficaplaca."' where codindividuovivo = ".$codtestemunho.";";

//		echo $sql;
//		exit;

		$transaction = pg_exec($this->conn,"BEGIN TRANSACTION;");
		$result = pg_exec($this->conn,$sql);
		if (!$result)
		{
			$transaction = pg_exec($this->conn,"ROLLBACK;");
			return 0;
		}
		else
		{
			$transaction = pg_exec($this->conn,"COMMIT;");
			return $codtestemunho;
		}
	}
	
	
	public function alterar($codtestemunho)
	{
		//$this->desaparecido='N';
		//echo "desaparecido=".$this->desaparecido;
		//exit;

$sql = "select t.numtombo,t.codtestemunho,a.codarvtaxon,a.aux_nomecompltaxon,
a.codarvtaxon,ugp.codunidgeo,ugp.aux_nomecomplunidgeo, *
 from jabot.testemunho t, jabot.determinacao det,
jabot.arvoretaxon a, jabot.unidgeopolitica ugp,
jabot.detacesso deta
where
t.codtestemunho = t.codtestemunho and
t.ultimadeterm = det.coddeterminacao and
det.codarvtaxon = a.codarvtaxon and
t.codacesso = deta.coddetacesso and
deta.codunidgeo = ugp.codunidgeo and
 t.codtestemunho = ".$codtestemunho;

	   $restestemunho = pg_exec($this->conn,$sql);
	   $rowtestemunho = pg_fetch_array($restestemunho);
	   
	   $sqllog = "insert into jabot.log_testemunho (op,login,ip,codtestemunho,taxon,unidadegeopolitica,codunidgeo,codarvtaxon,numtombo)
			values ('A','".$_SESSION['s_idusuario']."','".$_SERVER["REMOTE_ADDR"]."',".$codtestemunho.",'".$rowtestemunho['aux_nomecompltaxon']."',
			'".$rowtestemunho['aux_nomecomplunidgeo']."',".$rowtestemunho['codunidgeo'].",".$rowtestemunho['codarvtaxon'].",'".$rowtestemunho['numtombo']."');";
		pg_exec($this->conn,$sqllog);	
	  // pego a coleção botanica para busca o calculo do numero tombo
	   $transaction = pg_exec($this->conn,"BEGIN TRANSACTION;");
       
	   // DETACESSO
	   $sqlcampo = "select * from jabot.abatipocolecaocampo atc, jabot.campo c where
					atc.idcampo = c.codcampo and atc.idaba in (2,3,4,5) and tabelaorigem = 'detacesso' and atc.idtipocolecaobotanica = ".$this->codtipocolecaobotanica." ";
					//echo $sqlcampo;
	   $rescampo = pg_exec($this->conn,$sqlcampo);
	    $sqlcampo = '';
		$sqlvalor = '';
		while ($row = pg_fetch_array($rescampo))
		{
			$valor = $this->pegaValorCampo($row['atributo']);

			if (($row['zeroequivalenull']=='t') && ($valor==''))
			{
				$valor="null";
			}
			if ($row['comaspas']=='T'){
				$valor="'".$valor."'";
			}
		  $sqlcampo.=', '.$row['nomecampofisico'].'='.$valor;
		}
	   $sql = ' update jabot.detacesso set coddetacesso=coddetacesso'.$sqlcampo.' where coddetacesso = '.$rowtestemunho['coddetacesso'].';';
		
	   
	   // Testemunho
	   $sqlcampo = "select * from jabot.abatipocolecaocampo atc, jabot.campo c where
					atc.idcampo = c.codcampo and atc.idaba in (6,7,8) and tabelaorigem = 'testemunho'
					and atc.idtipocolecaobotanica = ".$this->codtipocolecaobotanica.";	";
					//echo $sqlcampo;
	   $rescampo = pg_exec($this->conn,$sqlcampo);
	    $sqlcampo = '';
		$sqlvalor = '';
					
		while ($row = pg_fetch_array($rescampo))
		{
			$valor = $this->pegaValorCampo($row['atributo']);

			if (($row['zeroequivalenull']=='t') && ($valor==''))
			{
				$valor="null";
			}
			
			if ($row['atributo']=='duplicata')
			{
				if (($valor =='null') || ($valor ==''))
				{
					$valor='null';
				}
				else
				{
					if ($row['comaspas']=='T'){
						$valor="'".$valor."'";
					}	
				}
			}
			else
			{
				if ($row['comaspas']=='T'){
					$valor="'".$valor."'";
				}	
			}
			// if($_SESSION['s_idusuario'] == 2039){
				// if($row['nomecampofisico'] == 'comfrutopassado' ||$row['nomecampofisico'] == 'comfrutoimat' || $row['nomecampofisico'] == 'comfruto' || $row['nomecampofisico'] == 'comfrutomad'){
					// echo $row['nomecampofisico'].' - '.$valor.'<br>';
					//exit;
				// }
			// }
			
		  $sqlcampo.=', '.$row['nomecampofisico'].'='.$valor;
		}
		
		

		if (!empty($this->numtombo))
		{
			$sqlcamponumtombo = ", numtombo = '".$this->numtombo."',sufixonumtombo = '".$this->sufixonumtombo."' ";
		}
		//echo 'TOMBADO = '.$this->tombado;
		if (!empty($this->tombado))
		{
			$sqlcampotombado = ", tombado = 'true'";
		}
		else
		{
			$sqlcampotombado = ", tombado = 'false'";
		}
		
	   	   $sql .= ' update jabot.testemunho set desaparecido = \''.$this->desaparecido.'\', codtipocolbot = '.$this->codtipocolecaobotanica.', alteradopor='.$_SESSION['s_idusuario'].$sqlcampo.' '.$sqlcamponumtombo.' '.$sqlcampotombado.' where codtestemunho = '.$codtestemunho.';';

//		  echo $sql.'<br>';
	   // DETERMINACAO
	   $sqlcampo = "select * from jabot.abatipocolecaocampo atc, jabot.campo c where
					atc.idcampo = c.codcampo and atc.idaba in (1,9) and tabelaorigem = 'determinacao' and atc.idtipocolecaobotanica = ".$this->codtipocolecaobotanica." ";
	   $rescampo = pg_exec($this->conn,$sqlcampo);
	    $sqlcampo = '';
		$sqlvalor = '';
		while ($row = pg_fetch_array($rescampo))
		{
			$valor = $this->pegaValorCampo($row['atributo']);

			if (($row['zeroequivalenull']=='t') && ($valor==''))
			{
				$valor="null";
			}
			if ($row['comaspas']=='T'){
				$valor="'".$valor."'";
			}
			//if ($row['nomecampofisico']=='codarvtaxon') 
			//{
			//	if (!empty($valor))
			//	{
			//		$sqlcampo.=', '.$row['nomecampofisico'].'='.$valor;
			//	}
			//}
			//else
			//{
				$sqlcampo.=', '.$row['nomecampofisico'].'='.$valor;
			//}
		}
	   $sql .= ' update jabot.determinacao set coddeterminacao=coddeterminacao '.$sqlcampo.' where coddeterminacao = '.$rowtestemunho['coddeterminacao'].';';
	// SE O TIPO DE COLEÇÃO FOR DO TIPO VIVA INCLUIR DADOS NA TABELA INDIVIDUO VIVO
	//if (($codtipocolbotpadrao==12) || ($codtipocolbotpadrao==14) || ($codtipocolbotpadrao==15))
	//{
		// INDIVIDUO VIVO
	   $sqlcampo = "select * from jabot.abatipocolecaocampo atc, jabot.campo c where
					atc.idcampo = c.codcampo and atc.idaba = 8 and tabelaorigem = 'individuovivo' and atc.idtipocolecaobotanica = ".$this->codtipocolecaobotanica." ";
	   $rescampo = pg_exec($this->conn,$sqlcampo);
	    $sqlcampo = '';
		$sqlvalor = '';
		while ($row = pg_fetch_array($rescampo))
		{
			$valor = $this->pegaValorCampo($row['atributo']);

			if (($row['zeroequivalenull']=='t') && ($valor==''))
			{
				$valor="null";
			}
			if ($row['comaspas']=='T'){
				if ($valor!='null' || $valor!='')
				{
					$valor="'".$valor."'";
				}
				else
				{
					$valor = "''";
				}
			}
		   $sqlcampo.=', '.$row['nomecampofisico'].'='.$valor;
		}
	   $sql .= ' update jabot.individuovivo set codindividuovivo=codindividuovivo '.$sqlcampo.' where codindividuovivo = '.$rowtestemunho['codtestemunho'].';';

//	 }
	
	// if($_SESSION['s_idusuario'] == 2039){
		// print '<pre>';
		// print $sql;
		// print '</pre>';
		// exit;
	// }
	   $result = pg_exec($this->conn,$sql);
	   
	 
	   
	   if (!$result)
	   {
			$transaction = pg_exec($this->conn,"ROLLBACK;");
			return 0;
		}
		else
		{
			$transaction = pg_exec($this->conn,"COMMIT;");
			return 1;
		}


	}

	public function pegaValorCampo($campo)
	{
		if ($campo == 'cf') return $this->cf;
		if ($campo == 'aff') return $this->aff;
		if ($campo == 'confirmacao') return $this->confirmacao;
		if ($campo == 'determinador') return $this->determinador;
		if ($campo == 'determinadorhospedeiro') return $this->determinadorhospedeiro;
		
		if ($campo == 'diadeterminacao') return $this->diadeterminacao;
		if ($campo == 'mesdeterminacao') return $this->mesdeterminacao;
		if ($campo == 'anodeterminacao') return $this->anodeterminacao;
		if ($campo == 'codarvtaxon') return $this->codarvtaxon;
		if ($campo == 'codarvtaxonhospedeiro') return $this->codarvtaxonhospedeiro;
		if ($campo == 'codcategoriatypus') return $this->codcategoriatypus;
		if ($campo == 'notasdeterminacao') return $this->notasdeterminacao;
	
		if ($campo == 'coletor') return $this->coletor;
		if ($campo == 'numerocoleta') return $this->numerocoleta;
		if ($campo == 'coletoresadicionais') return $this->coletoresadicionais;
		if ($campo == 'projetoexpedicao') return $this->projetoexpedicao;
		if ($campo == 'numcoletaprojeto') return $this->numcoletaprojeto;
		if ($campo == 'diacoleta') return $this->diacoleta;
		if ($campo == 'mescoleta') return $this->mescoleta;
		if ($campo == 'anocoleta') return $this->anocoleta;
		if ($campo == 'diacoletafinal') return $this->diacoletafinal;
		if ($campo == 'mescoletafinal') return $this->mescoletafinal;
		if ($campo == 'anocoletafinal') return $this->anocoletafinal;
		if ($campo == 'nomesvulgares') return $this->nomesvulgares;

		if ($campo == 'coletaemcultivo') return $this->coletaemcultivo;
		if ($campo == 'coletorcultivo') return $this->coletorcultivo;
		if ($campo == 'numcoleta_cultivo') return $this->numcoleta_cultivo;
		if ($campo == 'datacoleta_cultivo') return $this->datacoleta_cultivo;
		
		if ($campo == 'codunidgeo') return $this->codunidgeo;
		if ($campo == 'descricaolocal') return $this->descricaolocal;
		if ($campo == 'descricaoambiente') return $this->descricaoambiente;
		if ($campo == 'latgrau') return $this->latgrau;
		if ($campo == 'latmin') return $this->latmin;
		if ($campo == 'latseg') return $this->latseg;
		if ($campo == 'latns') return $this->latns;

		if ($campo == 'longgrau') return $this->longgrau;
		if ($campo == 'longmin') return $this->longmin;
		if ($campo == 'longseg') return $this->longseg;
		if ($campo == 'longlo') return $this->longlo;

		if ($campo == 'latgraumaxima') return $this->latgraumaxima;
		if ($campo == 'latminmaxima') return $this->latminmaxima;
		if ($campo == 'latsegmaxima') return $this->latsegmaxima;
		if ($campo == 'latnsmaxima') return $this->latnsmaxima;

		if ($campo == 'longgraumaxima') return $this->longgraumaxima;
		if ($campo == 'longminmaxima') return $this->longminmaxima;
		if ($campo == 'longsegmaxima') return $this->longsegmaxima;
		if ($campo == 'longlomaxima') return $this->longlomaxima;

		if ($campo == 'descricaolocal') return $this->descricaolocal;
		if ($campo == 'unidadeconservacao') return $this->unidadeconservacao;
		if ($campo == 'codunidadeconservacao') return $this->codunidadeconservacao;
		// echo 'Classe: '.$this->codunidadeconservacao;
		// exit;
		if ($campo == 'elevacaoprofundidade') return $this->elevacaoprofundidade;
		if ($campo == 'elevacaoprofundidademaxima') return $this->elevacaoprofundidademaxima;

		if ($campo == 'unidademedidaelevacao') return $this->unidademedidaelevacao;
		if ($campo == 'descricaoambiente') return $this->descricaoambiente;
		if ($campo == 'tipovegetacao') return $this->tipovegetacao;
		
//		if ($campo == 'desaparecido') return $this->desaparecido;
		if ($campo == 'altura') return $this->altura;
		if ($campo == 'unidademedidaaltura') return $this->unidademedidaaltura;
		if ($campo == 'dap') return $this->dap;
		if ($campo == 'fuste') return $this->fuste;
		if ($campo == 'descricaoindividuo') return $this->descricaoindividuo;
		if ($campo == 'habitat') return $this->habitat;
		if ($campo == 'habito') return $this->habito;

		if ($campo == 'usos') return $this->usos;
		if ($campo == 'frequencia') return $this->frequencia;
		if ($campo == 'luminosidade') return $this->luminosidade;

		
		
		if ($campo == 'esteril') return $this->esteril;
		if ($campo == 'comflor') return $this->comflor;
		if ($campo == 'comfruto') return $this->comfruto;	
		if ($campo == 'combotao') return $this->combotao;
		
		if ($campo == 'comflorpassada') return $this->comflorpassada;
		if ($campo == 'comfrutomaduro') return $this->comfrutomaduro; 
		if ($campo == 'comfrutoimaturo') return $this->comfrutoimaturo;		
		if ($campo == 'comfrutopassado') return $this->comfrutopassado; 
		
		if ($campo == 'siglacolecaoorigem') return $this->siglacolecaoorigem;
		if ($campo == 'duplicata') return $this->duplicata;

		if ($campo == 'quantidadeduplicata') 
		//return $this->quantidadeduplicata;
		{ 
			if (empty($this->quantidadeduplicata))
			{
				$this->quantidadeduplicata = '0';
			}
			return $this->quantidadeduplicata;
		}

		
		if ($campo == 'especimeemcolecoescorrelatas') return $this->especimeemcolecoescorrelatas;
		
		if ($campo == 'citacoesnabibliografia')	return $this->citacoesnabibliografia;
		
		if ($campo == 'observacao') return $this->observacao;
		

		if ($campo == 'secao') return $this->secao;
		if ($campo == 'canteiro') return $this->canteiro;
		if ($campo == 'plantadopor') return $this->plantadopor;
		if ($campo == 'diaplantio') return $this->diaplantio;
		if ($campo == 'mesplantio') return $this->mesplantio;
		if ($campo == 'anoplantio') return $this->anoplantio;
		if ($campo == 'plaqueado') 
		{
			if (empty($this->plaqueado))
			{
				$this->plaqueado = 'false';
			}
			return $this->plaqueado;
		}
		
		if ($campo == 'plaquear')
		{
			if (empty($this->plaquear))
			{
				$this->plaquear = 'false';
			}
			return $this->plaquear;
		}
		if ($campo == 'restaurarplaca')
		{
			if (empty($this->restaurarplaca))
			{
				$this->restaurarplaca = 'false';
			}
			return $this->restaurarplaca;
		}
		
		if ($campo == 'nomevulgarplaca') return $this->nomevulgarplaca;
		if ($campo == 'distribuicaogeograficaplaca') return $this->distribuicaogeograficaplaca;
		if ($campo == 'latitudeplantio') return $this->latitudeplantio;
		if ($campo == 'longitudeplantio') return $this->longitudeplantio;
		

	}
	
	public function incluir()
	{
      //echo $this->siglacolbotorigem.'<br>';
	  //echo $this->duplicata;
	
		//codcolbot
	  // pego a coleção botanica para busca o calculo do numero tombo
	   $sql = "  select * from jabot.basedados bd, jabot.v_colbotanica_ih col where 
					bd.codbasedados = col.codpessoa and
						bd.codbasedados  = '".$_SESSION['s_ultimatrabalhada']."'";
	   $result = pg_exec($this->conn,$sql);
       $row = pg_fetch_array($result);
	   
	   /*if (empty($_SESSION['s_ultimatrabalhada']))
	   {
			$sqlbase = " select 'RBd:'||fam.nometaxon || ' ' || gen.nometaxon from jabot.arvoretaxon a,
			jabot.arvoretaxon fam,
			jabot.arvoretaxon gen
			where
			a.codarvtaxon = ".$this->codarvtaxon." and
			fam.codarvtaxon = a.aux_familia and
			gen.codarvtaxon = a.aux_genero";
			$resbase = pg_exec($this->conn,$sqlbase);
			$rowbase = pg_fetch_array($resbase);
			
			$sqlbase2 = "select codbasedados,nomebase from jabot.basedados bd where
nomebase ilike '".$rowbase[0]."'";
			$resbase2 = pg_exec($this->conn,$sqlbase2);
			if (pg_num_rows($resbase2)>0)
			{
				// pega a base encontrada
				$rowbase2 = pg_fetch_array($resbase2);
				$this->codbasedados = $rowbase2['codbasedados'];
			}
			else
			{
				// insert nova base de dados
				$sqlbase3 = "insert into jabot.basedados (nomebase,codcolbotpadrao,codunidgeopadrao,podepublicar) values ('".$rowbase[0]."',3172,24,'T')";
				$resbase3 = pg_exec($this->conn,$sqlbase3);

				$sqlbase4 = "select max(codbasedados) from jabot.basedados ";
				$resbase4 = pg_exec($this->conn,$sqlbase4);
				$rowbase4 = pg_fetch_array($resbase4);
				$this->codbasedados = $rowbase4[0];
			}
		}
   */
	   //$codtipocolbotpadrao = $this->codtipocolecaobotanica;
	   $this->colecaobotanica = $this->codcolbot;// $row['codcolbot'];
	   if (empty($this->siglacolecaoorigem))
	   {
			$this->siglacolecaoorigem = $row['siglapj'];
	   }
	   $transaction = pg_exec($this->conn,"BEGIN TRANSACTION;");
       $sql =  ' insert into jabot.individuo (quantidade,populacao) values (1,\'F\');';
       $sql .= ' insert into jabot.acesso (codindividuo) values (currval(\'jabot.individuo_codindividuo_seq\'));';
       
	   // DETACESSO
	   $sqlcampo = "select * from jabot.abatipocolecaocampo atc, jabot.campo c where
					atc.idcampo = c.codcampo and atc.idaba in (2,3,4,5) and tabelaorigem = 'detacesso' and atc.idtipocolecaobotanica = ".$this->codtipocolecaobotanica." ";
					//echo $sqlcampo;
	   $rescampo = pg_exec($this->conn,$sqlcampo);
	    $sqlcampo = '';
		$sqlvalor = '';
		while ($row = pg_fetch_array($rescampo))
		{
			$valor = $this->pegaValorCampo($row['atributo']);

			if (($row['zeroequivalenull']=='t') && ($valor==''))
			{
				$valor="null";
			}
			if ($row['comaspas']=='T'){
				$valor="'".$valor."'";
			}
		  $sqlcampo.=', '.$row['nomecampofisico'];
		  $sqlvalor.=', '.$valor;
		}
	   $sql .= ' insert into jabot.detacesso (det_criadopor, coddetacesso'.$sqlcampo.') values ('.$_SESSION['s_idusuario'].',currval(\'jabot.acesso_codacesso_seq\')'.$sqlvalor.');';

	   // Testemunho
	   $sqlcampo = "select * from jabot.abatipocolecaocampo atc, jabot.campo c where
					atc.idcampo = c.codcampo and atc.idaba in (6,7,8) and tabelaorigem = 'testemunho' and atc.idtipocolecaobotanica = ".$this->codtipocolecaobotanica." ";
	   $rescampo = pg_exec($this->conn,$sqlcampo);
	    $sqlcampo = '';
		$sqlvalor = '';
		while ($row = pg_fetch_array($rescampo))
		{
			$valor = $this->pegaValorCampo($row['atributo']);

			if (($row['zeroequivalenull']=='t') && ($valor==''))
			{
				$valor="null";
			}
			if (($row['comaspas']=='T') && ($row['atributo']!='duplicata'))
			{
				if ($valor !='null')
				{
					$valor="'".$valor."'";
				}
				else
				{
					$valor = "''";
				}
			}
			else
			{
				if ($row['atributo']=='duplicata')
				{
					if ($valor =='null')
					{
						$valor="null";
					}
					if ($valor =='')
					{
						$valor="null";
					}
				}
			}
		  $sqlcampo.=', '.$row['nomecampofisico'];
		  $sqlvalor.=', '.$valor;
		}
		if (!empty($this->numtombo))
		{
			$sqlcamponumtombo = ', numtombo, sufixonumtombo ';
			$sqlvalornumtombo = ", '".$this->numtombo."','".$this->sufixonumtombo."'";
		}
		if (!empty($this->tombado))
		{
			$sqlcampotombado = ', tombado ';
			$sqlvalortombado = ", '".$this->tombado."'";
		}
	   	   $sql .= ' INSERT INTO jabot.testemunho (codacesso'.$sqlcampo.',codbasedados,criadopor, codtipocolbot,codcolbot'.$sqlcamponumtombo.' '.$sqlcampotombado.' ) 
		   values (currval(\'jabot.acesso_codacesso_seq\')'.$sqlvalor.','.$this->codbasedados.','.$_SESSION['s_idusuario'].','.$this->codtipocolecaobotanica.',
		   '.$this->colecaobotanica.' '.$sqlvalornumtombo.' '.$sqlvalortombado.');';

	   // DETERMINACAO
	   $sqlcampo = "select * from jabot.abatipocolecaocampo atc, jabot.campo c where
					atc.idcampo = c.codcampo and atc.idaba = 1 and tabelaorigem = 'determinacao' and atc.idtipocolecaobotanica = ".$this->codtipocolecaobotanica." ";
	   $rescampo = pg_exec($this->conn,$sqlcampo);
	    $sqlcampo = '';
		$sqlvalor = '';
		while ($row = pg_fetch_array($rescampo))
		{
			$valor = $this->pegaValorCampo($row['atributo']);

			if (($row['zeroequivalenull']=='t') && ($valor==''))
			{
				$valor="null";
			}
			if ($row['comaspas']=='T') {
				$valor="'".$valor."'";
			}
		  $sqlcampo.=', '.$row['nomecampofisico'];
		  $sqlvalor.=', '.$valor;
		}
	   $sql .= ' INSERT INTO jabot.determinacao (criadopor,codtestemunho'.$sqlcampo.') values 
	   ('.$_SESSION['s_idusuario'].', currval(\'jabot.testemunho_codtestemunho_seq\')'.$sqlvalor.');';

		 
	// SE O TIPO DE COLEÇÃO FOR DO TIPO VIVA INCLUIR DADOS NA TABELA INDIVIDUO VIVO
//	if (($codtipocolbotpadrao==12) || ($codtipocolbotpadrao==14) || ($codtipocolbotpadrao==15))
//	{

		// INDIVIDUO VIVO
	   $sqlcampo = "select * from jabot.abatipocolecaocampo atc, jabot.campo c where
					atc.idcampo = c.codcampo and atc.idaba = 8 and tabelaorigem = 'individuovivo' and atc.idtipocolecaobotanica = ".$this->codtipocolecaobotanica." ";
	   $rescampo = pg_exec($this->conn,$sqlcampo);
	    $sqlcampo = '';
		$sqlvalor = '';
		while ($row = pg_fetch_array($rescampo))
		{
			$valor = $this->pegaValorCampo($row['atributo']);

			if (($row['zeroequivalenull']=='t') && ($valor==''))
			{
				$valor="null";
			}
			if ($row['comaspas']=='T'){
				$valor="'".$valor."'";
			}
		  $sqlcampo.=', '.$row['nomecampofisico'];
		  $sqlvalor.=', '.$valor;
		}
	   $sql .= ' INSERT INTO jabot.individuovivo (codindividuovivo'.$sqlcampo.') values 
	   (currval(\'jabot.testemunho_codtestemunho_seq\')'.$sqlvalor.')';
//	}
 
//	echo "<STRONG>EM MANUTENÇÃO<STRONG><BR>";
//	echo $sql;
//	exit;

	   $result = pg_exec($this->conn,$sql);
	  // echo pg_last_error($result);
	  // exit;
	   
	   $sql2 = 'select currval(\'jabot.testemunho_codtestemunho_seq\')';
       $result2 = pg_exec($this->conn,$sql2);
       
	   
	   
	   $row2 = pg_fetch_array($result2);
	   
	   if (!$result)
	   {
			$transaction = pg_exec($this->conn,"ROLLBACK;");
//			return 0;
		}
		else
		{
			$transaction = pg_exec($this->conn,"COMMIT;");
			return $row2[0];
		}
//		echo $row2[0];
//		exit;
		
	}
	
	
	public function georef_grdec($grau,$min,$seg,$tipo)
	{
		if(is_null($grau)){
		$grau = 'NULL::integer';
		}if(is_null($min)){
		$min = 'NULL::integer';
		}if(is_null($seg)){
		$seg = 'NULL::integer';
		}	
	
		$sql_geo = "select jabot.georef_grdec(".$grau.", ".$min.", ".$seg.", '".$tipo."')";
		//echo $sql_geo;
		
		
		if ($res_geo = pg_exec($this->conn,$sql_geo))
		{
			$row_geo = pg_fetch_array($res_geo);
			return $row_geo[0];
		}
		else
		{
			return 0;
		}
		
	}
	
	
	public function getDadosRapido($row)
	{

			$this->codtestemunho = $row['codtestemunho'];
		   	$this->codcolbot = $row['codcolbot'];
			$this->codtipocolecaobotanica = $row['codtipocolbot'];
			//------------
			$this->colecaobotanica = $row['colecaobotanica'];
            //---------
		   	$this->codbasedados = $row['codbasedados'];
		   	$this->numtombo = $row['numtombo'];
			$this->tombado = $row['tombado'];
			//-------
			$this->sufixonumtombo = $row['sufixonumtombo'];
			//--------
			$this->siglacolecao = $row['siglapj'];
			//$this->numtomboformatado ='rafael';// $this->formataNumTombo();

	}
	
	
	public function getDados($row)
	{
	// print 'Aqui';
	// $dbname = $_SESSION['dbname'];
	// if($dbname == 'HUENF'){
	// print"<pre>";
	// print_r($row);
	//exit;
	// }
			
			$this->estado_esporifero_0 = $row['estado_esporifero_0'];
			$this->estado_esporifero_i = $row['estado_esporifero_i'];
			$this->estado_esporifero_ii = $row['estado_esporifero_ii'];
			$this->estado_esporifero_iii = $row['estado_esporifero_iii'];
		   	$this->codtestemunho = $row['codtestemunho'];
		   	$this->codcolbot = $row['codcolbot'];
			$this->codtipocolecaobotanica = $row['codtipocolbot'];
			//------------
					   	$this->colecaobotanica = $row['colecaobotanica'];
            //---------
		   	$this->codbasedados = $row['codbasedados'];
		   	$this->numtombo = $row['numtombo'];
			$this->tombado = $row['tombado'];
			//-------
			$this->sufixonumtombo = $row['sufixonumtombo'];
			//--------
			$this->siglacolecao = $row['siglapj'];
			$this->numtomboformatado = $this->formataNumTombo();
			$this->determinacaoHTML = $row['aux_nomecompltaxhtml'];
			
			$this->linhasuperior_html = $row['linhasuperior_html'];
			$this->linhaespecie_html = $row['linhaespecie_html'];
			$this->linhainfra_html = $row['linhainfra_html'];
			$this->detpor = $row['detpor'];
			//echo $this->detpor.'RAFAEL';
			$this->procedenciacompleta = $row['procedencia'];
			$this->observacaocompleta = $row['observacaocompleta'];
			$this->todoscoletores = $row['todoscoletores'];
			$this->datacoletacompleta = $row['datacoletacompleta'];
			$this->projetoexpedicaocompleto = $row['projetoexpedicaocompleto'];
			//---
			$this->nota  = $row['nota'];
			//---
			$this->aff = $row['aff'];
			$this->cf = $row['cf'];
			$this->confirmacao = $row['confirmacao'];
			
			$this->determinacao = $row['aux_nomecompltaxon'];
			$this->codarvtaxon = $row['codarvtaxon'];
			$this->determinacaohospedeiro = $row['aux_nomecompltaxonhospedeiro'];
			$this->codarvtaxonhospedeiro = $row['codarvtaxon_hospedeiro'];
			$this->determinador = $row['aux_detpor'];
			$this->determinadorhospedeiro = $row['detby_hospedeiro'];
			$this->diadeterminacao  = $row['diadeterm'];
			$this->mesdeterminacao  = $row['mesdeterm'];
			$this->anodeterminacao  = $row['anodeterm'];
			$this->codcategoriatypus = $row['codcattypus'];
			//$this->determinador = $this->formataDeterminador();
			$this->coddetacesso = $row['coddetacesso'];
			$this->coddeterminacao = $row['coddeterminacao'];
			//--
			$this->altura = $row['altura'];
			//--

///////////////////////////////////////////////////
////////////// DADOS DA COLETA ////////////////////
///////////////////////////////////////////////////

			$this->coletor = $row['aux_coletprinc'];
			$this->numerocoleta = $row['aux_numcolprinc'];
			$this->coletoresadicionais = $row['aux_coladic'];
			$this->projetoexpedicao = $row['exped'];
			$this->numcoletaprojeto= $row['expednumcol'];
			$this->diacoleta = $row['diaacesso1'];
			$this->mescoleta = $row['mesacesso1'];
			$this->anocoleta = $row['anoacesso1'];
			$this->datacoleta = $this->formata_data($this->diacoleta,$this->mescoleta,$this->anocoleta,'R');
			
			$this->diacoletafinal = $row['diaacesso2'];
			$this->mescoletafinal = $row['mesacesso2'];
			$this->anocoletafinal = $row['anoacesso2'];

			/*$NomeVulgar = new NomeVulgar();
			$NomeVulgar->conn = $this->conn;

			$arr = $NomeVulgar->pegaNomeVulgarTaxon($row['codarvtaxon']);
			$nomevulgar2 = '';
			foreach ($arr as $value) {
				$s .= $value.', ';
			}
			$s = substr($s,0, strlen($s)-2);
			$nomevulgar2 .=$s.'';
			$nomevulgar2 = $nomevulgar2;
			*/
			$this->nomesvulgares = $row['aux_nomevulg'];

			$this->nomevulgar = $nomevulgar2;
			$this->aux_nomevulg = $row['aux_nomevulg'];

//////////////////////////////////////////////////////////////////			

			$this->coletaemcultivo = $row['coletaemcultivo'];
			$this->coletorcultivo = $row['coletorcultivo'];
			$this->numcoleta_cultivo = $row['numcoleta_cultivo'];
			$this->datacoleta_cultivo = $row['datacoleta_cultivo'];
			
			$datatemp = explode("/", $this->datacoleta_cultivo);
			$this->diacoletacultivo = $datatemp[0]; 
			$this->mescoletacultivo = $datatemp[1];
			$this->anocoletacultivo = $datatemp[2];

//////////////////////////////////////////////////////////////////			
//////////////////////////////////////////////////////////////////			
			
			$this->pais = $row['pais'];
			$this->estadoprovincia = $row['estado_prov'];
			$this->cidade = $row['cidade'];
			
			$this->descricaolocal = $row['descrlocal'];
			$this->descricaoambiente = $row['descrambiente'];
			$this->descricaoindividuo = $row['descrindividuo'];
			$this->elevacaoprofundidade = $row['altprof'];
			$this->elevacaoprofundidademaxima = $row['altprofmaxima'];
			$this->unidademedidaelevacao = $row['unidmedaltprof'];
			
			
			$this->dap= $row['dap'];
			$this->unidademedidaaltura = $row['unidmedaltura'];
			
			$this->fuste= $row['fuste'];
			$this->habitat= $row['habitat'];
			$this->habito= $row['habito'];

			$this->usos= $row['usos'];
			$this->frequencia= $row['aux_frequencia'];
			$this->luminosidade= $row['aux_luminosidade'];
			//--
			//$this->unidadeconservacao
			$this->unidadeconservacao = $row['aux_uc'];
			$this->codunidadeconservacao = $row['coduc'];
			//--
			
			$this->procedencia = $row['aux_nomecompunidgeo_invertido'].' '.$row['descrlocal'];
			$this->unidadegeopolitica = $row['aux_nomecompunidgeo_invertido'];
			$this->codunidgeo = $row['codunidgeo'];

			$this->latgrau = $row['latmin_grau'];// = $_REQUEST['edtlatgrau'];
			$this->latmin = $row['latmin_min'];// = $_REQUEST['edtlatmin'];
			$this->latseg = $row['latmin_seg'];// = $_REQUEST['edtlatseg'];
			$this->latns = $row['nortesulac'];// = $_REQUEST['edtlatns'];

			$this->longgrau = $row['longmin_grau'];// = $_REQUEST['edtlonggrau'];
			$this->longmin = $row['longmin_min'];// = $_REQUEST['edtlongmin'];
			$this->longseg = $row['longmin_seg'];// = $_REQUEST['edtlongseg'];
			$this->longlo = $row['lesteoesteac'];// = $_REQUEST['edtlonglo'];

			//--

			$this->latgraumaxima = $row['latmax_grau'];// = $_REQUEST['edtlatgrau'];
			$this->latminmaxima = $row['latmax_min'];// = $_REQUEST['edtlatmin'];
			$this->latsegmaxima = $row['latmax_seg'];// = $_REQUEST['edtlatseg'];
			$this->latnsmaxima = $row['nslatmaxima'];
			

			$this->longgraumaxima = $row['longmax_grau'];// = $_REQUEST['edtlonggrau'];
			$this->longminmaxima = $row['longmax_min'];// = $_REQUEST['edtlongmin'];
			$this->longsegmaxima = $row['longmax_seg'];// = $_REQUEST['edtlongseg'];
			
			$this->longlomaxima = $row['lolongmaxima'];
			
			$this->longmaxns= $row['nslatmaxima'];// = $_REQUEST['edtlongmin'];
			$this->longmaxwe = $row['lolongmaxima'];// = $_REQUEST['edtlongseg'];
			//--

			$this->latitude = $this->georef_grdec($this->latgrau,$this->latmin,$this->latseg,$this->latns);
			$this->longitude = $this->georef_grdec($this->longgrau,$this->longmin,$this->longseg,$this->longlo);

//--
			$this->tipovegetacao = $row['aux_tipovegetacao'];
			
//--
			$this->esteril = $row['esteril'];// = $_REQUEST['edtlonglo'];
			$this->comflor = $row['comflor'];// = $_REQUEST['edtlonglo'];
			$this->combotao = $row['combotao'];// = $_REQUEST['edtlonglo'];
			$this->comflorpassada = $row['comflorpassada'];// = $_REQUEST['edtlonglo'];
			$this->comfruto = $row['comfruto'];// = $_REQUEST['edtlonglo'];
			$this->comfrutoimaturo = $row['comfrutoimat'];
			$this->comfrutomaduro = $row['comfrutomad'];
			$this->comfrutopassado = $row['comfrutopassado'];// = $_REQUEST['edtlonglo'];
			$this->siglacolecaoorigem = $row['siglacolbotorigem'];// = $_REQUEST['edtlonglo'];
			$this->duplicata = $row['aux_duplicatas'];
			if ($this->duplicata == 'null')
			{
				$this->duplicata = '';
			}
			// =
			$this->quantidadeduplicata = $row['qtdestoqueduplic'];// = $_REQUEST['edtlonglo'];
			$this->especimeemcolecoescorrelatas = $row['colecoescorrelatas'];// = $_REQUEST['edtlonglo'];
			$this->citacoesnabibliografia = $row['fontebibliogr'];// = $_REQUEST['edtlonglo'];
			
			$this->dataprep = $row['dataprep'];
			
			$this->metodoprep = $row['metodoprep'];
			
			$this->observacao = $row['observacoes'];
			
			$this->codigobarras = $row['codigobarras'];
			
			$this->emprestado = $this->emprestado($row['codtestemunho']);
			
			$this->desaparecido = $row['desaparecido'];
			//echo $row['procedencia'].'<--';

			
			$this->secao = $row['locfisico1'];// = $_REQUEST['edtlonglo'];
			$this->canteiro = $row['locfisico2'];// = $_REQUEST['edtlonglo'];
			$this->plantadopor = $row['plantadopor'];// = $_REQUEST['edtlonglo'];
			$this->diaplantio = $row['diaplantio'];// = $_REQUEST['edtlonglo'];
			$this->mesplantio = $row['mesplantio'];// = $_REQUEST['edtlonglo'];
			$this->anoplantio = $row['anoplantio'];// = $_REQUEST['edtlonglo'];
			$this->plaqueado = $row['plaqueado'];// = $_REQUEST['edtlonglo'];
			$this->plaquear = $row['plaquear'];// = $_REQUEST['edtlonglo'];
			$this->restaurarplaca = $row['restaurarplaca'];// = $_REQUEST['edtlonglo'];
			
			$this->homenagem = $row['homenagem'];
			
			$this->nomevulgarplaca = $row['placa_nomevulgar'];// = $_REQUEST['edtlonglo'];
			$this->distribuicaogeograficaplaca = $row['placa_distribgeo'];// = $_REQUEST['edtlonglo'];
			//$this->latitudeplantio = $row['esteril'];// = $_REQUEST['edtlonglo'];
			//$this->longitudeplantio = $row['esteril'];// = $_REQUEST['edtlonglo'];
			
			$this->datacomplementar = $row['datacomplementar'];// = $datacomplementar;// = $_REQUEST['edtdatacomplementar'];
			$this->missao=$row['missao'];// = $missao;// = $_REQUEST['edtmissao'];
			$this->historiaexsicata=$row['historiaexsicata'];//= $
			
	}	
	
	public function desenhaHTML($codtestemunho,$logado=false)
	{
		$vcodtestemunho = '';
		$html_imagem = '';
   		$this->getById($codtestemunho);
		$vcodtestemunho = $this->codtestemunho; 
		$numtombo = $this->numtomboformatado;
		$determinacao = $this->determinacaoHTML;
		$determinador = $this->formataDeterminador();
		$coletor = $this->coletor;
		$html_determinacao = '';
		if (!empty($determinacao)) { $html_determinacao.= "<strong>$determinacao</strong>"; } else { $html_determinacao.= "<strong> INDET.</strong>";}
		if (!empty($determinador)) { $html_determinacao.= "<br>$determinador"; } else { $html_determinacao.= " Det.: ";}
		$datacoleta = $this->datacoleta;
		$html_coleta = '';
		if (!empty($coletor)) {	$html_coleta= "<strong>".$coletor."</strong>"; 	}else{ $html_coleta.= "<strong>s/coletor</strong>";}
		if (!empty($this->numerocoleta)){ $html_coleta.=' <strong>'.$this->numerocoleta.'</strong>';}
		if (!empty($datacoleta)) { $html_coleta.= "<br>$datacoleta";} else {$html_coleta.= "<br>s/data";}
		$localizacao = '';
		$html_determinacao.= "<br>Proced&ecirc;ncia: ".$this->procedencia; 
		$html_determinacao.= "<br>Observa&ccedil;&otilde;es: ".$this->observacao; 

		if ($this->codcolbot == '4635')
		{
			$html_determinacao.='<br>Se&ccedil;&atilde;o: '.$this->secao.' Canteiro: '.$this->canteiro.' <a href=\'arboreto.php?cmboxtipo=TOMBO&edtvalor='.$this->numtombo.'\'><i class="fa fa-map-marker"></i></a>';
			$html_determinacao.='<br>Nome vulgar: '.$this->nomevulgar;		
		}
        	$html_imagem="";
		$html_imagem=$this->pegaImagem($codtestemunho,1);

		if (!empty($this->codcategoriatypus))
		{
			$trcolor.= "class='alert alert-typus'";
		}
		else
  		{
			$trcolor = "";
  		}
		if ($this->emprestado=='0')
		{
			$trcolor= "class='alert alert-info'";//"bgcolor='#CCCCCC'";
			$msg_emprestado = '<i class="fa fa-envelope-o"></i> Emprestado</br>';
			$this->emprestado_ = true;
		}
		else
		{
			$msg_emprestado = '';
			$this->emprestado_ = false;
		}

		if ($this->desaparecido=='T')
		{
			$trcolor= "bgcolor='#CCCCCC'";//"bgcolor='#CCCCCC'";
		}
		//print_r($_SESSION['s_colecao']);
		//print( '-->'.$this->codcolbot);
		//print($logado);
		if (($logado==true) && (in_array($this->codcolbot,$_SESSION['s_colecao'])))
		{
			$disabled = 'disabled';
			// 86 = ALTERAR EXSICATA
			//print_r($_SESSION['s_funcao']);
			if (in_array("86", $_SESSION['s_funcao']))
			{
				$disabled = '';
			}
			
			$qtdcopia = 1;
			if ($this->quantidadeduplicata>0)
			{
				$qtdcopia = $qtdcopia + $this->quantidadeduplicata;
			}
			
			$ch = '<input type="checkbox" id="chtestemunho[]" name="chtestemunho[]" value="'.$this->codtestemunho.'"><br>
			<input type="text" id="edtqtd'.$this->codtestemunho.'" name="edtqtd'.$this->codtestemunho.'" value="'.$qtdcopia.'" size="1">';		
			//$btnexcluir = '<button type="button" class="btn btn-warning btn-sm '.$disabled.'" onClick="alterarTestemunho('.$codtestemunho.')"><span class="glyphicon glyphicon-pencil"></span> Editar
//							</button>';

			if (in_array($this->codcolbot,$_SESSION['s_colecao']))
			{
				$disabled = '';
			}
			else
			{
				$disabled = 'disabled';
			}

			
		
			// ACESSO AO MENU gerenciar Colecao Correlata
			$acesso91='class="disabled" '; // desabilita o objeto
			$funcao91 = '';				 // desabilita a funcao
            if (in_array("91", $_SESSION['s_funcao'])) 
			{
				$acesso91 = ''; // habilita o controle
				$funcao91 = 'gerenciarColecaoCorrelata('.$this->codtestemunho.')'; // habilita a função
			}


			// ACESSO AO MENU ENVIAR IMAGEM
			$acesso105='class="disabled" '; // desabilita o objeto
			$funcao105 = '';				 // desabilita a funcao
            if (in_array("105", $_SESSION['s_funcao'])) 
			{
				$acesso105 = ''; // habilita o controle
				$funcao105 = 'enviarImagem('.$this->codtestemunho.')'; // habilita a função
			}
			
			// ACESSO AO MENU GERAR DUPLICATA
			$acesso103='class="disabled" '; // desabilita o objeto
			$funcao103 = '';				 // desabilita a funcao
            if (in_array("103", $_SESSION['s_funcao'])) 
			{
				$acesso103 = ''; // habilita o controle
				$funcao103 = 'gerarDuplicata('.$this->codtestemunho.')'; // habilita a função
			}
			// ACESSO AO MENU REGISTRAR ESPeCIME
			$acesso86='class="disabled" '; // desabilita o objeto
			$funcao86 = '';				 // desabilita a funcao
            if (in_array("86", $_SESSION['s_funcao'])) 
			{
				$acesso86 = ''; // habilita o controle
				$funcao86 = 'alterarTestemunho('.$this->codtestemunho.')'; // habilita a função
			}
			
			
			$opcoes = '<!-- Single button -->
 <div class="input-group">
 
		<div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.$this->numtomboformatado.' <span class="caret"></span></button>
	
  <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li '.$acesso86.'><a onClick="'.$funcao86.'">Alterar</a></li>
          <li '.$acesso103.'><a onClick="'.$funcao103.'">Gerar duplicata</a></li>
          <li '.$acesso91.'><a onClick="'.$funcao91.'">'.'Coleções Correlatas'.'</a></li>
       <!--   <li '.$acesso105.'><a onClick="'.$funcao105.'">Enviar imagem</a></li> -->
   </ul>
</div>
</div>';
			
		}
		else
		{
			if (($this->codcolbot=='23987') || ($this->codcolbot=='21291'))
			{
				$opcoes = $this->codigobarras;
			}
			else
			{
				$opcoes = $this->numtomboformatado;
			}
		
		
			//$opcoes = utf8_encode($this->numtomboformatado);
		}

		
		
		
		$html = ' 
                      <td>'.$ch.'</td>
					  <td nowrap '.$trcolor .'>'.$opcoes.
					  '<br>'.$html_imagem.'</td>
					  <td '.$trcolor .'>'.$html_determinacao.'<br>';
		//$html_colecaocorrelata = $this->pegaColecaoCorrelata($codtestemunho);
		//$html_historicodeterminacao =$this->pegaHistoricoDeterminacao($codtestemunho);
		if (($this->emprestado_==true) || ($this->colecaocorrelata_==true) || ($this->historicodeterminacao_==true))
		{
		$html.='
					  <br><a data-toggle="collapse" data-parent="#accordion" href="#detail'.$this->codtestemunho.'">Mais informa&ccedil;&otilde;es</a>
					  <div id="detail'.$this->codtestemunho.'" class="panel-collapse collapse">
                                        <div class="panel-body">'.$msg_emprestado.'<br>
											'.$html_colecaocorrelata.'<br>
											'.$html_historicodeterminacao.'<br>
                                        </div>
                      </div>';
		}
		$html.='
					  </td>
					  <td nowrap '.$trcolor.'>'.$html_coleta.'<br><i class="fa fa-barcode fa-lg"></i><span> <a href=ficha.php?codtestemunho='.$vcodtestemunho.' target="_blank">'.$vcodtestemunho.'</a></span><br>
					  </td>
					  ';
        echo $html;
	} 
	
	public function desenhaHTMLInterno($row,$logado=true)
	{
	
	//print '<pre>';
	//print_r ($row);
	//print '</pre>';	
	
	$vcodtestemunho = '';
	$html_imagem = '';
		
   		//$this->getById($codtestemunho);
	//	$vcodtestemunho = $row['codtestemunho'];//this->codtestemunho; 
	
	$Configuracao = new Configuracao();
	$Configuracao->conn = $this->conn;		
	$Configuracao->getConfiguracao();
	
	//$Configuracao->tam_codigo_barras;
	
	$codbarrasimagem = str_pad($row['codtestemunho'], $Configuracao->tam_codigo_barras, "0", STR_PAD_LEFT);	
	$vcodtestemunho = $row['siglapj'].$codbarrasimagem;//this->codtestemunho;
	$numtombo = $row['numtombo'];//this->numtomboformatado;
	$determinacao = $row['aux_nomecompltaxon'];
	$sufixo = $row['sufixonumtombo'];
	$taxonhospedeiro = $row['taxonhospedeiro'];
		//-----------------------------------------------
		//-----------------------------------------------
		//-----------------------------------
	$adet = explode(" ",$row['aux_nomecompltaxon']);
	
	header("Content-Type: application/json");
	$obj = NULL;
    $res = NULL;	 
	     if(!empty($adet['1']) & !empty($adet['2']) ){
	    
		$busca = $adet['1']."%20".$adet['2']; //Gênero e espécie
		
		 $jsonData = file_get_contents("http://cncflora.jbrj.gov.br:80/services/api-docs/../assessments/taxon/$busca");
		 
		 $link = "http://cncflora.jbrj.gov.br/portal/pt-br/profile/$busca";
		 $obj = json_decode($jsonData);
      
        
		if(!empty($obj)){
	
	
		if($obj->category == 'LC'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Menos preocupante" src="imagens/lc.png"  class="img-circle" height="30" width="30">';
		}
			if($obj->category == 'CR'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Criticamente em Perigo" src="imagens/cr.png"  class="img-circle" height="30" width="30">';
		}
		
			if($obj->category == 'EN'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Em Perigo" src="imagens/en.png"  class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'VU'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Vulnerável" src="imagens/vu.png"  class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'NT'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Quase ameaçada" src="imagens/nt.png"  class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'DD'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Insuficientes" src="imagens/dd.png"  class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'EX'){
		
		$res = '<img  data-toggle="tooltip" data-placement="top" title=" Extinta" src="imagens/ex.png"  class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'EW'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Extinta na natureza" src="imagens/ew.png"  class="img-circle" height="30" width="30">';
		}
		
		// print"obj: ".$res;
		}else{
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Não informado" src="imagens/ok.png" class="img-circle" height="30" width="30">';
		// $res = "-  NE";
		}
		 }else{
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Não informado" src="imagens/ok.png" class="img-circle" height="30" width="30">';
		 }

		
		//-----------------------------------------------
		//-----------------------------------------------
		$determinador = $this->formataDeterminadorInterno($row['aux_detpor'],$row['diadeterm'],$row['mesdeterm'],$row['anodeterm']);//utf8_encode($this->determinador);
		$coletor =  $row['aux_coletprinc'];//$this->coletor;
		$categtypus =  $row['nomecattypus'];
		$html_determinacao = '';
		if (!empty($determinacao)) { $html_determinacao.= " <strong>$determinacao  <a href='$link' target='_blank' >$res</a></strong> "; } else { $html_determinacao.= "<strong> INDET.</strong>";}
		
		if (!empty($taxonhospedeiro))
		{
			$html_determinacao.='<br><strong>Hospedeiro: </strong>'.$taxonhospedeiro;
		}
		
		if (!empty($determinador)) { $html_determinacao.= "<br>$determinador"; } else { $html_determinacao.= " Det.: ";}
		$datacoleta = $this->formata_data($row['diaacesso1'],$row['mesacesso1'],$row['anoacesso1'],'R');// $this->datacoleta;
		$html_coleta = '';
		if (!empty($coletor)) {	$html_coleta= "<strong>$coletor</strong>"; 	}else{ $html_coleta.= "<strong>s/coletor</strong>";}
		if (!empty($row['aux_numcolprinc'])){ $html_coleta.=' <strong>'.$row['aux_numcolprinc'].'</strong>';}
		if (!empty($datacoleta)) { $html_coleta.= "<br>$datacoleta";} else {$html_coleta.= "<br>s/data";}
		$localizacao = '';
		$html_determinacao.= "<br>Proced&ecirc;ncia: ".$row['aux_nomecompunidgeo_invertido'].', '.$row['descrlocal'];
		
		
		

		
			//adicionado por vander 
		if ((!empty($row['descrindividuo'])))
			{
				$html_determinacao.= "<br>Observa&ccedil;&otilde;es: ".$row['descrindividuo']; 
			}
					
		//adicionado por vander 
		if ((!empty($row['latitude']))  && (!empty($row['longitude'])))
		{
			$html_determinacao.= '<i class="fa fa-map-marker"></i>';
			$html_determinacao.="<br>Coordenadas: <i>Latitude: </i>".$row['latitude'].',<i> Longitude: </i>'.$row['longitude'];
		}
		
		
		
		
		
		
		if (($row['codtipocolbot']=='12') || ($row['codtipocolbot']=='13') || ($row['codtipocolbot']=='14') || ($row['codtipocolbot']=='15'))
		{
			$html_determinacao.= "<br>Localização: <a href='arboreto.php?cmboxtipo=TOMBO&edtvalor=".$row['numtombo']."#RESULTADO' target='_blank'>".$row['locfisico1'].'/'.$row['locfisico2'].'</a>';
			if ($logado==true)
			{
				$html_determinacao.= "<br>Observa&ccedil;&otilde;es: ".$row['observacoes']; 
			}
		}
		
		else
		{
			if (!empty($row['observacoes']))
			{
				$html_determinacao.= "<br>Observa&ccedil;&otilde;es: ".$row['observacoes']; 
			}
		}
		$html_imagem="";
		$this->codcolbot = $row['codcolbot'];//
		
		//print 'codtestemunho: '.$row['codtestemunho'];
		
		$html_imagem=$this->pegaImagem($row['codtestemunho'],1);
		
		//echo $html_imagem;
		if ((!empty($row['codcattypus'])) && ($row['codcattypus']!=402))
		{
			$trcolor.= "class='alert alert-typus'";
		}
		else
  		{
			$trcolor = "";
  		}
		if ($this->emprestado($row['codtestemunho'])=='0')
		{
			$trcolor= "class='alert alert-info'";//"bgcolor='#CCCCCC'";
			$msg_emprestado = '<i class="fa fa-envelope-o"></i> Emprestado</br>';
			$this->emprestado_ = true;
		}
		else
		{
			$msg_emprestado = '';
			$this->emprestado_ = false;
		}

		if ($row['desaparecido']=='T')
		{
			$trcolor= "bgcolor='#CCCCCC'";//"bgcolor='#CCCCCC'";
		}
		
			$qtdcopia = 1;
			if ($row['qtdestoqueduplic']>1)
			{
				$qtdcopia = $row['qtdestoqueduplic'];
			}
		//	print" testemunho ".$row['codtestemunho'];
			$ch = '<input type="checkbox" id="chtestemunho[]" name="chtestemunho[]" value="'.$row['codtestemunho'] .'"><br>
			<input type="text" id="edtqtd'.$row['codtestemunho'].'" name="edtqtd'.$row['codtestemunho'].'" value="'.$qtdcopia.'" size="1">';		
		
		
		if (($row['codcolbot']=='23987') || ($row['codcolbot']=='21291')) 
			{
				$numtombo = $row['codigobarras'];
			}
			else
			{
				// SE A BASE ɠFUNGO.... COLOCO A SIGLA COMO RB
				if ($row['codcolbot']=='25986')
				{
				if(!empty($sufixo)){
					$numtombo = 'RB '.$row['numtombo'].'  '.' - '.$sufixo;;
				}else{
				$numtombo = 'RB '.$row['numtombo'];
				}
				}
				else
				{
				if(!empty($sufixo)){
					$numtombo = $row['siglapj'].' '.$row['numtombo'].'  '.' - '.$sufixo;
					}else{
					$numtombo = $row['siglapj'].' '.$row['numtombo'];
					}
					
				}
			}
		
		
		if (($logado==true) && (in_array($row['codcolbot'],$_SESSION['s_colecao'])))
		{
			$disabled = 'disabled';

			// ACESSO AO MENU gerenciar Colecao Correlata
			$acesso110='class="disabled" '; // desabilita o objeto
			$funcao110 = '';				 // desabilita a funcao
            if (in_array("110", $_SESSION['s_funcao'])) 
			{
				$acesso110 = ''; // habilita o controle
				$funcao110 = 'alterarBaseDados('.$row['codtestemunho'].')'; // habilita a funções
				$menu .= '<li '.$acesso110.'><a onClick="'.$funcao110.'">'.'Migrar para outra base'.'</a></li>';
			}

			// ACESSO AO MENU gerenciar Colecao Correlata
			$acesso113='class="disabled" '; // desabilita o objeto
			$funcao113 = '';				 // desabilita a funcao
            if (in_array("113", $_SESSION['s_funcao'])) 
			{
				$acesso113 = ''; // habilita o controle
				$funcao113 = 'alterarColecaoBotanica('.$row['codtestemunho'].')'; // habilita a função
				$menu .= '<li '.$acesso113.'><a onClick="'.$funcao113.'">'.'Alterar Coleção Botânica'.'</a></li>';
			}


			
			// ACESSO AO MENU gerenciar Colecao Correlata
			$acesso91='class="disabled" '; // desabilita o objeto
			$funcao91 = '';				 // desabilita a funcao
            if (in_array("91", $_SESSION['s_funcao'])) 
			{
				$acesso91 = ''; // habilita o controle
				$funcao91 = 'gerenciarColecaoCorrelata('.$row['codtestemunho'].')'; // habilita a função
				$menu .= '<li '.$acesso91.'><a onClick="'.$funcao91.'">'.'Coleções Correlatas'.'</a></li>';
			}

			// ACESSO AO MENU ENVIAR IMAGEM
			// $acesso105='class="disabled" '; // desabilita o objeto
			// $funcao105 = '';				 // desabilita a funcao
            // if (in_array("105", $_SESSION['s_funcao'])) 
			// {
				// $acesso105 = ''; // habilita o controle
				// $funcao105 = 'enviarImagem('.$row['codtestemunho'].')'; // habilita a função
				// $menu .= '<li '.$acesso105.'><a onClick="'.$funcao105.'">Enviar imagem</a></li>';
			// }
			
			// ACESSO AO MENU GERAR DUPLICATA
			$acesso103='class="disabled" '; // desabilita o objeto
			$funcao103 = '';				 // desabilita a funcao
            if (in_array("103", $_SESSION['s_funcao'])) 
			{
				$acesso103 = ''; // habilita o controle
				$funcao103 = 'gerarDuplicata('.$row['codtestemunho'].')'; // habilita a função
				$menu .= '<li '.$acesso103.'><a onClick="'.$funcao103.'">Gerar duplicata</a></li>';
			}
			// ACESSO AO MENU REGISTRAR ESPECIME
			$acesso86='class="disabled" '; // desabilita o objeto
			$funcao86 = '';				 // desabilita a funcao
            if ((in_array("86", $_SESSION['s_funcao'])) || ($row['codbasedados']==$_SESSION['s_ultimatrabalhada'])) 
			{
				$acesso86 = ''; // habilita o controle
				$funcao86 = 'alterarTestemunho('.$row['codtestemunho'].')'; // habilita a função
				$menu .= '<li '.$acesso86.'><a target="_blank" onClick="'.$funcao86.'">Alterar</a></li>';
			}
	
	     
	
	
			// ACESSO AO MENU REGISTRAR ESPECIME
			$acesso87='class="disabled" '; // desabilita o objeto
			$funcao87 = '';				 // desabilita a funcao
            if (in_array("87", $_SESSION['s_funcao'])) 
			{
				$acesso87 = ''; // habilita o controle
				$funcao87 = 'excluirTestemunho('.$row['codtestemunho'].')'; // habilita a função
				$menu .= '<li '.$acesso87.'><a onClick="'.$funcao87.'">Excluir</a></li>';
			}
			
			
			
			
			$opcoes = '<!-- Single button -->
 <div class="input-group">
 
		<div class="input-group-btn">
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.$numtombo.'  <span class="caret"></span></button>
	
  <ul class="dropdown-menu dropdown-menu-right" role="menu">
  '.$menu.'
   </ul>
</div>
</div>';

		}
		else
		{
			$opcoes = $numtombo;
			//utf8_encode($row['siglapj'].' '.$row['numtombo']);
		}

		$html = ' 
                      <td '.$trcolor .'>'.$ch.'</td>
					  <td nowrap '.$trcolor .'>'.$opcoes.
					  '<br>'.$html_imagem.'</td>
					  
					  <td '.$trcolor .'>'.$html_determinacao.'<br>';
		if ($this->cons_colecaocorrelata==true)
		{
			$html_colecaocorrelata = $this->pegaColecaoCorrelata($row['codtestemunho']);
		}
		if ($this->cons_historicodeterminacao==true)
		{
			$html_historicodeterminacao =$this->pegaHistoricoDeterminacao($codtestemunho);
		}
		if (($this->emprestado_==true) || ($this->colecaocorrelata_==true) || ($this->historicodeterminacao_==true))
		{
		$html.='
					  <br><a data-toggle="collapse" data-parent="#accordion" href="#detail'.$row['codtestemunho'].'">Mais informa&ccedil;&otilde;es</a>
					  <div id="detail'.$row['codtestemunho'].'" class="panel-collapse collapse">
                                        <div class="panel-body">'.$msg_emprestado.'<br>
											'.$html_colecaocorrelata.'<br>
											'.$html_historicodeterminacao.'<br>
                                        </div>
                      </div>';
		}
		
		if (!empty($categtypus))
		{
			$s_categoriatypus = '<br>Cat. typus: '.$categtypus;
		}
		if (!empty($row['nomebase']))
		{
			$s_nomebase = '<i class="fa fa-database"></i> '.$row['nomebase'];
		}
		$html.=$s_nomebase.$s_categoriatypus.'
					  </td>
					  <td nowrap '.$trcolor.'>'.$html_coleta.'<br><i class="fa fa-barcode fa-lg"></i><span> <a href=ficha.php?codtestemunho='.$row['codtestemunho'].' target="_blank">'.$vcodtestemunho.'</a></span><br>
					  </br>Última alteração:<br><b>'.date('d/m/Y h:i',strtotime($row['dataultalter'])).' </b><a alt="'.$row['alteradopor'].'"><a onclick="alert(\'Usuário código: '.$row['alteradopor'].'\')"><i class="fa fa-user"></a></i>  
					  </td>
					  ';
        echo $html;
	} 
		
	public function desenhaHTMLPublico($row)
	{
		
	/* //print 'Aqui';
	$dbname = $_SESSION['dbname'];
	print 'Aqui'.$dbname;
	if($dbname == 'HUENF'){
	print"<pre>";
	print_r($row);
	exit;
	} */
	
	//print"<pre>";
	//print_r($row);
	
		if($row['familia'] == $row['taxoncompleto']){
			$taxoncompleto = $row['taxoncompleto'];
			$taxoncompleto_etiqueta = $row['taxoncompleto'];
			
		}else{
			if (strstr($row['taxoncompleto'], $row['familia'])) {
		        $taxoncompleto = $row['taxoncompleto'];
		        $taxoncompleto_etiqueta = $row['taxoncompleto'];
		    }else{
		    	$taxoncompleto = $row['familia'].' '.$row['taxoncompleto'];
				$taxoncompleto_etiqueta = $row['familia'].'  '.'<i>'.$row['taxoncompleto'].'</i>';
		    }
			
		}

	$taxonhospedeiro = $row['taxonhospedeiro'];
	  
		$vcodtestemunho = '';
		$html_imagem = '';
   		//$this->getById($row['codtestemunho']);
	//	$vcodtestemunho = $row['codtestemunho'];
	
	$Configuracao = new Configuracao();
	$Configuracao->conn = $this->conn;		
	$Configuracao->getConfiguracao();
	
	//$Configuracao->tam_codigo_barras;
	
	  $codbarrasimagem = str_pad($row['codtestemunho'], $Configuracao->tam_codigo_barras, "0", STR_PAD_LEFT);

      $vcodtestemunho =$row['siglacolecao']. $codbarrasimagem;//this->codtestemunho;	
	
		$this->codcolbot = $row['codcolbot'];
		$numtombo = $row['siglacolecao'].'- '.$row['numtombo'];// $this->numtomboformatado;
		$determinacao = $taxoncompleto;//utf8_encode($this->determinacaoHTML);		
		
		
		$determinacao_etiqueta = $taxoncompleto_etiqueta;
		$determinador = $row['detpor'];//utf8_encode($this->formataDeterminador());//utf8_encode($this->determinador);
		
		
		//-----------------------------------------------
		//-----------------------------------------------
		//----------------------------------- Estado de conservação
		
		$adet = explode(" ",$taxoncompleto);
	
	header("Content-Type: application/json");
	 $obj = NULL;
     $res = NULL;	 
	     if(!empty($adet['1']) & !empty($adet['2']) ){
	     $busca = $adet['1']."%20".$adet['2'];
	
		 $jsonData = file_get_contents("http://cncflora.jbrj.gov.br:80/services/api-docs/../assessments/taxon/$busca");
		 
		 $link = "http://cncflora.jbrj.gov.br/portal/pt-br/profile/$busca";
		 $obj = json_decode($jsonData);
      
        
		if(!empty($obj)){
	
	
		if($obj->category == 'LC'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Menos preocupante" src="imagens/lc.png" alt="" class="img-circle" height="30" width="30">';
		}
			if($obj->category == 'CR'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Criticamente em Perigo" src="imagens/cr.png" alt="" class="img-circle" height="30" width="30">';
		}
		
			if($obj->category == 'EN'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Em Perigo" src="imagens/en.png" alt="Em perigo" class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'VU'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Vulnerável" src="imagens/vu.png" alt="Vulnerável" class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'NT'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Quase ameaçada" src="imagens/nt.png" alt="Quase ameaçada" class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'DD'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Insuficientes" src="imagens/dd.png" alt="Dados insuficientes" class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'EX'){
		
		$res = '<img  data-toggle="tooltip" data-placement="top" title=" Extinta" src="imagens/ex.png" alt="Extinta" class="img-circle" height="30" width="30">';
		}
		
				if($obj->category == 'EW'){
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Extinta na natureza" src="imagens/ew.png" alt="Extinta na natureza" class="img-circle" height="30" width="30">';
		}
		
	//	$res = "-  ".$obj->category; 
		
		// print"obj: ".$res;
		}else{
		
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Não informado" src="imagens/ok.png" alt="Não Encontrada" class="img-circle" height="30" width="30">';
		// $res = "-  NE";
		}
		 }else{
		$res = '<img data-toggle="tooltip" data-placement="top" title=" Não informado" src="imagens/ok.png" alt="Não Encontrada" class="img-circle" height="30" width="30">';
		 }

		
		//-----------------------------------------------
		//-----------------------------------------------
		
	
		
		
		
		
		
		
		
		
		$coletor = $row['coletor'];//$this->coletor;
		$html_determinacao = '';
		if (!empty($determinacao)) { $html_determinacao.= "
<strong>$determinacao  <a href='$link' target='_blank' > $res </a></strong>"; } else { $html_determinacao.= "<strong> INDET.</strong>";}
		
		if (!empty($taxonhospedeiro))
		{
			$html_determinacao.='<br><strong>Hospedeiro: </strong>'.$taxonhospedeiro;
		}
		if (!empty($determinador)) { $html_determinacao.= "<br>$determinador"; } else { $html_determinacao.= " Det.: ";}
		$datacoleta = $row['datacoleta'];// $this->datacoleta;
		$html_coleta = '';
		if (!empty($row['coletor'])) {	$html_coleta= "<strong>$coletor</strong>"; 	}else{ $html_coleta.= "<strong>s/coletor</strong>";}
		if (!empty($row['numcoleta'])){ $html_coleta.=' <strong>'.$row['numcoleta'].'</strong>';} //$this->numerocoleta
		if (!empty($datacoleta)) { $html_coleta.= "<br>$datacoleta";} 
		$localizacao = '';
		$html_determinacao.= "<br>Proced&ecirc;ncia: ".$row['aux_nomecompunidgeo_invertido'].' '.$row['descrlocal']; 
		if ($row['siglacolecao']=='RBv')
		{
			$html_determinacao.= "<br>Localização: <a href='arboreto.php?cmboxtipo=TOMBO&edtvalor=".$row['numtombo']."#RESULTADO' target='_blank'>".$row['locfisico1'].'/'.$row['locfisico2'].'</a>';
			if (!empty($row['plantadopor']))
			{
				$html_determinacao.= "<br><strong>Plantado por:</strong> ".$row['plantadopor'];
			}
		}
		else
		{
			if (!empty($row['notas']))
			{
				$html_determinacao.= "<br>Observa&ccedil;&otilde;es: ".$row['notas']; 
			}
		}

        	$html_imagem="";
		$html_imagem=$this->pegaImagem($row['codtestemunho'],1);

		if ((!empty($row['nat_typus'])) && ($row['nat_typus']!='?'))
		{
			$trcolor.= "class='alert alert-typus'";
		}
		else
  		{
			$trcolor = "";
  		}
		
		if ($this->emprestado($row['codtestemunho'])=='0')
		{
			$trcolor= "class='alert alert-info'";//"bgcolor='#CCCCCC'";
			$msg_emprestado = '<i class="fa fa-envelope-o"></i> Emprestado</br>';
			$this->emprestado_ = true;
		}
		else
		{
			$msg_emprestado = '';
			$this->emprestado_ = false;
		}
		
		if ($row['desaparecido']=='T')
		{
			$trcolor= "bgcolor='#CCCCCC'";//"bgcolor='#CCCCCC'";
		
		}
		
		$Configuracao = new Configuracao();
		$Configuracao->conn = $this->conn;		
		$Configuracao->getConfiguracao();
		
		$codcolinformatizacao = explode(',', $Configuracao->codcolinformatizacao);
		
		if (in_array( $row['codcolbot'], $codcolinformatizacao))
			{
			
		//($row['codcolbot']=='23987') || ($row['codcolbot']=='21291')
				$numtombo = $row['codigobarras'];
			}
			else
			{
				//Não se aplica a outros herbários
				// SE A BASE ɠFUNGO.... COLOCO A SIGLA COMO RB
				if ($row['codcolbot']=='25986')
				{
					$numtombo = 'RB '.$row['numtombo'];
				}
				else
				{
					$numtombo = $row['siglacolecao'].' '.$row['numtombo'];
				}
		}
//		$numtombo.='-'.$row['siglacolecao'];
		
		
		$opcoes = $numtombo;

		$html = ' 
                      <td>'.$ch.'</td>
					  <td nowrap '.$trcolor .'>'.$opcoes.
					  '<br>'.$html_imagem.'</td>
					  <td '.$trcolor .'>'.$html_determinacao.'<br>';
		$html_colecaocorrelata = $this->pegaColecaoCorrelata($row['codtestemunho']);
		$html_historicodeterminacao =$this->pegaHistoricoDeterminacao($row['codtestemunho']);
		if (($this->emprestado_==true) || ($this->colecaocorrelata_==true) || ($this->historicodeterminacao_==true))
		{
		$html.='
					  <br><a data-toggle="collapse" data-parent="#accordion" href="#detail'.$row['codtestemunho'].'">Mais informa&ccedil;&otilde;es</a>
					  <div id="detail'.$row['codtestemunho'].'" class="panel-collapse collapse">
                                        <div class="panel-body">'.$msg_emprestado.'<br>
											'.$html_colecaocorrelata.'<br>
											'.$html_historicodeterminacao.'<br>
                                        </div>
                      </div>';
		}
		$html.='
					  </td>
					  <td nowrap '.$trcolor.'>'.$html_coleta.'<br><i class="fa fa-barcode fa-lg"></i><span> <a href=ficha.php?codtestemunho='.$row['codtestemunho'].' target="_blank">'.$vcodtestemunho.'</a></span><br>
					  </td>
					  ';
        echo $html;
	} 



		public function adicionaDeterminacao($codtestemunho,$codarvtaxon,$determinador,$diadeterminacao,$mesdeterminacao,$anodeterminacao,$codcategoriatypus,$notadeterminacao='',$cf,$aff,$confirmacao)
	{
		if (empty($diadeterminacao))
		{
			$diadeterminacao = 'null';
		}
		
		if (empty($mesdeterminacao))
		{
			$mesdeterminacao = 'null';
		}
		if (empty($anodeterminacao))
		{
			$anodeterminacao = 'null';
		}
		if (empty($codcategoriatypus))
		{
			$codcategoriatypus = 'null';
		}
		if (empty($cf)){ $cf = 'null';}else{ $cf = "'T'";}
		if (empty($aff)){ $aff = 'null';}else{ $aff = "'T'";}
		if (empty($confirmacao)){ $confirmacao = 'null';}else{ $confirmacao = "'T'";}
		
		
		$sql_begin = "BEGIN;";
		$res_begin = pg_exec($this->conn,$sql_begin);
		
		
		
		
		$sql = "insert into jabot.determinacao (codarvtaxon,aux_detpor,codtestemunho,diadeterm,mesdeterm,anodeterm,codcattypus,nota,aff,cf,confirmacao)
		values (".$codarvtaxon.",'".$determinador."',".$codtestemunho.",".$diadeterminacao.",".$mesdeterminacao.",".$anodeterminacao.",".$codcategoriatypus.",'".$notadeterminacao."',$cf,$aff,$confirmacao);";
		//echo $sql.'<br>';
		// exit;
		
		$res = pg_exec($this->conn,$sql);
		
		//if($res)
		//print 'ok - $res <br>';
		
		$sql1 = " select t.numtombo,t.codtestemunho,a.codarvtaxon,a.aux_nomecompltaxon,
				a.codarvtaxon,ugp.codunidgeo,ugp.aux_nomecomplunidgeo, *
				 from jabot.testemunho t, jabot.determinacao det,
				jabot.arvoretaxon a, jabot.unidgeopolitica ugp,
				jabot.detacesso deta
				where
				t.codtestemunho = t.codtestemunho and
				t.ultimadeterm = det.coddeterminacao and
				det.codarvtaxon = a.codarvtaxon and
				t.codacesso = deta.coddetacesso and
				deta.codunidgeo = ugp.codunidgeo and
				 t.codtestemunho = ".$codtestemunho;
				 
		//echo $sql1.'<br>';		 


	   $restestemunho = pg_exec($this->conn,$sql1);
	   $rowtestemunho = pg_fetch_array($restestemunho);
	
		$sqllog = "insert into jabot.log_testemunho (op,login,ip,codtestemunho,taxon,unidadegeopolitica,codunidgeo,codarvtaxon,numtombo)
		values ('A','".$_SESSION['s_idusuario']."','".$_SERVER["REMOTE_ADDR"]."',".$codtestemunho.",'".$this->Aspas_ao_Gravar($rowtestemunho['aux_nomecompltaxon'])."',
		'".$this->Aspas_ao_Gravar($rowtestemunho['aux_nomecomplunidgeo'])."',".$rowtestemunho['codunidgeo'].",".$rowtestemunho['codarvtaxon'].",'".$rowtestemunho['numtombo']."');";
		//echo $sqllog.'<br>';
		//exit;
		
			
		$res2 = pg_exec($this->conn,$sqllog);	
		
		// if($res2)
		// print 'ok - $res2 <br>';
		
			
		if ($res && $res2)
		{
		// print 'aqui -  OK';
		//exit;
			$sql_end = "END;";
			$res_end = pg_exec($this->conn,$sql_end);
			
			return true;
		}
		else
		{	
		//print 'aqui -  ERRO';
		//exit;
			$sql_rollback = "ROLLBACK;";
			$res_rollback = pg_exec($this->conn,$sql_rollback);
			
			return false;
		}
	
	
	
	}
			
	
public function AlterarDeterminacao($codtestemunho,$codarvtaxon,$determinador,$diadeterminacao,$mesdeterminacao,$anodeterminacao,$codcategoriatypus,$notadeterminacao='',$coddeterminacao)
	{
		if (empty($diadeterminacao))
		{
			$diadeterminacao = 'null';
		}
		
		if (empty($mesdeterminacao))
		{
			$mesdeterminacao = 'null';
		}
		if (empty($anodeterminacao))
		{
			$anodeterminacao = 'null';
		}
		if (empty($codcategoriatypus))
		{
			$codcategoriatypus = 'null';
		}
		
		$sql_begin = "BEGIN;";
		$res_begin = pg_exec($this->conn,$sql_begin);
		
		
		
		$sql = "update jabot.determinacao set codarvtaxon = ".$codarvtaxon.", 
		aux_detpor = '".$determinador."', diadeterm = ".$diadeterminacao.",mesdeterm = ".$mesdeterminacao.",
		anodeterm = ".$anodeterminacao.",codcattypus = ".$codcategoriatypus.", nota = '".$notadeterminacao."' 
		where coddeterminacao = ".$coddeterminacao."
		; ";
		// echo $sql;
		// exit;
		
		
		$res = pg_exec($this->conn,$sql);
		
		
		
		
		
		$sql1 = " select t.numtombo,t.codtestemunho,a.codarvtaxon,a.aux_nomecompltaxon,
				a.codarvtaxon,ugp.codunidgeo,ugp.aux_nomecomplunidgeo
				 from jabot.testemunho t, jabot.determinacao det,
				jabot.arvoretaxon a, jabot.unidgeopolitica ugp,
				jabot.detacesso deta
				where
				t.codtestemunho = t.codtestemunho and
				t.ultimadeterm = det.coddeterminacao and
				det.codarvtaxon = a.codarvtaxon and
				t.codacesso = deta.coddetacesso and
				deta.codunidgeo = ugp.codunidgeo and
				 t.codtestemunho = ".$codtestemunho;
	//echo $sql1;
	   $restestemunho = pg_exec($this->conn,$sql1);
	   $rowtestemunho = pg_fetch_array($restestemunho);
	
		$sqllog = "insert into jabot.log_testemunho (op,login,ip,codtestemunho,taxon,unidadegeopolitica,codunidgeo,codarvtaxon,numtombo)
		values ('A','".$_SESSION['s_idusuario']."','".$_SERVER["REMOTE_ADDR"]."',".$codtestemunho.",'".$rowtestemunho['aux_nomecompltaxon']."',
		'".$rowtestemunho['aux_nomecomplunidgeo']."',".$rowtestemunho['codunidgeo'].",".$rowtestemunho['codarvtaxon'].",'".$rowtestemunho['numtombo']."');";
	//	echo $sqllog;
	//	exit;
		
		$res2 = pg_exec($this->conn,$sqllog);	
		
		
		
		if ($res && $res2)
		{
			$sql_end = "END;";
			$res_end = pg_exec($this->conn,$sql_end);
			
			return true;
		}
		else
		{	
			$sql_rollback = "ROLLBACK;";
			$res_rollback = pg_exec($this->conn,$sql_rollback);
			
			return false;
		}
	
	
	
	}		
	
		
	public function adicionaColecaoCorrelata($codtestemunho,$codtestemunhocorrelato,$portombo='T',$codusuario,$alt)
	{
		if (!empty($codtestemunho))
		{
			if($portombo == 'T'){
				$sql2 = "select t.codtestemunho,upper(pj.siglapj || t.numtombo) 
				from jabot.testemunho t, jabot.colecaobotanica cb, pessoajuridica pj 
				where t.codcolbot = cb.codcolecaobot and
				cb.codcolecaobot = pj.codpj and
				(upper(pj.siglapj || t.numtombo)) = trim(upper(replace('".$codtestemunhocorrelato."',' ','')))";
				print $sql;
				//exit;
				
				$res = pg_exec($this->conn,$sql2);
				if (pg_numrows($res)>0)
				{
					$row = pg_fetch_array($res);
					$codtestemunhocorrelato = $row['codtestemunho'];
				}
			}
			
			
			$sql = "insert into jabot.colecao_correlata values($codtestemunho,$codtestemunhocorrelato,'$alt',$codusuario);";
			 // echo $sql;
			 // exit;
			$res = pg_exec($this->conn,$sql);
			if (!$res)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}
		
	public function DeterminacaoLoteColecaoCorrelata($codtestemunhocorrelato,$codtestemunho)
	{
	//print '<br>testemunho1: '.$codtestemunhocorrelato; //Testemunho de outa coleção (correlata)
	//print '<br>testemunho2: '.$codtestemunho; //Testemunho  RB
	//exit;	
	
		if (!empty($codtestemunhocorrelato) && !empty($codtestemunho))
		{
		//Pega os dados da determinacao no codtestemunho e salva uma nova determinacao com o codtestemunhocorrelato
			$sql = "select d.* from  jabot.determinacao d
					inner join jabot.testemunho t on t.ultimadeterm = d.coddeterminacao
					where t.codtestemunho = ".$codtestemunho;
			
			$res = pg_exec($this->conn,$sql);	
			$row = pg_fetch_array($res);
	
			//print_r ($_SESSION);
			
			$alteradopor = $_SESSION['s_idusuario'];
			$dataultalter = "'".date('Y-m-d')."'";
			$codarvtaxon = $row['codarvtaxon'];
			
		
			if(!empty( $row['diadeterm'])){		
				$diadeterm = "'".$row['diadeterm']."'";
			}else{$diadeterm = 'NULL';}	
			
			if(!empty( $row['mesdeterm'])){		
				$mesdeterm = "'".$row['mesdeterm']."'";
			}else{$mesdeterm = 'NULL';}
			
					
			if(!empty( $row['anodeterm'])){		
				$anodeterm = "'".$row['anodeterm']."'";
			}else{$anodeterm = 'NULL';}	
			
			if(!empty( $row['aux_detpor'])){		
				$aux_detpor = "'".$row['aux_detpor']."'";
			}else{$aux_detpor = 'NULL';}	
			
			if(!empty( $row['aff'])){		
				$aff = "'".$row['aff']."'";
			}else{$aff = 'NULL';}	
			
			if(!empty( $row['cf'])){		
				$cf = "'".$row['cf']."'";
			}else{$cf = 'NULL';}	
			
			if(!empty( $row['codcattypus'])){		
				$codcattypus = "'".$row['codcattypus']."'";
			}else{$codcattypus = 'NULL';}	
			
			if(!empty( $row['confirmacao'])){		
				$confirmacao = "'".$row['confirmacao']."'";
			}else{$confirmacao = 'NULL';}	
			
			if(!empty( $row['aux_datadet'])){		
				$aux_datadet = "'".$row['aux_datadet']."'";
			}else{$aux_datadet = 'NULL';}	
			
			if(!empty( $row['etiqouplaca'])){		
				$etiqouplaca = "'".$row['etiqouplaca']."'";
			}else{$etiqouplaca = 'NULL';}	
			
			if(!empty( $row['datacriacao'])){		
				$datacriacao = "'".$row['datacriacao']."'";
			}else{$datacriacao = 'NULL';}	
			
			if(!empty( $row['aux_datadetcalc'])){		
				$aux_datadetcalc = "'".$row['aux_datadetcalc']."'";
			}else{$aux_datadetcalc = 'NULL';}	
			
			if(!empty( $row['nota'])){		
				$nota = "'".$row['nota'].' [determinação por coleção correlata]'."'";
			}else{$nota = "'".'[determinação por coleção correlata]'."'";}	
			
			
			
			if(!empty( $row['codarvtaxon_hospedeiro'])){		
				$codarvtaxon_hospedeiro = "'".$row['codarvtaxon_hospedeiro']."'";
			}else{$codarvtaxon_hospedeiro = 'NULL';}	
			
			if(!empty( $row['detby_hospedeiro'])){		
				$detby_hospedeiro = "'".$row['detby_hospedeiro']."'";
			}else{$detby_hospedeiro = 'NULL';}	
				
				
		
			$sql = 'insert into jabot.determinacao (codarvtaxon,codtestemunho,diadeterm,mesdeterm,anodeterm,aux_detpor,aff,cf,codcattypus,confirmacao,aux_datadet,etiqouplaca,datacriacao,aux_datadetcalc,nota,codarvtaxon_hospedeiro,detby_hospedeiro,alteradopor,dataultalter)
			values('.$codarvtaxon.','.$codtestemunhocorrelato.','.$diadeterm.','.$mesdeterm.','.$anodeterm.','.$aux_detpor.','.$aff.','.$cf.','.$codcattypus.','.$confirmacao.','.$aux_datadet.','.$etiqouplaca.','.$datacriacao.','.$aux_datadetcalc.','.$nota.','.$codarvtaxon_hospedeiro.','.$detby_hospedeiro.','.$alteradopor.','.$dataultalter.')';
			//echo $sql;
			//exit;
			
		
			
			
			
				
			$sql1 = " select t.numtombo,t.codtestemunho,a.codarvtaxon,a.aux_nomecompltaxon,
				a.codarvtaxon,ugp.codunidgeo,ugp.aux_nomecomplunidgeo, *
				 from jabot.testemunho t, jabot.determinacao det,
				jabot.arvoretaxon a, jabot.unidgeopolitica ugp,
				jabot.detacesso deta
				where
				t.codtestemunho = t.codtestemunho and
				t.ultimadeterm = det.coddeterminacao and
				det.codarvtaxon = a.codarvtaxon and
				t.codacesso = deta.coddetacesso and
				deta.codunidgeo = ugp.codunidgeo and
				 t.codtestemunho = ".$codtestemunhocorrelato;

			//print '<br>'.$sql1;			
		   $restestemunho = pg_exec($this->conn,$sql1);
		   $rowtestemunho = pg_fetch_array($restestemunho);
		
			$sqllog = "insert into jabot.log_testemunho (op,login,ip,codtestemunho,taxon,unidadegeopolitica,codunidgeo,codarvtaxon,numtombo)
			values ('A','".$alteradopor."','".$_SERVER["REMOTE_ADDR"]."',".$codtestemunhocorrelato.",'".$rowtestemunho['aux_nomecompltaxon']."',
			'".$rowtestemunho['aux_nomecomplunidgeo']."',".$rowtestemunho['codunidgeo'].",".$rowtestemunho['codarvtaxon'].",'".$rowtestemunho['numtombo']."');";
			
			//echo '<br>'.$sqllog;
			//exit;
			
			pg_exec($this->conn,$sqllog);	
			
			$res = pg_exec($this->conn,$sql);
			
		
			if (!$res)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
		
	}
	
	public function adicionarDigitacao($tipo,$codcolbot,$codusuario)
	{
		$sql = "select * from jabot.reflora_imagem ri where origem = '".$tipo."' and iniciodigitacao is null limit 1 ";
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0)
		{
			$row = pg_fetch_array($res);
			$codigobarra = $row['codigobarra'];
			$sql2=" update jabot.reflora_imagem set digitadopor=".$codusuario.", iniciodigitacao  = now(),status = 1 where codigobarra = '".$codigobarra."'";
			$res = pg_exec($this->conn,$sql2);
		
			
		// CODUNIDGEO 18515 = '?'
		// CODBASEDADOS 8923 - INFORMATIZAÇÃO HERBÁRIO
		// TAXON 850844 = INDETERMINADA
		
		
			
		
		
		
		$sql="
		insert into jabot.individuo (quantidade,populacao) values (1,'F'); 
		
		insert into jabot.acesso (codindividuo) values (currval('jabot.individuo_codindividuo_seq')); 
		
		insert into jabot.detacesso (det_criadopor, coddetacesso, aux_coletprinc, aux_coladic, diaacesso1, mesacesso1, anoacesso1, diaacesso2, 
		mesacesso2, anoacesso2, aux_nomevulg, aux_numcolprinc, exped, expednumcol, codunidgeo, descrlocal, descrambiente, latmin_grau, latmin_min, 
		latmin_seg, nortesulac, longmin_grau, longmin_min, longmin_seg, lesteoesteac, latmax_grau, latmax_min, latmax_seg, nslatmaxima, longmax_grau, 
		longmax_min, longmax_seg, lolongmaxima, aux_uc, altprof, unidmedaltprof, altprofmaxima, aux_tipovegetacao, descrindividuo, altura, unidmedaltura, 
		habitat, habito, usos, aux_frequencia, dap, fuste, aux_luminosidade) 
		values (".$codusuario.",currval('jabot.acesso_codacesso_seq'), '', '', '', '', '', null, null, null, '', '', '', '', 18515, '', '', 
		null, null, null, 'S', null, null, null, 'W', null, null, null, 'S', null, null, null, 'W', '', '', null, '', '', '', '', 
		null, '', '', '', '', null, null, ''); 
		
		INSERT INTO jabot.testemunho (codacesso, comflor, combotao, observacoes, comfruto, aux_duplicatas, siglacolbotorigem, comfrutoimat, comfrutomad, comflorpassada, 
		comfrutopassado, esteril, qtdinicialduplic, fontebibliogr, colecoescorrelatas,codbasedados,codtipocolbot,codcolbot,codigobarras,tiponumtombo,tipoinclusao) 
		values (currval('jabot.acesso_codacesso_seq'), '', '', '', '', '0', '', '', '', '', '', '', null, '', '',8923,1, ".$codcolbot.",'".$codigobarra."','S','D');
		
		INSERT INTO jabot.determinacao (criadopor,codtestemunho, cf, aff, confirmacao, codarvtaxon, aux_detpor, diadeterm, mesdeterm, 
		anodeterm, codcattypus, nota) 
		values (".$codusuario.", currval('jabot.testemunho_codtestemunho_seq'), '', '', '', 850844, '', null, null, null, null, ''); 

		";
		
		
//		$sql.=" update jabot.reflora_imagem set digitadopor=".$codusuario.", iniciodigitacao  = now(),status = 1 where codigobarra = '".$codigobarra."'";
		
//		echo $sql;
//		exit;
		$transaction = pg_exec($this->conn,"BEGIN TRANSACTION;");
			//echo $sql_excluitest;
			//exit;
			
			$result_excluitest = pg_exec($this->conn, $sql);
			//$result_excluitest = false;
			if (!$result_excluitest)
			{
				$transaction = pg_exec($this->conn,"ROLLBACK;");
				//return false;
			}
			else
			{
				$sql3=" select * from jabot.testemunho where codigobarras = '".$codigobarra."'";
				$res3 = pg_exec($this->conn,$sql3);
				if (pg_num_rows($res3)==1)
				{	
					
					$transaction = pg_exec($this->conn,"COMMIT;");
				}
				else
				{
					$transaction = pg_exec($this->conn,"ROLLBACK;");
				}
				//return true;
			}
			
	   $sql2 = 'select currval(\'jabot.testemunho_codtestemunho_seq\')';
       $result2 = pg_exec($this->conn,$sql2);
	   $row = pg_fetch_array($result2);
	   }
	   else
	   {
			$row[0]=0;
	   }
	   return $row[0];
	}

	public function excluirColecaoCorrelata($codtestemunho,$codtestemunhocorrelato)
	{
		if (!empty($codtestemunho))
		{
			$sql = 'delete from jabot.colecao_correlata 
			where codtestemunho = '.$codtestemunho.'
			and codtestemunho_colcorrelata = '.$codtestemunhocorrelato.';
			delete from jabot.colecao_correlata 
			where codtestemunho = '.$codtestemunhocorrelato.'
			and codtestemunho_colcorrelata = '.$codtestemunho.';';
			$res = pg_exec($this->conn,$sql);
//			echo $sql;
//			exit;
			if (!$res)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}


	
	public function pegaColecaoCorrelata($codtestemunho,$op='')
	{
		
	
		if (empty($codtestemunho))
		{
			$codtestemunho = 0;
		}
		$html = '';
		$sql = 'select codtestemunho_colcorrelata from jabot.colecao_correlata cc where
			cc.codtestemunho = '.$codtestemunho.'
			union
			select codtestemunho from jabot.colecao_correlata cc where
			cc.codtestemunho_colcorrelata = '.$codtestemunho.'
			group by 1';
		//echo $sql;
		
		$res = pg_exec($this->conn,$sql);
		$this->colecaocorrelata_ = false;
		if (pg_numrows($res)>0)
		{
			$this->colecaocorrelata_ = true;
			$html = '
			<div class="panel panel-success">
			  <div class="panel-heading">Cole&ccedil;&otilde;es Correlatas</div>
			  <div class="panel-body">
				<table><tr>
			
					

			';
			while ($rowX=pg_fetch_array($res))
			{
			
				$TestemunhoCorrelato = new Testemunho();
				$TestemunhoCorrelato->conn = $this->conn;
				$TestemunhoCorrelato->getById($rowX[0]);
				$html_imagem = $this->pegaimagem($rowX[0],1,$TestemunhoCorrelato->codcolbot);

				if ((isset($_SESSION['s_idusuario'])) && ($op=='E'))
				{
					$disabled = 'disabled';
					// 90 = EXCLUIR COLEÇÃO CORRELATA
					if (in_array("90", $_SESSION['s_funcao']))
					{
						$disabled = '';
					}
					
					$btnexcluir = '<br><button type="button" class="btn btn-danger btn-sm '.$disabled.'" onClick="excluirColecaoCorrelata('.$codtestemunho.','.$rowX[0].')"><span class="glyphicon glyphicon-trash"></span>
										</button>';
				}				


				$html.='<td nowrap>'.$TestemunhoCorrelato->numtomboformatado. '<br>'.$html_imagem.$btnexcluir.'</td>';

  				//$html.=$this->desenhaHTML($row[0]);
			}
			$html .= '</tr></table></div>
</div>
';
		}
		
		return $html;
	
	
	
	}

	public function temHistoricoDeterminacao($codtestemunho)
	{
		if (empty($codtestemunho))
		{
			$codtestemunho = 0;
		}
		$sql = 'select a.aux_nomecompltaxhtml,det.diadeterm,det.mesdeterm,det.anodeterm,det.aux_detpor from jabot.determinacao det, jabot.arvoretaxon a
where det.codarvtaxon = a.codarvtaxon and
det.codtestemunho = '.$codtestemunho.' and coddeterminacao <> (select ultimadeterm from jabot.testemunho where codtestemunho = '.$codtestemunho.')';
		//echo $sql;
		$res = pg_exec($this->conn,$sql);
		if (pg_numrows($res)>0)
		{
			return true;
		}
		else
		{	return false;
		}
	}


	public function pegaHistoricoDeterminacao($codtestemunho)
	{
	 
	
		if (empty($codtestemunho))
		{
			$codtestemunho = 0;
		}
		$html = '';
		$sql = 'select det.coddeterminacao,a.aux_nomecompltaxhtml,det.diadeterm,det.mesdeterm,det.anodeterm,det.aux_detpor,det.nota, t.primeiradeterm,t.ultimadeterm,a.codarvtaxon,det.codcattypus
				from jabot.determinacao det
				inner join jabot.arvoretaxon a on det.codarvtaxon = a.codarvtaxon 
				inner join jabot.testemunho t on t.codtestemunho = det.codtestemunho 
				where det.codtestemunho = '.$codtestemunho.' 
				and coddeterminacao <> (select ultimadeterm from jabot.testemunho where codtestemunho = '.$codtestemunho.')
				order by 1
				';
		//echo $sql;
		$res = pg_exec($this->conn,$sql);
		$this->historicodeterminacao_ = false;
		if (pg_numrows($res)>0)
		{
			$this->historicodeterminacao_ = true;
			$html = '<div class="panel panel-info">
						<div class="panel-heading">Hist&oacute;rico das determina&ccedil;&otilde;es</div>
						<div class="panel-body">
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th> # </th> <th>Táxon</th> <th>Det. Por</th> <th>Data</th>  <th>Notas</th> 
							</tr> 
						</thead> 
						<tbody> 	';
					
			if(!empty($_SESSION)){						
				$secao = 'OK';
			}
			
			while ($row=pg_fetch_array($res))
			{
			
			//print_r($row);
			if($secao == 'OK'){								
				if($row['coddeterminacao']!= $row['primeiradeterm'] ){
					$ExcluirDeterm = '<a title="Excluir Determinação!" href="exec.testemunho.php?op=ED&coddeterminacao='.$row['coddeterminacao'].'&codtestemunho='.$codtestemunho.'&path='.$_REQUEST['path'].'&batch='.$_REQUEST['batch'].'&imagem='.$_REQUEST['imagem'].'"><span class="glyphicon glyphicon-trash"></span></a> ';
				}
				//if($_SESSION['s_idusuario'] == 2039){
					$editarht = '<a title="Alterar Determinação!" onClick = "alterarDeterminacao(\''.$row['codarvtaxon'].'\',\''.$row['aux_detpor'].'\',\''.$row['diadeterm'].'\',\''.$row['mesdeterm'].'\',\''.$row['anodeterm'].'\',\''.$row['nota'].'\',\''.$row['aux_nomecompltaxon'].'\',\''.$row['codcattypus'].'\',\''.$row['coddeterminacao'].'\')"  ><span class="fa fa-pencil"></span></a> ';
				//}			
				if(!empty($ExcluirDeterm) && !empty($editarht)){
					$ExcluirEditar = $ExcluirDeterm.' - '.$editarht;
				}elseif(!empty($ExcluirDeterm)){
					$ExcluirEditar = $ExcluirDeterm;
				}elseif(!empty($editarht)){
					$ExcluirEditar = $editarht;
				}							
			}
			
			if(!empty($row['nota'])){
				$nota = '<span class="glyphicon glyphicon-list-alt" title="'.$row['nota'].'"></span> ';
			}
			
  				$html.='<tr> 
							<th scope="row"> '.$ExcluirEditar.' </th> 
							<td>'.$row['aux_nomecompltaxhtml'].'</td> 
							<td>'.$row['aux_detpor'].'</td> 
							<td>'.$this->formata_data($row['diadeterm'],$row['mesdeterm'],$row['anodeterm'],'R').'</td> 
							<td>'.$nota.'</td> 
						</tr>';
				
			}
			$html .= '</tbody> </table></div></div>';
		}
		return $html;
	}
	
	
	
	public function Aspas_ao_Gravar($a){
 
 //a função varre todo o array e troca ' por '' para poder gravar no banco.
 
        if(is_array($a)){
            foreach($a as $n=>$v){
                $b[$n]= str_replace("'","''", $v);
            }
            return $b;
        }else{
            return str_replace("'","''", $a);
        }
    }
	
	
	
	public function ExcluirDeterminacao($coddeterminacao)
	{
		if (!empty($coddeterminacao))
		{
			$sql = 'begin; 
					delete from jabot.determinacao
					where coddeterminacao = '.$coddeterminacao."; ";
			//echo $sql;
			//exit;
			$res = pg_exec($this->conn,$sql);
						
			if($res){
				$sql = 'end';
				$res = pg_exec($this->conn,$sql);
				return true;
			}else{
				$sql = 'rollback;';
				$res = pg_exec($this->conn,$sql);
				return false;
			}
		}
		
	}	
	public function excluirImagemReflora($idimagem)
	{
		if (!empty($idimagem))
		{
			$sql = 'begin; 
					delete from jabot.reflora_imagem where id = '.$idimagem."; ";
			//echo $sql;
			//exit;
			$res = pg_exec($this->conn,$sql);
						
			if($res){
				$sql = 'end';
				$res = pg_exec($this->conn,$sql);
				return true;
			}else{
				$sql = 'rollback;';
				$res = pg_exec($this->conn,$sql);
				return false;
			}
		}
		
	}
	
	
	
	public function temImagem($codtestemunho,$sigla)
	{
	$Configuracao = new Configuracao();
	$Configuracao->conn = $this->conn;		
	$Configuracao->getConfiguracao();
	
	$tipocodigobarra = $Configuracao->etiqueta_tipocodigobarra;
	$tamanhocodbarras = $Configuracao->tam_codigo_barras;
	
	if($tipocodigobarra == 128){
		$codbarra = $sigla.str_pad($this->codtestemunho, $tamanhocodbarras, "0", STR_PAD_LEFT);
	}else{				
		$codbarra = str_pad($this->codtestemunho, $tamanhocodbarras, "0", STR_PAD_LEFT); 
	}	
	
	// if($sigla=='FURB' ){
		// $codbarra = $sigla.str_pad($codtestemunho, $Configuracao->tam_codigo_barras, "0", STR_PAD_LEFT);
	// }else{
		// $codbarra = str_pad($codtestemunho, $Configuracao->tam_codigo_barras, "0", STR_PAD_LEFT);
	// }
		// echo '$sigla: '.$sigla;
		// echo '$codtestemunho: '.$codtestemunho;
	
	   $sql = "select codigobarras from jabot.imagem where codigobarras = '".$codbarra."'";
	   // echo $sql;
	   // exit;
	   $result = pg_exec($this->conn,$sql);
	   $qtd_imagem = pg_numrows($result);
	   return $qtd_imagem;
	}

	public function pegaImagem($codtestemunho,$qtd=1,$codcolbotcorrelato = '')
	{
	  // echo 'codtestemunho: ['.$codtestemunho.']';
	  //echo 'codcolbotcorrelato: ['.$codcolbotcorrelato.']';
	   //$html_imagem = '';
	   
	   //echo 'Rafael'.$codtestemunho;
	  // $this->getById($codtestemunho);
	   
	   //echo "rafael".$this->codcolbot;// = '3172';
	   //$sql = "select * from jabot.testemunho_imagem ti, testemunho t where where 
	   //ti.codtestemunho = t.codtestemunho and
	   //ti.codtestemunho = ".$codtestemunho." order by arquivo";
	   //$result = pg_exec($this->conn,$sql);
	   //$row2 = pg_fetch_array($res);
	   //$this->codcolbot = $row2['codcolbot'];
	   if (empty($codcolbotcorrelato))
	   {
		  $codcolbotcorrelato = $this->codcolbot;
	   }
	   //felipe - Teste
	 // $felipe = $_REQUEST['felipe'];
	//$felipe = 'ok';
	// echo 'codcolbotcorrelato: ['.$codcolbotcorrelato.']';
	   
	 //echo 'codcolbotcorrelato: '.$this->codcolbot;
	   
	   if(!empty($codcolbotcorrelato))
	   {
	   // print 'aqui Dentro - ';
		//Colecões vivas
		//PRINT 'codcolbotcorrelato: '.$codcolbotcorrelato;
		
		$Configuracao = new Configuracao();
		$Configuracao->conn = $this->conn;		
		$Configuracao->getConfiguracao();
		$etiqueta_tipocodigobarra = $Configuracao->etiqueta_tipocodigobarra;
		$tamanhocodbarras = $Configuracao->tam_codigo_barras;
		
		
		
		if($etiqueta_tipocodigobarra == '128')
		{
			
			
			//$this->getById($codtestemunho);
			//$siglacolecao = $this->siglacolecao;
			
			$siglacolecao = $this->getsiglabytestemunho($codtestemunho);
			//echo 'siglacolecao: '.$siglacolecao;
			
			$codbarrasimagem = $siglacolecao.str_pad($codtestemunho, $tamanhocodbarras, "0", STR_PAD_LEFT);
			//echo $codbarrasimagem;
			
			$sql_imagem = "select * from jabot.imagem where  codigobarras = '".$codbarrasimagem."' ";
			//print '<br>'.$sql_imagem;
			//	exit;
			
			$siglacolbot = $siglacolecao;
			
			
		}
		else
		{
			
			//$tamanhocodbarras = $Configuracao->tam_codigo_barras;
			
			//Não se aplica a outros herbários
			if(($codcolbotcorrelato == 25986) || ($codcolbotcorrelato == 21176)){
			//25986 (RBfungo) entra como 3172(RB)
			//21176 (RBCarpoteca) entra como 3172(RB)
				$codcolbotcorrelato = 3172;
			}
			$codcolviva = $Configuracao->codcolviva;
					
			//$Array_colViva = array(18678,18686,19346,21374,4635,26412,25216);
			$Array_colViva = explode(',',$codcolviva);
		
			if (in_array($codcolbotcorrelato, $Array_colViva)) { 
			
				$sql_tombo = 'select numtombo from jabot.testemunho 
				where codtestemunho = '.$codtestemunho;
				
				$result_tombo = pg_exec($this->conn,$sql_tombo);
				$row_tombo = pg_fetch_array($result_tombo);
				$tombo_codbarrasimagem = $row_tombo['numtombo'];
				//$codbarrasimagem = substr('00000000',0,8-strlen($tombo_codbarrasimagem)).$tombo_codbarrasimagem;
				$codbarrasimagem = str_pad($tombo_codbarrasimagem, $tamanhocodbarras, "0", STR_PAD_LEFT);
				//print "<br>Codbarrasimagem ".$codbarrasimagem ;
						
			} else{
			
				$codbarrasimagem = str_pad($codtestemunho, $tamanhocodbarras, "0", STR_PAD_LEFT);	
				//$codbarrasimagem = substr('00000000',0,8-strlen($codtestemunho)).$codtestemunho;
				//print "Codbarrasimagem ".$codbarrasimagem ;
			}	
		
		
			$sql_imagem = "	select i.*, pj.siglapj  from jabot.imagem i, pessoa p, pessoajuridica pj, jabot.colecaobotanica cb
							where cb.seqnumtombo is not null 
							and p.codpessoa = cb.codcolecaobot 
							and p.codpessoa = pj.codpj 
							and lower(i.siglacolbotorigem) = lower(pj.siglapj)
							and cb.codcolecaobot = ".$codcolbotcorrelato."
							and codigobarras = '".$codbarrasimagem."'";				
			// print 	'<br>'.$sql_imagem;	
			// exit;
			
		}
		
	//	echo $sql_imagem;
	//if($_SESSION[s_idusuario] == 2039){	
	//	print 	$sql_imagem;	
		//exit;
		
	//}						
			
			
		$result = pg_exec($this->conn,$sql_imagem);
		$row = pg_fetch_array($result);
		$qtd_imagem = pg_numrows($result);
		
		// print "<pre>";
		// print_r ($row);
		// print "</pre>";
		//exit;
		
	   $servidor = $row['servidor'];
	   $path =  $row['path'];
	   $arquivo =  $row['arquivo'];
	   
	   if(!empty($row['siglapj'])){	   
			$siglacolbot =  $row['siglapj'];
	   }
	  //print 'SIGLA: '.$siglacolbot;
	  if($qtd_imagem > 0){
	   
		if ($qtd_imagem>1)
		{
			$botao = '<span class="badge">'.$qtd_imagem.'</span>';
		}
		
		$html_imagem.='<a href=templaterb2.php?colbot='. $siglacolbot.'&codtestemunho='.$codtestemunho.'&arquivo='.$arquivo.' target=\'Visualizador\'><img src="http://'.$servidor.'/fsi/server?type=image&source='.$path.'/'.$arquivo.'&width=300&height=100&profile=jpeg&quality=20"></a>'.$botao;
		 
	}
	 // print '<br>IMAGEM: '.$html_imagem;
		
	   
}
/*Não está em uso.

else{
	   
	//  print 'aqui Fora  - ';
	   
	   if (($codcolbotcorrelato == '3172') || ($codcolbotcorrelato == '21176') || ($codcolbotcorrelato == '25986') ) 
	   { 
		   $servidor = 'imagens3';
		   $sql = "select * from jabot.testemunho_imagem where codtestemunho = ".$codtestemunho." order by arquivo";
		   $result = pg_exec($this->conn,$sql);
		   $qtd_imagem = pg_numrows($result);
		  // echo $qtd_imagem;
		   if ($qtd_imagem>0)
		   {
			 if ($qtd==1)
			 {
				$row = pg_fetch_array($result);
				$parte_arquivo = explode(".", $row['arquivo']);
				$extensao = $parte_arquivo[1];
				$imagem_dir = substr('00000000',0,8-strlen($row['codtestemunho'])).$row['codtestemunho']; 
				$part1 = (int)substr($imagem_dir,0,2);
				$part2 = (int)substr($imagem_dir,2,2);
				$part3 = (int)substr($imagem_dir,4,2);
				$part4 = (int)substr($imagem_dir,6,2);
				$botao = '';
				if ($qtd_imagem>1)
				{
					$botao = '<span class="badge">'.$qtd_imagem.'</span>';
				}
				$html_imagem.='<a href=templaterb2.php?colbot=RB&codtestemunho='.$row['codtestemunho'].'&arquivo='.$row['arquivo'].' target=\'Visualizador\'><img src="http://'.$servidor.'.jbrj.gov.br/fsi/server?type=image&source=rb%2F'.$part1.'%2F'.$part2.'%2F'.$part3.'%2F'.$part4.'%2F'.$imagem_dir.'.'.$extensao.'&width=300&height=100&profile=jpeg&quality=20"></a>'.$botao;
			 }
			 else
			 {
				while ($row = pg_fetch_array($result))
				{
					$imagem_dir = substr('00000000',0,8-strlen($row['codtestemunho'])).$row['codtestemunho']; 
					$parte_arquivo = explode(".", $row['arquivo']);
					$extensao = $parte_arquivo[1];
					$part1 = (int)substr($imagem_dir,0,2);
					$part2 = (int)substr($imagem_dir,2,2);
					$part3 = (int)substr($imagem_dir,4,2);
					$part4 = (int)substr($imagem_dir,6,2);
					$html_imagem.='<a href=templaterb2.php?colbot=RB&codtestemunho='.$row['codtestemunho'].'&arquivo='.$row['arquivo'].' target=\'Visualizador\'><img src="http://'.$servidor.'.jbrj.gov.br/fsi/server?type=image&source=rb%2F'.$part1.'%2F'.$part2.'%2F'.$part3.'%2F'.$part4.'%2F'.$row['arquivo'].'&width=300&height=100&profile=jpeg&quality=95"></a> ';
				}
			 } 
		   }
	   }
	   //RBv
	   if ($this->codcolbot == '4635')
	   {
	   	   $sql = "select * from jabot.testemunho_imagem where codtestemunho = ".$codtestemunho." order by arquivo";
		   $result = pg_exec($this->conn,$sql);
		   $qtd_imagem = pg_numrows($result);
		   if ($qtd_imagem>0)
		   {	 
		   	  	if ($qtd_imagem>1)
			  	{
					$botao = '<span class="badge">'.$qtd_imagem.'</span>';
				}  	 
			  $imagem = substr('00000000',0,8-strlen($this->numtombo)).$this->numtombo.'_01'; 
			  $row = pg_fetch_array($result);
			  $html_imagem.='<a href="templaterb2.php?colbot=RBv&codtestemunho='.$codtestemunho.'&arquivo='.$row['arquivo'].'" target="_blank"><img src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=rbv%2F'.$row['arquivo'].'&width=300&height=100&profile=jpeg&quality=95"></a>'.$botao;
		   }  
	   }
	   //RBvb
	   if ($this->codcolbot == '18678')
	   { 
	   	   $sql = "select * from jabot.testemunho_imagem where codtestemunho = ".$codtestemunho." order by arquivo";
		   $result = pg_exec($this->conn,$sql);
		   $qtd_imagem = pg_numrows($result);
		   if ($qtd_imagem>0)
		   {	   	 
		   		if ($qtd_imagem>1)
			  	{
					$botao = '<span class="badge">'.$qtd_imagem.'</span>';
				}  
	   			$imagem = substr('00000000',0,8-strlen($this->numtombo)).$this->numtombo.'_01';
				$row = pg_fetch_array($result); 
				$html_imagem.='<a href=templaterb2.php?colbot=RBvb&codtestemunho='.$codtestemunho.'&arquivo='.$row['arquivo'].'" target="_blank"><img src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=rbvb%2F'.$row['arquivo'].'&width=300&height=100&profile=jpeg&quality=95"></a>'.$botao;
		   }
	   }
	   // RBvs
	   if ($codcolbotcorrelato == '25216')
	   { 
	   	   $sql = "select * from jabot.testemunho_imagem where codtestemunho = ".$codtestemunho." order by arquivo";
		   $result = pg_exec($this->conn,$sql);
		   $qtd_imagem = pg_numrows($result);
		   if ($qtd_imagem>0)
		   {	   	 
		   		if ($qtd_imagem>1)
			  	{
					$botao = '<span class="badge">'.$qtd_imagem.'</span>';
				}  
	   			$imagem = substr('00000000',0,8-strlen($this->numtombo)).$this->numtombo.'_01';
				$row = pg_fetch_array($result); 
				$html_imagem.='<a href=templaterb2.php?colbot=RBvs&codtestemunho='.$codtestemunho.'&arquivo='.$row['arquivo'].'" target="_blank"><img src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=rbvs%2F'.$row['arquivo'].'&width=300&height=100&profile=jpeg&quality=95"></a>'.$botao;
		   }
	   }
	   // RBvc
	   if ($codcolbotcorrelato == '21374')
	   { 
	   	   $sql = "select * from jabot.testemunho_imagem where codtestemunho = ".$codtestemunho." order by arquivo";
		   $result = pg_exec($this->conn,$sql);
		   $qtd_imagem = pg_numrows($result);
		   if ($qtd_imagem>0)
		   {	   	 
		   		if ($qtd_imagem>1)
			  	{
					$botao = '<span class="badge">'.$qtd_imagem.'</span>';
				}  
	   			$imagem = substr('00000000',0,8-strlen($this->numtombo)).$this->numtombo.'_01';
				$row = pg_fetch_array($result); 
				$html_imagem.='<a href=templaterb2.php?colbot=RBvc&codtestemunho='.$codtestemunho.'&arquivo='.$row['arquivo'].'" target="_blank"><img src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=rbvc%2F'.$row['arquivo'].'&width=300&height=100&profile=jpeg&quality=95"></a>'.$botao;
		   }
	   }

	   // RBvv
	   if ($codcolbotcorrelato == '18686')
	   { 
	   	   $sql = "select * from jabot.testemunho_imagem where codtestemunho = ".$codtestemunho." order by arquivo";
		   $result = pg_exec($this->conn,$sql);
		   $qtd_imagem = pg_numrows($result);
		   if ($qtd_imagem>0)
		   {	   	 
		   		if ($qtd_imagem>1)
			  	{
					$botao = '<span class="badge">'.$qtd_imagem.'</span>';
				}  
	   			$imagem = substr('00000000',0,8-strlen($this->numtombo)).$this->numtombo.'_01';
				$row = pg_fetch_array($result); 
				$html_imagem.='<a href=templaterb2.php?colbot=RBvv&codtestemunho='.$codtestemunho.'&arquivo='.$row['arquivo'].'" target="_blank"><img src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=rbvv%2F'.$row['arquivo'].'&width=300&height=100&profile=jpeg&quality=95"></a>'.$botao;
		   }
	   }
	   
	   // RBvi
	   if ($codcolbotcorrelato == '19346')
	   { 
	   	   $sql = "select * from jabot.testemunho_imagem where codtestemunho = ".$codtestemunho." order by arquivo";
		   $result = pg_exec($this->conn,$sql);
		   $qtd_imagem = pg_numrows($result);
		   if ($qtd_imagem>0)
		   {	   	 
		   		if ($qtd_imagem>1)
			  	{
					$botao = '<span class="badge">'.$qtd_imagem.'</span>';
				}  
	   			$imagem = substr('00000000',0,8-strlen($this->numtombo)).$this->numtombo.'_01';
				$row = pg_fetch_array($result); 
				$html_imagem.='<a href=templaterb2.php?colbot=RBvi&codtestemunho='.$codtestemunho.'&arquivo='.$row['arquivo'].'" target="_blank"><img src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=rbvi%2F'.$row['arquivo'].'&width=300&height=100&profile=jpeg&quality=95"></a>'.$botao;
		   }
	   }
	   
	   
	   
	   if ($codcolbotcorrelato == '3173')
	   { 
	   
	   // rbw
	   	   $sql = "select * from jabot.testemunho_imagem where codtestemunho = ".$codtestemunho." order by arquivo";
		   //echo $sql;
		   $result = pg_exec($this->conn,$sql);
		   $qtd_imagem = pg_numrows($result);
		   if ($qtd_imagem>0)
		   {	   	 
		   		if ($qtd_imagem>1)
			  	{
					$botao = '<span class="badge">'.$qtd_imagem.'</span>';
				}  
	   			//$imagem = substr('00000000',0,8-strlen($this->codtestemunho)).$this->codtestemunho.'.jpg';
				
				$row = pg_fetch_array($result); 
				$html_imagem.='<a href=templaterb2.php?colbot=RBw&codtestemunho='.$codtestemunho.'&arquivo='.$row['arquivo'].' target="_blank"><img src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=rbw%2F'.$row['arquivo'].'&width=300&height=100&profile=jpeg&quality=95"></a>'.$botao;
		   }
	   }


	   if ($this->codcolbot == '21291')
	   { 
		// kew
	   	   $sql = "select * from jabot.reflora_imagem ri,jabot.testemunho t 
			where t.codigobarras = ri.codigobarra and
			t.codtestemunho = '".$codtestemunho."'";
		   $resultimagem = pg_exec($this->conn,$sql);
		   $rowimagem = pg_fetch_array($resultimagem);
		   $imagem = $rowimagem['codigobarra'];
		   $batch = $rowimagem['batch'];
		   if ($batch<10)
		   {
				$batch='0'.$batch;
		   }
		   $html_imagem.='<a href=templaterb2.php?batch='.$batch.'&colbot=KFoto&imagem='.$imagem.' target=\'Visualizador\'>
		   <img alt="'.$this->codigobarras.'.JPG" src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=hvpr%2Fkew%2Fbatch'.$batch.'%2F'.$imagem.'.jpg&width=300&height=100&profile=jpeg&quality=95"></a><br>Batch: '.$batch;
		}

		if ($this->codcolbot == '23987')
	   { 
		// Paris
	   	   $sql = "select * from jabot.reflora_imagem ri,jabot.testemunho t 
			where t.codigobarras = ri.codigobarra and
			t.codtestemunho = '".$codtestemunho."'";
		   $resultimagem = pg_exec($this->conn,$sql);
		   $rowimagem = pg_fetch_array($resultimagem);
		   $imagem = $rowimagem['codigobarra'];
		   $batch = $rowimagem['path'];
		   //if ($batch<10)
		   //{
			//$batch='0'.$batch;
		   //}
		   $html_imagem.='<a href=templaterb2.php?batch='.$batch.'&colbot=PFoto&imagem='.$imagem.' target=\'Visualizador\'>
		   <img alt="'.$imagem.'.jpg" src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=hvpr%2Fmnhn%2F'.$batch.'%2F'.$imagem.'.jpg&width=300&height=100&profile=jpeg&quality=95"></a><br>Batch: '.$batch;
		}
			
		if ($codcolbotcorrelato == '24856')
	   { 
		// swiss SOF
	   	   $sql = "select * from jabot.reflora_imagem ri where ri.origem = 'SOF' and ri.codigobarra = '".$this->codigobarras."'";
		   $resultimagem = pg_exec($this->conn,$sql);
		   $rowimagem = pg_fetch_array($resultimagem);
		   $imagem = $this->codigobarras;
		   $batch = $rowimagem['path'];
		   //if ($batch<10)
		   //{
			//$batch='0'.$batch;
		   //}
		   //echo $sql;
		   $html_imagem.=$rowimagem['codigobarra'].'<br><a href=templaterb2.php?batch=&colbot=SOF&imagem='.$imagem.' target=\'Visualizador\'>
		   <img alt="'.$this->codigobarras.'.JPG" src="http://imagens1.jbrj.gov.br/fsi/server?type=image&source=hvpr%2Fswiss%2F'.$this->codigobarras.'.jpg&width=300&height=100&profile=jpeg&quality=95"></a><br>Batch: '.$batch;
		}	
		
	}		*/
		
	//print $html_imagem.'IMAGEM<br>';

	   return $html_imagem;
	   
	
	}
	
		
	public function adicionaDeterminacaoDataC()
	{
		if (empty($this->diadeterminacao))
		{
			$diadeterminacao = 'null';
		}
		
		if (empty($this->mesdeterminacao))
		{
			$mesdeterminacao = 'null';
		}
		if (empty($this->anodeterminacao))
		{
			$anodeterminacao = 'null';
		}
		if (empty($this->codcategoriatypus))
		{
			$codcategoriatypus = 'null';
		}
		
		
		$sql = "insert into jabot.determinacao (codarvtaxon,aux_detpor,codtestemunho,diadeterm,mesdeterm,anodeterm,codcattypus)
		values (".$this->codarvtaxon.",'".$this->determinador."',".$this->codtestemunho.",".$this->diadeterminacao.",".$this->mesdeterminacao.",".$this->anodeterminacao.",".$this->codcategoriatypus.");";
		//echo $sql;
		//exit;
		$res = pg_exec($this->conn,$sql);
		
		
		
		if ($res)
		{
			return true;
		}
		else
		{	return false;
		}
	
	
	
	}		

		
	function getCodTestemunho($numtombo,$codcolbot)
	{
		$sql = "select codtestemunho from jabot.testemunho where numtombo = '".$numtombo."' and codcolbot= '".$codcolbot;
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		return $row[0];
	}
	
	function listaCombounidmedida($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from jabot.unidmedida ";
		$sql.=" order by unidmed ";
		//print $sql;
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Selecione </option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['codunidmed'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['codunidmed']."' ".$s." >".$row['unidmed']."( ".$row['siglaunidmed'].")</option> ";
	    }

		$html .= '</select>';

		return $html;	

	}	
	
	function listaCombounidconservacao($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select u.coduc,pj.nomefantasia
				from jabot.unidconservacao u 
				inner join pessoajuridica pj on pj.codpj = u.coduc
				order by 2 ";
				
		//print $sql;
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Selecione </option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['coduc'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['coduc']."' ".$s." >".$row['nomefantasia']."</option> ";
	    }

		$html .= '</select>';

		return $html;	

	}
	
	function pegaNumTombo($codtestemunho)
	{
		$sql = "select pj.siglapj || ' ' ||numtombo as numtombo from jabot.testemunho t, pessoajuridica pj where
t.codcolbot = pj.codpj and t.codtestemunho = '".$codtestemunho."' limit 1 ";
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0)
		{
			$row = pg_fetch_array($res);
			return $row[0];
		}
		else
		{
			return 0;
		}
	}
	
	function pegaNumTomboSemSigla($codtestemunho)
	{
		$sql = "select numtombo from jabot.testemunho t where  t.codtestemunho = '".$codtestemunho."'  ";
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0)
		{
			$row = pg_fetch_array($res);
			return $row[0];
		}
		else
		{
			return 0;
		}
	}
	
	function pegaTaxon($codarvtaxon)
	{
		$sql = "select aux_nomecompltaxhtml, * from jabot.arvoretaxon a where  a.codarvtaxon = '".$codarvtaxon."'  ";
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0)
		{
			$row = pg_fetch_array($res);
			return $row[0];
		}
		else
		{
			return 'Não encontrado';
		}
	}
	
	
	 function alterarNumeroTombo($codtestemunho,$numerotombo){

	 $sql = "update jabot.testemunho set 
				numtombo =  ".$numerotombo."
				where codtestemunho = ".$codtestemunho."";
	//print $sql;
	//exit;
	 $resultado = pg_exec($this->conn,$sql);
	   if ($resultado){
	   	return true;
	   }
	   else
	   {
	      return false;
	   }
	
	}
	
	
	 function alterarcodigotestemunho($de,$para){
	
		$sql = "update jabot.testemunho set 
		codtestemunho = '".$para."' where codtestemunho = '".$de."' ";
	  //print $sql;
	
	 $resultado = pg_exec($this->conn,$sql);
	   if ($resultado){
	   	  $this->incluirExecutor($id,$this->idexecutor);
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	
	}
	public function gerarDuplicata($id, $qtd, $numtombo)
	{
		$sql = " insert into jabot.testemunho 
 (sufixonumtombo, original, desaparecido, codbasedados, 
            numtomboantigo, codcolbot, codacesso, codtipocolbot, criadopor, 
            alteradopor, codbarras, locfisico1, datacriacao, iniciocriacao, 
            locfisico2, numtombo, comflor, comfruto, combotao, preppor, dataprep, 
            qtdinicialduplic, qtdestoqueduplic, aux_duplicatas, siglacolbotorigem, 
            dataultalter, colecoescorrelatas, tiponumtombo, observacoes, 
            tipoinclusao, pendencias, tombado, metodoprep, ultimadeterm, 
            codlotedigitacao, comfrutoimat, comfrutomad, comflorpassada, 
            esteril, comfrutopassado, primeiradeterm, pesobruto, pesoliquido, 
            info_armazenagem, rel_peso_volume, info_armazenagem2, fontebibliogr, 
            unidconservacao, codigobarras)

select sufixonumtombo, original, desaparecido, codbasedados, 
            numtomboantigo, codcolbot, codacesso, codtipocolbot, criadopor, 
            alteradopor, codbarras, locfisico1, datacriacao, iniciocriacao, 
            locfisico2, 0, comflor, comfruto, combotao, preppor, dataprep, 
            qtdinicialduplic, qtdestoqueduplic, aux_duplicatas, siglacolbotorigem, 
            dataultalter, colecoescorrelatas, 'S', observacoes, 
            'D', pendencias, tombado, metodoprep, ultimadeterm, 
            codlotedigitacao, comfrutoimat, comfrutomad, comflorpassada, 
            esteril, comfrutopassado, primeiradeterm, pesobruto, pesoliquido, 
            info_armazenagem, rel_peso_volume, info_armazenagem2, fontebibliogr, 
            unidconservacao, codigobarras
 from jabot.testemunho where codtestemunho =".$id.";
 update jabot.testemunho set numtombo = ".$numtombo." where codtestemunho = (select( currval('jabot.testemunho_codtestemunho_seq')))";

//		echo $sql;
//		exit;
 		for ($i=1;$i<=$qtd;$i++){
  			$result2 = pg_exec($this->conn,$sql);
			
  		}
//		exit;
	}

	 function alterarbasetestemunho($codbase,$codtestemunho){

	 $sql = "update jabot.testemunho set 
				codbasedados =  ".$codbase."
				where codtestemunho = ".$codtestemunho."";
	// print $sql;
	// exit;
	 $resultado = pg_exec($this->conn,$sql);
	   if ($resultado){
	   	return true;
	   }
	   else
	   {
	      return false;
	   }
	
	}
	
	
	function listarbasetestemunho($codtestemunho)
   { 
			$sql = "select * from jabot.basedados bd,jabot.testemunho t 
			where bd.codbasedados = t.codbasedados
			and t.codtestemunho = '".$codtestemunho."'";
		   $result = pg_exec($this->conn,$sql);
		   $array = pg_fetch_all($result);
    return $array;	 
	}
	
	//----------------------------------------Leonardo
		 function alterarcolecaobotanicatestemunho($codcolbot,$codtestemunho){

	 $sql = "update jabot.testemunho set 
				codcolbot =  ".$codcolbot."
				where codtestemunho = ".$codtestemunho."";
	//print $sql;
	//exit;
	 $resultado = pg_exec($this->conn,$sql);
	   if ($resultado){
	   	return true;
	   }
	   else
	   {
	      return false;
	   }
	
	}
	//-----------------------
	
		function uploadFile($arquivo, $pasta, $tipos, $nome = null){ 
	if(isset($arquivo)){ 
	
	
		$infos = explode(".", $arquivo); 
		//print_r($infos);
		//$nome = $infos['']
		//print"ss2".$nome;
		$nome = $infos['0'];
		if(!$nome){ 
				$nomeOriginal = $nomeOriginal . $infos['1']; 
		}else{ 
				$nomeOriginal = $nome ; 
            } 
	print" NOME ORIGINAL:    ".$nomeOriginal;
		$tipoArquivo = $infos['1'];

		$tipoPermitido = false; 
	
			if(strtolower($tipoArquivo) == strtolower($tipos)){ 
				$tipoPermitido = true; 
			} 
		

		if(!$tipoPermitido){ 
            $retorno["erro"] = "Por favor, enviar arquivo em jpg .jpg"; 
			unlink('imagens_testemunho/'.$nomenovo.'.jpg');
		}else{ 
			//print"<br>";
			//print"ss23".$pasta.$nomeOriginal.$tipoArquivo;
			if(move_uploaded_file($arquivo, $pasta . $nomeOriginal . $tipoArquivo)){ 
				$retorno["caminho"] = $pasta . $nomeOriginal . $tipoArquivo; 
             print " RETORNO CAMINHO: ".$retorno["caminho"];
				chmod($pasta.$nome.'.jpg',0777);
			} 
			else{ 
				$retorno["erro"] = "Erro ao fazer upload"; 
				unlink('imagens_testemunho/'.$nomenovo.'.jpg');
			} 
		} 
	} 
	else{ 
		$retorno["erro"] = "Arquivo não enviado"; 
		unlink('imagens_testemunho/'.$nomenovo.'.jpg');
	} 
		return $retorno; 
	} 
	
	// FUNÇÃO CRIADA PARA SABER QUANTAS IMAGENS AINDA FALTA PARA SER DIGITADAS PELO RBv
	public function contaImagemDisponivel($tipo)
	{
		$sql = "select count(*) from jabot.reflora_imagem ri where
ri.origem = '".$tipo."' and ri.digitadopor is null";

		// echo $sql;
		// exit;
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		return $row[0];
	}
	
	//--------------------------------------------------------------------
		public function pegaHistoricoDeterminacao2($codtestemunho)
	{
		if (empty($codtestemunho))
		{
			$codtestemunho = 0;
		}
		$html = '';
		$sql = 'select det.coddeterminacao,a.aux_nomecompltaxhtml,det.diadeterm,det.mesdeterm,det.anodeterm,det.aux_detpor from jabot.determinacao det, jabot.arvoretaxon a
		where det.codarvtaxon = a.codarvtaxon and
		det.codtestemunho = '.$codtestemunho.' and coddeterminacao <> (select ultimadeterm from jabot.testemunho where codtestemunho = '.$codtestemunho.')';
		//echo $sql;
		$res = pg_exec($this->conn,$sql);
		$this->historicodeterminacao_ = false;
		if (pg_numrows($res)>0)
		{
			$this->historicodeterminacao_ = true;
			$html = '';
					
			if(!empty($_SESSION)){						
				$secao = 'OK';
			}
			
			while ($row=pg_fetch_array($res))
			{
			//print_r($row);
		
			
  				$html = $row['aux_nomecompltaxhtml'].'    | Det.: '.$row['aux_detpor'].'    | Data: '.$this->formata_data($row['diadeterm'],$row['mesdeterm'],$row['anodeterm'],'R');
			}
			
		}
		return $html;
	}
	
		public function cattypus($id)
	{
		$sql = "select * from jabot.categoriatypus where codcattypus = '".$id."'";

		//echo $sql;
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		return $row['nomecattypus'];
	}





		public function getsiglabytestemunho($codtestemunho)
	{
		$sql = "select siglapj from jabot.testemunho t 
				inner join pessoajuridica pj on t.codcolbot = pj.codpj
				where t.codtestemunho = $codtestemunho";

		//echo $sql;
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		return $row['siglapj'];
	}


	
	
	
	
}
?>