<div class="form-group">
    <label for="cmboxordenar">Ordenar por</label>
    <select id="cmboxordenar" name="cmboxordenar" class="form-control">
        <option value="EXPERIMENTO" <?php if ($ordenapor=='EXPERIMENTO') echo "selected";?>>Experimento</option>
        <option value="USUARIO" <?php if ($ordenapor=='USUARIO') echo "selected";?>>Usuário</option>
    </select>
</div>