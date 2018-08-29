<?php session_start();
//print_r ($_SESSION['s_taxon']);
$especiesReflora = $_SESSION['s_taxon'];
$usuarioreflora = 5; // id tipo usuario reflora;


header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: http://php7.jbrj.gov.br');
header("Access-Control-Allow-Headers: Content-Type");

require_once('classes/conexao.class.php');
require_once('classes/experimento.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

$idsource = $_REQUEST['cmboxfonte'];
$especie = $_REQUEST['edtespecie'];

if ($op=='A')
{
	$Experimento->getById($id);
	$idexperiment = $Experimento->idexperiment;
	$name = $Experimento->name ;
	$description = $Experimento->description ;
}

?>

<link href="css/dadosbioticos.css" rel="stylesheet" type="text/css" media="all">

<div class="modal fade" id="instructionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"> 
        <div class="modal-content"> 
        <div class="modal-header">
            <h4 class="modal-title" >Instruções CSV</h4>
        </div>
        <!-- dialog body -->
        <div class="modal-body"> 
            <p>
                O CSV deve seguir o seguinte modelo:
                <br><br>
                [espécie],[estado],[município],[coletor],[número de coleta],[longitude],[latitude]
                <br><br>
                Todos os dados podem ser separados por vírgula(,), dois pontos(:) ou ponto e vírgula(;).
                Não é necessário marcar o final da linha. 
                <br><br>
                Restrições:
                <br><br>
                Espécies: O nome da espécie deve ser sem acento;
                <br><br>
                Longitude: Valor decimal (ex.: -11.6358334);
                <br><br>
                Latitude: Valor decimal (ex.: -41.0013889);
            </p>
        </div>
        <!-- dialog buttons -->
        <div class="modal-footer csv-modal-footer"> 
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="multSpeciesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"> 
        <div class="modal-content"> 
        <div class="modal-header">
            <h4 class="modal-title" >Múltiplas Espécies</h4>
        </div>
        <!-- dialog body -->
        <div class="modal-body"> 
            <p>
                Você está adicionando mais de uma espécie. Gostaria de adicionar todas as ocorrências 
				no mesmo experimento ou criar um experimento para cada espécie ? 
            </p>
        </div>
        <!-- dialog buttons -->
        <div class="modal-footer csv-modal-footer"> 
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="sameExperiment()">Mesmo Experimento</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="moreThanOneExperiment()">Mais de um Experimento</button>
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
    <h2>Dados Bióticos <small></small></h2>
    <div class="clearfix">
    </div>
    </div>
    <form name='frm2' id='frm2' action='' method="post" class="form-horizontal form-label-left" novalidate>
        <input id="op" value="<?php echo $op;?>" name="op" type="hidden">
        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
        <div class="x_content">
        <div>
            <div class="item form-group files-options">
            <label class="control-label" for="email">Fonte<span class="required">*</span>
            </label>
            <div class="">
                <div class="radio-group" style="width:250px;">
                    <div><input type="checkbox" name="fontebiotico[]" id="checkfontejabot" value="1" <?php if ($_REQUEST['fontebiotico'][0]=='1') echo "checked";?> /> JABOT</div>
                    <div><input type="checkbox" name="fontebiotico[]" id="checkfontegbif" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='2' ||$_REQUEST['fontebiotico'][1]=='2') echo "checked";?>/> GBIF</div>
                    <!--<div><input type="radio" disabled name="fontebiotico[]" id="checkfontesibbr" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='3') echo "checked";?>/> SiBBr</div>-->
                    <div><input disabled type="checkbox" name="fontebiotico[]" id="checkfontesibbr" value="3" <?php if ($_REQUEST['fontebiotico'][0]=='3') echo "checked";?>/> SiBBr</div>
					<div><input <?php if ($_SESSION['s_idtipousuario']==$usuarioreflora){ echo "disabled" ;} ?> type="checkbox" name="fontebiotico[]" id="checkfontecsv" value="3" <?php if ($_REQUEST['fontebiotico'][0]=='3') echo "checked";?>/> CSV</div>
                </div>
                <div class="csv-button" <?php if ($_SESSION['s_idtipousuario']==$usuarioreflora){ echo 'style="display:none"' ;} ?>>
                    <form enctype="multipart/form-data"><label id="label-arquivo" for='upload'>Arquivo CSV</label><input id="upload" type=file accept="text/csv" name="files[]" size=30></form>
                    <div onclick="showInstructions()">
                    <span style="cursor: pointer;">Instruções</span>
				</div>
				
            </div>
            
            <span id="filename"></span>
            </div>
            </div>
            <div id="csv-separator" class="item form-group files-options">
                <label class="control-label" for="email">Selecione o separador do CSV<span class="required">*</span></label>
                <select id="csv-select">
                    <option value=",">Vírgula (,)</option>
                    <option value=";">Ponto e vírgula (;) </option>
                    <option value=":">Dois pontos (:)</option>
                </select>
            </div>
            <div class="item form-group species-name">
                <div class="">
                    <div class="input-group">
						<?php if ($_SESSION['s_idtipousuario']==$usuarioreflora){
                            echo "<select id='edtespecie' name='edtespecie' class='form-control'>";
                            while (list ($key,$val) = @each($especiesReflora)) {
								$valor = explode(' ',$val);
								
								$s = '';
								if ($description==$valor[0])
								{
									$s = 'selected';
								}
								
                                echo "<option value='".$valor[0]."' ".$s.">" . $val . "</option>";
                             }
                             echo "</select>";
						}?>
							
                        <?php if ($_SESSION['s_idtipousuario']!=$usuarioreflora){ ?>
                            <input id="edtespecie" value="<?php echo $especie;?>"  name="edtespecie" class="form-control col-md-7 col-xs-12" >
                        <?php } ?>
                        <span class="input-group-btn"><button type="button" onclick="buscar()" class="btn btn-primary" >Buscar</button>
                        <button type="button" onclick="adicionarOcorrencia()" class="btn btn-success btn"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Adicionar</button></span>
                    </div>
                </div>
            </div>
        </form>
    </div>		
    <!--id="check-all" class="flat"-->
    <div id='div_resultadobusca'>
        <table class="table table-striped responsive-utilities jambo_table bulk_action">
        <?php 
        //1 jabot
        //2 Gbif
        if ((!empty($especie)) && ($_REQUEST['fontebiotico'][0]=='1'))
        {
			$ws = file_get_contents("https://model-r.jbrj.gov.br/execjabot.php?especie=" . $especie);
            /*$sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude,
            pais,estado_prov as estado,cidade as municipio, siglacolecao as herbario
                from  
            publicacao.extracao_jabot where latitude is not null and longitude is not null and
            familia || ' ' || taxoncompleto ilike '%".$especie."%'";
            $res = pg_exec($conn,$sql);
            $totalregistroselecionados = pg_num_rows($res);
        ?>
                                                                                    <tbody>

            <thead>
                <tr class="headings">
                    <th>
                        <input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">
                    </th>
                    <th class="column-title">T�xon </th>
                    <th class="column-title">Tombo </th>
                    <th class="column-title">Herb�rio </th>
                    <th class="column-title">Coletor </th>
                    <th class="column-title">Coordenadas </th>
                    <th class="column-title">Localiza��o</th>
                </tr>
            </thead>
        <?php while ($row = pg_fetch_array($res))
            {
            $codigobarras= str_pad($row['codtestemunho'], 8, "0", STR_PAD_LEFT);	
            $sqlimagem = "select * from jabot.imagem where codigobarras = '".$codigobarras."' limit 1";
            $resimagem = pg_exec($conn,$sqlimagem);
            $rowimagem = pg_fetch_array($resimagem);
            $servidor = $rowimagem ['servidor'];
            $path =  $rowimagem ['path'];
            $arquivo =  $rowimagem ['arquivo'];
            $html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='.$row['codtestemunho'].'&arquivo='.$arquivo.' target=\'Visualizador\'><img src="http://'.$servidor.'/fsi/server?type=image&source='.$path.'/'.$arquivo.'&width=300&height=100&profile=jpeg&quality=20"></a>';
            ?>
                <tr class="even pointer">
                    <td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="<?php echo $row['codtestemunho'];?>" type="checkbox" ></td>
                    <td class=" "><?php echo $html_imagem.' ';?><?php echo $row['taxoncompleto'];?></td>
                    <td class="a-right a-right "><?php echo $row['numtombo'];?></td>
                    <td class=" "><?php echo $row['herbario'];?></td>
                    <td class="a-right a-right "><?php echo $row['coletor'];?> <?php echo $row['numcoleta'];?></td>
                    <td class=" "><?php echo $row['latitude'];?>, <?php echo $row['longitude'];?></td>
                    <td class=" "><?php echo $row['pais'];?>, <?php echo $row['estado'];?> - <?php echo $row['municipio'];?></td>
                </tr>
        <?php 
            }*/ 
        } // if ((!empty($especie)) && ($_REQUEST['fontebiotico'][0]=='JABOT'))
	?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/custom.js"></script>
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
	
	<script src="js/loading.js"></script>	

    <!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>	
    
