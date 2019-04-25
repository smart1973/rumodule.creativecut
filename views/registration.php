<?php global $controller; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width">
		<title>Module</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<link rel="stylesheet" type="text/css" href="/css/login-style.css">
		<link rel="stylesheet" type="text/css" href="/css/mobile.css">
	</head>
	<body class="page-register page-login">
		<div class="wrapper">
			<div class="logo">
				<a href="/">
					<img src="logo.png">
					<img src="logo_mobile.jpg">
				</a>
			</div>
			<div class="content">
				<div class="login-register">
          <form class="register-form" action="/register" method="post">
            <h2>הרשמה</h2>
            <div class="register-description">כדי להתחיל להשתמש בשירותי חיתוך בלייזר, עליך ליצור חשבון כאן. לאחר שתסיים, תוכל להעלות את הקבצים שלך ולקבל הצעת מחיר מיידית.</div>
            <div>
              <input type="text" name="name" placeholder="שם"<?php if (isset($register['name'])) : ?> value="<?php echo $register['name'] ?>"<?php endif; ?>>
              <?php if (isset($register_errors['name'])) : ?><div class="error"><?php echo $register_errors['name'] ?></div><?php endif; ?>
            </div>
						<div>
							<input type="text" name="surname" placeholder="משפחה"<?php if (isset($register['surname'])) : ?> value="<?php echo $register['surname'] ?>"<?php endif; ?>>
							<?php if (isset($register_errors['surname'])) : ?><div class="error"><?php echo $register_errors['surname'] ?></div><?php endif; ?>
						</div>
            <div>
              <input type="text" name="email" placeholder="דואר אלקטרוני"<?php if (isset($register['email'])) : ?> value="<?php echo $register['email'] ?>"<?php endif; ?>>
              <?php if (isset($register_errors['email'])) : ?><div class="error"><?php echo $register_errors['email'] ?></div><?php endif; ?>
            </div>
            <div>
              <input type="text" name="phone" placeholder="טלפון נייד"<?php if (isset($register['phone'])) : ?> value="<?php echo $register['phone'] ?>"<?php endif; ?>>
              <?php if (isset($register_errors['phone'])) : ?><div class="error"><?php echo $register_errors['phone'] ?></div><?php endif; ?>
            </div>
						<div class="o-hidden">
							<input type="text" name="phone_code" placeholder="sms הזן קוד"<?php if (isset($register['phone_code'])) : ?> value="<?php echo $register['phone_code'] ?>"<?php endif; ?>>
							<div id="send-phone-message-spinner"><img src="/images/spinner.png"></div>
							<button id="send-phone-message" class="button">קבל קוד לנייד</button>
							<?php if (isset($register_errors['phone_code'])) : ?><div class="error"><?php echo $register_errors['phone_code'] ?></div><?php endif; ?>
						</div>
            <div>
							<input type="password" name="password" placeholder="בחר סיסמא">
              <?php if (isset($register_errors['password'])) : ?><div class="error"><?php echo $register_errors['password'] ?></div><?php endif; ?>
            </div>
            <div>
              <select name="specialty">
                <option value="0">- בחר את התחום שלך -</option>
                <?php foreach ($specialties as $id => $specialty) : ?>
                <option value="<?php echo $id ?>"<?php if ($register['specialty'] == $id) : ?> selected<?php endif; ?>><?php echo $specialty ?></option>
                <?php endforeach; ?>
              </select>
              <?php if (isset($register_errors['specialty'])) : ?><div class="error"><?php echo $register_errors['specialty'] ?></div><?php endif; ?>
            </div>
            <label class="register-agree-text">
              <input type="checkbox" name="agree-rules" value="1">
              <span>אני מסכים עם <a href="/" class="show-popup" popup-width="1200" popup-height="600" popup-content="<?php echo htmlspecialchars($controller->agreeRules) ?>">תנאי הפרטיות והשימוש באתר</a></span>
							<?php if (isset($register_errors['agree-rules'])) : ?><div class="error"><?php echo $register_errors['agree-rules'] ?></div><?php endif; ?>
            </label>
            <input type="hidden" name="page" value="registration">
            <input type="submit" value="הרשמה">
            <div class="separator mobile"><div>או</div></div>
            <div class="social-login">
              <a id="facebook" class="facebook" target="_blank" href="/facebook">Login width Facebook</a>
              <a id="google" class="google" target="_blank" href="/google">Login width google</a>
            </div>
          </form>
				</div>
			</div>
		</div>
	</body>
</html>