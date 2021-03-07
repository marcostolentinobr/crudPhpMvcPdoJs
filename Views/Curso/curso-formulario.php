<!-- NOME -->
<? $campo = ['NOME', 'Nome', 'text',  100, ' required autofocus minlength="3" '] ?>
<label for="<?= $campo[0] ?>"><?= $campo[1] ?>:</label>
<input type="<?= $campo[2] ?>" id="<?= $campo[0] ?>" name="<?= $campo[0] ?>" value="<?= @$this->dado[$campo[1]] ?>" maxlength="<?= $campo[3] ?>" <?= $campo[4] ?> >