<script>


// This example adds a user-editable rectangle to the map.
function selecionaTodos2(isChecked) {
	//alert('');
	var chks = document.getElementsByName('chtestemunho[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=document.getElementById('chkboxtodos2').checked;
				
	}
	
}

function selecionaTodos(isChecked) {
	//alert('');
	var chks = document.getElementsByName('table_records[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=document.getElementById('chkboxtodos').checked;
				
	}
	
}

function contaSelecionados(objeto)
{
    var chks = objeto;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		if (chks[i].checked){
			conta = conta + 1;
		}
	}
	return conta;
}

   
function getSibbr(sp)
{
	//alert('');
	// var xmlhttp = new XMLHttpRequest();
	// xmlhttp.onreadystatechange = function() {
    // if (this.readyState == 4 && this.status == 200) {
    //     var myObj = JSON.parse(this.responseText);
    //     console.log(myObj);
	// 	}
	// };
	// console.log(sp);
	// xmlhttp.open("GET", "http://gbif.sibbr.gov.br/api/v1.1/ocorrencias?scientificname=" + sp + "&ignoreNullCoordinates=true", true);
	// xmlhttp.send();
    // var xhr = createCORSRequest('GET', "http://gbif.sibbr.gov.br/api/v1.1/ocorrencias?scientificname=" + sp + "&ignoreNullCoordinates=true");
    // if (!xhr) {
    //     throw new Error('CORS not supported');
    // }

    // example request
    // getCORS('http://gbif.sibbr.gov.br/api/v1.1/ocorrencias?scientificname=' + sp + '&ignoreNullCoordinates=true', function(request){
    //     var response = request.currentTarget.response || request.target.responseText;
    //     console.log(response);
    // });
    var destinationUrl = 'https://gbif.sibbr.gov.br/api/v1.1/ocorrencias?scientificname=' + sp + '&ignoreNullCoordinates=true';
    $.ajax({
      type: 'GET',
      url: destinationUrl,
      dataType: 'json', // use json only, not jsonp
      crossDomain: true, // tell browser to allow cross domain.
      success: successResponse,
      error: failureFunction
    });

}

