<?php

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: https://modelr.jbrj.gov.br');

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

<div id="instructionModal" class="modal fade">
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
                [espécie],[longitude],[latitude]
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

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
    <h2>Dados Bióticos <small></small></h2>
    <div class="clearfix">
    </div>
    </div>
    <div class="x_content">
    <div>
        <div class="item form-group files-options">
        <label class="control-label" for="email">Fonte<span class="required">*</span>
        </label>
        <div class="">
            <div class="radio-group">
                <div><input type="radio" name="fontebiotico[]" id="checkfontejabot" value="1" <?php if ($_REQUEST['fontebiotico'][0]=='1') echo "checked";?> /> JABOT</div>
                <div><input type="radio" name="fontebiotico[]" id="checkfontegbif" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='2') echo "checked";?>/> GBIF</div>
                <div><input type="radio" name="fontebiotico[]" id="checkfontesibbr" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='3') echo "checked";?>/> SiBBr</div>
                <div><input type="radio" name="fontebiotico[]" id="checkfontecsv" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='2') echo "checked";?>/> CSV</div>
            </div>
            <div class="csv-button">
                <form enctype="multipart/form-data"><label id="label-arquivo" for='upload'>Arquivo CSV</label><input id="upload" type=file accept="text/csv" name="files[]" size=30></form>
                <div class="csv-instruction" data-toggle="tooltip" data-placement="right" title data-original-title="Instruções">
                <span class="glyphicon glyphicon-modal-window" data-toggle="modal" data-target="#instructionModal"></span>
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
                    <input id="edtespecie" value="<?php echo $especie;?>"  name="edtespecie" class="form-control col-md-7 col-xs-12" >
                    <span class="input-group-btn"><button type="button" onclick="buscar()" class="btn btn-primary" >Buscar</button>
                    <button type="button" onclick="adicionarOcorrencia()" class="btn btn-success btn"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Adicionar</button></span>
                </div>
            </div>
        </div>
    </div>		
    <!--id="check-all" class="flat"-->
    <div id='div_resultadobusca'>
        <table class="table table-striped responsive-utilities jambo_table bulk_action">
        <?php 
        //1 jabot
        //2 Gbif
        if ((!empty($especie)) && ($_REQUEST['fontebiotico'][0]=='1'))
        {
            $sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude,
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
                    <th class="column-title">Táxon </th>
                    <th class="column-title">Tombo </th>
                    <th class="column-title">Herbário </th>
                    <th class="column-title">Coletor </th>
                    <th class="column-title">Coordenadas </th>
                    <th class="column-title">Localização</th>
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
            } 
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

    <script src="js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>
	<!-- select2 -->
    <script src="js/select/select2.full.js"></script>
	
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

    function buscar()
{
	//alert(document.getElementById('checkfontegbif').checked);
	if (document.getElementById('edtespecie').value=='' && document.getElementById('checkfontecsv').checked==false)
	{
		criarNotificacao('Atenção','Informe o nome da espécie','warning')
	}
	else
	{
		var texto = document.getElementById('edtespecie').value;
		var palavra = texto.split(' ');
		if ((palavra.length)<2 && document.getElementById('checkfontecsv').checked==false)
		{
			criarNotificacao('Atenção','Informe o nome da espécie','warning');
		}
		else
		{
			if (document.getElementById('checkfontegbif').checked==true)
			{
				//alert('gbif');
				getTaxonKeyGbif(texto);
				//gbif(texto);
			}
			else if (document.getElementById('checkfontejabot').checked==true)
			{
				//alert('jabot');
				document.getElementById('frm').action="cadexperimento.php?busca=TRUE";
				document.getElementById('frm').submit();
			}
			else if (document.getElementById('checkfontesibbr').checked==true)
			{
				//alert('jabot');
				getSibbr(texto);
			}
			else printCSV(file);
		}
	}
}

