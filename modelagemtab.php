<link href="css/sectab.css" rel="stylesheet" type="text/css" media="all">

<div class="x_content">
	<div class="tab_container" role="tab_container" data-example-id="togglable-tabs">
		<!--<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php //if ($stab=='6') echo 'class="active"';?>><a href="#tab_content6" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Parâmetros</a>
			</li>
			<li role="presentation" <?php //if ($stab=='7') echo 'class="active"';?>><a href="#tab_content7" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Resultados</a>
			</li>
		</ul>-->
		
		<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab6" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab6"><span>Dados Parâmetros</span></label>


			<input id="tab7" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab7"><span>Dados Resultados</span></label>
			
		</div>
		
		<div id="teste" class="tab-content">
			<div class="tab-pane  <?php if ($stab=='6') echo 'in active';?>" id="tab_content6" aria-labelledby="home-tab">
				<?php require "parametrosmodelagem.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($stab=='7') echo 'in active';?>" id="tab_content7" aria-labelledby="home-tab">
				<?php require "resultadotab.php";?>
			</div>
		</div>
	</div>
</div>

<script>
var stab = <?php 
	if(isset($stab)){
		echo $stab;
	} else {
		echo 0;
	}
?>;

if(stab == 6){
	document.getElementById('tab6').checked = true;
	document.getElementById('tab_content6').classList.add("in");
	document.getElementById('tab_content6').classList.add("active");
	document.getElementById('tab_content7').classList.remove("in");
	document.getElementById('tab_content7').classList.remove("active");
}
else if(stab == 7){
	document.getElementById('tab7').checked = true;
	document.getElementById('tab_content6').classList.remove("in");
	document.getElementById('tab_content6').classList.remove("active");
	document.getElementById('tab_content7').classList.add("in");
	document.getElementById('tab_content7').classList.add("active");
}

$("label").click(function(){
    console.log($(this).attr('for'))
	var tab = $(this).attr('for');
	if(tab == 'tab6'){
		document.getElementById('tab_content6').classList.add("in");
		document.getElementById('tab_content6').classList.add("active");
		document.getElementById('tab_content7').classList.remove("in");
		document.getElementById('tab_content7').classList.remove("active");
	}
	else if(tab == 'tab7'){
		document.getElementById('tab_content6').classList.remove("in");
		document.getElementById('tab_content6').classList.remove("active");
		document.getElementById('tab_content7').classList.add("in");
		document.getElementById('tab_content7').classList.add("active");
	}
});
</script>