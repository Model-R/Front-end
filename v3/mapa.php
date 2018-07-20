<?php session_start();
// error_reporting(E_ALL);
// ini_set('display_errors','1');
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}
?><html lang="pt-BR">
<?php
require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$tab = $_REQUEST['tab'];
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

$Experimento->getById($id);
$Experimento->getPath($id);
$idexperiment = $Experimento->idexperiment;//= $row['nomepropriedade'];
$pngCutPath = $Experimento->pngCutPath;
$rasterCutPath = $Experimento->rasterCutPath;
$pngBinPath = $Experimento->pngBinPath;
$pngContPath = $Experimento->pngContPath;
$isImageCut = $Experimento->isImageCut;
$isImageCut = $isImageCut === 't'? true: false;
$pngPath = $Experimento->pngPath;
$tiffPath = $Experimento->tiffPath;
$rasterPngPath = $Experimento->rasterPngPath;

$rasterPngPath = str_replace("/var/www/html/rafael/modelr","https://model-r.jbrj.gov.br",$rasterPngPath);        
$novoRaster;

?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Model-R </title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

	<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
	  #map3 {
        height: 65%;
      }
    </style>
</head>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<form name='frmmapa' id='frmmapa' action='exec.modelagem.php' method="post" class="form-horizontal form-label-left" novalidate></form>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_content map-content">
		<input class="opacity-slider" type="range" min="0" max="1" step="0.1" value="1" onchange="updateOpacity(this.value)" data-toggle="tooltip" data-placement="top" title="Arraste para alterar transparência da imagem no Mapa">
		<?php require "templates/cortarraster.php";?>
		 <div id="map">
		 </div>
			<!-- end pop-over -->
		</div>
	</div>

	</div> <!-- table panel -->

</div>


<!-- custom notification-->

<div id="custom_notifications" class="custom-notifications dsp_none">
	<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
	</ul>
	<div class="clearfix"></div>
	<div id="notif-group" class="tabbed_notifications"></div>
</div>

<!-- scripts -->

<script src="js/bootstrap.min.js"></script>

<!-- chart js -->
<script src="js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<script src="js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="js/icheck/icheck.min.js"></script>

<script src="js/custom.js"></script>
<!-- form validation -->
<script src="js/validator/validator.js"></script>

<script src="js/loading.js"></script>	

<!-- PNotify -->
<script type="text/javascript" src="js/notify/pnotify.core.js"></script>
<script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
<script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>

<script>

<?php require 'MSGCODIGO.php';?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];?>

var PolygonArrayString = [];

function HomeControl(controlDiv, map) {
  controlDiv.style.padding = '5px';
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = '#FFCC00';
  controlUI.style.border='1px solid';
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Minha Localização';
  controlDiv.appendChild(controlUI);
  var controlText = document.createElement('div');
  controlText.style.fontFamily='Arial,sans-serif';
  controlText.style.fontSize='12px';
  controlText.style.paddingLeft = '4px';
  controlText.style.paddingRight = '4px';
  controlText.innerHTML = '<img src="imagens/eu.png" height="30px">'
  controlUI.appendChild(controlText);
  map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlUI);

  // Setup click-event listener: simply set the map to London
  google.maps.event.addDomListener(controlUI, 'click', function() {
   minhaLocaizacao()
  });
}

//---------------------------------- Map Shape Control

var drawingManager;
var selectedShape;
var imageOverlay;
var mapOverlay;
var imageBounds;
var polygonArray = [];

function clearSelection() {
    if (selectedShape) {
        selectedShape.setEditable(false);
        selectedShape = null;
    }
}

function setSelection(shape) {
    clearSelection();
    selectedShape = shape;
    shape.setEditable(true);
}

function CenterControl(controlDiv, map) {

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    
    controlUI.style.height = '24px';
    controlUI.style.display = 'flex';
    controlUI.style.alignItems = 'center';
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginTop = '5px';
    controlUI.style.marginLeft = '-5px';
    controlUI.style.boxShadow = '0 1.5px rgba(31, 30, 30, 0.15)';
    controlUI.title = 'Apagar desenhos selecionados';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '14px';
    controlText.style.lineHeight = '20px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = 'Apagar Polígono';
    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to Chicago.
    controlUI.addEventListener('click', function() {
        if (selectedShape) {
            deleteHiddenInput(selectedShape);
        }
    });

}

