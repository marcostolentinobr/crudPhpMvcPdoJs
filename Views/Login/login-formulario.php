<!-- PONTOS -->
<? $campo = ['PONTO', 'Pontos', 'text', 3, ' required autofocus minlength="14" onkeypress="return mascaraCPF(CPF)" '] ?>
<label for="<?= $campo[2] ?>" ><?= $campo[1] ?>:</label>
<input type="<?= $campo[2] ?>" id="<?= $campo[0] ?>" name="<?= $campo[0] ?>" maxlength="<?= $campo[2] ?>" <?= $campo[3] ?> >

<!-- SENHA -->
<? $campo = ['SENHA', 'Senha', 'password', 20, ' required '] ?>
<label for="<?= $campo[0] ?>" >Senha:</label>
<input type="<?= $campo[2] ?>" id="<?= $campo[1] ?>" name="<?= $campo[1] ?>" maxlength="<?= $campo[3] ?>" <?= $campo[4] ?>>