function successResponse(data) {
    //console.log('success');
    //console.log(data);
  }

 function failureFunction(data) {
    //console.log('failure');
    //console.log(data);
  }

function getCORS(url, success) {
    var xhr = new XMLHttpRequest();
    if (!('withCredentials' in xhr)) xhr = new XDomainRequest(); // fix IE8/9
    xhr.open('GET', url);
    xhr.onload = success;
    xhr.send();
    return xhr;
}
  
  // Helper method to parse the title tag from the response.
  function getTitle(text) {
    return text.match('<title>(.*)?</title>')[1];
  }
  

function getTaxonKeyGbif(sp)
{
	//alert('');
	if(document.getElementById('checkfontegbif').checked==true){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			//console.log('resultado gbif');
			//console.log(this.responseText)
			var myObj = JSON.parse(this.responseText);
			document.getElementById("demo").innerHTML = myObj.results[0]["key"]; //this.responseText;//myObj.result[key];//count;
			//gbif(myObj.results[0]["key"]);
			jabot(myObj.results[0]["key"])
			}
		};
		xmlhttp.open("GET", "https://api.gbif.org/v1/species?name="+sp, true);
		xmlhttp.send();
	} else if (document.getElementById('checkfontejabot').checked==true){
		jabot(null);
	}
}

