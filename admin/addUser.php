<h2>Add User</h2>
<div class="addUser">
    <form id="addUserForm" action="" method="post" autocomplete="off">
      <table>
        <tbody>
          <tr>
            <td>Username</td>
            <td><input type="text" name="username" required/></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><input type="email" name="email" required/></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="password" name="password" required/></td>
          </tr>
          <tr>
            <td>Role</td>
            <td>
              <select name="role" required>
                <option value="">Select Role</option>
                <option value="1">Admin</option>
                <option value="2">Editor</option>
                <option value="3">Author</option>
              </select>
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="submit" value="Add"/></td>
          </tr>
        </tbody>
      </table>
    </form>
</div>
