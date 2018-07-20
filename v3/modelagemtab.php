<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php if ($stab=='6') echo 'class="active"';?>><a href="#tab_content6" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Parâmetros</a>
			</li>
			<li role="presentation" <?php if ($stab=='7') echo 'class="active"';?>><a href="#tab_content7" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Resultados</a>
			</li>
		</ul>
		<div id="modelagemTab" class="tab-content">
			<div class="tab-pane  <?php if ($stab=='6') echo 'in active';?>" id="tab_content6" aria-labelledby="home-tab">
				<?php require "parametrosmodelagem.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($stab=='7') echo 'in active';?>" id="tab_content7" aria-labelledby="home-tab">
				<?php require "resultadotab.php";?>
			</div> 
		</div>
	</div>
</div>