<? $campo = ['NOME', 'Nome', 100] ?>
<label for="<?= $campo[0] ?>"><?= $campo[1] ?>:</label>
<input type="text" id="<?= $campo[0] ?>" name="<?= $campo[0] ?>" value="<?= @$this->dado[$campo[1]] ?>" maxlength="<?= $campo[2] ?>" required minlength="3" autofocus>