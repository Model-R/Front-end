#install.packages('devtools')
#library(devtools)
#install_github("bnosac/cronR")

getwd();
install.packages("taskscheduleR")
library(taskscheduleR)

setwd("C:/Users/JBRJ/Marcos")
myscript <- file.path(getwd(), "extract_ipt.R")

taskscheduler_delete(taskname = "extract_datat_from_ipts_5min")

taskscheduler_create(taskname = "extract_datat_from_ipts_5min", rscript = myscript,
                     schedule = "MINUTE", starttime = "10:30", modifier = 5)

## log file is at the place where the helloworld.R script was located
mylog <- file.path(getwd(), "extract_ipt.log")
cat(readLines(mylog), sep = "\n")
