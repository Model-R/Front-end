<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Model-R </title>

	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">
	
	<!-- select2 -->
    <link href="css/select/select2.min.css" rel="stylesheet">
	<!-- switchery -->
    <link rel="stylesheet" href="css/switchery/switchery.min.css" />


    <script src="js/jquery.min.js"></script>

	
</head>

<?php
session_start();
require_once('classes/conexao.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();
?>

<body>  
<form enctype="multipart/form-data" id="frmcsvfile" method="post"><label id="label-arquivo" for='upload'>Arquivo CSV</label><input id="upload" type=file accept="text/csv" name="files[]" size=30></form>   
</body>

<script>

document.getElementById('upload').addEventListener('change', handleFileSelect, false);

function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // use the 1st file from the list
    f = files[0];

    var reader = new FileReader();

    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {

		//console.log(e.target.result)
		var arr = e.target.result.split('\n');

		file = arr;
        console.log(file);
        
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "data");
        input.setAttribute("value", file.join('//'));

        //append to form element that you want .
        document.getElementById("frmcsvfile").appendChild(input);

        document.getElementById('frmcsvfile').action='exec.checklocation.php';
        document.getElementById('frmcsvfile').submit();

        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsText(f);
  }


</script>
</html>

