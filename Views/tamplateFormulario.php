<? if ($this->mostrarDescricaoAcao) { ?>
    <h2 style="text-align: center;"><?= $this->descricao ?> - <?= $this->acaoDescricao ?></h2> 
<? } ?>
<form method="POST" enctype="multipart/form-data" action="<?= URL . CLASSE . '/listar' ?>">
    <input type="text" name="<?= $this->ID_CHAVE ?>" value="<?= @$this->dado[$this->ID_CHAVE] ?>" hidden>
    <? require_once __DIR__ . '/' . CLASSE . '/' . strtolower(CLASSE) . "-formulario{$this->arquivoForm}.php"; ?>
    <hr>
    <? if ($this->botaoFormulario) { ?>
        <div style="border: 0px solid; text-align: center">
            <input name="ACAO" value="<?= $this->acaoDescricao ?>" type="submit">
        </div>
    <? } ?>

</form>