function jabot (gbifTaxonKey) {
	//alert(taxonKey);
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			//console.log('resultado jabot');
			//console.log(this.responseText)
			var jabotData = JSON.parse(this.responseText);
			if(gbifTaxonKey) gbif(gbifTaxonKey, jabotData)
			else printJabotOnly(jabotData)
		}
		else {
			//console.log(this.readyState)
			//console.log(this.responseText)
		}
	};
	
	if(document.getElementById('checkfontejabot').checked==true){
		xmlhttp.open("GET", <?php echo "'https://model-r.jbrj.gov.br/execjabot.php?especie=" . $especie . "'"; ?>, true);
		xmlhttp.send();
	} else {
		gbif(gbifTaxonKey, [])
	}


}

function printJabotOnly(jabotData){
	
	var body = '';		
	//print jabot
    //console.log(jabotData[0]);
	for (i = 0; i < jabotData.length; i++) {
		//alert(i);
		longitude = jabotData[i].longitude;
		latitude = jabotData[i].latitude;
			
		taxon = jabotData[i].taxoncompleto;
		tombo = jabotData[i].numtombo;
		coletor = jabotData[i].coletor;
		numcoleta = jabotData[i].numcoleta;
		pais = jabotData[i].pais;
		estado = jabotData[i].estado;
		cidade = jabotData[i].municipio;
		herbario = jabotData[i].herbario;
		
		//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
		var idexperimento = document.getElementById('id').value;
		var html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='+jabotData[i].codtestemunho+'&arquivo='+jabotData[i].arquivo+' target=\'Visualizador\'><img src="http://'+jabotData[i].servidor+'/fsi/server?type=image&source='+jabotData[i].path+'/'+jabotData[i].arquivo+'&width=300&height=100&profile=jpeg&quality=20"></a>'
		var Jval = jabotData[i].codtestemunho; 

			body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
			body +='<td class=" ">'+html_imagem+taxon+'</td>';
			body +='<td class="a-right a-right ">Jabot</td>';
            body +='<td class="a-right a-right ">'+herbario+'</td>';
			body +='<td class="a-right a-right ">'+tombo+'</td>';
			body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
			body +='<td class=" ">'+latitude+', '+longitude+'</td>';
			body +='<td class=" ">'+pais+', '+estado+' - '+cidade+'</td>';
		
	}
	
	var table = '';
	table += '<table class="table table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
	table += '</th><th class="column-title">Táxon </th><th class="column-title">Origem </th><th class="column-title">Herbário </th><th class="column-title">Tombo </th><th class="column-title">Coletor </th><th class="column-title">Coordenadas </th>';
	table += '<th class="column-title">Localização</th>';
	table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
	table += '</th></tr></thead>';
	table += '<tbody><td class="a-center total-busca" colspan=8>Total:' + (jabotData.length)  + '</td>'+body+'</tbody></table>';
	table += '';
	
	document.getElementById("div_resultadobusca").innerHTML = table;
}