function ExportShapeControl(controlDiv, map) {

    //Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.height = '24px';
    controlUI.style.display = 'flex';
    controlUI.style.alignItems = 'center';
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.borderTopRightRadius = '3px';
    controlUI.style.borderBottomRightRadius = '3px';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginTop = '5px';
    controlUI.style.boxShadow = '0 1.5px rgba(31, 30, 30, 0.15)';
    controlUI.title = 'Exportar desenhos selecionados';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '14px';
    controlText.style.lineHeight = '20px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = 'Cortar Polígono';
    controlUI.appendChild(controlText);

    controlUI.addEventListener('click', function() {
		console.log('entrou cortar raster')
        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function()  {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                mapOverlay.setMap(null);
                mapOverlay = new google.maps.GroundOverlay(
					'https://model-r.jbrj.gov.br/temp/' + <?php echo $id;?> + '/png_map-' + <?php echo $id;?> + '.png?' + Math.random(),
                imageBounds,{opacity:1});
                mapOverlay.setMap(map);
                <?php 
					$novoRaster = 'https://model-r.jbrj.gov.br/temp/' . $id .'/png_map-' . $id . '.png';
				?>
                
                isImageCut = true;
                pngCutPath = 'https://model-r.jbrj.gov.br/temp/' + <?php echo $id;?> + '/png_map-' + <?php echo $id;?> + '.png';
                console.log(pngCutPath);
				imageOverlay = mapOverlay;
				document.getElementById("cancelarCorteRaster").style.display = 'flex';
            }
        }
        console.log(PolygonArrayString)
        console.log('cutGeoJson.php?table=polygon&array=' + PolygonArrayString.join(':') + '&expid=' + <?php echo $id;?>)
        xmlhttp.open("GET",'cutGeoJson.php?table=polygon&array=' + PolygonArrayString.join(':') + '&expid=' + <?php echo $id;?>,true);
        xmlhttp.send();
    }); 

}

 document.getElementById("cancelarCorteRaster").onclick = () => {
	 console.log('entrou cancelar cortar raster')
     mapOverlay.setMap(null);

     if(rasterPngPath){
        mapOverlay = new google.maps.GroundOverlay(rasterPngPath,imageBounds,{opacity:1});
    } 

    isImageCut = false;
     mapOverlay.setMap(mapresult);

     imageOverlay = mapOverlay;
	 document.getElementById("cancelarCorteRaster").style.display = 'none';

     xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()  {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            console.log('limpou corte');
        }
    }
    xmlhttp.open("GET",'controleCorteRaster.php?op=L&expid= <?php echo $idexperiment; ?>',true);
    xmlhttp.send();
};

function updateOpacity (value){
    imageOverlay.setOpacity(Number(value));
}

var mapresult;

var pngCutPath;
var rasterCutPath;
var isImageCut;
var rasterPngPath;

function initMapExpResultado() {
	console.log('initMapExpResultado')
  var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -21.6481541, lng: -56.52764},
	    panControl:true,
      	zoomControl:true,
          gestureHandling: 'greedy',
        scaleControl:true,
	  	zoomControlOptions: {
  		    style:google.maps.ZoomControlStyle.DEFAULT
	 	},
        mapTypeId: 'terrain',
        mapTypeControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['terrain','roadmap', 'satellite']
        },
        styles: [
            {
                "featureType": "landscape",
                "stylers": [
                    {"hue": "#FFA800"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {"hue": "#53FF00"},
                    {"saturation": -73},
                    {"lightness": 40},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {"hue": "#FBFF00"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {"hue": "#00FFFD"},
                    {"saturation": 0},
                    {"lightness": 30},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {"hue": "#00BFFF"},
                    {"saturation": 6},
                    {"lightness": 8},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {"hue": "#679714"},
                    {"saturation": 33.4},
                    {"lightness": -25.4},
                    {"gamma": 1}
                ]
            }
        ],
    zoom: 4
  });
  
  var overlay;
   USGSOverlay.prototype = new google.maps.OverlayView();

  var centerControlDiv = document.createElement('div');
