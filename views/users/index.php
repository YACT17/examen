<div class="contenedor">
<h2>Listado de usuarios</h2>
 <?php if (!empty($users)): ?>


<h4>Número de usuario</h4>
<div class=""><?php echo $usersCount; ?></div>

<table class="table table-bordered responsive" id="table">
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>Password</th>
		<th>Type</th>
		<th>Accion</th>
	</tr>
	<?php foreach ($users as $user): ?>

	 <tr>
	 	<td><?php echo $user["users"]["id"]; ?> </td>
	 	<td><?php echo $user["users"]["name"]; ?> </td>
	 	<td><?php echo $user["users"]["password"]; ?> </td>
	 	<td><?php echo $user["types"]["name"]; ?> </td>
	 	<td>
      <?php
      echo $this->Html->link("Edit", array(
          "controller"=>"users",
          "method"=>"edit",
          "arg"=>$user["users"]["id"]
      ));
      ?>

      <?php
      echo  $this->Html->link("Delete", array(
          "controller"=>"users",
          "method"=>"delete",
          "arg"=>$user["users"]["id"]
      ));
      ?>
      <a href="<?php echo APP_URL."/users/edit/".$user["users"]["id"]?>" class="delete" >Edit</a>
			<a href="<?php echo APP_URL."/users/delete/".$user["users"]["id"]?>" class="delete">Delete</a>
	 	</td>
	 </tr>
	<?php endforeach; ?>

</table>

<?php  endif; ?>
</div>
<!-- //Los valores son recibidos por la vista desde el controlador usersController
//echo "<pre>"; -->
