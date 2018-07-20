<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php if ($ttab=='13') echo 'class="active"';?>><a href="#tab_content13" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Estatísticos</a>
			</li>
			<li role="presentation" <?php if ($ttab=='14') echo 'class="active"';?>><a href="#tab_content14" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Modelos Gerados</a>
			</li>
			<li role="presentation" <?php if ($ttab=='15') echo 'class="active"';?>><a href="#tab_content15" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Ensemble Inicial</a>
			</li>
			<li role="presentation" <?php if ($ttab=='16') echo 'class="active"';?>><a href="#tab_content16" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Ensemble Final</a>
			</li>
			<li role="presentation" <?php if ($ttab=='17') echo 'class="active"';?>><a href="#tab_content17" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Metadados</a>
			</li>
		</ul>
		<div id="modelagemTab" class="tab-content">
			<div class="tab-pane  <?php if ($ttab=='13') echo 'in active';?>" id="tab_content13" aria-labelledby="home-tab">
				<?php require "dadosestatisticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($ttab=='14') echo 'in active';?>" id="tab_content14" aria-labelledby="home-tab">
				<?php require "modelos.php";?>
			</div> 
			<div class="tab-pane  <?php if ($ttab=='15') echo 'in active';?>" id="tab_content15" aria-labelledby="home-tab">
				<?php require "ensembleinicial.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($ttab=='16') echo 'in active';?>" id="tab_content16" aria-labelledby="home-tab">
				<?php require "ensemblefinal.php";?>
			</div> 
			<div class="tab-pane  <?php if ($ttab=='17') echo 'in active';?>" id="tab_content17" aria-labelledby="home-tab">
				<?php require "metadados.php";?>
			</div> 
		</div>
	</div>
</div>