var centerControl = new CenterControl(centerControlDiv, map);

centerControlDiv.index = 1;
map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

var exportShapeDiv = document.createElement('div');
var exportShape = new ExportShapeControl(exportShapeDiv, map);

exportShapeDiv.index = 1;
map.controls[google.maps.ControlPosition.TOP_CENTER].push(exportShapeDiv);

console.log('rasterPngPath: ' + rasterPngPath);
console.log('isImageCut: ' + isImageCut);
console.log('pngCutPath: ' + pngCutPath);
  imageBounds = new google.maps.LatLngBounds(
	new google.maps.LatLng(-33.77584, -57.84917),
	new google.maps.LatLng(-2.775838, -34.84917));

		if(isImageCut){
			mapOverlay = new google.maps.GroundOverlay(pngCutPath,imageBounds,{opacity:1});
		} else {
			mapOverlay = new google.maps.GroundOverlay(rasterPngPath,imageBounds,{opacity:1});
		}
		
mapOverlay.setMap(map);

imageOverlay = mapOverlay;

map.setZoom(4);

var drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.POLYGON,
    drawingControl: true,

    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_CENTER,
      drawingModes: [
        google.maps.drawing.OverlayType.CIRCLE,
        google.maps.drawing.OverlayType.RECTANGLE,
        google.maps.drawing.OverlayType.POLYGON
      ]
    },
    markerOptions: {
		icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 6,
            fillColor: '#A74EAF',
            fillOpacity: 0.8,
            strokeColor: '#fff',
            strokeWeight: 1
		}
		
//      icon: 'imagens/place-03.png'
    },
    circleOptions: {
      fillColor: '#50657e;',
      fillOpacity: .3,
      strokeWeight: 3,
      clickable: true,
      editable: true,
      zIndex: 1
    }
  });	
  
  drawingManager.setMap(map);

google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
    if (e.type != google.maps.drawing.OverlayType.MARKER) {
        console.log('desenho polygon')
        polygonArray.push(e.overlay);
        createHiddenInput(e.overlay);
        // Switch back to non-drawing mode after drawing a shape.
        drawingManager.setDrawingMode(null);
        // Add an event listener that selects the newly-drawn shape when the user
        // mouses down on it.
        var newShape = e.overlay;
        newShape.type = e.type;
        google.maps.event.addListener(newShape, 'click', function() {
            setSelection(newShape);
        });
        setSelection(newShape);
    }
});

// Clear the current selection when the drawing mode is changed, or when the
// map is clicked.
google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
google.maps.event.addListener(map, 'click', clearSelection);

mapresult = map;
// [START region_rectangle]
  var bounds1 = {
    north: <?php echo $extensao1_norte;?>,
    south: <?php echo $extensao1_sul ;?>,
    east: <?php echo $extensao1_leste ;?>,
    west: <?php echo $extensao1_oeste ;?>
  };
  
var bounds = new google.maps.LatLngBounds(
new google.maps.LatLng(-35.074, -73.844),
new google.maps.LatLng(6.485, -32.766));

  // Define a rectangle and set its editable property to true.
  var rectangle = new google.maps.Rectangle({
    bounds: bounds1,
    editable: true,
	draggable: true
  });

function createHiddenInput (shape) {
    if(typeOfShape(shape) == 'polygon'){
        var vertices = [];
        for(var i = 0; i < shape.getPath().getLength(); i++){
            vertices.push(shape.getPath().getAt(i).toUrlValue(5));
        }
    } else {
        var bounds = shape.getBounds();
        var NE = bounds.getNorthEast();
        var SW = bounds.getSouthWest();
        var NW = new google.maps.LatLng(NE.lat(), SW.lng()).toString().replace('(','').replace(')','');
        var SE = new google.maps.LatLng(SW.lat(), NE.lng()).toString().replace('(','').replace(')','');
        NE = bounds.getNorthEast().toString().replace('(','').replace(')','');
        SW = bounds.getSouthWest().toString().replace('(','').replace(')','');

        var vertices = [SW,NW,NE,SE];
    }

    PolygonArrayString.push(vertices.join(';'));
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "polygon[]");
    input.setAttribute("value", vertices.join(';'));

    //append to form element that you want .
    document.getElementById("frmmapa").appendChild(input);

}

