<?php
	include '../main.php';
	$user = new Users($db,$validate);
	$subscribers = $user->getSubscribers();
?>

<div class='subscribers'>
	<h2>Subscriber List</h2>
	<div class='block'>
	<table class='secondTable' style="text-align:center;">
		<thead>
		  <tr>
			<th>Serial</th>
			<th>Email</th>
			<th>Action</th>
		  </tr>
		</thead>
		<tbody>
		<?php
			if(!empty($subscribers)){
				$i = 1;
				foreach($subscribers as $key){
		?>
		  <tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $key['email'];?></td>
			<td><a href='' class='subDel' id='<?php echo $key['subId'];?>'>Delete</a></td>
		  </tr>
		<?php
				}
			}else{
				echo "<tr><td colspan='3'>No Subscribers Found.</td></tr>";
			}
		?>
		</tbody>
	</table>
	</div>
</div>
