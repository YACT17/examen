<?php
/**
* Author Edwin Omar Poot Díaz
*
*/
class Password
{

	public function __construct()
	{
		$this->checkBlowfish();
	}

	public function checkBlowfish(){
		if (!define("CRYPT_BLOWFISH")&&!CRYPT_BLOWFISH ) {
			echo " checkBlowfish no soportado";
			die();
		}
	}

	static public function getPassword($password){
		$option = array("cost"=>7);
		return password_hash($password, PASSWORD_BCRYPT, $option);


	}
	static public function passwordVerify($pass1, $pass2){
		if (password_verify($pass1, $pass2)) {
			return true;
		}
		return false;
	}
}

$password1 = 12345;
$password2 = 12345;

$hash = Password::getPassword($password1);


if(Password::passwordVerify($password2, $hash)){
	/*echo sha1($password1);
	echo "<br>";
	echo md5($password1);
	echo "Contraseñas Validas";
	echo "<br>";*/
	echo $hash;

}else{
	echo "Contraseñas invalidos";
}




?>
