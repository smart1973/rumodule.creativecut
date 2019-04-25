<!DOCTYPE html>
<html id="login-page">
  <head>
    <link rel="stylesheet" type="text/css" href="/css/a-panel/style.css">
  </head>
  <body>
    <table id="login-table">
      <tbody>
        <tr>
          <td>
            <form method="post" action="/a-panel/login">
              <label>Login: <input type="text" name="login"<?php if (isset($_POST['login'])) : ?> value="<?php echo $_POST['login'] ?>"<?php endif; ?>></label>
              <label>Password: <input type="password" name="password"></label>
              <input type="submit" name="submit" value="Login">
            </form>
            <?php if (isset($error)) : ?><div class="error">Wrong login or password</div><?php endif; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>