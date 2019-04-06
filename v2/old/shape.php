
<!DOCTYPE html><html><head>
<meta charset='utf-8'/>

	 <title>Shapefile in Leaflet!</title>   <style>
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0;}
      #map{ height: 100% }
    </style>
	 <link rel="stylesheet" href="js/leaflet.css" />
<!--[if lte IE 8]>
    <link rel="stylesheet" href="site/leaflet.ie.css" />
<![endif]-->
<link rel="stylesheet" href="js/gh-fork-ribbon.css" />
<script src="js/leaflet.js"></script>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40454900-1', 'calvinmetcalf.github.io');
  ga('send', 'pageview');
</script>
	 </head><body><div class="github-fork-ribbon-wrapper right">
		<div class="github-fork-ribbon">
			<a href="https://github.com/calvinmetcalf/shapefile-js">Fork me on GitHub</a>
		</div>
	</div>  <div id="map"></div>
<script src="js/shp.min.js"> </script>
<script>
	 var m= L.map('map').setView([34.74161249883172,18.6328125], 2);
	 
	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(m);
	 
	 
      var geo = L.geoJson({features:[]},{onEachFeature:function popUp(f,l){
    		var out = [];
    		if (f.properties){
        		for(var key in f.properties){
            	out.push(key+": "+f.properties[key]);
        }
        l.bindPopup(out.join("<br />"));
    }
}}).addTo(m);
      var base = 'parques.zip';
		shp(base).then(function(data){
		geo.addData(data);
		});

</script>
</body></html>