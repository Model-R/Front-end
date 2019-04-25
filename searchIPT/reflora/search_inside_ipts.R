folder_path = "C:/Users/JBRJ/Marcos/"
read_ocurrence_list <- readRDS(paste0(folder_path, "ocurrences_list.Rds"))
filtered_ocurrences_list = list();
i = 1;

for(list in read_ocurrence_list){
  filtered_ocurrences_list[[i]] = filter(list, str_detect(scientificName, "Anemiaceae Anemia"))
  i = i + 1
}
  
  
nrow(filtered_ocurrences_list[[1]])
nrow(filtered_ocurrences_list[[2]])
compiled_ocurrence_list = bind_rows(filtered_ocurrences_list)
write.csv(compiled_ocurrence_list, file = paste0(folder_path, "compiled_ocurrence_list.csv"))
