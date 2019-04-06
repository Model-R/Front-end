<?php @session_start();
	  require_once('classes/conexao.class.php');
	  $Conexao = new Conexao;
	  $conn = $Conexao->Conectar();
	  
?>
<div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="images/user.png" alt=""><?php echo $_SESSION['s_nome'];?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="trocarsenha.php">  Trocar Senha</a>
                                    </li>
                                    <li><a href="manual_modelr.pdf"><i class="fa fa-file-pdf-o pull-right"></i> Manual</a>
                                    </li>
                                    <li><a href="login.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>
							
							<?php $sql = '
							select * from modelr.experiment e, modelr.project p where
e.idproject = p.idproject and idusuario = '.$_SESSION['s_idusuario'];
								  $res = @pg_exec($conn,$sql);
								  $conta = @pg_num_rows($res);
								  $sql.=' order by datavisita desc
								  limit 6 ';
								  $res = @pg_exec($conn,$sql);
								  ?>

                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green"><?php echo $conta;?></span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                                    
									<?php 
									$c = 0;
									while ($row = pg_fetch_array($res))
									{
										$c++;
									?>
									<li>
                                        <a>
                                            <span class="image">
                                        <img src="images/user.png" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span><?php echo $row['nomepropriedade'];?></span>
                                            <span class="time"><?php echo date('d/m/Y',strtotime($row['datavisita']));?></span>
                                            </span>
                                            <span class="message"><?php echo $row['relatorio'];?>
                                         
                                    </span>
                                        </a>
                                    </li>
									<?php } ?>
									
                                   
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong><a href="consprojeto.php">Visualizar todos</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->
<?php 
?>
