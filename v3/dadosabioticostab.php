<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php if ($ttab=='11') echo 'class="active"';?>><a href="#tab_content11" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Seleção</a>
			</li>
			<li role="presentation" <?php if ($ttab=='12') echo 'class="active"';?>><a href="#tab_content12" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Extensão</a>
			</li>
		</ul>
		<div id="dadosAbioticosTab" class="tab-content">
			<div class="tab-pane  <?php if ($ttab=='11') echo 'in active';?>" id="tab_content11" aria-labelledby="home-tab">
				<?php require "selecaodadosabioticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($ttab=='12') echo 'in active';?>" id="tab_content12" aria-labelledby="home-tab">
				<?php require "expextensao.php";?>
			</div> 
		</div>
	</div>
</div>