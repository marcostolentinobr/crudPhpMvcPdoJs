<?php

class Usuario extends Controller {

    protected $descricao = 'Usuário';
    protected $sistemaLargura = 200;
    protected $listarMostrar = false;

    public function alterarSenha() {
        $this->dado = getSession();
        $this->requireForm('senha', 'Alterar');
    }

    protected function executaPosAcao() {
        if ($this->ok == 1 && getSession()) {
            setSession('SENHA', $this->dado['SENHA']);
        }
    }

}
