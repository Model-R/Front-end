<div class="form-group">
    <label for="cmboxtipofiltro">Tipo</label>
    <select id="cmboxtipofiltro" name="cmboxtipofiltro" class="form-control">
        <option value="EXPERIMENTO" <?php if ($tipofiltro=='EXPERIMENTO') echo "selected";?>>Experimento</option>
        <option value="USUARIO" <?php if ($tipofiltro=='USUARIO') echo "selected";?>>Usuário</option>
    </select>
</div>