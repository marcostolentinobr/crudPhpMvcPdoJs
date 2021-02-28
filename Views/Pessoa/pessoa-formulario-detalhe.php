<?

$VIRTUAL = URL . "arquivos/";
$ind = 0;

echo "<b>Nome:</b>{$this->dado['NOME']}<BR>";
echo "<b>Curso:</b>{$this->dado['CUR_NOME']}<BR>";
echo "<b>Formações:</b>";

if ($this->pessoaFormacaoLista) {
    foreach ($this->pessoaFormacaoLista as $id_formacao => $formacao) {
        echo $this->formacaoLista[$id_formacao]['NOME'] . ', ';
    }
} else {
    echo 'Sem formação cadastrada';
}

echo "<br><b>Pontos:</b>{$this->dado['FORMACAO_PONTOS']}<br>";
echo "<b>Obervação:</b>{$this->dado['OBSERVACAO']}<BR>";
echo "<br><small style='color: blue'><b>Cadastrado por: </b>{$this->dado['USU_NOME']}</small><BR>";

echo '<br><b>Títulos:</b><br>';
foreach (mArquivosListar(RAIZ . "/arquivos/" . CHAVE) as $nome => $arquivo) {
    $ind++;
    echo "<a target='_blank' href='{$VIRTUAL}{$nome}'>Arquivo $ind</a> ";
    if (getSession('ID_USUARIO') == @$dado['ID_USUARIO']) {
        echo "<input name='" . base64_encode("EXCLUIR-$nome") . "' value='X' type='submit'>";
    }
    echo '<br>';
}

if (!$ind) {
    echo 'Sem arquivos cadastrados';
}