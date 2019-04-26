<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

$expid = $_REQUEST['expid'];
$sp = $_REQUEST['sp'];

exec("Rscript  searchIPT/reflora/search_inside_ipts.R $expid '$sp'", $a, $b);
print_r($a);
echo '<br>--------------------<br>';
print_r($b);

echo "../../../../../../../../mnt/dados/modelr/ipt/reflora/searches/" . $sp . "_ocurrence_list-exp" . $expid . ".csv";
	