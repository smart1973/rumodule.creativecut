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
	<body class="page-login">
		<div class="wrapper">
			<div class="logo">
				<a href="/">
					<img src="logo.png">
					<img src="logo_mobile.jpg">
				</a>
			</div>
			<div class="content">
				<div class="login-register<?php if (isset($user_additional_data)) : ?> additional-data<?php endif; ?>">
					<?php $controller->getMessages() ?>
					<?php if (isset($user_additional_data)) : ?>
						<form method="post" class="register-additional-data" action="/userAdditionalData">
							<h2>Additional data</h2>
							<div>
								<input type="text" name="name" placeholder="שם"<?php if (isset($user_additional_data['name'])) : ?> value="<?php echo $user_additional_data['name'] ?>"<?php endif; ?>>
								<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
							</div>
							<div>
							<input type="text" name="surname" placeholder="משפחה"<?php if (isset($user_additional_data['surname'])) : ?> value="<?php echo $user_additional_data['surname'] ?>"<?php endif; ?>>
							<?php if (isset($register_errors['surname'])) : ?><div class="error"><?php echo $register_errors['surname'] ?></div><?php endif; ?>
						</div>
							<div>
								<input type="text" name="email" placeholder="דואר אלקטרוני"<?php if (isset($user_additional_data['email'])) : ?> value="<?php echo $user_additional_data['email'] ?>"<?php endif; ?>>
								<?php if (isset($errors['email'])) : ?><div class="error"><?php echo $errors['email'] ?></div><?php endif; ?>
							</div>
							<div>
								<input type="text" name="phone" placeholder="טלפון נייד"<?php if (isset($user_additional_data['phone'])) : ?> value="<?php echo $user_additional_data['phone'] ?>"<?php endif; ?>>
								<?php if (isset($errors['phone'])) : ?><div class="error"><?php echo $errors['phone'] ?></div><?php endif; ?>
							</div>
							<div class="o-hidden">
								<input type="text" name="phone_code" placeholder="sms הזן קוד"<?php if (isset($user_additional_data['phone_code'])) : ?> value="<?php echo $user_additional_data['phone_code'] ?>"<?php endif; ?>>
								<div id="send-phone-message-spinner"><img src="/images/spinner.png"></div>
								<button id="send-phone-message" class="button">קבל קוד לנייד</button>
								<?php if (isset($errors['phone_code'])) : ?><div class="error"><?php echo $errors['phone_code'] ?></div><?php endif; ?>
							</div>
							<div>
								<input type="password" name="password" placeholder="בחר סיסמא">
								<?php if (isset($errors['password'])) : ?><div class="error"><?php echo $errors['password'] ?></div><?php endif; ?>
							</div>
							<div>
								<select name="specialty">
									<option value="0">- בחר את התחום שלך -</option>
									<?php foreach ($specialties as $id => $specialty) : ?>
									<option value="<?php echo $id ?>"<?php if ($user_additional_data['specialty'] == $id) : ?> selected<?php endif; ?>><?php echo $specialty ?></option>
									<?php endforeach; ?>
								</select>
								<?php if (isset($errors['specialty'])) : ?><div class="error"><?php echo $errors['specialty'] ?></div><?php endif; ?>
							</div>
							<input type="submit" value="הרשמה">
						</form>
					<?php else : ?>
						<form class="login-form" action="/login" method="post">
							<h2>Авторизация</h2>
							<div>
								<input type="text" name="email" placeholder="Email"<?php if (isset($login['email'])) : ?> value="<?php echo $login['email'] ?>"<?php endif; ?>>
								<?php if (isset($login_errors['email'])) : ?><div class="error"><?php echo $login_errors['email'] ?></div><?php endif; ?>
							</div>
							<div>
								<input type="password" name="password" placeholder="Пароль">
								<?php if (isset($login_errors['password'])) : ?><div class="error"><?php echo $login_errors['password'] ?></div><?php endif; ?>
							</div>
							<div class="remember-me-forgot-password">
								<label class="remember-me">
									<input type="checkbox" name="remember" value="1">
									<span>Запомнить меня</span>
								</label>
								<a class="forgot-password blue" href="/forgot-password">Забыли пароль?</a>
							</div>
							<input type="submit" value="Войти">
							<div class="after-submit-text">אין לך חשבון? <a class="blue" href="/registration">הירשם עכשיו</a></div>
							<div class="separator mobile"><div>או</div></div>
							<div class="social-login">
								<a id="facebook" class="facebook" target="_blank" href="/facebook">Login width Facebook</a>
								<a id="google" class="google" target="_blank" href="/google">Login width google</a>
							</div>
							<div class="after-social-text">במידה ויש לך בעיה להיכנס לחשבונך, אנא צור<a class="blue" href="http://creativecut.co.il/%D7%A6%D7%95%D7%A8-%D7%A7%D7%A9%D7%A8/"> איתנו קשר</a></div>
						</form>
						<form class="register-form" action="/register" method="post">
							<h2>Регистрация</h2>
							<div class="register-description">
								Чтобы начать пользоваться услугами лазерной резки, вам необходимо зарегистрироваться здесь. Как только вы закончите, вы можете загрузить свои файлы и получить мгновенное предложение.
							</div>
							<div>
								<input type="text" name="name" placeholder="Имя"<?php if (isset($register['name'])) : ?> value="<?php echo $register['name'] ?>"<?php endif; ?>>
								<?php if (isset($register_errors['name'])) : ?><div class="error"><?php echo $register_errors['name'] ?></div><?php endif; ?>
							</div>
							<div>
								<input type="text" name="surname" placeholder="Фамилия"<?php if (isset($register['surname'])) : ?> value="<?php echo $register['surname'] ?>"<?php endif; ?>>
								<?php if (isset($register_errors['surname'])) : ?><div class="error"><?php echo $register_errors['surname'] ?></div><?php endif; ?>
							</div>
							<div>
								<input type="text" name="email" placeholder="Email"<?php if (isset($register['email'])) : ?> value="<?php echo $register['email'] ?>"<?php endif; ?>>
								<?php if (isset($register_errors['email'])) : ?><div class="error"><?php echo $register_errors['email'] ?></div><?php endif; ?>
							</div>
							<div>
								<input type="text" name="phone" placeholder="Телефон"<?php if (isset($register['phone'])) : ?> value="<?php echo $register['phone'] ?>"<?php endif; ?>>
								<?php if (isset($register_errors['phone'])) : ?><div class="error"><?php echo $register_errors['phone'] ?></div><?php endif; ?>
							</div>
							<div class="o-hidden">
								<input type="text" name="phone_code" placeholder="sms код"<?php if (isset($register['phone_code'])) : ?> value="<?php echo $register['phone_code'] ?>"<?php endif; ?>>
								<div id="send-phone-message-spinner"><img src="/images/spinner.png"></div>
								<button id="send-phone-message" class="button">Выслать код</button>
								<?php if (isset($register_errors['phone_code'])) : ?><div class="error"><?php echo $register_errors['phone_code'] ?></div><?php endif; ?>
							</div>
							<div>
								<input type="password" name="password" placeholder="Введите пароль">
								<?php if (isset($register_errors['password'])) : ?><div class="error"><?php echo $register_errors['password'] ?></div><?php endif; ?>
							</div>
							<div>
								<select name="specialty">
									<option value="0">- Выберите специальность -</option>
									<?php foreach ($specialties as $id => $specialty) : ?>
									<option value="<?php echo $id ?>"<?php if ($register['specialty'] == $id) : ?> selected<?php endif; ?>><?php echo $specialty ?></option>
									<?php endforeach; ?>
								</select>
								<?php if (isset($register_errors['specialty'])) : ?><div class="error"><?php echo $register_errors['specialty'] ?></div><?php endif; ?>
							</div>
							<label class="register-agree-text">
								<input type="checkbox" name="agree-rules" value="1">
								<span>Я согласен с <a href="/" class="show-popup" popup-width="1200" popup-height="600" popup-content="<?php echo htmlspecialchars($controller->agreeRules) ?>">условиями конфиденциальности и использования сайта</a></span>
								<?php if (isset($register_errors['agree-rules'])) : ?><div class="error"><?php echo $register_errors['agree-rules'] ?></div><?php endif; ?>
							</label>
							<input type="submit" value="Зарегистрироваться">
							<div class="social-login">
								<a id="facebook" class="facebook" target="_blank" href="/facebook"></a>
								<a id="google" class="google" target="_blank" href="/google"></a>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</body>
</html>