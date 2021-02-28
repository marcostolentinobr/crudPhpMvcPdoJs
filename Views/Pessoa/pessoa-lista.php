<?
if ($this->Model->buscarCampos) {
    require_once __DIR__ . '/../tamplateBusca.php';
}
?>
<table border="1" style="width: 100%">
    <tr>
        <th>Nome</th>
        <th>Curso</th>
        <th>Formações</th>
        <th>Pontos</th>
        <th>Ações</th>
    </tr>
    <? while ($dado = $this->qry->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <span class="sublinhadoPointer" 
                      title="<?= "$dado[NOME]&#013;Observação: $dado[OBSERVACAO]" ?>" 
                      >
                    <a href="<?= URL . "Pessoa/detalhe/" . $dado['ID_PESSOA'] ?>"><?= reticencias($dado['NOME'], 15) ?></a>
                </span>
            </td>
            <td><?= reticencias($dado['CUR_NOME'], 15) ?></td>
            <td><?
                echo $dado['FORMACAO_QUANTIDADE'];
                echo '
                    <small class="sublinhadoPontilhadoPointer" title="Quantidade de arquivos vinculados">
                        <small> (Arq: ' . count(mArquivosListar(RAIZ . "/arquivos/" . $dado['ID_PESSOA'])) . ')</small>
                    </small>
                ';
                ?>
            </td>
            <td><?= $dado['FORMACAO_PONTOS'] ?></td>
            <td>
                <?
                if (getSession('ID_USUARIO') == $dado['ID_USUARIO']) {
                    require __DIR__ . '/../tamplateBotoes.php';
                } else {
                    echo '
                        <small class="sublinhadoPontilhadoPointer"
                               title="Cadastrado por: ' . $dado['USU_NOME'] . '"
                        >
                                Não pode alterar
                        </small>
                    ';
                }
                ?>
            </td>
        </tr>
    <? } ?>

</table>
<?
require_once __DIR__ . '/../tampletePaginacao.php';
