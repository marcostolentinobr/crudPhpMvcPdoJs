<?php

class Model {

    private $pdo;
    private $order = '';
    protected $dado;
    protected $erro;
    public $linhasTotal;
    public $linhasTotalMomento;
    public $pagina_total = 8;
    public $buscarCampos = [];
    public $paginacao = true;

    public function __construct($pdo = '', $paginacao = true) {
        if ($pdo) {
            $this->pdo = $pdo;
        }
        $this->pdo = $this->pdo();
        $this->paginacao = $paginacao;
    }

    public function ultimoInsertId() {
        $retorno = $this->listarRetorno('SELECT LAST_INSERT_ID() AS ID');
        return $retorno[0]['ID'];
    }

    public function getDados() {
        $this->dado[$this->chave] = $_POST[$this->chave];
        return $this->dado;
    }

    //DADOS
    protected function dado($dado, $metodo = __METHOD__) {
        return [];
    }

    public function pdo() {
        if ($this->pdo) {
            return $this->pdo;
        }

        $this->pdo = new PDO(DB_LIB . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->pdo;
    }

    private function dadosQry($insert = false, $dados) {
        $ITEM = [];
        $ITEM['sintaxe'] = [];
        $ITEM['valores'] = [];
        foreach ($dados as $coluna => $valor) {
            if (!empty($valor) || $valor === '0') {
                if ($insert) {
                    $ITEM['sintaxe'][] = "$coluna";
                } else {
                    $ITEM['sintaxe'][] = "$coluna=:$coluna";
                }
                $key = ":$coluna";
                $ITEM['valores'][$key] = $valor === 'NULL' ? null : $valor;
            }
        }
        return $ITEM;
    }

    public function where($valores) {
        $where = '';
        if ($valores) {
            $dado = $this->dadosQry(false, $valores);
            $where = ' WHERE ' . implode(' AND ', $dado['sintaxe']);
            $valores = $dado['valores'];
        }

        //Buscar
        $buscar = campo(@$_POST['Buscar']);
        if ($buscar && $this->buscarCampos) {
            foreach ($this->buscarCampos as $campo) {
                @$whereBuscar[] = " $campo LIKE '%$buscar%'";
            }
        }

        if ($this->paginacao) {
            if (isset($whereBuscar)) {
                $whereBuscar = implode(' OR ', $whereBuscar);
            }

            if ($where && isset($whereBuscar)) {
                $where .= " AND ($whereBuscar) ";
            }

            if (!$where && isset($whereBuscar)) {
                $where = " WHERE $whereBuscar ";
            }
        }

        return $where;
    }

    public function addOrder($str) {
        $this->order = ' ORDER BY ' . $str;
    }

    public function prepareExecute($sql, $dado = [], $listar = false) {
        $acao = $this->pdo->prepare($sql);
        $execute = $acao->execute($dado);
        $this->linhasTotal = $acao->rowCount();
        return ($listar ? $acao : $execute);
    }

    public function incluir() {
        $dado = coalesce($this->dado, $this->dado($_POST, __METHOD__));
        $dadoIncluir = $this->dadosQry(true, $dado);
        $sql = "INSERT INTO $this->tabela (" . implode(", ", $dadoIncluir['sintaxe']);
        $sql .= ') VALUES ( :' . implode(", :", $dadoIncluir['sintaxe']) . ')';
        return $this->prepareExecute($sql, $dadoIncluir['valores']);
    }

    public function excluir() {
        $valores = [$this->chave => coalesce(@$this->dado[$this->chave], @$_POST[$this->chave])];
        $sql = "DELETE FROM $this->tabela " . $this->where($valores);
        return $this->prepareExecute($sql, $valores);
    }

    public function alterar() {
        $where = [$this->chave => $_POST[$this->chave]];
        $dado = coalesce($this->dado, $this->dado($_POST, __METHOD__));
        $dadoAlterar = $this->dadosQry(false, $dado);
        $whereAlterar = $this->dadosQry(false, $where);
        $sql = "UPDATE $this->tabela SET " . implode(", ", $dadoAlterar['sintaxe']);
        $sql .= ' WHERE ' . implode(' AND ', $whereAlterar['sintaxe']);
        return $this->prepareExecute($sql, array_merge($dadoAlterar['valores'], $whereAlterar['valores']));
    }

    public function listar($valores = [], $todos = false) {
        $sql = "SELECT *, 0 AS ITEM_UTILIZADO FROM $this->tabela";
        return $this->listarRetorno($sql, $valores, $todos);
    }

    public function listarRetorno($sql, $valores = [], $todos = true) {

        $limite = '';
        if ($this->paginacao) {
            $inicio = (coalesce(@$_GET['pagina'], 1) - 1) * $this->pagina_total;
            $limite = " LIMIT $inicio,$this->pagina_total ";
        }

        $acao = $this->prepareExecute($sql . $this->where($valores) . $this->order . $limite, $valores, true);
        $this->linhasTotalMomento = $this->linhasTotal;
        if ($this->paginacao) {
            $total = $this->prepareExecute($sql . $this->where($valores) . $this->order, $valores, true);
        }
        if ($todos) {
            return $acao->fetchAll(PDO::FETCH_ASSOC);
        }
        return $acao;
    }

    public function dadosValidacao() {
        if ($this->erro) {
            $mensagem = '';
            foreach ($this->erro as $campo => $msg) {
                $mensagem .= "<b>$campo</b>: <small>" . ucfirst($msg) . "</small><br>";
            }
            throw new Exception("<div style='color: black'>$mensagem</div>");
        }
        return $this->dado;
    }

    public function campoValidacao($campoNome, $digitoMaximo = 100, $obrigatorio = true, $numero = false, $digitoMinimo = '') {
        $str = trim($this->dado[$campoNome]);
        $campoNome = ucwords(mb_strtolower(str_replace('_', ' ', $campoNome)));

        if (!$str && $obrigatorio) {
            @$this->erro[$campoNome] .= ' obrigatório, ';
        }

        //MAXIMO CARACTERES ====================================================
        if (strlen($str) > $digitoMaximo) {
            @$this->erro[$campoNome] .= " até $digitoMaximo digitos, ";
        }

        //MAXIMO CARACTERES ====================================================
        if ($digitoMinimo && strlen($str) < $digitoMinimo) {
            @$this->erro[$campoNome] .= " mínimo de $digitoMinimo digitos, ";
        }

        //NUMERO ===============================================================
        if ($numero && !is_numeric($str)) {
            @$this->erro[$campoNome] .= " tem que ser um número, ";
        }

        return true;
    }

}
