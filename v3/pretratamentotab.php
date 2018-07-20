<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php if ($stab=='4') echo 'class="active"';?>><a href="#tab_content4" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Bióticos</a>
			</li>
			<li role="presentation" <?php if ($stab=='5') echo 'class="active"';?>><a href="#tab_content5" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Abióticos</a>
			</li>
		</ul>
		<div id="preTratamentoTab" class="tab-content">
			<div class="tab-pane  <?php if ($stab=='4') echo 'in active';?>" id="tab_content4" aria-labelledby="home-tab">
				<?php require "dadosbioticostab.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($stab=='5') echo 'in active';?>" id="tab_content5" aria-labelledby="home-tab">
				<?php require "dadosabioticostab.php";?>
			</div> 
		</div>
	</div>
</div>