function typeOfShape(shape){
    if(typeof shape.getPath === "function"){
        return "polygon";
    }else if(typeof shape.getRadius === "function"){
        return "circle";
    }else{
        return "unknown";
    }
}

function USGSOverlay(bounds, image, map) {

        // Initialize all properties.
        this.bounds_ = bounds;
        this.image_ = image;
        this.map_ = map;

        // Define a property to hold the image's div. We'll
        // actually create this div upon receipt of the onAdd()
        // method so we'll leave it null for now.
        this.div_ = null;

        // Explicitly call setMap on this overlay.
        this.setMap(map);
      }

      /**
       * onAdd is called when the map's panes are ready and the overlay has been
       * added to the map.
       */
      USGSOverlay.prototype.onAdd = function() {

        var div = document.createElement('div');
        div.style.borderStyle = 'none';
        div.style.borderWidth = '0px';
        div.style.position = 'absolute';

        // Create the img element and attach it to the div.
        var img = document.createElement('img');
        img.src = this.image_;
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.position = 'absolute';
        div.appendChild(img);

        this.div_ = div;

        // Add the element to the "overlayLayer" pane.
        var panes = this.getPanes();
        panes.overlayLayer.appendChild(div);
      };

      USGSOverlay.prototype.draw = function() {

        // We use the south-west and north-east
        // coordinates of the overlay to peg it to the correct position and size.
        // To do this, we need to retrieve the projection from the overlay.
        var overlayProjection = this.getProjection();

        // Retrieve the south-west and north-east coordinates of this overlay
        // in LatLngs and convert them to pixel coordinates.
        // We'll use these coordinates to resize the div.
        var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
        var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

        // Resize the image's div to fit the indicated dimensions.
        var div = this.div_;
        div.style.left = sw.x + 'px';
        div.style.top = ne.y + 'px';
        div.style.width = (ne.x - sw.x) + 'px';
        div.style.height = (sw.y - ne.y) + 'px';
      };

      // The onRemove() method will be called automatically from the API if
      // we ever set the overlay's map property to 'null'.
      USGSOverlay.prototype.onRemove = function() {
        this.div_.parentNode.removeChild(this.div_);
        this.div_ = null;
      };
 
 
  
  rectangle.addListener('bounds_changed', showNewRect);
  
   function showNewRect(event) {
        var ne = rectangle.getBounds().getNorthEast();
        var sw = rectangle.getBounds().getSouthWest();

        document.getElementById('edtextensao1_oeste').value=ne.lat();
        document.getElementById('edtextensao1_sul').value=sw.lat();
        document.getElementById('edtextensao1_leste').value=sw.lng();
        document.getElementById('edtextensao1_norte').value=ne.lng();
		
      }
 
<?php 
	$sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
    path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,
case when lat2 is not null then lat2 else lat end as lat, case when long2 is not null then long2
else long end as long
 from modelr.occurrence, modelr.statusoccurrence where 
							occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
							idexperiment = ".$id. " and occurrence.idstatusoccurrence in (4,17) ";

//echo $sql; 
$res = pg_exec($conn,$sql);
$conta = pg_num_rows($res);
$marker = '';
	
	$c=0;
	while ($row = pg_fetch_array($res))
	{
		
		// preparo os quadros de informação para cada ponto
		$c++;
		if ($c < $conta) {
			$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."'],";
		}
		else
		{
			$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."']";
			$latcenter = $row['lat'];
			$longcenter = $row['long'];
		}
	}