function gbif(taxonKey, jabotData)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		//console.log('resultado gbif222');
			//console.log(this.responseText)
        var myObj = JSON.parse(this.responseText);
		var body = '';
		//print gbif
		for (i = 0; i < myObj.results.length; i++) {
			//alert(i);
			longitude = myObj.results[i].decimalLongitude;
			latitude = myObj.results[i].decimalLatitude;

			taxon = myObj.results[i].scientificName;
			tombo = myObj.results[i].catalogNumber;
			coletor = myObj.results[i].recordedBy;
			numcoleta = myObj.results[i].recordNumber;
			pais = myObj.results[i].country;
			estado = myObj.results[i].stateProvince;
			cidade = myObj.results[i].municipality;
			herbario = myObj.results[i].datasetName;
			
			//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
			var idexperimento = document.getElementById('id').value;
			//split * 
			var Jval = idexperimento + '*2*'+latitude+'*'+longitude+'*'+taxon+'*'+ coletor+'*'+numcoleta+'****'+ pais+'*'+ estado+'*'+ cidade + '*' + herbario + '*' + tombo; 

				body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
				body +='<td class=" ">'+taxon+'</td>';
				body +='<td class="a-right a-right ">GBIF</td>';
                body +='<td class="a-right a-right ">'+herbario+'</td>';
				body +='<td class="a-right a-right ">'+tombo+'</td>';
				body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
				body +='<td class=" ">'+latitude+', '+longitude+'</td>';
				body +='<td class=" ">'+pais+', '+estado+' - '+cidade+'</td>';
		}
		
		//print jabot
		for (i = 0; i < jabotData.length; i++) {
			//alert(i);
			longitude = jabotData[i].longitude;
			latitude = jabotData[i].latitude;
				
			taxon = jabotData[i].taxoncompleto;
			tombo = jabotData[i].numtombo;
			coletor = jabotData[i].coletor;
			numcoleta = jabotData[i].numcoleta;
			pais = jabotData[i].pais;
			estado = jabotData[i].estado;
			cidade = jabotData[i].municipio;
			herbario = jabotData[i].herbario;
			
			//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
			var idexperimento = document.getElementById('id').value;
			var html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='+jabotData[i].codtestemunho+'&arquivo='+jabotData[i].arquivo+' target=\'Visualizador\'><img src="http://'+jabotData[i].servidor+'/fsi/server?type=image&source='+jabotData[i].path+'/'+jabotData[i].arquivo+'&width=300&height=100&profile=jpeg&quality=20"></a>'
			var Jval = jabotData[i].codtestemunho; 

				body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
				body +='<td class=" ">'+html_imagem+taxon+'</td>';
				body +='<td class="a-right a-right ">Jabot</td>';
				body +='<td class="a-right a-right ">'+herbario+'</td>';
                body +='<td class="a-right a-right ">'+tombo+'</td>';
				body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
				body +='<td class=" ">'+latitude+', '+longitude+'</td>';
				body +='<td class=" ">'+pais+', '+estado+' - '+cidade+'</td>';
			
		}
		
		var table = '';
		table += '<table class="table table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
		table += '</th><th class="column-title">Táxon </th><th class="column-title">Origem </th><th class="column-title">Herbário </th><th class="column-title">Tombo </th><th class="column-title">Coletor </th><th class="column-title">Coordenadas </th>';
		table += '<th class="column-title">Localização</th>';
		table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
		table += '</th></tr></thead>';
		table += '<tbody><td class="a-center total-busca" colspan=8>Total:' + (jabotData.length + myObj.results.length)  + '</td>'+body+'</tbody></table>';
		table += '';
			
//			x += '('+myObj.results[i]['decimalLongitude'] + ', '+myObj.results[i]['decimalLongitude']+ ')';
//		}

//		decimalLongitude":-41.336139,"decimalLatitude
		
			document.getElementById("div_resultadobusca").innerHTML = table;
		}
	};
	xmlhttp.open("GET", "https://api.gbif.org/v1/occurrence/search?taxonKey="+taxonKey+'&hasCoordinate=true&limit=4000', true);
//	xmlhttp.open("GET", "https://api.gbif.org/v1/occurrence/search?taxonKey="+taxonKey+'', true);
	xmlhttp.send();
}

function adicionarOcorrencia()
{
	if (contaSelecionados(document.getElementsByName('chtestemunho[]'))>0 && !multipleSpecies)
	{
		//console.log(document.getElementsByName('chtestemunho[]'))
		exibe('loading','Adicionando Ocorrências');
		document.getElementById('frm2').action='exec.adicionarocorrencia.php';
		document.getElementById('frm2').submit();
	}
    else if(contaSelecionados(document.getElementsByName('chtestemunho[]'))>0 && multipleSpecies){
        //csv com mais de uma esp�cie
        //exibe('loading','Adicionando Ocorrências');
		//document.getElementById('frm2').action='exec.adicionargrupo.php';
		//document.getElementById('frm2').submit();
		$('#multSpeciesModal').modal('show');
    }
	else
	{
		criarNotificacao('Atenção','Selecione os registros que deseja adicionar','warning');
	}
}

function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // use the 1st file from the list
    f = files[0];

    var reader = new FileReader();

    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {

		//console.log(e.target.result)
		var arr = e.target.result.split('\n');

		document.getElementById("checkfontecsv").checked = true;
		document.getElementById("filename").innerHTML = f.name;
		document.getElementById("csv-separator").style.display = 'flex';
		file = arr;
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsText(f);
  }

