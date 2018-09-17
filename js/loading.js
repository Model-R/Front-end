
function exibe(id, text) { 
	console.log(text)
	console.log('dwqdwq')
	console.log(document.getElementById('loading-title'))
	console.log(document.getElementById('loading-title').innerHTML)
    if(text != '') document.getElementById('loading-title').innerHTML = text;
	if(document.getElementById(id).style.display=="none") {  
	document.getElementById(id).style.display = "inline";  
	}else {  
		document.getElementById(id).style.display = "none";  
	}  
}  
	
