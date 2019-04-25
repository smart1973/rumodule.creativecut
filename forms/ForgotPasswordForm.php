<?php

class ForgotPasswordForm extends Forms {

  public function render($args = array()) {
    $this->beforeRender(); ?>
    <form class="register-form" method="post">
      <div>
        <input type="text" placeholder="Email" name="email"<?php if (isset($args['email'])) : ?> value="<?php echo $args['email'] ?>"<?php endif; ?>>
        <?php if (isset($this->errors['email'])) : ?><div class="error"><?php echo $this->errors['email'] ?></div><?php endif; ?>
      </div>
      <input type="hidden" name="form_name" value="<?php echo __CLASS__ ?>">
      <input type="hidden" name="form_id" value="<?php echo $this->getFormId(); ?>">
      <input type="submit" value="Восстановить">
    </form>
  <?php }

  public function validate() {
    global $controller;
    $user = $controller->getCurrentUser();
    if ($user['id']) $controller->redirect('/');
    elseif (!isset($_POST['email']) || !is_string($_POST['email']) || !$_POST['email'] || !$controller->isValidEmail($_POST['email'])) $this->setError('email', 'Wrong email');
  }

  public function submit() {
    global $controller;
    if ($user = Models::get('Users')->get(array('email' => $_POST['email']))) {
      $symbols = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $pass = '';
      while (strlen($pass) < 10) {
        $pass .= substr($symbols, rand(0, strlen($symbols) - 1), 1);
      }
      Models::get('Users')->save(array('id' => key($user), 'password' => $pass));
      mail($_POST['email'], 'שחזור סיסמה creativecut', 'הסיסמא חדשה: ' . $pass);
    }
    $controller->setMessage('Новый пароль был отправлен на ваш адрес электронной почты. <a href="/">Войти.</a>');
    $controller->redirect('/forgot-password');
  }
}

?>