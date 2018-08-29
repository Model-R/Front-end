<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div class="container">
 <div class="row">
  <div class="process">
   <div class="process-row nav nav-tabs">
    <div class="process-step">
     <button type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#menu1"><i class="fa fa-info fa-3x"></i></button>
     <p><small>Fill<br />information</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu2"><i class="fa fa-file-text-o fa-3x"></i></button>
     <p><small>Fill<br />description</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu3"><i class="fa fa-image fa-3x"></i></button>
     <p><small>Upload<br />images</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu4"><i class="fa fa-cogs fa-3x"></i></button>
     <p><small>Configure<br />display</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu5"><i class="fa fa-check fa-3x"></i></button>
     <p><small>Save<br />result</small></p>
    </div>
   </div>
  </div>
  <div class="tab-content">
   <div id="menu1" class="tab-pane fade active in">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-info next-step">Next <i class="fa fa-chevron-right"></i></button></li>
    </ul>
   </div>
   <div id="menu2" class="tab-pane fade">
    <h3>Menu 2</h3>
    <p>Some content in menu 2.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
     <li><button type="button" class="btn btn-info next-step">Next <i class="fa fa-chevron-right"></i></button></li>
    </ul>
   </div>
   <div id="menu3" class="tab-pane fade">
    <h3>Menu 3</h3>
    <p>Some content in menu 3.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
     <li><button type="button" class="btn btn-info next-step">Next <i class="fa fa-chevron-right"></i></button></li>
    </ul>
   </div>
   <div id="menu4" class="tab-pane fade">
    <h3>Menu 4</h3>
    <p>Some content in menu 4.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
     <li><button type="button" class="btn btn-info next-step">Next <i class="fa fa-chevron-right"></i></button></li>
    </ul>
   </div>
   <div id="menu5" class="tab-pane fade">
    <h3>Menu 5</h3>
    <p>Some content in menu 5.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
     <li><button type="button" class="btn btn-success"><i class="fa fa-check"></i> Done!</button></li>
    </ul>
   </div>
  </div>
 </div>
</div>

<style>
.process-step .btn:focus{outline:none}
.process{display:table;width:100%;position:relative}
.process-row{display:table-row}
.process-step button[disabled]{opacity:1 !important;filter: alpha(opacity=100) !important}
.process-row:before{top:40px;bottom:0;position:absolute;content:" ";width:100%;height:2px;background-color:#ccc;z-index:0}
.process-step{display:table-cell;text-align:center;position:relative}
.process-step p{margin-top:4px}
.btn-circle{width:80px;height:80px;text-align:center;font-size:12px;border-radius:50%}

</style>
<script>
$(function(){
 $('.btn-circle').on('click',function(){
   $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
   $(this).addClass('btn-info').removeClass('btn-default').blur();
 });

 $('.next-step, .prev-step').on('click', function (e){
   var $activeTab = $('.tab-pane.active');

   $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

   if ( $(e.target).hasClass('next-step') )
   {
      var nextTab = $activeTab.next('.tab-pane').attr('id');
      $('[href="#'+ nextTab +'"]').addClass('btn-info').removeClass('btn-default');
      $('[href="#'+ nextTab +'"]').tab('show');
   }
   else
   {
      var prevTab = $activeTab.prev('.tab-pane').attr('id');
      $('[href="#'+ prevTab +'"]').addClass('btn-info').removeClass('btn-default');
      $('[href="#'+ prevTab +'"]').tab('show');
   }
 });
});
</script>