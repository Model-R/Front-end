<link href="css/custom.css" rel="stylesheet">

<!--<div class="form-group shapebox-content" style="display: flex;flex-direction: row;width: 50%;text-align: center;margin: auto;justify-content: space-between;">-->
<div class="form-group shapebox-content" style="display: flex;flex-direction: row;width: 10%;text-align: center;margin: auto;justify-content: space-between;">
<!--    <label for="cmboxcortarraster" style="margin-top:7px">Selecionar Shape</label>
    <select id="cmboxcortarraster" name="cmboxcortarraster" class="form-control" style="width: 200px;">
        <option value="BACIAS" selected="selected">Bacias</option>
        <option value="BIOMAS">Biomas</option>
        <option value="VEGETACIONAIS">Tipos Vegetacionais</option>
    </select> 

    <button type="button" class="btn btn-info" onClick='cortarRaster()' data-toggle="tooltip" data-placement="top" title data-original-title="Cortar Raster" style="">Salvar</button>-->
	<button type="button" class="btn btn-danger" id="cancelarCorteRaster" onClick='cancelarCorteRaster()' data-toggle="tooltip" data-placement="top" title data-original-title="Cancelar Corte" style="display: <?php if ($isImageCut) echo ' flex'; else echo 'none'?>;">Cancelar Corte</button>
</div> 