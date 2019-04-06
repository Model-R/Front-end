args <- commandArgs(TRUE)
 
N1 <- args[1]
N2 <- args[2]
x1 <- rnorm(N1,0,1)
x2 <- rnorm(N1+10,0,1)
 
png(filename="temp.png", width=500, height=500)
hist(x1, col="lightblue")

png(filename="temp.png", width=500, height=500)
hist(x2, col="lightblue")

dev.off()