function getTaxonKeyGbif(sp)
{
	//alert('');
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myObj = JSON.parse(this.responseText);
        document.getElementById("demo").innerHTML = myObj.results[0]["key"]; //this.responseText;//myObj.result[key];//count;
		gbif(myObj.results[0]["key"]);
		}
	};
	console.log(sp);
	xmlhttp.open("GET", "http://api.gbif.org/v1/species?name="+sp, true);
	xmlhttp.send();
}

function gbif(taxonKey)
{
	//alert(taxonKey);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myObj = JSON.parse(this.responseText);
		var body = '';
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
			
			var Jval = idexperimento + '|2|'+latitude+'|'+longitude+'|'+taxon+'|'+ coletor+'|'+numcoleta+'||||'+ pais+'|'+ estado+'|'+ cidade + '|' + herbario + '|' + tombo; 

				body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
				body +='<td class=" ">'+taxon+'</td>';
				body +='<td class="a-right a-right ">'+tombo+'</td>';
				body +='<td class="a-right a-right ">'+herbario+'</td>';
				body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
				body +='<td class=" ">'+latitude+', '+longitude+'</td>';
				body +='<td class=" ">'+pais+', '+estado+' - '+cidade+'</td>';
			
			//var str = "insert into modelr.occurrence (idexperiment,iddatasource,lat,long,taxon,collector,collectnumber,server,path,file,idstatusoccurrence,country,majorarea,minorarea) values (";
			//str+=idexperiment+','+'2'+','+latitude+','+longitude+",'"+taxon+"','"+coletor+"','"+numcoleta+"','','','','','',


			//x =  myObj.results[i].decimalLongitude + ', '+ myObj.results[i].decimalLatitude;
			//exec.adicionarocorrenciagbif
			//alert(x);
		}
		
		var table = '';
		table += '<table class="table table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
		table += '</th><th class="column-title">Táxon </th><th class="column-title">Tombo </th><th class="column-title">Herbário </th><th class="column-title">Coletor </th><th class="column-title">Coordenadas </th>';
		table += '<th class="column-title">Localização</th>';
		table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
		table += '</th></tr></thead>';
		table += '<tbody>'+body+'</tbody></table>';
		table += '';
			
//			x += '('+myObj.results[i]['decimalLongitude'] + ', '+myObj.results[i]['decimalLongitude']+ ')';
//		}

//		decimalLongitude":-41.336139,"decimalLatitude
		
			document.getElementById("div_resultadobusca").innerHTML = table;
		}
	};
	xmlhttp.open("GET", "http://api.gbif.org/v1/occurrence/search?taxonKey="+taxonKey+'&hasCoordinate=true', true);
	xmlhttp.send();
}

function adicionarOcorrencia()
{

	if (contaSelecionados(document.getElementsByName('chtestemunho[]'))>0)
	{
		exibe('loading');
		document.getElementById('frm').action='exec.adicionarocorrencia.php';
		document.getElementById('frm').submit();
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
	for (i = 0; i < lines.length-1; i++) {

		var values = lines[i].split(separator);
		//alert(i);
		longitude = values[1] || 0;
		latitude = values[2] || 0;

		taxon = values[0];
		
		var idexperimento = document.getElementById('id').value;
		
		var Jval = idexperimento + '|2|'+latitude+'|'+longitude+'|'+taxon+'||||||||||'; 

		body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
		body +='<td class=" ">'+taxon+'</td>';
		body +='<td class=" ">'+latitude+', '+longitude+'</td>';

	}
	
	var table = '';
	table += '<table class="table table-csv table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
	table += '</th><th class="column-title">Táxon </th><th class="column-title">Coordenadas</th>';
	table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
	table += '</th></tr></thead>';
	table += '<tbody>'+body+'</tbody></table>';
	table += '';
	
	document.getElementById("div_resultadobusca").innerHTML = table;
}

  document.getElementById('upload').addEventListener('change', handleFileSelect, false);
  
</script>