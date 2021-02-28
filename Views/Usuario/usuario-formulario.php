<label>CPF:</label>
<input type="text" id="CPF" name="CPF" value="<?= @$this->dado['CPF'] ?>" autofocus minlength="14" maxlength="14" onkeypress="return mascaraCPF(CPF)" required>

<label>Nome:</label>
<input type="text" id="NOME" name="NOME" value="<?= @$this->dado['NOME'] ?>" autofocus minlength="3" maxlength="50" onblur="return validaNomeSobrenome(NOME)" required>

<label>Senha:</label>
<input type="text" id="SENHA" name="SENHA" value="<?= @$this->dado['SENHA'] ?>" autofocus minlength="3" maxlength="20" required>