?>							
  	var markers = [
        <?php echo $marker;;?>
    ];

    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]); 
		marker2 = new google.maps.Marker({
            position: position,
            map: map,
			draggable: false,
            icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
            title: markers[i][0]
        });
       
    }
	
}

function typeOfShape(shape){
    if(typeof shape.getPath === "function"){
        return "polygon";
    }else if(typeof shape.getRadius === "function"){
        return "circle";
    }else{
        return "unknown";
    }
}


function deleteHiddenInput (shape) {

    if(typeOfShape(shape) == 'polygon'){
        var vertices = [];
        for(var i = 0; i < shape.getPath().getLength(); i++){
            vertices.push(shape.getPath().getAt(i).toUrlValue(5));
        }
    } else {
        var bounds = shape.getBounds();
        var NE = bounds.getNorthEast();
        var SW = bounds.getSouthWest();
        var NW = new google.maps.LatLng(NE.lat(), SW.lng()).toString().replace('(','').replace(')','');
        var SE = new google.maps.LatLng(SW.lat(), NE.lng()).toString().replace('(','').replace(')','');
        NE = bounds.getNorthEast().toString().replace('(','').replace(')','');
        SW = bounds.getSouthWest().toString().replace('(','').replace(')','');

        var vertices = [SW,NW,NE,SE];
    }

    var polygons = document.getElementsByName("polygon[]");
    for(var i = 0; i < polygons.length; i++)
    {   
        if(polygons[i].value == vertices.join(';'))
        {
            polygons[i].parentNode.removeChild(polygons[i]);
        }
    }

    var index = PolygonArrayString.indexOf(vertices.join(';'));
    if (index > -1) {
        PolygonArrayString.splice(index, 1);
    }

    shape.setMap(null);

}

function cortarRaster(){
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			console.log('entrou' + xmlhttp.responseText);
			mapOverlay.setMap(null);
			mapOverlay = new google.maps.GroundOverlay(
				'https://model-r.jbrj.gov.br/temp/' + <?php echo $id;?> + '/png_map-' + <?php echo $id;?> + '.png?' + Math.random(),
			imageBounds,{opacity:1});
			mapOverlay.setMap(mapresult);
			<?php 
				$novoRaster = 'https://model-r.jbrj.gov.br/temp/' . $id .'/png_map-' . $id . '.png';
			?>
			
			isImageCut = true;
			pngCutPath = 'https://model-r.jbrj.gov.br/temp/' + <?php echo $id;?> + '/png_map-' + <?php echo $id;?> + '.png';
			imageOverlay = mapOverlay;
			document.getElementById("cancelarCorteRaster").style.display = 'flex';
		}
	}
	console.log(PolygonArrayString)
	console.log('cutGeoJson.php?table=polygon&array=' + PolygonArrayString.join(':') + '&expid=' + <?php echo $id;?>)
	xmlhttp.open("GET",'cutGeoJson.php?table=polygon&array=' + PolygonArrayString.join(':') + '&expid=' + <?php echo $id;?>,true);
	xmlhttp.send();
    console.log(document.getElementById('cmboxcortarraster').value)
} 

$(document ).ready(function() {
    pngCutPath = <?php echo "'" . $pngCutPath . "'"; ?>;
    rasterCutPath = <?php echo "'" . $rasterCutPath . "'"; ?>;
    isImageCut = <?php echo "'". $isImageCut . "'" ; ?>;
    rasterPngPath = <?php echo "'". $rasterPngPath . "'"; ?>;
	initMapExpResultado();	
});

$('.nav-tabs a[href="#tab_content13"]').click(function(){
    console.log('tab 13');
    initMapExpResultado();
    setTimeout(function() {
        google.maps.event.trigger(window, 'resize', {});
        mapresult.setCenter({lat: -21.6481541, lng: -56.52764});
	}, 500)
})
		
$('.nav-tabs a[href="#tab_content3"]').click(function(){
	//alert('3');
    $(this).tab('show');
});	

$('.nav-tabs').on('shown.bs.tab', function () {
    google.maps.event.trigger(window, 'resize', {});
    initMapExpResultado();
});
</script>