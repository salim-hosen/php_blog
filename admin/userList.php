<?php
	require_once '../main.php';
	$user = new Users($db,$validate);
	$userList = $user->getUsers();
?>

<div class='users'>
	<h2>User List</h2>
	<div class='block'>
	<table class='userlist' style="text-align:center;">
		<thead>
		  <tr>
			<th>Serial</th>
			<th>Username</th>
      <th>Email</th>
      <th>Role</th>
			<th>Action</th>
		  </tr>
		</thead>
		<tbody>
		<?php
			if(!empty($userList)){
				$i = 1;
				foreach($userList as $key){
		?>
		  <tr id="<?php echo $key['userId'];?>">
			<td><?php echo $i++;?></td>
			<td><?php echo $key['username'];?></td>
      <td><?php echo $key['email'];?></td>
      <td><?php
        if($key['status'] == '1'){
          echo "Admin";
        }else if($key['status'] == '2'){
          echo "Editor";
        }else if($key['status'] == '3'){
          echo "Author";
        }
      ?></td>
			<td>
        <a href='' class='userDel'>Delete</a>
      </td>
		  </tr>
		<?php
				}
			}else{
				echo "<tr><td colspan='5' style='text-align: center;'><hr />No User Found.<hr /></td></tr>";
			}
		?>
		</tbody>
	</table>
	</div>
</div>
