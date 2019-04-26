<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

if(dirname(__FILE__) != '/var/www/html/rafael/modelr'){
	$baseUrl = '../';
} else {
	$baseUrl = '';
}

if (!is_dir($baseUrl . "../modelr-data")) {
    mkdir($baseUrl . "../modelr-data/ipt/reflora/searches", 0777, true);
}

$expid = $_REQUEST['expid'];
$sp = $_REQUEST['sp'];

exec("Rscript  searchIPT/reflora/search_inside_ipts.R $expid '$sp'", $a, $b);

echo $baseUrl . "../modelr-data/ipt/reflora/searches/" . $sp . "_ocurrence_list-exp" . $expid . ".csv";
	