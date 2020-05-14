<?php
	include '../main.php';
	$user = new Users($db,$validate);
	$msgs = $user->getMessages();
?>

<div class='contactList'>
	<h2>Message List</h2>
	<div class='block'>
	<table class='messageList'>
		<thead>
		  <tr>
			<th width='5%'>Serial</th>
			<th width='25%'>Email</th>
			<th width='40%'>Message</th>
			<th width='30%'>Action</th>
		  </tr>
		</thead>
		<tbody>
		 <?php
			if(!empty($msgs)){
				$i = 1;
				foreach($msgs as $key){
		?>
		  <tr id="<?php echo $key['conId'];?>" style="<?php if($key['status'] == '0')echo 'color:#707070;'?>">
			<td><?php echo $i++;?></td>
			<td><?php echo $key['email'];?></td>
			<td><?php
				if(strlen($key['message']) > 50){
					echo substr($key['message'],0,50)."...";
				}else{
					echo $key['message']."...";
				}
			?></td>
			<td><a href="" id="view">View</a><a id='delMsg' href="">Delete</a></td>
		  </tr>
		<?php
				}
			}else{
				echo "<tr style='text-align:center;'><td colspan='4'>No Messages Found.</td></tr>";
			}
		?>
		</tbody>
	</table>
	</div>
</div>
