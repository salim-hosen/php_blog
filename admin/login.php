<?php
  require_once "../lib/Session.php";
  Session::init();
  if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] === true){
    exit(header("Location: index.php"));
  }
?>
<!doctype html>

<html lang="en-US">
  <head>
    <title>Simple Blog Site</title>
    <link href="../css/style.css" type="text/css" rel="stylesheet"/>
    <link href="../fa/css/fontawesome-all.min.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/admin.js"></script>
  </head>
  <body>
    <div id="wrapper">
      <section style="background:#fff;" class="main container">
        <h3>Login Form</h3>
        <div class="login">
          <form id="userLogin" method="post">
            <table>
              <tbody>
                <tr>
                  <td><label>Username</label></td>
                  <td><input required type="text" name="username"/></td>
                </tr>
                <tr>
                  <td><label>Password</label></td>
                  <td><input required type="password" name="password"/></td>
                </tr>
                <tr>
                  <td></td>
                  <td><input type="submit" name="login" value="Login"/></td>
                </tr>
                <tr>
                  <td></td>
                  <td>Forgot Password? <a style="display: inline;" href="resetPass.php">Click Here</a></td>
                </tr>
              </tbody>
            </table>
          </form>
		  
		<div class="success" style="padding:10px;font-size: 18px;">
			<p>Username: <b>admin</b></p>
			<p>Password: <b>password</b></p>
		</div>
        </div>
      </section>
      <footer class="footerSec">
        <div class="copyright">
          <p>&copy; By Salim Hosen 2018</p>
        </div>
      </footer>
    </div>
    <section class="notificationBox">
      <div id="notification">
        <p>Error Occured.</p>
      </div>
    </section>
  </body>
</html>