function printCSV(lines){
	var body = '';
	var separator = document.getElementById("csv-select").options[document.getElementById("csv-select").selectedIndex].value;

    checkIsMultipleSpecies(lines, separator);
	for (i = 0; i < lines.length-1; i++) {

		var values = lines[i].split(separator);
		//alert(i);
		//[espécie],[estado],[município],[coletor],[número de coleta],[longitude],[latitude]
		taxon = values[0];
		estado = values[1];
		municipio = values[2];
		coletor = values[3];
		numcoleta = values[4];
		longitude = values[5] || 0;
		latitude = values[6] || 0;
		
		var idexperimento = document.getElementById('id').value;
		//split * 
		var Jval = idexperimento + '*2*'+latitude+'*'+longitude+'*'+taxon+'*'+ coletor+'*'+numcoleta+'*****'+estado+'*'+municipio+'**'; 
		 
		body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
		body +='<td class=" ">'+taxon+'</td>';
		body +='<td class=" ">'+coletor+'</td>';
		body +='<td class=" ">'+numcoleta+'</td>';
		body +='<td class=" ">'+estado+'</td>';
		body +='<td class=" ">'+municipio+'</td>';
		body +='<td class=" ">'+latitude+', '+longitude+'</td>';

	}
	
	var table = '';
	table += '<table class="table table-csv table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
	table += '</th><th class="column-title">Taxon </th><th>Coletor</th><th>Número de Coleta</th><th>Estado</th><th>Município</th><th class="column-title">Coordenadas</th>';
	table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
	table += '</th></tr></thead>';
	table += '<tbody>'+body+'</tbody></table>';
	table += '';
	
	document.getElementById("div_resultadobusca").innerHTML = table;
}

  document.getElementById('upload').addEventListener('change', handleFileSelect, false);

var multipleSpecies = false;
function checkIsMultipleSpecies(lines, separator){

    var species = [];
    for (i = 0; i < lines.length-1; i++) {

		var values = lines[i].split(separator);
		species.push(values[0]);
	}

    var uniques = species.unique();
    if(uniques.length > 1) multipleSpecies = true;
    
    return;
}

Array.prototype.unique = function() {
    var arr = [];
    for(var i = 0; i < this.length; i++) {
        if(!arr.includes(this[i])) {
            arr.push(this[i]);
        }
    }
    return arr; 
}

function showInstructions() {
	$('#instructionModal').modal('show');
}

$(document).ready(function(){
    //console.log(document.getElementById('checkfontegbif').checked==true)
	//console.log(document.getElementById('checkfontejabot').checked==true)
    if(document.getElementById('checkfontejabot').checked==true || document.getElementById('checkfontegbif').checked==true){
        var especie = document.getElementById('edtespecie').value;
		getTaxonKeyGbif(especie);
    }
    //console.log('document ready');
});

function buscar()
{
	//exibe('loading','Buscando Ocorrências');
	 if (document.getElementById('edtespecie').value=='' && document.getElementById('checkfontecsv').checked==false)// && document.getElementById('checkfontecsv').checked==false)
	 {
	 	criarNotificacao('Atenção','Informe o nome da espécie','warning')
	 }
	 else
	 {   
	 	var texto = document.getElementById('edtespecie').value;
	 	var palavra = texto.split(' ');
		
         if (document.getElementById('checkfontejabot').checked==true || document.getElementById('checkfontegbif').checked==true)
         {
             document.getElementById('frm2').action="cadexperimento.php?id=" + '<?php echo $id;?>' + "&op=" + '<?php echo $op;?>' + "&busca=TRUE&tab=9";
             document.getElementById('frm2').submit();
         }
         else if (document.getElementById('checkfontesibbr').checked==true)
         {
             getSibbr(texto);
         }
         else printCSV(file);
     }
}

function sameExperiment () {
	exibe('loading','Adicionando Ocorrências');
	document.getElementById('frm2').action='exec.adicionarocorrencia.php';
	document.getElementById('frm2').submit();
}

function moreThanOneExperiment () {
    exibe('loading','Adicionando Ocorrências');
	document.getElementById('frm2').action='exec.adicionargrupo.php';
	document.getElementById('frm2').submit();
}
$('#checkfontecsv').on('change', function() {
    if(document.getElementById('checkfontecsv').checked){
        document.getElementById('checkfontejabot').checked = false;
        document.getElementById('checkfontegbif').checked = false
    }
});

$('#checkfontejabot').on('change', function() {
    if(document.getElementById('checkfontejabot').checked){
        document.getElementById('checkfontecsv').checked = false;
    }
});

$('#checkfontegbif').on('change', function() {
    if(document.getElementById('checkfontegbif').checked){
        document.getElementById('checkfontecsv').checked = false;
    }
});
</script>