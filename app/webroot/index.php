<?php
/* mostra o phpinfo */
//phpinfo(); die();

/* mostrar todos os erros. comentar quando for pra produção */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(dirname(__FILE__))));
define('LIB', ROOT . DS . 'lib');
define('APP', ROOT . DS . 'app');
define('WEBROOT', APP . DS . 'webroot');

date_default_timezone_set('America/Sao_Paulo');

if(!include LIB . DS . 'bootstrap.php')
	die('Arquivo lib/bootstrap.php não encontrado.');

App::import('Request', 'Core');
App::import('Controller', 'Controller');
App::import('View', 'View');

/* pega os dados da requisição e transforma no nosso padrao */
$request = new Request();


$ctrlClass = null;

/* obtem o controller. se nao existir eh acionado a exception ControllerNotFoundException */
try {
	$ctrlClass = Controller::getController(Inflector::camelize($request->params['controller']));
}
catch(ControllerNotFoundException $e) {
	/* tratativa de erro de controller nao encontrado */
	http_response_code(404);
	die('controller not found');
}


$controller = $view = null;

/* cria a instancia do controle */
$controller = new $ctrlClass($request->params['controller'], $request);


/* cria a instancia da view e seta no controller */
$view = new View($request->params['action'], $controller);
$controller->view = $view;


/* executa o beforeAction do controller */
$controller->beforeAction();


/* executa a action */
try {
	$controller->invokeAction($request->params['action'], $request->params['args']);
}
catch(ActionNotFoundException $e) {
	/* tratativa de erro de acao nao encontrada */
	http_response_code(404);
	die('action nao existe');
	
}
catch(PrivateMethodException $e) {
	/* tratativa de erro de metodo nao encontrado */
	die('private method');
}


/* renderiza a view */
if($controller->autoRender === true) {
	$view->render();
}


/* 
	o que falta:
		tratativa de erros
*/