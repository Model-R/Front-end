<html>
<body>
<form name='frm' id='frm' method="get">
Number values to generate:

<input type="text" name='N' id="N" value="">
<input value="Enviar" type="submit">
<?php 

if(isset($_GET['N']))
{
  $N = $_GET['N'];
 
  // execute R script from shell
  // this will save a plot at temp.png to the filesystem
  echo "aqui";
  exec("Rscript my_rscript.R $N");
 
  // return image tag
  $nocache = rand();
  ?>
  <img src='temp.png?<?php echo $nocache;?>'>
  <?php
}
?>
</form>
