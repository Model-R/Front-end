<?php session_start();?>
<script>
	var pMenuBar;
	dojo.addOnLoad(function() {
		pMenuBar = new dijit.MenuBar({});
		
		// cadastro
		var pSubMenu = new dijit.Menu({});

		pSubMenu.addChild(new dijit.MenuItem({
			label: "Produtor",
			disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,
			onClick: function()
			{
				parent.corpo.location.href='consprodutor.php'
			}
		}));
		pSubMenu.addChild(new dijit.MenuItem({
			label: "Propriedade",
			disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,
			onClick: function()
			{
				parent.corpo.location.href='conspropriedade.php'
			}
		}));

		pSubMenu.addChild(new dijit.MenuItem({
			label: "T&eacute;cnico",
			disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel']))) 
			               { echo "false"; } 
						   else 
						   {  echo "true";};
					   ?>,
			onClick: function()
			{
				parent.corpo.location.href='constecnico.php'
			}
		}));

		pSubMenu.addChild(new dijit.MenuSeparator());
	    
				var pSubMenuApoio = new dijit.Menu();
                pSubMenuApoio.addChild(new dijit.MenuItem({
                    label: "Tipo de Capital",
						disabled: true,
					onClick: function()
					{
						parent.corpo.location.href='constipocapital.php'
					}
                }));
                pSubMenuApoio.addChild(new dijit.MenuItem({
                    label: "Categoria Tipo Capital",
					disabled: true,
					onClick: function()
					{
						parent.corpo.location.href='conscategoriatipocapital.php'
					}
                }));
                pSubMenuApoio.addChild(new dijit.MenuItem({
                    label: "Tipo Movimento",
					disabled: true,
					onClick: function()
					{
						parent.corpo.location.href='constipomovimento.php'
					}
                }));
                pSubMenuApoio.addChild(new dijit.MenuItem({
                    label: "Categoria Tipo Movimento",
					disabled: true,
					onClick: function()
					{
						parent.corpo.location.href='conscategoriatipomovimento.php'
					}					
                }));
                pSubMenuApoio.addChild(new dijit.MenuItem({
                    label: "Unidade",
					disabled: true,
					onClick: function()
					{
						parent.corpo.location.href='consunidade.php'
					}
                }));
                pSubMenuApoio.addChild(new dijit.MenuItem({
                    label: "Unidade Medida",
					disabled: true,
					onClick: function()
					{
						parent.corpo.location.href='consunidademedida.php'
					}
                }));
                	

		pSubMenu.addChild(new dijit.MenuItem({
			label: "Tabelas de Apoio",
			popup: pSubMenuApoio
		}));



		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Cadastro",
			popup: pSubMenu
		}));

		var pSubMenuRelatorio = new dijit.Menu({});
		pSubMenuRelatorio.addChild(new dijit.MenuItem({
			label: "Visita T&eacute;cnica",
			disabled: <?php if ((in_array("AUDITOR", $_SESSION['s_papel'])) || (in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='consvisitatecnica.php';
			}
		}));

		pSubMenuRelatorio.addChild(new dijit.MenuItem({
			label: "Visita Supervisor",
			disabled: <?php if ((in_array("AUDITOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) )
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='consvisitasupervisor.php';
			}
		}));

		pSubMenuRelatorio.addChild(new dijit.MenuItem({
			label: "T&eacute;cnico x Produtor x Propriedade",
			disabled: <?php if ((in_array("AUDITOR", $_SESSION['s_papel'])) || (in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='relgeral.php?tipo=1';
			}
		}));
		pSubMenuRelatorio.addChild(new dijit.MenuItem({
			label: "Produtor x Propriedade x T&eacute;cnico",
			disabled: <?php if ((in_array("AUDITOR", $_SESSION['s_papel'])) || (in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='relgeral.php?tipo=2';
			}
		}));
		pSubMenuRelatorio.addChild(new dijit.MenuItem({
			label: "Propriedade x Produtor x T&eacute;cnico",
			disabled: <?php if ((in_array("AUDITOR", $_SESSION['s_papel'])) || (in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='relgeral.php?tipo=3';
			}
		}));


		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Relat&oacute;rio",
			popup: pSubMenuRelatorio
		}));


		var pSubMenuAgenda = new dijit.Menu({});
		pSubMenuAgenda.addChild(new dijit.MenuItem({
			label: "Visita T&eacute;cnica",
			disabled: <?php if ((in_array("AUDITOR", $_SESSION['s_papel'])) || (in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("TECNICO", $_SESSION['s_papel'])))
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='agendatecnico.php';
			}
		}));

		pSubMenuAgenda.addChild(new dijit.MenuItem({
			label: "Visita Supervisor",
			disabled: <?php if ((in_array("AUDITOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) )
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='agendasupervisor.php';
			}
		}));


		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Agenda",
			popup: pSubMenuAgenda
		}));




		var pSubMenuRelatorio = new dijit.Menu({});
		pSubMenuRelatorio.addChild(new dijit.MenuItem({
			label: "Patrim&ocirc;nio",
			disabled: false,
			onClick: function()
			{
				parent.corpo.location.href='conspatrimonio.php';
			}
		}));
		pSubMenuRelatorio.addChild(new dijit.MenuItem({
			label: "Planilha",
			disabled: false,
			onClick: function()
			{
				parent.corpo.location.href='consplanilha.php';
			}
		}));


		pSubMenuRelatorio.addChild(new dijit.MenuItem({
			label: "Acompanhamento Zoot&eacute;cnico",
			disabled: true,
			onClick: function()
			{
				parent.corpo.location.href='consacompanhamento.php?tipo=AZ';
			}
		}));



		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Acompanhamento",
			popup: pSubMenuRelatorio
		}));

		var pSubMenuFinacneiro = new dijit.Menu({});
		pSubMenuFinacneiro.addChild(new dijit.MenuItem({
			label: "Financeiro",
			disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) || (in_array("OPERADOR FINANCEIRO", $_SESSION['s_papel'])))
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='consfinanceiro.php';
			}
		}));

		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Financeiro",
			popup: pSubMenuFinacneiro
		}));

		var pSubMenu7 = new dijit.Menu({});

		pSubMenu7.addChild(new dijit.MenuItem({
			label: "Trocar senha",
			iconClass: "dijitRtl dijitIconUndo",	
			onClick: function() {
				parent.corpo.location.href='trocarsenha.php';
			}
		}));
		pSubMenu7.addChild(new dijit.MenuItem({
			label: "Permiss&atilde;o",
			iconClass: "dijitRtl dijitIconKey",	
			disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) )
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function() {
				parent.corpo.location.href='cadpermissao.php';
			}
		}));		
		pSubMenu7.addChild(new dijit.MenuItem({
			label: "Usu&aacute;rio",
			disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])) )
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			onClick: function()
			{
				parent.corpo.location.href='consusuario.php'
			}
		}));

		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Acesso",
			popup: pSubMenu7

		}));

		var pSubMenuConfig = new dijit.Menu({});
		pSubMenuConfig.addChild(new dijit.MenuItem({
			label: "Configura&ccedil;&atilde;o",
			disabled: <?php if ((in_array("OPERADOR", $_SESSION['s_papel'])) || (in_array("ADMINISTRADOR", $_SESSION['s_papel'])))
	   		{ echo "false"; } 
	   		else 
	   		{  echo "true";};
	   		?>,
			iconClass: "dijitIconError dijitIconFunction",
			//iconClass: "dijitIconError dijitIconSample",	
			onClick: function() {
				parent.corpo.location.href='configuracao.php';
				
			}
		}));

		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Configura&ccedil;&atilde;o",		
			popup: pSubMenuConfig
		}));

		var pSubMenuDownload = new dijit.Menu({});
		pSubMenuDownload.addChild(new dijit.MenuItem({
			label: "Download",
			disabled: false,
			//iconClass: "dijitIconError dijitIconFunction",
			//iconClass: "dijitIconError dijitIconSample",	
			onClick: function() {
				parent.corpo.location.href='download.php';
				
			}
		}));

		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Download",		
			popup: pSubMenuDownload
		}));




		var pSubMenu5 = new dijit.Menu({});
		pSubMenu5.addChild(new dijit.MenuItem({
			label: "Sobre",
			onClick: function()
			{
				parent.corpo.location.href='sobre.php'
			}
		}));

		pSubMenu5.addChild(new dijit.MenuItem({
			label: "Conte&uacute;do",
			onClick: function()
			{
				location.href='manualbaldecheio.pdf';
			}
		}));

		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Ajuda",
			popup: pSubMenu5
		}));
		
		var pSubMenu6 = new dijit.Menu({});
		pSubMenu6.addChild(new dijit.MenuItem({
			label: "Sair do Sistema",
			iconClass: "dijitEditorIcon dijitEditorIconCancel",	
			onClick: function() {
				location.href='login.php'
			}
		}));
		pMenuBar.addChild(new dijit.PopupMenuBarItem({
			label: "Sair",
			popup: pSubMenu6
		}));

		pMenuBar.placeAt("navMenu");
		pMenuBar.startup();

	});
</script>
