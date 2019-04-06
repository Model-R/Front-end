<html>
<body>
<form action='pooman.php' method='get'>    
<?php 
error_reporting(E_ALL);
ini_set('display_errors','1');

// poorman.php     
echo "Number values to generate: "
?>
<input type='text' name='N' />    
<input type='submit' />    
</form>     
<?php
if( isset($_GET['N']))    
{
  $N = $_GET['N'];
  // execute R script from shell    
  // this will save a plot at temp.png to the filesystem

  exec("Rscript script_pos.R 98 file.json");
  echo $N;
  // return image tag

  $nocache = rand();
  ?>
  <img src='temp/temp7.png'>    
<?php } ?>
</body>
</html>


