<?php global $controller; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width">
		<title><?php if (isset($title)) echo $title ?></title>
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<link rel="stylesheet" type="text/css" href="/css/logged-in-style.css">
		<link rel="stylesheet" type="text/css" href="/css/mobile.css">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="/js/help-plugin.js"></script>
		<script type="text/javascript" src="/js/script.js"></script>
	</head>
	<body class="logged-in<?php if (isset($body_classes)) : ?> <?php echo $body_classes ?><?php endif; ?>">
		<div class="wrapper">
			<header>
				<div class="header-inner">
					<div class="logo">
						<img src="/logo2.png">
						<img src="/logo_mobile.jpg">
					</div>
					<ul id="creativecut-menu">
						<li>
							<a href="http://creativecut.co.il/" target="_blank">Главная</a>
						</li>
						<li>
							<a href="http://creativecut.co.il/leasertype/" target="_blank">Лазерная резка</a>
						</li>
						<li>
							<a href="http://creativecut.co.il/services/" target="_blank">Услуги</a>
						</li>
						<li>
							<a href="http://creativecut.co.il/myworks/" target="_blank">Завод</a>
						</li>
						<li>
							<a href="http://creativecut.co.il/material/" target="_blank">Вещества</a>
						</li>
						<li>
							<a href="http://creativecut.co.il/articles/" target="_blank">Статьи</a>			
						</li>
						<li>
							<a href="http://creativecut.co.il/aboutwe/" target="_blank">О нас</a>
						</li>
						<li>
							<a href="http://creativecut.co.il/contact/" target="_blank">Контакты</a>
						</li>
						<li class="yellow">
							<a href="http://creativecut.co.il/gservices/" target="_blank">Графические услуги</a>
						</li>
					</ul>
					<div class="personal">
						<a href="/" class="repick-file"></a>
						<div>
							<span class="user-image" style="background-image:url(<?php echo $user['image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/files/' . $user['image']) ? CropImage::getImage($user['image'], '50x50') : '/images/default_user.svg' ?>)"></span>
							<div>
								<div id="mobile-menu">
									<div class="mobile-menu"></div>
									<div class="mobile-menu"></div>
									<div class="mobile-menu"></div>
								</div>
								<a href="javascript:void(0)" class="name"><?php echo $user['name'] ?></a>
								<ul>
									<li>
										<a class="upload-file" href="/">Загрузить файлы</a>
									</li>
									<li>
										<a class="your-objects" href="/public-files">Публичные файлы</a>
									</li>
									<li>
										<a class="your-objects" href="/your-objects">Файлы и бронирование</a>
									</li>
									<li>
										<a class="your-objects" href="/your-orders">Счет-фактуры</a>
									</li>
									<li>
										<a class="your-account" href="/personal">Профиль</a>
									</li>
									<li>
										<a class="your-objects" href="/cart">Корзина</a>
									</li>
									<li>
										<a class="logout" href="/logout">Выход</a>
									</li>
								</ul>
							</div>
						</div>
						<?php echo Models::get('Prompts')->getHTML(8); ?>
						<div id="prompts-controll">
							<label class="checkbox-switcher">
								<input type="checkbox" value="1"<?php if (isset($_COOKIE['user_is_newbie']) && $_COOKIE['user_is_newbie'] === 'yes') : ?> checked<?php endif; ?>>
								<div>
									<div></div>
								</div>
							</label>
						</div>
					</div>
				</div>
			</header>
			<?php $controller->getMessages() ?>
			<?php echo $content; ?>
		</div>
<!--		<div class="info-message">
			<div class="info-message-close"></div>
			<div class="info-message-left">
				<div class="info-message-image" style="background-image: url(/images/default_user.svg);"></div>
			</div>
			<div class="info-message-right">
				<div>Barak Zipori</div>
				<a href="http://creativecut.co.il/%D7%A6%D7%95%D7%A8-%D7%A7%D7%A9%D7%A8/" target="_blank">Contacts</a>
			</div>
		</div>-->
		<footer>
			<div class="footer-top">
				<div class="footer-inner">
					<div>
						<img src="/logo.png">
					</div>
					<div>
						<h3>קבל הצעת מחיר אונליין</h3>
						<div>CreativeCut специализируется на лазерной резке по самым передовым и быстрым технологиям с акцентом на качество продукции, маневренность и эффективность. От современных медицинских и электронных устройств до уникальных дизайнерских продуктов и дизайнеров интерьера, архитектурных моделей и работы для студентов. Все сделано аккуратно и с использованием различного сырья по выбору заказчика.</div>
					</div>
					<div>
						<h3>Свяжитесь с нами</h3>
						<div>
							<ul class="contact-data">
								<li>
									<div>Адрес:</div>
									<div>הלהב 6, חולון, ביתן 272</div>
								</li>
								<li>
									<div>Телефон:</div>
									<div>
										<a href="tel:050-4888822">050-4888822</a>
									</div>
								</li>
								<li>
									<div>Телефон:</div>
									<div>
										<a href="tel:03-554-5584">03-554-5584</a>
									</div>
								</li>
								<li>
									<div>Email:</div>
									<div>
										<a href="mailto:info@creativecut.co.il">info@creativecut.co.il</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div>
						<h3>Мы в Facebook</h3>
						<div>
							<iframe width="320px" height="1000px" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" title="fb:page Facebook Social Plugin" src="https://www.facebook.com/v2.3/plugins/page.php?app_id=&amp;channel=http%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter%2Fr%2F2VRzCA39w_9.js%3Fversion%3D42%23cb%3Df1ddc79b4061328%26domain%3Dcreativecut.co.il%26origin%3Dhttp%253A%252F%252Fcreativecut.co.il%252Ff98f4ae2960b78%26relation%3Dparent.parent&amp;container_width=263&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2FCreativeCut1&amp;locale=he_IL&amp;sdk=joey&amp;show_facepile=true&amp;width=320" style="border: none; visibility: visible; width: 263px; height: 180px;" class=""></iframe>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="footer-inner">
					<ul>
						<li>
							<a href="http://creativecut.co.il/aboutwe/">О нас</a>
						</li>
						<li>&nbsp;&nbsp;
							<a href="http://creativecut.co.il/contact/">Свяжитесь с нами</a>
						</li>
					</ul>
				</div>
			</div>
		</footer>
	</body>
</html>