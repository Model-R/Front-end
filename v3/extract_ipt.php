<?php 
$zip_url          = "http://ipt.jbrj.gov.br/reflora/archive.do?r=alcb_herbarium&v=1.130";
$destination_path = "/var/www/html/rafael/modelr/v3/".uniqid(time(), true).".zip";
file_put_contents($destination_path, fopen($zip_url, 'r'));
echo "end";
?>