<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
	  require_once('classes/programa.class.php');
	  require_once('classes/produtor.class.php');
	  require_once('classes/propriedade.class.php');
	  require_once('classes/tecnico.class.php');
	  
	  $FORM_ACTION = 'visitatecnica';
	  $tipofiltro = $_REQUEST['cmboxtipofiltro'];
	  $ordenapor = $_REQUEST['cmboxordenar'];
	  $financeiro = false;
	  if ($_REQUEST['FINANC']=='T')
	  {
		  $financeiro = true;
	  }
	  
	  if (empty($tipofiltro))
	  {
		  $tipofiltro = 'NOME';
	  }
	  
	  $idprograma = $_REQUEST['cmboxprograma'];
	  $idprodutor = $_REQUEST['cmboxprodutor'];
	  $idpropriedade = $_REQUEST['cmboxpropriedade'];
	  $idtecnico = $_SESSION['s_idtecnico'];
	  if ( (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
		|| (in_array('SINDICATO',$_SESSION['s_papel']))
		|| (in_array('AUDITOR',$_SESSION['s_papel']))
		|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
		)
	  {
		  $idtecnico = $_REQUEST['cmboxtecnico'];
	  }
	  
	  if ( (in_array('SINDICATO',$_SESSION['s_papel']))
		)
	  {
		  if (empty($idtecnico))
		  {
			$idtecnico = '-1';//$'_REQUEST['cmboxtecnico'];
		  }
	  }
	  
	  
	  $periodo = $_REQUEST['reservation'];
	  $mesreferencia = $_REQUEST['cmboxmesreferencia'];
	  $anoreferencia = $_REQUEST['cmboxanoreferencia'];
	  $ativas = $_REQUEST['chkboxativas'];
	  $pagamentonaorealizado = $_REQUEST['chkboxpagamentonaorealizado'];
	  
	  if (!empty($periodo))
	  {
		$dia = substr($periodo,0,2);
		$mes = substr($periodo,3,2);
		$ano = substr($periodo,6,4);
		$datainicio = $mes.'-'.$dia.'-'.$ano;

		$dia = substr($periodo,13,2);
		$mes = substr($periodo,16,2);
		$ano = substr($periodo,19,4);

		$datafim = $mes.'-'.$dia.'-'.$ano;
		
//		$datafim = date('m-d-Y',strtotime(substr($periodo,13,10)));
	  }
	  if (empty($datainicio))
	  {
		  $datainicio = date('m-d-Y',strtotime('01/01/2012'));
	 }
	  if (empty($datafim))
	  {
		  $datafim = date('m-d-Y');
	  }
	
	class MyPag extends Paginacao
	{
		var $financeiro_;
		function desenhacabeca($row)
		{
		 	 $html = '
			 <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">Propriedade </th>
                                                <th class="column-title">Produtor </th>
                                                <th class="column-title">Técnico </th>
                                                <th class="column-title">Data </th>
                                                <th class="column-title">Mês/Ano Ref. </th>
                                                <th class="column-title">Data Pagto </th>';
												
												if ($this->financeiro_)
												{
													$html.='
													<th class="column-title">Valor pagto</th>';
												}
												
                                                $html.='<th class="column-title no-link last"><span class="nobr">Ação</span>
                                                </th>
                                                <th class="bulk-actions" colspan="7">
                                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                </tr>
                            </thead>
                      ';
		 		echo $html;
		}

		function desenha($row){
			$datapagamento = $row['datapagamento'];
			if (!empty($datapagamento))
			{
				$datapagamento = date('d/m/Y',strtotime($datapagamento));
			}
			$row['ativo'] = false;
			if ($row['ativo']=='true')
			{
				$inativo = 'alert-danger';
			}
			else
			{
				$inativo = '';
			}
			
			if ($this->financeiro_)
			{
				$acoes = '<a target="_blank" href="exec.relvisitatecnicatecnico.php?idvisitatecnica='.$row['idvisitatecnica'].'" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>';
				/*if (empty($row['valorpago']))
				{
					$acoes.= '<a onClick="lancarPagamento('.$row['idvisitatecnica'].')" class="btn btn-success btn-xs"><i class="fa fa-money"></i></a>';
				}
				if (!empty($row['valorpago']))
				{
					$acoes.= '<a onClick="estornarPagamento('.$row['idvisitatecnica'].')" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>';
				}
				*/
			}
			else
			{
				if ( (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
					|| (in_array('AUDITOR',$_SESSION['s_papel']))
					|| (in_array('TECNICO',$_SESSION['s_papel']))
					|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
					)
				{
					$acoes = '<a href="cadvisitatecnica.php?op=A&id='.$row['idvisitatecnica'].'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
				}
				$acoes .= '<a target="_blank" href="exec.relvisitatecnicatecnico.php?idvisitatecnica='.$row['idvisitatecnica'].'" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a>';
			}
			
			$html = '<td class="a-center '.$inativo.'"><input type="checkbox" class="flat" name="id_visitatecnica[]" id="id_visitatecnica" value="'.$row["idvisitatecnica"].'" ></td>
                                    <td class="'.$inativo.'">'.$row['nomepropriedade'].'</td>
                                    <td class="'.$inativo.'">'.$row['nomeprodutor'].'</td>
                                    <td class="'.$inativo.'">'.$row['nometecnico'].'</td>
                                    <td class="'.$inativo.'">'.date('d/m/Y',strtotime($row['datavisita'])).'</td>
                                    <td class="'.$inativo.'">'.$row['mesreferencia'].'/'.$row['anoreferencia'].'</td>
                                    <td class="'.$inativo.'">'.$datapagamento.'</td>';
									if ($this->financeiro_)
												{
													$html.='
													<td class="'.$inativo.'">'.number_format($row['valorpago'],2,',','.').'</td>';
												}
									$html.='
                                    <td class=" last">'.$acoes.'
                                    </td>';
													
			// $date = new DateTime($row['datacadastro']);
			/*$html = ' 
                      <td align="center"><input type="checkbox" name="id_[]" id="id_" value="'.$row["iddescricao"].'" /></td>
					  <td nowrap><a href="caddescricao.php?op=A&id='.$row['iddescricao'].'">'.$row["descricao"].'</a></td>
					  ';
*/		 	

	echo $html;
				echo "";
		}// function
	}	  
	  
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Programa = new Programa();
$Programa->conn = $conn;

$Produtor = new Produtor();
$Produtor->conn = $conn;

$Propriedade = new Propriedade();
$Propriedade->conn = $conn;

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$Paginacao = new MyPag();
$Paginacao->conn = $conn;


   $sql= "select * from visitatecnica vt, propriedade prop left join programa p on prop.idprograma = p.idprograma, 
   produtor prod, tecnico t
where vt.idpropriedade = prop.idpropriedade and 
prop.idprodutor = prod.idprodutor and
vt.idtecnico = t.idtecnico and (datavisita >= '".$datainicio."' and datavisita <= '".$datafim."')
";


if (!empty($idprograma))
{
   $sql.= " and p.idprograma = ".$idprograma;
}
if (!empty($idprodutor))
{
   $sql.= " and prod.idprodutor = ".$idprodutor;
}
if (!empty($idpropriedade))
{
   $sql.= " and prop.idpropriedade = ".$idpropriedade;
}
if (!empty($idtecnico))
{
   $sql.= " and t.idtecnico = ".$idtecnico;
}
if (!empty($mesreferencia))
{
	$sql.=' and vt.mesreferencia = '.$mesreferencia;
}
if (!empty($anoreferencia))
{
	$sql.=' and vt.anoreferencia = '.$anoreferencia;
}
if (!empty($ativas))
{
	$sql.=' and prop.idsituacaopropriedade = 1 ';
}
if (!empty($pagamentonaorealizado))
{
	$sql.=' and vt.valorpago is null ';
}

//$sql.=' group by 1,2,3,4,5,6 ,7';

if ($ordenapor=='PROPRIEDADE')
{
   $sql.= " order by upper(sem_acentos(prop.nomepropriedade))";	
}

if ($ordenapor=='TECNICO')
{
   $sql.= " order by upper(sem_acentos(t.nometecnico))";	
}

if ($ordenapor=='PRODUTOR')
{
	   $sql.= " order by upper(sem_acentos(prod.nomeprodutor))";	
}
if ($ordenapor=='DATA VISITA')
{
   $sql.= " order by vt.datavisita desc";	
}

//echo $sql;

    $Paginacao->sql = $sql; // a  sem o filtro
	$Paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$Paginacao->order = $_REQUEST['o']; // como será¡¯rdenado o resultado
	$Paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1  que  por linha
	$Paginacao->numero_linhas = $_REQUEST['nr']; // quantidade de linhas por pâ¨©nas
	$Paginacao->quadro = ''; // conteò¤¯ em a ser exibido
	$Paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$Paginacao->largura_coluna = '100%';
	$Paginacao->mostra_informe = 'T';//
	$Paginacao->pagina = $_REQUEST['p'];//$_REQUEST['p']; // pâ¨©na que estáŠ‰$paginacao->tamanho_imagem = '60';
	$Paginacao->separador = '' ; // sepador linha que separa as rows
	$Paginacao->financeiro_ = $financeiro;  
?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Balde Cheio</title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir todos o(s) registros(s)? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>

                               


    <div class="container body">


        <div class="main_container">

           
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    
					<?php require "menu.php";?>
                </div>
            </div>

            <!-- top navigation -->
			<?php require "menutop.php";?>


            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="clearfix"></div>

                    <div class="row">
						<form name="frm" id="frm" method="post" class="form-horizontal form-label-left">

								<div id="myModalEstorno" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Estornar Pagamento</h4>
                                            </div>
                                            <div class="modal-body">
												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Motivo</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='id' name='id' type="hidden" class="form-control" value="<?php echo $id;?>">
												<textarea id="edtmotivo" name="edtmotivo" class="form-control" ></textarea>
												</div>
												</div>                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                <button type="button" class="btn btn-primary" onClick="execEstornarPagamento()" >Salvar</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
						
								<div id="myModalPagamento" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Lançar Pagamento</h4>
                                            </div>
                                            <div class="modal-body">
												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Data pagto</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='id' name='id' type="hidden" class="form-control" value="<?php echo $id;?>">
												<input id='edtdatapagamento' name='edtdatapagamento' type="text" class="form-control" data-inputmask="'mask': '99/99/9999'">
												</div>
												</div>

												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Valor</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='edtvalorpago' name='edtvalorpago' type="text" class="form-control" value="">
												</div>
												</div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                <button type="button" class="btn btn-primary" onClick="execLancarPagamento()" >Salvar</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

					 <input type="hidden" name="FINANC" value="<?php echo $_REQUEST['FINANC'];?>">
					 <input type="hidden" name="datainicio" value="<?php echo $datainicio;?>">
					 <input type="hidden" name="datafim" value="<?php echo $datafim;?>">
					 <div class="x_panel">
                        <div class="x_title">
                            <h2>Filtros <small>Utilize os filtros abaixo para realizar a consulta </small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="row">

                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Programa->listaCombo('cmboxprograma',$idprograma,'S','class="form-control"');?>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Produtor->listaCombo('cmboxprodutor',$idprodutor,'S',$idtecnico,'class="form-control"',$_SESSION['s_idsindicato']);?>
                                </div>
								<div class="col-md-5 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Propriedade->listaCombo('cmboxpropriedade',$idpropriedade,'','S','','class="form-control"',$_SESSION['s_idsindicato']);?>
                                </div>
								
								<div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <?php echo $Tecnico->listaCombo('cmboxtecnico',$idtecnico,'S','N','class="form-control"',$_SESSION['s_idsindicato']);?>
                                </div>


                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
								
                                            <fieldset>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <div class="input-prepend input-group">
                                                            <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                            <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="<?php echo $_REQUEST['reservation'];?>" />
														</div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                
								</div>
							</div>
							<div class="row">	
								<?php 
								// FILTROS APENAS PARA A CONSULTA FINANCEIRA
								if ($financeiro)
								{
								?>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    		<select id="cmboxmesreferencia" name="cmboxmesreferencia" class="form-control">
													<option value="" <?php if ($mesreferencia=='') echo "selected";?>>Mês Ref.</option>
                                                    <?php for ($mes = 1;$mes<=12;$mes++)
													{
														?>
														<option value="<?php echo $mes;?>" <?php if ($mesreferencia==$mes) echo "selected";?>><?php echo $mes;?></option>
													<?php }
													?>
													
                                                </select>
								
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    		<select id="cmboxanoreferencia" name="cmboxanoreferencia" class="form-control">
													<option value="" <?php if ($anoreferencia=='') echo "selected";?>>Ano Ref.</option>
                                                    <?php for ($ano = 2011;$ano<=date(Y)+1;$ano++)
													{
														?>
														<option value="<?php echo $ano;?>" <?php if ($anoreferencia==$ano) echo "selected";?>><?php echo $ano;?></option>
													<?php }
													?>
													
                                                </select>
								
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
										<input type="checkbox" class="flat" name="chkboxativas" id="chkboxativas" value="S" <?php if ($ativas=='S') echo "checked";?>> Ativas
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
										<input type="checkbox" class="flat" name="chkboxpagamentonaorealizado" id="chkboxpagamentonaorealizado" value="S" <?php if ($pagamentonaorealizado=='S') echo "checked";?>> Pagto Não realizado
									</div>
									
									
								<?php
								}
								?>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
										<select id="cmboxordenar" name="cmboxordenar" class="form-control">
                                                    <option value="DATA VISITA" <?php if ($ordenapor=='DATA VISITA') echo "selected";?>>Ordenar por data da visita</option>
                                                    <option value="NOME" <?php if ($ordenapor=='NOME') echo "selected";?>>Ordenar por propriedade</option>
                                                    <option value="TECNICO" <?php if ($ordenapor=='TECNICO') echo "selected";?>>Ordenar por técnico</option>
                                                    <option value="PRODUTOR" <?php if ($ordenapor=='PRODUTOR') echo "selected";?>>Ordernar por produtor</option>
                                                </select>
								</div>

                               <div class="col-md-1 col-sm-12 col-xs-12 form-group">
										
                                     <button type="button" class="btn btn-success" onClick='filterApply()'>Filtrar</button>
								</div>
                            </div>

                        </div>
                    </div>
					
					
					
                        
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Consulta Visita Técnica <?php if ($financeiro){echo "(Financeira)";}?> <small>Visitas Técnica cadastrados no sistema</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                                                            <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                Ação
                                <span class="caret"></span>
                            </a>
                                        <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                            <?php if (!$financeiro)
											{
												if ((in_array('ADMINISTRADOR',$_SESSION['s_papel']))
												|| (in_array('AUDITOR',$_SESSION['s_papel']))
												|| (in_array('TECNICO',$_SESSION['s_papel']))
												|| (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
												)
												{
												
												?>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="cadvisitatecnica.php?op=I">Novo</a>
                                            </li>
                                           <li role="presentation"><a role="menuitem" tabindex="-1" onClick='showExcluir()'>Excluir</a>
                                            </li>
										   
												<?php }
											
											} ?>
 											<?php if ($financeiro)
											{
												if (in_array('OPERADOR FINANCEIRO',$_SESSION['s_papel']))
												{
												?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="lancarPagamento()">Lançar Pagamentos</a>
                                            </li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="estornarPagamento()">Estornar Pagamentos</a>
                                            </li>
											<?php }
												if (in_array('ADMINISTRADOR',$_SESSION['s_papel']))
												{
												?>

                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="relPagamentosPeriodo('xls')">Pagamentos no período</a>
                                            </li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick="relPagamentosPeriodo('pdf')">Pagamentos no período</a>
                                            </li>
											

											
												<?php }
												} ?>
                                        </ul>
                                    </li>
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
								<?php $Paginacao->paginar();?>
                              </div>
								
                            </div>
                       
                    </div>
</form>
                </div>

                <!-- footer content -->
                <footer>
                    <div class="">
                        <!--<p class="pull-right">Gentelella Alela! a Bootstrap 3 template by <a>Kimlabs</a>. |
                            <span class="lead"> <i class="fa fa-paw"></i> Gentelella Alela!</span>
                        </p>-->
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>

    <script src="js/custom.js"></script>
	
	<!-- daterangepicker -->
    <script type="text/javascript" src="js/moment.min2.js"></script>
    <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
    
<!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>		
 <!-- input mask -->
    <script src="js/input_mask/jquery.inputmask.js"></script>	
  
	
	
	 <script type="text/javascript">
	   $(document).ready(function () {
            $('#reservation').daterangepicker(null, function (start, end, label) {
                //console.log(start, end, label);
//				start = now()
				//alert(start);
				//alert(end);
				console.log(start,end,label);
            });
        });
       
	
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').target='_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}

	function filterApply()
	{
		document.getElementById('frm').target='_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
	}
	
	function relPagamentosPeriodo(tipo)
	{
		document.getElementById('frm').target='_blank';
		if (tipo=='pdf')
		{
		document.getElementById('frm').action='relpagamentosnoperiodo.php';
    	}
		else{
		document.getElementById('frm').action='relpagamentosnoperiodoxls.php';
		}
		document.getElementById('frm').submit();
	}

	function imprimir(tipo)
	{
		alert(tipo);
	}

	function novo()
	{
		window.location.href = 'cad<?php echo strtolower($FORM_ACTION);?>.php?op=I';
	}

	
	function removeFilter()
	{
		window.location.href = 'cons<?php echo strtolower($FORM_ACTION);?>.php';
	}

	function showExcluir()
	{
		$('#myModal').modal({
  		keyboard: true
	})
	}

	
	function excluir()
	{
		$('#myModal').modal('hide');
//		showalert("Deleted","alert-error");
		document.getElementById('frm').action='exec.<?php echo strtolower($FORM_ACTION);?>.php?op=E';
  			document.getElementById('frm').submit();
	  	//$('#myModal').modal();
	}	
	
	function lancarPagamento()
	{
		$('#myModalPagamento').modal({
  		keyboard: true
	})
	}
	function estornarPagamento()
	{
		$('#myModalEstorno').modal({
  		keyboard: true
	})
	}
	
	function execLancarPagamento()
	{
		var chks = document.getElementsByName('id_visitatecnica[]');
		var hasChecked = false;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				hasChecked = true;
				break;
			}
		
		}
		if (!hasChecked)
		{
		   alert('Selecione uma visita técnica');
		   return false;	
		}
		else
		{
			document.getElementById('frm').target='_self';
			document.getElementById('frm').action='exec.lancarpagamento.php';
			document.getElementById('frm').submit();
		}
	}
	
	function execEstornarPagamento()
	{
		var chks = document.getElementsByName('id_visitatecnica[]');
		var hasChecked = false;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				hasChecked = true;
				break;
			}
		
		}
		if (!hasChecked)
		{
		   alert('Selecione uma visita técnica');
		   return false;	
		}
		else
		{
			if (document.getElementById('edtmotivo').value=='')
			{
				alert('Informe o motivo');
			}
			else
			{
				document.getElementById('frm').target='_self';
				document.getElementById('frm').action='exec.estornarpagamento.php';
				document.getElementById('frm').submit();
			}
		}
	}
	
	function imprimirFormulario()
	{
		var chks = document.getElementsByName('id_visitatecnica[]');
		var hasChecked = false;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				hasChecked = true;
				break;
			}
		
		}
		if (!hasChecked)
		{
		   alert('Selecione uma visita técnica');
		   return false;	
		}
		else
		{
			document.getElementById('frm').target='_blank';
			document.getElementById('frm').action='exec.relvisitatecnicatecnico.php';
			document.getElementById('frm').submit();
		}
	}	
	
	
	</script>

</body>

</html>