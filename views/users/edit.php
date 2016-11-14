<h2>Usuario editado</h2>



<form action="<?php echo APP_URL."/users/edit/";?>" method="POST" >
	<p>
		<input type="hidden" name="id" value="<?php echo $user["id"] ?>">
	</p>

	<p>
		<label for="username"> Username</label>
		<input type="text" name="name" value="<?php echo $user["name"] ?>">
	</p>
	<p>
		<label for="NewPassword">Password</label>
		<input type="password" name="newPassword" value="">
	</p>
	<p>
		<label for="type_id">Types</label>
		<select name="type_id" id="type_id">
			<?php 
			foreach ($types as $type) :?>
			<?php if ($type["types"]["id"] == $user["type_id"]) {?>
				<option selected value="<?php echo $type["types"]["id"];?>">
					<?php echo $type["types"]["name"];?>
				</option>
			<?php }else{?>

				<option value="<?php echo $type["types"]["id"];?>">
					<?php echo $type["types"]["name"];?>
				</option>
			<?php }?>
			
			 <?php endforeach?>
		</select>
	</p>
	<p>
		<input type="submit" >
	</p>
</form>

