<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php if ($stab=='8') echo 'class="active"';?>><a href="#tab_content8" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Mapa</a>
			</li>
		</ul>
		<div id="posProcessamentoTab" class="tab-content">
			<div class="tab-pane  <?php if ($stab=='8') echo 'in active';?>" id="tab_content8" aria-labelledby="home-tab">
				<?php require "mapa.php";?>
			</div> 
		</div>
	</div>
</div>