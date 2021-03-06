<?php

class PessoaModel extends Model {

    public $tabela = 'PESSOA';
    public $chave = 'ID_PESSOA';
    public $buscarCampos = ['P.NOME','C.NOME'];
    
    //PessoaFormacao
    private $PessoaFormacao;

    public function __construct($pdo = '') {
        parent::__construct($pdo);
        $this->PessoaFormacao = instanciaModel('PessoaFormacao', $this->pdo());
    }

    public function listar($valores = [], $todos = false) {
        $sql = "
            SELECT P.*,
                   C.NOME AS CUR_NOME,
                   (SELECT COUNT(*) FROM PESSOA_FORMACAO PF WHERE PF.ID_PESSOA = P.ID_PESSOA) AS FORMACAO_QUANTIDADE,
                   (    SELECT COALESCE(SUM(F.PONTO),0) 
                          FROM PESSOA_FORMACAO PF 
                          JOIN FORMACAO F
                            ON F.ID_FORMACAO = PF.ID_FORMACAO
                          WHERE PF.ID_PESSOA = P.ID_PESSOA
                    ) AS FORMACAO_PONTOS,
                   0 AS ITEM_UTILIZADO,
                   U.NOME AS USU_NOME
              FROM PESSOA P 
              JOIN CURSO C
                ON C.ID_CURSO = P.ID_CURSO
              JOIN USUARIO U
                ON U.ID_USUARIO = P.ID_USUARIO
        ";

        $this->addOrder('
            FORMACAO_PONTOS DESC,  
            C.NOME'
        );

        return $this->listarRetorno($sql, $valores, $todos);
    }

    //DADOS
    protected function dado($dado, $metodo = __METHOD__) {

        //OBSERVACAO opcional e ate 1000 caracteres
        $this->dado['OBSERVACAO'] = trim($dado['OBSERVACAO']);
        if (!$this->dado['OBSERVACAO']) {
            $this->dado['OBSERVACAO'] = 'NULL';
        }
        $this->campoValidacao('OBSERVACAO', 1000, false);

        //NOME - Obrigatório e até 100 caracteres
        $this->dado['NOME'] = ucwords(mb_strtolower(campo($dado['NOME'], 'S')));
        $this->campoValidacao('NOME', 50, true, false, 3);
        if (!nomeSobreNomeValidar($this->dado['NOME'])) {
            $this->erro['Nome'] = 'É necessário nome e sobrenome';
        }

        //ID_CURSO - Obrigatório
        $this->dado['ID_CURSO'] = $dado['ID_CURSO'];
        $this->campoValidacao('ID_CURSO', 3, true, true);

        //ID_USUARIO - Obrigatório
        $this->dado['ID_USUARIO'] = getSession('ID_USUARIO');
        $this->campoValidacao('ID_USUARIO');

        //NOME - Já existe?
        if (!$this->erro && $metodo != 'Model::alterar') {
            $sql = "SELECT NOME FROM PESSOA WHERE NOME = '{$this->dado['NOME']}' LIMIT 1";
            $this->paginacao = false;
            if ($this->listarRetorno($sql)) {
                $this->erro['Nome'] = 'Já cadastrado';
            }
        }

        return $this->dadosValidacao();
    }

    public function incluir() {
        return $this->PessoaFormacao->incluirPessoaFormacao(parent::incluir());
    }

    public function alterar() {
        return $this->PessoaFormacao->incluirPessoaFormacao(parent::alterar());
    }

    public function excluir() {
        $okPessoaExcluir = parent::excluir();
        if ($okPessoaExcluir) {
            return $this->PessoaFormacao->excluir();
        }
        return $okPessoaExcluir;
    }

}
