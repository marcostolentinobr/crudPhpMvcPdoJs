<?

session_start();

//BANCO DE DADOS
define('DB_LIB', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'CRUD');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASS', '');

define('TITULO', 'Exemplo de Sistema com PHP e JS');

//Funções
require_once 'funcoes.php';

//URL
$url = [];
if (isset($_GET['pg'])) {
    $url = explode('/', $_GET['pg']);
}
define('CLASSE', isset($url[0]) ? $url[0] : '');
define('METODO', isset($url[1]) ? $url[1] : '');
define('CHAVE', isset($url[2]) ? $url[2] : '');

//DIRETORIO RAIZ
define('RAIZ', __DIR__);

//URL
$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
$url = $protocolo . '://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
define('URL', $url);
define('URL_ATUAL', URL . '/' . CLASSE . '/' . METODO);