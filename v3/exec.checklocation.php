<?php 
// session_start();
// error_reporting(E_ALL);
// ini_set('display_errors','1');


// require_once('classes/conexao.class.php');
// $conexao = new Conexao;
// $conn = $conexao->Conectar();
// $data = $_POST['data'];
// $data = explode('//',$data);

// //output headers so that the file is downloaded rather than displayed
// header('Content-Type: text/csv; charset=utf-8');
// header('Content-Disposition: attachment; filename=file.csv');

// // create a file pointer connected to the output stream
// $output = fopen('php://output', 'w');

// // output the column headings
// fputs($output, implode(array('latitude', 'longitude', 'status'), ';')."\n");

// // loop over the rows, outputting them
// foreach($data as $occurrence){
//     $value = '';
//     $fields = explode(',',$occurrence);
//     $sql = "select CASE WHEN contains(GeomFromEWKT(base_geografica.\"shp_limite_brasil_250MIL\".geom),GeomFromEWKT('SRID=4326;POINT(' || " . $fields[1] . " || ' ' || " . $fields[0]. " || ')'))
//     THEN CAST(1 AS BIT)
//     ELSE CAST(0 AS BIT) END
//     from base_geografica.\"shp_limite_brasil_250MIL\"";

//     $res = pg_exec($conn,$sql);
//     while ($row = pg_fetch_array($res))
//     {	
//         if($row[0] == 1){
//             fputs($output, implode(array(trim($fields[0],"\n"), trim($fields[1],"\n"), 'OK'), ';')."\n");
//         } else {
//             fputs($output, implode(array(trim($fields[0],"\n"), trim($fields[1],"\n"), 'outside Brazil'), ';')."\n");
//         }
//     }

// }

session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');


require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$data = $_POST['data'];
$data = explode('//',$data);

//output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=file.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputs($output, implode(array('taxon','latitude', 'longitude', 'município','status'), ';')."\n");

// loop over the rows, outputting them
foreach($data as $occurrence){
    $value = '';
    $fields = explode(';',$occurrence);

    //lat = 0 ou lon = 0
    //teste coordenada zero
    if($fields[1] == 0 || $fields[2] == 0){
        $value = 'Coordenada zerada';
    }
    
    if($value == ''){
        //teste fora do Brasil
        $sql = "select CASE WHEN contains(GeomFromEWKT(base_geografica.\"shp_limite_brasil_250MIL\".geom),GeomFromEWKT('SRID=4326;POINT(' || " . $fields[2] . " || ' ' || " . $fields[1]. " || ')'))
        THEN CAST(1 AS BIT)
        ELSE CAST(0 AS BIT) END
        from base_geografica.\"shp_limite_brasil_250MIL\"";
    
        $res = pg_exec($conn,$sql);
        while ($row = pg_fetch_array($res))
        {	
            if($row[0] == 1){
                $value = 'Dentro do Brasil';
            } else {
                $value = 'Fora do Brasil';
            }
        }

        //teste fora do municipio
        $sql = "select nm_mun from base_geografica.\"municipios_2014\" where contains(GeomFromEWKT(base_geografica.\"municipios_2014\".geom),GeomFromEWKT('SRID=4326;POINT(' || " . $fields[2] . " || ' ' || " . $fields[1]. " || ')'))";
    
        $res = pg_exec($conn,$sql);
        while ($row = pg_fetch_array($res))
        {	
            // echo trim($row[0]);
            // echo preg_replace('/\s+/', ' ',trim($row[0]));
            // echo strtolower(preg_replace('/\s+/', ' ',trim($fields[3])));
            if(strtolower(preg_replace('/\s+/', ' ',trim($row[0]))) == strtolower(preg_replace('/\s+/', ' ',trim($fields[3])))){
                $value = 'Dentro do Município';
            } else {
                $value = 'Fora do Município';
            }
        }

        //teste inverter coordenada
        if($value == '' || $value == 'Fora do Brasil' || $value == 'Fora do Município'){
            $sql = "select nm_mun from base_geografica.\"municipios_2014\" where contains(GeomFromEWKT(base_geografica.\"municipios_2014\".geom),GeomFromEWKT('SRID=4326;POINT(' || " . $fields[1] . " || ' ' || " . $fields[2]. " || ')'))";
            
            $res = pg_exec($conn,$sql);
            while ($row = pg_fetch_array($res))
            {	
                if(trim($row[0]) == trim($fields[3])){
                    $value = 'Coordenada Invertida';
                    $tmp = $fields[1];
                    $fields[1] = $fields[2];
                    $fields[2] = $tmp;
                } 
            }
        }

        //teste trocar sinal latitude
        if($value == '' || $value == 'Fora do Brasil' || $value == 'Fora do Município'){
            $sql = "select nm_mun from base_geografica.\"municipios_2014\" where contains(GeomFromEWKT(base_geografica.\"municipios_2014\".geom),GeomFromEWKT('SRID=4326;POINT(' || " . $fields[2] . " || ' ' || -1 *" . $fields[1]. " || ')'))";
            
            $res = pg_exec($conn,$sql);
            while ($row = pg_fetch_array($res))
            {	
                if(trim($row[0]) == trim($fields[3])){
                    $value = 'Sinal Latitude Invertido';
                    $fields[1] = -1 * $fields[1];
                } 
            }
        }

        //teste trocar sinal longitude
        if($value == '' || $value == 'Fora do Brasil' || $value == 'Fora do Município'){
            $sql = "select nm_mun from base_geografica.\"municipios_2014\" where contains(GeomFromEWKT(base_geografica.\"municipios_2014\".geom),GeomFromEWKT('SRID=4326;POINT(' || -1 *" . $fields[2] . " || ' ' || " . $fields[1]. " || ')'))";
            
            $res = pg_exec($conn,$sql);
            while ($row = pg_fetch_array($res))
            {	
                if(trim($row[0]) == trim($fields[3])){
                    $value = 'Sinal Longitude Invertido';
                    $fields[2] = -1 * $fields[2];
                } 
            }
        }

        //teste trocar sinal latitude e longitude
        if($value == '' || $value == 'Fora do Brasil' || $value == 'Fora do Município'){
            $sql = "select nm_mun from base_geografica.\"municipios_2014\" where contains(GeomFromEWKT(base_geografica.\"municipios_2014\".geom),GeomFromEWKT('SRID=4326;POINT(' || -1 *" . $fields[2] . " || ' ' || -1 *" . $fields[1]. " || ')'))";
            
            $res = pg_exec($conn,$sql);
            while ($row = pg_fetch_array($res))
            {	
                if(trim($row[0]) == trim($fields[3])){
                    $value = 'Sinal Latitude e Longitude Invertidos';
                    $fields[1] = -1 * $fields[1];
                    $fields[2] = -1 * $fields[2];
                } 
            }
        }
    }

    fputs($output, implode(array(trim($fields[0]),trim($fields[1]), trim($fields[2]), trim($fields[3]),$value), ';')."\n");

}

?>



