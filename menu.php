<?php Session_start();
//print_r($_SESSION);
?>
                    <!-- menu prile quick info -->
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><div class="profile_pic">
                            <!--<img src="imagens/logo.jpg" alt="..." width="60px">-->
                        </div> <span>Model-R</span></a>
                    </div>
                    <div class="clearfix"></div>
					<div class="profile">
                        <div class="profile_pic">
                            <img src="images/user.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Bem-vindo,</span>
                            <h2><?php echo $_SESSION['s_nome'];?></h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3><strong>Função:</strong><br> </h3>
							
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> Cadastro <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
										<li><a href="consexperimento.php">Experimento</a>
                                        </li>
										<?php if ($_SESSION['s_idtipousuario']=='2')
										{
										?>
										<li><a href="consprojeto.php">Projeto</a>
                                        </li>
										<li><a href="consraster.php">Raster</a>
                                        </li>
										<li><a href="consalgoritmo.php">Algoritmos</a>
                                        </li>
										<li><a href="constipoparticionamento.php">Tipo Particionamento</a>
                                        </li>
										<?php } ?>
                                    </ul>
                                </li>
									<?php if ($_SESSION['s_idtipousuario']=='2')
										{
											/*
										?>
                                <li><a><i class="fa fa-edit"></i> Relatórios <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="consvisitatecnica.php?FINANC=F">Projeto</a>
                                        </li>
                                        <li><a href="form_advanced.html">Visita Supervisor</a>
                                        </li>
                                        <li><a href="relgeral.php?tipo=1" target="_Blank">Técnico x Produtor x Propriedade</a>
                                        </li>
										<li><a href="consperiodo.php?tipo=4" target="_Blank">Técnico x Propriedade x Produtor x Visita Técnica</a>
                                        </li>
										<li><a href="relgeral.php?tipo=2" target="_Blank">Produtor x Propriedade x Técnico</a>
                                        </li>
										<li><a href="relgeral.php?tipo=3" target="_Blank">Propriedade x Produtor x Técnico</a>
                                        </li>

                                    </ul>
                                </li>
										<?php 
										*/
										} ?>
                            </ul>
							<?php if ($_SESSION['s_idtipousuario']=='2')
										{
											/*
										?><ul class="nav side-menu">
                                <li><a><i class="fa fa-bug"></i> Ferramentas <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="videos.php">Video</a>
                                        </li>
                                        <li><a href="downloads.php">Download</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
										<?php */ } ?>
                        </div>
						
						<?php if ($_SESSION['s_idtipousuario']=='2')
						{
						?>
						
                        <div class="menu_section">
                            <h3>Administração</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-users"></i> Acesso <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="consusuario.php">Usuário</a>
                                        </li>
                                        <!--<li><a href="configuracao.php">Configuração</a>
                                        </li>
										-->
                                    </ul>
                                </li>
                            </ul>
                        </div>
						<?php } ?>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <!--<a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
						-->
                    </div>
                    <!-- /menu footer buttons -->
<?php 
?>