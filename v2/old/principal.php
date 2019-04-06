<?php session_start();
if (!isset($_SESSION['s_idusuario']))
{
	header('Location: login.php');
}
include "paths.inc";
require_once("classes/conexao.class.php");
$conexao = new Conexao;
$conn = $conexao->Conectar();
$lang = $_SESSION['s_lang'];
$codusuario = $_SESSION['s_codusuario'];
$sistema = $_SESSION['s_sistema'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/imagens/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php echo $DOJO_PATH;?>/dijit/themes/claro/claro.css"/>
<link rel="stylesheet" type="text/css" href="css/styles1.css"/>
<link rel="stylesheet" type="text/css" href="css/styles2.css"/>
<link rel="stylesheet" type="text/css" href="css/styles3.css"/>
<link rel="stylesheet" type="text/css" href="css/styles4.css"/>
<link rel="stylesheet" type="text/css" href="css/styles5.css"/>
</head></head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="claro">
<!-- Tags end on line afterwards to eliminate any whitespace -->
<div class="google-header-bar"> 
  <div class="header content clearfix"><a href="principal.php"><img src="imagens/baldecheio2.JPG" alt="Balde Cheio"  height="50px" class="logo"></a> 
    <span class="signup-button"> Usuário : (<b> 
    <?php echo $_SESSION['s_nome'];?>
    </b>) 
    <?php echo $_SESSION['s_idtecnico'];?>
    </span> </div>
</div>
<div id="navMenu"></div>
<span id="toolbar"></span> 
</body>
<script type="text/javascript" src="<?php echo $DOJO_PATH;?>/dojo/dojo.js" djConfig="parseOnLoad: true"></script>
<script type="text/javascript">
      dojo.require("dijit.Toolbar");
        dojo.require("dijit.form.Button");
    	dojo.require("dijit.MenuBar");
    	dojo.require("dijit.MenuBarItem");
		dojo.require("dijit.PopupMenuBarItem");
    	dojo.require("dijit.Menu");
    	dojo.require("dijit.MenuItem");
    	dojo.require("dijit.PopupMenuItem");
</script></script>
<?php if (($_SESSION['s_idusuario'])==7)
{
	$home = 'consfinanceiro.php?ativa=S&pagto=S';
}
else
{
	$home = 'home.php';
}
?>
<iframe scrolling="yes" name="corpo" frameborder="0" width="100%" height="<?php echo $_SESSION['s_altura'].'px';?>" src="<?php echo $home;?>"> 
</iframe>
<?php require "menu.php";?>
<script type="text/javascript">
dojo.addOnLoad(function() {
		if (document.pub) {
			document.pub();
		}
	});
</script>
</html>









