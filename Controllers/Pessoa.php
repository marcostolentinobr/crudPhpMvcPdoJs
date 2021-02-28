<?php

class Pessoa extends Controller {

    protected $descricao = 'Pessoa';
    //Curso
    private $Curso;
    protected $cursoLista;
    //Formacao
    protected $Formacao;
    protected $formacaoLista;
    //PessoaFormacao
    protected $PessoaFormacao;
    public $pessoaFormacaoLista;

    public function __construct() {
        parent::__construct();
        $this->Model->paginacao = true;
        //Caso a ação tenha dado ok e tenha arquivo enviar o arquivo
        if ($this->ok && @$_FILES['ARQUIVO']['name'][0]) {
            $ARQ = $_FILES['ARQUIVO'];

            $chave = coalesce(@$this->dado[$this->ID_CHAVE], $this->Model->ultimoInsertId());
            foreach ($ARQ['name'] as $ind => $nome) {
                $extencao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
                $arq_local = RAIZ . "/arquivos/{$chave}_" . date('Ymd_His') . "_$ind.$extencao";
                if (!move_uploaded_file($ARQ['tmp_name'][$ind], $arq_local)) {
                    echo '
                        <h1 style="color: red">
                            Cadastrado mais talvez haja arquivos que não foi enviado, tente novamente.
                        </h1>
                    ';
                }
            }
        }
        
        $this->PessoaFormacao = instanciaModel('PessoaFormacao');
        
        //EXCLUIR
        if ($this->ok && $this->acaoDescricaoPost == 'Excluir') {
            $this->PessoaFormacao->excluir();
        }

        //instancia de curso e formação
        $this->Curso = instanciaModel('Curso');
        $this->cursoLista = $this->Curso->listar([], true);
        
        //Quando for para editar setar os dados de formação vinculado a pessoa
        $this->setFormacao();
        if ($this->acaoDescricaoPost == 'Editar' && $this->where) {
            $this->setPessoaFormacao($this->where);
        }

        //Excluir arquivo
        foreach ($_POST as $dado => $valor) {
            if (strpos(base64_decode($dado), 'XCLUIR-' . CHAVE) == 1) {
                $ARQ = str_replace('EXCLUIR-', '', base64_decode($dado));
                $ARQ_FILE = RAIZ . "/arquivos/" . $ARQ;
                IF (file_exists($ARQ_FILE)) {
                    unlink($ARQ_FILE);
                }
            }
        }
    }

    public function setFormacao() {
        $this->Formacao = instanciaModel('Formacao');
        $this->formacaoLista = $this->Formacao->listar([], true);
        foreach ($this->Formacao->listar([], true) as $formacao) {
            $this->formacaoLista[$formacao['ID_FORMACAO']] = $formacao;
        }
    }

    public function setPessoaFormacao($where) {
        $pessoaFormacaoLista = $this->PessoaFormacao->listar($where, true);
        foreach ($pessoaFormacaoLista as $pessoaFormacao) {
            $this->pessoaFormacaoLista[$pessoaFormacao['ID_FORMACAO']] = $pessoaFormacao;
        }
    }

    public function tamplateLista() {
        require __DIR__ . '/../Views/' . CLASSE . '/' . strtolower(CLASSE) . '-lista.php';
    }

    public function detalhe() {
        $this->setPessoaFormacao([$this->ID_CHAVE => CHAVE]);
        $this->dado = $this->Model->listar($this->where, true)[0];
        $this->requireForm('detalhe', 'Detalhe', false);
    }

}
