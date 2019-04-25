read_ocurrence_list <- readRDS("ocurrences_list10-52.Rds")
filtered_ocurrences_list = list();
i = 1;

for(list in read_ocurrence_list){
  filtered_ocurrences_list[[i]] = filter(list, str_detect(scientificName, "Anemiaceae Anemia"))
  i = i + 1
}
  
  
nrow(filtered_ocurrences_list[[1]])
nrow(filtered_ocurrences_list[[2]])
compiled_ocurrence_list = bind_rows(filtered_ocurrences_list)
write.csv(compiled_ocurrence_list, file = "compiled_ocurrence_list.csv")
