<?php

/**
*
*/
class usersController extends AppsController
{
	function __construct()
	{
		parent::__construct();
	}

	public function index(){
		//Es para agregar la ruta de las librerias
		$this->_view->setlayout("website");
		//Estos valores se envian en la vista de los usuarios index.php
		/*$users = array(

				"Root",
				"Admin",
				"Test",
				"Soporte"
			/*),
			"name"=>array(
				"Juan",
				"Kevin",
				"Bryan"
			)

		);*/
		//$users = $this->find("users", "all");

		//Nombre del arreglo
		//Cacha todos los valores
		//$this->find("users", $this->find("users", "all"));

		//$this->_view->_users = $users;
		//$users = $this->find("users", "all");

		//Nombre del arreglo
		//Cacha todos los valores

		//var_dump($this);

		//Primera opción
		/*$this->set("users" ,$this->users->find("users", "all") );
		$this->set("usersCount" ,$this->users->find("users", "count") );*/

		/*Hacer la consulta en la table users and types*/
		$conditions = array("conditions" => "users.type_id=types.id");

		//Segunda opción
		$users = $this->users->find("users , types", "all", $conditions);
		$usersCount = $this->users->find("users", "count");
		$this->set("users", $users);
		$this->set("usersCount", $usersCount);
		/*//Tercera opción
		$users = $this->users->find("users", "all");
		$usersCount = $this->users->find("users", "count");
		$this->set(compact("users", "usersCount"));*/
	}

	public function add(){
		if ($_SESSION["type_name"]=="Administradores") {

		if ($_POST) {

				/*include_once(ROOT."libs".DS."password.php");

				$pass = new Password();
				echo $_POST["password"] = $pass->getPassword($_POST["password"]);*/
				//include_once(ROOT."libs".DS."password.php");
				$pass = new Password();
				$_POST["password"] = $pass->getPassword($_POST["password"]);
			//Manda los valores en la funcion save para guardar los registros
			if ($this->users->save("users",$_POST )) {


				$this->redirect(array("controller"=>"users"));

			}else{
				$this->redirect(array("controller"=>"users", "method"=>"add"));
			}
		}
		//Hacemos referencia a la tabla types
		$this->set("types", $this->users->find("types"));
		//Es una funcion indicamos que vista queremos visualizar
		$this->_view->setView("add");

	}else {
			$this->redirect(array("controller"=>"users"));
	}

	}

	public function edit($id){
		if ($_GET) {
			//print_r($_GET);
			//$this->set("id", $id);
			if ($id){
				$options = array("conditions"=>"id=".$id);
				$user = $this->users->find("users", "first", $options);
				$this->set("user", $user);
				//Hacemos referencia a la tabla types
				$this->set("types", $this->users->find("types"));
			}else{
				//Redirecciona cuando se hace la peticion de update
				//$this->redirect(array("controller"=>"users"));
			}
			//Comporbar si esta recibiendo los datos con el $_POST
			if ($_POST) {
				print_r($_POST);
				if (!empty($_POST["newPassword"])) {
					$pass = new Password();
					$_POST["password"] = $pass->getPassword($_POST["newPassword"]);
					//$_POST["password"] = $_POST["newPassword"];
				}
				//Primero le mandamo el nombre d ela tabla y luego el POST es dondo estan almacenados los datos a editar
				if ($this->users->update("users", $_POST)) {
					$this->redirect(array("controller"=>"users"));
				}else{
				$this->redirect(array("controller"=>"users", "method"=>"edit/".$_POST["id"]));

				}




			}

		}

	}


	public function delete($id){
		$conditions = "id=".$id;

		if ($_GET) {
			if ($this->users->delete("users", $conditions)) {
				$this->redirect(array("controller"=>"users"));

			}else{
				$this->redirect(array("controller"=> "users", "method"=>"add"));
			}
		}

	}

	public function login(){
		$this->_view->setLayout("login");

		if ($_POST) {

		$pass = new Password();
		$auth = new Authorization();
		$filter = new Validations();

		$username = $filter->sanitizeText($_POST["name"]);
		$password = $filter->sanitizeText($_POST["password"]);

		$options = array(
		"field" =>
		"users.id as user_id,
		users.password as password,
		users.name as username,
		types.name as type_name",
		"conditions"=>"users.name='$username' and users.type_id=types.id");
		$user = $this->users->find("users, types", "first", $options);


		if ($pass->passwordVerify($password, $user["password"])) {
				$auth->login($user);
				$this->redirect(array("controller"=>"pages"));
		}else {
			echo "Usuario no valido";
		}
	}
}
	public function logout(){
		$auth = new Authorization();
		$auth->logout();
		$this->_view->render("login");
	}
}
