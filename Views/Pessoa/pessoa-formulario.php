<!-- NOME -->
<? $campo = ['NOME', 'Nome', 50] ?>
<label for="<?= $campo[0] ?>" ><?= $campo[1] ?></label>
<input type="text" id="<?=$campo[0]?>"  name="<?=$campo[0]?>" value="<?= @$this->dado[$campo[0]] ?>" class="nomeSobrenome" onblur="return validaNomeSobrenome(NOME)" maxlength="<?=$campo[2]?>" equired minlength="3" autofocus><br>

<label>Curso:</label>
<select name="ID_CURSO" required>
    <option></option>
    <? foreach ($this->cursoLista as $curso) { ?>
        <option value="<?= $curso['ID_CURSO'] ?>" <?= (@$this->dado['ID_CURSO'] == $curso['ID_CURSO'] ? 'selected' : '') ?>><?= $curso['NOME'] ?></option>
    <? } ?>
</select><br>
<label style="font-weight: normal">Formação:</label>
<select name="ID_FORMACAO[]" multiple>
    <? foreach ($this->formacaoLista as $formacao) { ?>
        <option value="<?= $formacao['ID_FORMACAO'] ?>" <?= (isset($this->pessoaFormacaoLista[$formacao['ID_FORMACAO']]) ? 'selected' : '') ?>><?= $formacao['NOME'] ?></option>
    <? } ?>
</select><br>

<label style="font-weight: normal">Comprovante de título:</label>
<input type="file" name="ARQUIVO[]" autofocus multiple><br>

<?
if ($this->acaoDescricaoPost == 'Editar') {
    echo '<small style="color:red">Para ver ou editar arquivos clique no nome da pessoa</small><br>';
}
?>


<label style="font-weight: normal">Observação:</label>
<textarea maxlength="1000" style="height: 100px" name="OBSERVACAO"><?= @$this->dado['OBSERVACAO'] ?></textarea>
