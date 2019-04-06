<?php
   include "paths.inc";
   require_once('classes/conexao.class.php');
   require_once('classes/funcao.class.php');
   require_once('classes/propriedade.class.php');
   require_once('classes/produtor.class.php');
   require_once('classes/estado.class.php');
   require_once('classes/unidademedida.class.php');
   require_once('classes/situacaopropriedade.class.php');
   require_once('classes/tipoconsultoria.class.php');
   $clConexao = new Conexao;
   $conn = $clConexao->Conectar();
   $Propriedade = new Propriedade();
   $Propriedade->conn = $conn;
?>
<html>
<head>
<script = src="../openlayer/OpenLayers.js">
</script>
<script src="http://maps.google.com/maps/api/js?v=3.2&sensor=false"></script>
<script type="text/javascript">
	
var map;

	function init() {
	
//map = new OpenLayers.Map('map');
map = new OpenLayers.Map('map', 
                 {controls: [new OpenLayers.Control.Navigation(), 
                             new OpenLayers.Control.PanZoomBar()], 
                  numZoomLevels: 20 });

    var gphy = new OpenLayers.Layer.Google(
        "Google Physical",
        {type: google.maps.MapTypeId.TERRAIN}
    );
    var gmap = new OpenLayers.Layer.Google(
        "Google Streets" // the default
    );
    var ghyb = new OpenLayers.Layer.Google(
        "Google Hybrid",
        {type: google.maps.MapTypeId.HYBRID}
    );

    var gsat = new OpenLayers.Layer.Google(
        "Google Satellite",
        {type: google.maps.MapTypeId.SATELLITE}
    );

	var mapnik = new OpenLayers.Layer.OSM("OpenStreetMap (Mapnik)");


/*var map6 = new OpenLayers.Layer.Vector("Quadra14", {
                projection: map.displayProjection,
                strategies: [new OpenLayers.Strategy.Fixed()],
                protocol: new OpenLayers.Protocol.HTTP({
                    url: "kml/0004.kml",
                    format: new OpenLayers.Format.KML({
                        extractStyles: true,
                        extractAttributes: true
                    })
                })
            });
*/				
//gphy, gmap, ghyb, gsat
    // Google.v3 uses EPSG:900913 as projection, so we have to
    // transform our coordinates
var markers = new OpenLayers.Layer.Markers( "Markers" );

map.addLayer(markers);

var size = new OpenLayers.Size(20,22);
var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
//var icon = new OpenLayers.Icon('ax-slowkeys-yes.png', size, offset);
var icon = new OpenLayers.Icon('http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png', size, offset);


//markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(-42.839, -22.23),icon));
//markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(0,0),icon.clone()));

    map.addLayers([mapnik,gphy, gmap, ghyb, gsat]);

   map.setCenter(new OpenLayers.LonLat(-42.839, -22.23).transform(
        new OpenLayers.Projection("EPSG:4326"),
        map.getProjectionObject()
    ), 8);

<?php
	$sql = 'select * from propriedade ';
	$res = pg_exec($conn,$sql);
	while ($row = pg_fetch_array($res))
		{
		?>
	markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(<?php echo $row['longitude'];?>, <?php echo $row['latitude'];?>).transform(
        new OpenLayers.Projection("EPSG:4326"),
        map.getProjectionObject()
    ),icon));
	<?php } ?>
    
    // add behavior to html
  /*  var animate = document.getElementById("map");
    animate.onclick = function() {
        for (var i=map.layers.length-1; i>=0; --i) {
            map.layers[i].animationEnabled = this.checked;
        }
    };

*/

map.addControl(new OpenLayers.Control.LayerSwitcher());

map.addControl(new OpenLayers.Control.MousePosition());

map.addControl(new OpenLayers.Control.ScaleLine());


select = new OpenLayers.Control.SelectFeature(sundials);
            
            sundials.events.on({
                "featureselected": onFeatureSelect,
                "featureunselected": onFeatureUnselect
            });

            map.addControl(select);
            select.activate();  

//map.zoomToMaxExtent();
}

	function onPopupClose(evt) {
            select.unselectAll();
        }
        function onFeatureSelect(event) {
            var feature = event.feature;
            // Since KML is user-generated, do naive protection against
            // Javascript.
            var content = "<h2>"+feature.attributes.name + "</h2>"+feature.attributes.description;
            if (content.search("<script") != -1) {
                content = "Content contained Javascript! Escaped content below.<br>" + content.replace(/</g, "&lt;");
            }
            popup = new OpenLayers.Popup.FramedCloud("chicken", 
                                     feature.geometry.getBounds().getCenterLonLat(),
                                     new OpenLayers.Size(100,50),
                                     content,
                                     null, true, onPopupClose);
            feature.popup = popup;
            map.addPopup(popup);
        }
        function onFeatureUnselect(event) {
            var feature = event.feature;
            if(feature.popup) {
                map.removePopup(feature.popup);
                feature.popup.destroy();
                delete feature.popup;
            }
        }

</script>
</head>
<body onload="init()">
<div id="map" style="width: 100%; height: 600px"></div>
</body>
</html>
