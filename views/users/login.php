<h3>Inicio de sesion</h3>

<form action=""<?php echo APP_URL."/users/login"; ?> method="POST">

	<p>
			<label for="name">Username</label>
			<input type="text" name="name">
	</p>
	<p>
			<label for="password">password</label>
			<input type="password" name="password">
	</p>
	<p>
			<input type="submit" value="Entrar">
	</p>

</form>
