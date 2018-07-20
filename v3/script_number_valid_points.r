#############################
####    Script modelR   ####
############################

# Carregando pacotes
require(modelr)
require(raster)

args <- commandArgs(TRUE)     
id <- args[1]  
rasterCSVPath <- args[2]  
ocorrenciasCSVPath <- args[3]
coordenadas <- read.table(ocorrenciasCSVPath, sep = ';', h = T);
especies <- unique(coordenadas$taxon);

##-----------------------------------------------##
# vamos receber v�rias variaveis: ocorrencias.csv, raster.csv, partitions, buffer, num_points, tss, hash id
# criar variaveis_preditoras a partir de raster.csv
##-----------------------------------------------##

resultFolder <- 'temp/result/'
#Cria diret�rio onde ser�o salvos os resultados
#dir.create(paste0(resultFolder, hashId));

clean = function(coord, abio) {
    if (dim(coord)[2] == 2) {
        if (exists("abio")) {
            # selecionar os pontos únicos e sem NA
            mask = abio[[1]]
            # Selecionar pontos espacialmente únicos #
            cell <- cellFromXY(mask, coord)  # get the cell number for each point
            dup <- duplicated(cell)
            pts1 <- coord[!dup, ]  # select the records that are not duplicated
            pts1 <- pts1[!is.na(extract(mask, pts1)), ]  #selecionando apenas pontos que tem valor de raster
			return(dim(pts1)[1])
        } else (cat("Indicate the object with the predictive variables"))
    } else (stop("Coordinate table has more than two columns.\nThis table should only have longitude and latitude in this order."))
}

reg.clean=c()
for(especie in especies) {
  sp.clean = clean(coordenadas[coordenadas[, "taxon"] == especie, c("lon","lat")], variaveis_preditoras[[1]])
  sp.clean = as.array(sp.clean)
  sp.clean$sp=especie
  reg.clean = rbind(reg.clean,sp.clean)
}

reg.clean