function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
function SomenteNumeroDecimais(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0 || tecla==44) return true;
	else  return false;
    }
}

function verifica(tipo,op,valor)
{
if (tipo=='CPF'){
	document.getElementById("divcpf").innerHTML='';
}
if (tipo=='NOMEALUNO'){
	document.getElementById("divnomealuno").innerHTML='';
}

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
     if (xmlhttp.readyState==4 && xmlhttp.status==200)
     {
		if (tipo=='CPF'){
	 		document.getElementById("divcpf").innerHTML=xmlhttp.responseText;
		}
		if (tipo=='NOMEALUNO'){
	 		document.getElementById("divnomealuno").innerHTML=xmlhttp.responseText;
		}
	 }
  }
  if (tipo=='CPF'){
		xmlhttp.open("GET","verifica.php?tipo=CPF&op="+op+"&valor="+valor,true);
  }
  if (tipo=='NOMEALUNO'){
		xmlhttp.open("GET","verifica.php?tipo=NOMEALUNO&op="+op+"&valor="+valor,true);
  }
xmlhttp.send();

}	
