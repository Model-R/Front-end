N <- 10    
x <- rnorm(N,0,1) 
#list.files("./temp")   
png(filename="./temp/temp9.png", width=500, height=500)
hist(x, col="lightblue")    
dev.off()