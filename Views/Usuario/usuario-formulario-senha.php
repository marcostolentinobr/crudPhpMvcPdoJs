<?
echo campo(getSession('CPF'), 'CPF') . '<br>';
echo getSession('NOME') . '<br><br>';
?>

<!-- SENHA ATUAL -->
<? $campo = ['SENHA_ATUAL', 'Senha atual', 'password', 20, ' required autofocus minlength="3" '] ?>
<label for="<?= $campo[0] ?>" ><?= $campo[1] ?>:</label>
<input type="<?= $campo[2] ?>" id="<?= $campo[0] ?>" name="<?= $campo[0] ?>" maxlength="<?= $campo[3] ?>" <?= $campo[4] ?> >

<!-- SENHA -->
<? $campo = ['SENHA', 'Nova senha', 'password', 20, ' required autofocus minlength="3" '] ?>
<label for="<?= $campo[0] ?>" ><?= $campo[1] ?>:</label>
<input type="<?= $campo[2] ?>" id="<?= $campo[0] ?>" name="<?= $campo[0] ?>" maxlength="<?= $campo[3] ?>" <?= $campo[4] ?> >
