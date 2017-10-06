         
<?php
    include_once 'templates/nav.php';
    include_once 'templates/login.php';
    include_once 'templates/pass.php';
?>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<div id="main">
    <img src="img/rsz_1fundo-jb.jpg" class="background-image" alt="jardim botanico">
    <section id="contato">
        <h2>CONTATO</h2>
        <p>Entre em contato conosco.</p>
        <div>
            <img src="img/endereço.png" alt="endereço">
            <p><a href="https://www.google.com.br/maps/place/Rua+Pacheco+Le%C3%A3o,+915+-+Jardim+Bot%C3%A2nico,+Rio+de+Janeiro+-+RJ/@-22.965604,-43.2303486,17z/data=!3m1!4b1!4m5!3m4!1s0x9bd595ff0d8d55:0x3e8843dcc5a67f1a!8m2!3d-22.965604!4d-43.2281599">Rua Pacheco Leão, 915 - CEP 22460-030</a></p>
        </div>

        <div>
            <img src="img/fone.png" alt="fone">
            <p><a href="tel:2132042124">(21) 3204-2124</a></p>
        </div>

        <div>
            <img src="img/contato.png" alt="email">
            <p><a href="mailto:modelr.jbrj@gmail.com">modelr.jbrj@gmail.com</a></p>
        </div>
    </section>
</div>        

<?php
    include_once 'templates/footer.php';
?>

	<script>
			
					
		<?php 

		require 'MSGCODIGO.php';

		?>
		<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
		?>
	
	</script>