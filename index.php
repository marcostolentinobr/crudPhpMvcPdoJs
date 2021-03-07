<?
require_once 'config.php';

//Caso não exista usuario logado, logue antes
if (@!$_SESSION['USUARIO'] && CLASSE != 'Login') {
    //Pode acessar a classe usuário para cadastrar algum
    if (CLASSE != 'Usuario') {
        header('Location: ' . URL . 'Login/acessar');
    }
}
?>
<title><?= TITULO ?></title>
<base href="<?= URL ?>" />
<script src="script.js"></script>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<style>
    label {
        font-weight: bold;
        display: block;
        padding-top: 5px;
    }
    select, textarea, input[type=text] {
        width: 100%;        
    }

    input[type=submit] {
        width: 55px;        
    }

    .sublinhadoPontilhadoPointer {
        text-decoration: underline; 
        text-decoration-style: dotted; 
        cursor: pointer;
    }

    .sublinhadoPointer {
        text-decoration: underline; 
        cursor: pointer;
    }

</style>
<center>
    <BR>
    <a href="<?= URL ?>Index">INÍCIO</a> |
    <? if (isset($_SESSION['USUARIO'])) { ?>
        <a href="<?= URL ?>Curso/listar">CURSO</a> |
        <a href="<?= URL ?>Formacao/listar">FORMAÇÃO</a> |
        <a href="<?= URL ?>Pessoa/listar">PESSOA</a> |

        <?
        echo '
            <small 
                class="sublinhadoPontilhadoPointer"
                title="Clique para alterar a senha&#013;' . getSession('NOME') . ' (' . campo(getSession('CPF'), 'CPF') . ')" 
            >
                <a href="' . URL . 'Usuario/alterarSenha">(' . reticencias(getSession('NOME'), 10) . ')</a>
            </small>
        ';
        ?>
        <small> <a href="<?= URL ?>Login/sair"><sup>Sair</sup></a> </small>
    <? } else { ?>
        <a href="<?= URL ?>Usuario/listar">USUARIO</a> |
    <? } ?>
    <BR>
    <? require_once 'conteudo.php'; ?>
</center>