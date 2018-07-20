<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php if ($ttab=='9') echo 'class="active"';?>><a href="#tab_content9" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Aquisição</a>
			</li>
			<li role="presentation" <?php if ($ttab=='10') echo 'class="active"';?>><a href="#tab_content10" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Limpesa de Dados</a>
			</li>
		</ul>
		<div id="dadosBioticosTab" class="tab-content">
			<div class="tab-pane  <?php if ($ttab=='9') echo 'in active';?>" id="tab_content9" aria-labelledby="home-tab">
				<?php require "dadosbioticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($ttab=='10') echo 'in active';?>" id="tab_content10" aria-labelledby="home-tab">
				<?php require "expdatacleaning.php";?>
			</div> 
		</div>
	</div>
</div>