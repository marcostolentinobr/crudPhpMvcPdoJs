<? require_once __DIR__ . '/mensagemAcao.php'; ?>
<br>
<table border="1" style="width: <?= $this->sistemaLargura ?>px">
    <tr style=" vertical-align: top">
        <? if ($this->listarMostrar) { ?>
            <td style="text-align: right; padding-right: 10px">
                <h2 style="text-align: center"><?= $this->descricao ?> - Listar</h2> 
                <?
                //Mostra buscar caso tiver sido setado
                if ($this->Model->buscarCampos) {
                    require_once 'tamplateBusca.php';
                }
                require_once 'mensagemSemDadosListar.php';
                $this->tamplateLista();
                ?>
            </td>
        <? } ?>
        <td style="padding-left: 10px; width: <?= $this->formularioLargura ?>px">
            <? require_once 'tamplateFormulario.php' ?>
        </td>
    </tr>
</table>