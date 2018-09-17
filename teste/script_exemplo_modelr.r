#############################
####    Script modelR   ####
############################

# Carregando pacotes
require(ModelR)
require(raster)
require(vegan)
require(psych)

args <- commandArgs(TRUE)
id <- args[1]
hashId <- args[2]
partitions <- args[3]
bufferValue <- args[4]
num_points <- args[5]
tss <- args[6]
rasterCSVPath <- args[7]
ocorrenciasCSVPath <- args[8]
algorithms <- args[9]
extensionPath <- paste0('../../../../../','mnt/dados/modelr/json/polygon-283.json')

coordenadas <- read.table(ocorrenciasCSVPath, sep = ';', header = T);
rasters <- read.table(rasterCSVPath, sep = ';', header = F, as.is = T);
rasters
#rasters <- read.file(rasterCSVPath, sep = ';', h = F)
#setwd('../../../../../')
#getwd()algorithmsArray[[1]] == TRUE
algorithmsArray <- as.list(strsplit(algorithms, ';')[[1]])
rasters <- paste0('../../../../../',rasters)
stack_rasters <- stack(rasters)

data_json = geojsonio::geojson_read(extensionPath, what = "sp")
stack_rasters <- mask(crop(stack_rasters, data_json), data_json)

especies <- unique(coordenadas$taxon);
##-----------------------------------------------##
# vamos receber várias variáveis: ocorrencias.csv, raster.csv, partitions, buffer, num_points, tss, hash id
# criar variaveis_preditoras a partir de raster.csv
##-----------------------------------------------##

resultFolder <- 'temp/result/'
#Cria diretório onde serão salvos os resultados
#dir.create(paste0(resultFolder, hashId));

clean <- function(coord, abio) {
    if (dim(coord)[2] == 2) {
        if (exists("abio")) {
            # selecionar os pontos únicos e sem NA
            mask <- abio[[1]]
            # Selecionar pontos espacialmente únicos #
            cell <- cellFromXY(mask, coord)  # get the cell number for each point
            dup <- duplicated(cell)
            pts1 <- coord[!dup, ]  # select the records that are not duplicated
            pts1 <- pts1[!is.na(extract(mask, pts1)), ]  #selecionando apenas pontos que tem valor de raster

            cat(dim(coord)[1] - dim(pts1)[1], "points removed\n")
            cat(dim(pts1)[1], "spatially unique points\n")
            names(pts1) <- c("lon", "lat")#
            return(pts1)
        } else (cat("Indicate the object with the predictive variables"))
    } else (stop("Coordinate table has more than two columns.\nThis table should only have longitude and latitude in this order."))
}


reg.clean <- c()
for (especie in especies) {
    sp.clean <- clean(coordenadas[coordenadas[, "taxon"] == especie, c("lon","lat")], stack_rasters[[1]])
    sp.clean$sp <- especie
    reg.clean <- rbind(reg.clean,sp.clean)
}
#----#

coordenadas <- reg.clean
especies <- unique(coordenadas$sp)
#----#

#foreach(especie = especies,
#        .packages = c("raster", "modelr")) %dopar% {
# algorithmsArray = Mahalanobis;Maxent;GLM;Bioclim;Random Forest;Domain;SVM
coordenadas

variaveis_cortadas <- mask(crop(stack_rasters, mascara), mascara)
for (especie in especies) {
    # especies
	ocorrencias <- coordenadas[coordenadas$sp == especie, c("lon", "lat")]
	 do_enm(
	 species_name = especie,
	 coordinates = ocorrencias,
	 predictors = stack_rasters,
	 models_dir = paste0("./",resultFolder, hashId),
	 ## argumentos de setupsdmdata():
	 #lon = "lon",#caso as colunas estejam nomeadas diferentes dá para botar aqui
	 #lat = "lat",#idem
	 buffer = bufferValue,
	 seed = 512,
	 #clean_dupl = T,
	 #clean_nas = F,
	 #geo_filt = F,
	 #geo_filt_dist = NULL,
	 #plot_sdmdata = T,
	 n_back = as.numeric(num_points),
	 partition_type = "crossvalidation",
	 cv_n = 1,
	 cv_partitions = as.numeric(partitions),
	 #predictors1 = variaveis_cortadas,#aqui não vai servir ainda
	 ## argumentos de do_any()
	 project_model = F,
	 mask = mascara,
	 write_png = T,
	 #argumentos de do_enm():
	 bioclim = algorithmsArray[[4]] == TRUE,
	 maxent = algorithmsArray[[2]] == TRUE,
	 glm = algorithmsArray[[3]] == TRUE,
	 rf = algorithmsArray[[5]] == TRUE,
	 svm.k = algorithmsArray[[7]] == TRUE,#svm agora é svm.k do pacote kernlab
	 svm.e = F,#svm2 agora é svm.e do pacote e1071
	 #domain = algorithmsArray[[6]] == TRUE,
	 #mahal = algorithmsArray[[1]] == TRUE,
	 #centroid = ...,#NEW! mas é lento, eu não botaria
	 #mindist = ...,#NEW! mas é lento, eu não botaria
	 )
	
		#gerando os ensembles por algoritmo
	final_model(species_name = especie,
	            algorithms = c("maxent", "svm.k", "bioclim", "glm", "rf"),
	            select_par = "TSS",
	            select_par_val = tss,
	            models_dir = paste0("./",resultFolder, hashId),
	            which_models = c("cut_mean_th"), #as opcoes são: "raw_mean",
	            #"bin_mean", "cut_mean", "bin_mean_th", "bin_consensus",
	            #"cut_mean_th", dá para botar várias
	            write_png = T)

	#gerando o modelo final
	ensemble_model(species_name = especie,
	               occs = ocorrencias,
	               models_dir = paste0("./", resultFolder, hashId),
	               which_models = c("cut_mean_th"),
	               consensus = F,
	               consensus_level = 0.5,
	               write_png = T,#veja se é isso mesmo aqui
	               write_raw_map = T)

	#Criando a tabela com os valores de desempenho do modelo.

	lista <- list.files(paste0('./',resultFolder, hashId ,'/',especie, '/present/partitions'), pattern = ".txt", full.names = T)
	aval <- c()
	for (i in 1:(length(lista) - 1)) {
	    a <- read.table(lista[i])
	    aval <- rbind(aval,a)
	    row.names(aval) <- NULL
	    print(head(aval,10))
	    write.table(aval,
	                paste0("./",resultFolder, hashId, '/', especie, ".csv"),
	                row.names = F, sep = ";")
	}
}