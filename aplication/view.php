<?php

/**
*
*/
class View
{
	private $_controller;
	private $_method;
	private $_view;
	private $_layout = DEFAULT_LAYOUT;
	private $viewsVars; //Es un atributo que contiene los valores

	public function __construct(Request $p)
	{
		$this->_controller = $p->getController();
		$this->_method = $p->getMethod();
		$this->_view = $this->_method;
		$this->Html = new Html();

	}

	public function setVars($vars){
		if (empty($this->viewsVars)) {
			$this->viewsVars = $vars;
		}else{
			$this->viewsVars = array_merge($this->viewsVars, $vars);
		}

	}

	public function setLayout($layout){
		$this->_layout = $layout;
		//$this->_view->setlayout("website");
	}

	public function setView($view){
		$this->_view = $view;
	}

	public function render($view){

		if (!empty($this->viewsVars)) {
			extract($this->viewsVars, EXTR_OVERWRITE);
		}
		$_layoutParams = array(
			"route"     =>APP_URL."/views/layouts/".$this->_layout,
			"route_css" =>APP_URL."/views/layouts/".$this->_layout."/css",
			"route_img" =>APP_URL."/views/layouts/".$this->_layout."/img",
			"route_js"  =>APP_URL."/views/layouts/".$this->_layout."/js",
			"route_bootstrap_css" =>APP_URL."/views/layouts/".$this->_layout."/bootstrap/css",
			"route_bootstrap_img" =>APP_URL."/views/layouts/".$this->_layout."/bootstrap/img",
			"route_bootstrap_js" =>APP_URL."/views/layouts/".$this->_layout."/bootstrap/js"
		);


		$routeView = ROOT."views".DS.$this->_controller.DS.$view.".php";

		//$path = ROOT."controllers".DS.$controller."controller.php";
		//$view= ROOT."views".DS.$controller.DS.$action.".php";
		//echo $view;
		//exit();
		/*$header = ROOT."views".DS."layouts".DS."default".DS."header.phtml";

		$footer = ROOT."views".DS."layouts".DS."default".DS."footer.phtml";*/
		//Llamar la ruta de las carpetas de las librerias
		$header = ROOT."views".DS."layouts".DS.$this->_layout.DS."header.phtml";
		$footer = ROOT."views".DS."layouts".DS.$this->_layout.DS."footer.phtml";


		if (file_exists($routeView)) {
			include_once($header);
			require_once($routeView);
			include_once($footer);
			/*$ob = new $controller();
			$ob->$action($args);*/

			/*if (file_exists($view)) {
				require_once($header);
				require_once($view);
				require_once($footer);
			}else{
				echo "La vista para la acción $action no existe";
			}
*/
		}else{
			throw new Exception("Error Processing view");

		}
	}

	public function __destruct(){
		$this->render($this->_view);
	}



}
