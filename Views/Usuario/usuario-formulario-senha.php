<?
echo campo(getSession('CPF'), 'CPF') . '<br>';
echo getSession('NOME') . '<br><br>';
?>

<label>Senha atual:</label>
<input type="password" name="SENHA_ATUAL" autofocus minlength="3" maxlength="20" required>

<label>Nova senha:</label>
<input type="password" name="SENHA" autofocus minlength="3" maxlength="20" required>
