library(stringr)
library(dplyr)

args <- commandArgs(TRUE)
experiment_id <- args[1]
sp <- args[2]

folder_path = "../../../../../../../../mnt/dados/modelr/ipt/reflora/searches/"
read_ocurrence_list <- readRDS(paste0(folder_path, "ocurrences_list.Rds"))
filtered_ocurrences_list = list();
i = 1;

for(list in read_ocurrence_list){
  filtered_ocurrences_list[[i]] = subset(list, str_detect(scientificName, sp))
  i = i + 1
}
  
  
nrow(filtered_ocurrences_list[[1]])
nrow(filtered_ocurrences_list[[2]])
compiled_ocurrence_list = bind_rows(filtered_ocurrences_list)
write.csv(compiled_ocurrence_list, file = file(paste0(folder_path, sp, "_ocurrence_list-exp", experiment_id, ".csv"),encoding="UTF-8"))
