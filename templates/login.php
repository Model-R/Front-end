<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="loginForm" id="loginForm" method="post" action="testalogin.php">
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Usuário:</label>
                        <input type="text" class="form-control" name="edtlogin" id="edtlogin">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Senha:</label>
                        <input type="password" class="form-control" name="edtsenha" id="edtsenha">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="form_submit('loginForm')">Login</button>
                    <a class="pass_reset" data-toggle="modal" data-target="#senhaModal" data-dismiss="modal">Esqueceu sua senha?</a>
                </div>
            </div>
        </div>
    </div>
</div>
       
 