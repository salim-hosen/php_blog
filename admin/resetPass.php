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
        <h3>Password Reset</h3>
        <div class="login">
          <form id="resetPassword" method="post">
            <table>
              <tbody>
                <tr>
                  <td><label>Email</label></td>
                  <td><input required type="email" name="email"/></td>
                </tr>
                <tr>
                  <td></td>
                  <td><input type="submit" name="reset" value="Reset"/></td>
                </tr>
                <tr>
                  <td></td>
                  <td>Go Back to <a style="display: inline;" href="login.php">Login</a></td>
                </tr>
              </tbody>
            </table>
          </form>
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
    <div class="lcon">
      <div class="loader"></div>
    </div>
  </body>
</html>
