<?php

/**
*
*/
class ClassPDO
{

	public  $connection;
	private $dns; //Caddena de conexion
	private $drive;
	private $host;
	private $database;
	private $username;
	private $password;
	public  $result;
	public  $lastInsertId;
	public  $numbersRows; #Numero de filas


	public function __construct(
		$drive = "mysql",
		$host = "localhost",
		$database = "test",
		$username = "root",
		$password = ""
		){
		$this->drive = $drive;
		$this->host = $host;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->connection();
		//parent:: __construct();
	}

	public function connection(){
		$this->dsn = $this->drive.':host='.
		$this->host.';dbname='.$this->database;

		try {
			$this->connection = new PDO(
				$this->dsn,
				$this->username,
				$this->password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
			die();
		}
	}




	public function save($table, $data = array()){
		$sql = "SELECT * FROM $table";
		$result = $this->connection->query($sql);
		//Extraer el nombre de las columnas
		for ($i=0; $i < $result->columnCount(); $i++) {
			$meta = $result->getColumnMeta($i);
			$fields[$meta["name"]]=NULL;
		}
		$fieldsToSave = "id";
		$valuesToSave = "NULL";

		foreach ($data as $key => $value) {
			if (array_key_exists($key, $fields)) {
				$fieldsToSave .= ",".$key;
				$valuesToSave .= ","."\"$value\"";
			}
		}

		$sql = "INSERT INTO $table ($fieldsToSave) VALUES ($valuesToSave);";

		$this->result = $this->connection->query($sql);


		return $this->result;
	}

	public function update($table, $data = array()){
		$sql = "SELECT * FROM $table";
		$result = $this->connection->query($sql);
		//Extraer el nombre de las columnas
		for ($i=0; $i < $result->columnCount(); $i++) {
			$meta = $result->getColumnMeta($i);
			$fields[$meta["name"]]=NULL;
		}
		if (array_key_exists("id", $data)) {
			$fieldsToSave = "";
			$id = $data["id"];
			//Eliminamo el id para que no se modifique en el db
			unset($data["id"]);
			//$id = array_shift($data["id"]);
			foreach ($data as $key => $value) {
				if (array_key_exists($key, $fields)) {
					$fieldsToSave .=$key."="."\"$value\", ";
				}
			}
			//quitar la coma y espacio
			$fieldsToSave = substr_replace($fieldsToSave, "", -2);
			$sql ="UPDATE $table SET $fieldsToSave WHERE $table.id=$id";
		}
		$this->result = $this->connection->query($sql);
		return $this->result;
	}

	public function delete($table, $condition){
		$sql = "DELETE FROM $table WHERE $condition";
		$this->result = $this->connection->query($sql);
		return $this->result;
	}

	public function find($table, $query=NULL, $options=array()){
		$fields = "*";
		$parameters ="";
		if (!empty($options["field"])) {
			$fields = $options["field"];
		}
		if (!empty($options["conditions"])) {
			$parameters = " WHERE ". $options['conditions'];
		}
		if (!empty($options["group"])) {
			$parameters .= " GROUP BY " .$options['group'];
		}
		if (!empty($options["order"])) {
			$parameters .= " ORDER BY " .$options['order'];
		}
		if (!empty($options["limit"])) {
			$parameters .= " LIMIT " .$options['limit'];
		}

		switch ($query) {
			case 'all':
					all:
				$sql ="SELECT $fields FROM $table".$parameters;
				$this->result = $this->connection->query($sql);

				foreach (range(0, $this->result->columnCount() -1) as $column_index) {
					$meta[] = $this->result->getColumnMeta($column_index);
				}

				$records = $this->result->fetchALL(PDO::FETCH_NUM);
				for ($i=0; $i < count($records); $i++) {
					$j = 0;
					foreach ($meta as $key => $value) {
						$rows[$i][$value["table"]][$value["name"]] = $records[$i][$j];
						$j++;
					}
				}
				if (!empty($rows)) {
					$this->result = $rows;
				}


				break;

				case "first":
					$sql = "SELECT $fields FROM $table".$parameters;
					$result = $this->connection->query($sql);

					$this->result = $result->fetch();
					break;
				case "count":
					$sql = "SELECT COUNT(*) FROM $table".$parameters;
					$result = $this->connection->query($sql);
					$this->result = $result->fetchColumn();
					break;
			default:

				/*$sql ="SELECT $fields FROM $table".$parameters;
				$this->result = $this->connection->query($sql);

				foreach (range(0, $this->result->columnCount() -1) as $column_index) {
					$meta[] = $this->result->getColumnMeta($column_index);
				}

				$records = $this->result->fetchALL(PDO::FETCH_NUM);
				for ($i=0; $i < count($records); $i++) {
					$j = 0;
					foreach ($meta as $key => $value) {
						$rows[$i][$value["table"]][$value["name"]] = $records[$i][$j];
						$j++;
					}
				}
				$this->result = $rows;*/
				//Es una propiedad de php qe nos permite tomar algunas funciones especificicas de la clases
				//Es una ancla
				goto all;

				break;
		}
		return $this->result;
	}


}
