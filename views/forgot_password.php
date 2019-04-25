<?php global $controller; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width">
		<title>Module</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
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
          <?php if (isset($_SESSION['messages'])) $controller->getMessages(); else Forms::getForm('ForgotPasswordForm')->render($_POST); ?>
				</div>
			</div>
		</div>
	</body>
</html>