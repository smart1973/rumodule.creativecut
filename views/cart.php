<div class="content">
  <div id="cart-page">
    <h1>Корзина</h1>
    <?php if ($bids) : $total_price = 0; $tax = 0;?>
		<div class="order">Заказ <?php echo $order['id'] ?></div>
		<form action="/cart" method="post">
			<table id="cart" class="styled-table">
				<thead>
					<tr>
						<th>Название</th>
						<th>
							<div class="bid-quantity">Количество</div>
						</th>
						<th>Цена</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($bids as $bid) : $total_price += $bid['data']['total_price']; $tax += $bid['data']['tax']; ?>
				<tr bid-price="<?php echo $bid['data']['total_price'] ?>" bid-tax="<?php echo $bid['data']['tax'] ?>">
					<td>
						<div class="bid-image">
							<img src="/graphic_files/preview/<?php echo $bid['id'] ?>.png">
							<div>ID: <?php echo $bid['id'] ?></div>
						</div>
						<div class="bid-data-wrapper">
							<div class="bid-data">
								<div class="bid-file-name"><?php echo $bid['file_name'] ?></div>
								<div class="bid-material-size">
									<span>חומר - </span><?php echo $bid['mname'] ?> <?php echo $bid['msname'] ?>
								</div>
								<div class="bid-size">
									<span>גודל - </span><?php echo $bid['data']['work_width'] ?>/<?php echo $bid['data']['work_height'] ?> מ׳׳מ
								</div>
							</div>
						</div>
					</td>
					<td>
						<div class="bid-quantity">
							<input type="number" min="1" name="quantity[<?php echo $bid['id'] ?>]" value="<?php echo isset($_POST['quantity'][$bid['id']]) ? $_POST['quantity'][$bid['id']] : 1 ?>">
							<?php if (isset($errors['quantity'][$bid['id']])) : ?><div class="error"><?php echo $errors['quantity'][$bid['id']]; ?></div><?php endif; ?>
						</div>
					</td>
					<td>
						<div class="bid-price">
							<div class="bid-price-value">
								<?php echo $bid['data']['total_price'] ?> ש"ח
							</div>
							<a onclick="return creativecut_confirm('<?php echo 'Удалить из корзины товар ' . $bid['id'] . '' ?>', function () {window.location.href = '/cart?delete_from_cart=<?php echo $bid['id'] ?>';})" href="/cart?delete_from_cart=<?php echo $bid['id'] ?>">Удалить</a>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<div id="cart-form-wrapper">
				<div id="cart-form-fields">
					<div>
						<label>
							<input placeholder="Промокод" type="text" name="coupon"<?php if (isset($_POST['coupon'])) : ?> value="<?php echo htmlspecialchars($_POST['coupon']) ?>"<?php endif; ?>>
						</label>
						<?php if (isset($errors['coupon'])) : ?><div class="error"><?php echo $errors['coupon']; ?></div><?php endif; ?>
					</div>
					<div class="mb-30">
						<button id="cart-check-coupon" class="creativecut-button blue-button">Введите промокод</button>
					</div>
					<div class="delivery-times">
						<?php foreach ($dtimes as $dtime) : ?>
						<label>
							<input type="radio" name="delivery_time" price="<?php echo $dtime['price'] ?>" value="<?php echo $dtime['id'] ?>"<?php if ((isset($_POST['delivery_time']) && $_POST['delivery_time'] == $dtime['id']) || (!isset($_POST['delivery_time']) && $dtime['by_default'])) : ?> checked<?php endif; ?>>
							<span><?php echo $dtime['name'] ?></span>
						</label>
						<?php endforeach; ?>
						<?php if (isset($errors['delivery_time'])) : ?><div class="error"><?php echo $errors['delivery_time']; ?></div><?php endif; ?>
					</div>
					<div>Информация о доставке</div>
					<div>
						<label>
							<div>Имя*</div>
							<input type="text" name="name"<?php if (isset($values['name'])) : ?> value="<?php echo htmlspecialchars($values['name']) ?>"<?php endif; ?>>
						</label>
						<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name']; ?></div><?php endif; ?>
					</div>
					<div>
						<label>
							<div>Фамилия*</div>
							<input type="text" name="surname"<?php if (isset($values['surname'])) : ?> value="<?php echo htmlspecialchars($values['surname']) ?>"<?php endif; ?>>
						</label>
						<?php if (isset($errors['surname'])) : ?><div class="error"><?php echo $errors['surname']; ?></div><?php endif; ?>
					</div>
					<div class="cart-city">
						<label for="cart-input-city">Город</label>
						<div class="smart-input">
							<input id="cart-input-city" autocomplete="off" type="text" name="city"<?php if (isset($values['city'])) : ?> value="<?php echo htmlspecialchars($values['city']) ?>"<?php endif; ?>>
							<ul>
								<?php foreach (Models::get('Cities')->get() as $city) : ?>
								<li><?php echo $city['name'] ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php if (isset($errors['city'])) : ?><div class="error"><?php echo $errors['city']; ?></div><?php endif; ?>
					</div>
					<div>
						<label>
							<div>Улица</div>
							<input type="text" name="street"<?php if (isset($values['street'])) : ?> value="<?php echo htmlspecialchars($values['street']) ?>"<?php endif; ?>>
						</label>
						<?php if (isset($errors['street'])) : ?><div class="error"><?php echo $errors['street']; ?></div><?php endif; ?>
					</div>
					<div>
						<label>
							<div>Номер дома</div>
							<input type="text" name="house_number"<?php if (isset($values['house_number'])) : ?> value="<?php echo htmlspecialchars($values['house_number']) ?>"<?php endif; ?>>
						</label>
						<?php if (isset($errors['house_number'])) : ?><div class="error"><?php echo $errors['house_number']; ?></div><?php endif; ?>
					</div>
					<div class="mb-30">
						<label>
							<div>Индекс</div>
							<input type="text" name="post_index"<?php if (isset($values['post_index'])) : ?> value="<?php echo htmlspecialchars($values['post_index']) ?>"<?php endif; ?>>
						</label>
						<?php if (isset($errors['post_index'])) : ?><div class="error"><?php echo $errors['post_index']; ?></div><?php endif; ?>
					</div>
					<div>Детали счета:</div>
					<div>
						<label>
							<div>*Имя/название компании</div>
							<input type="text" name="company_name"<?php if (isset($values['company_name'])) : ?> value="<?php echo htmlspecialchars($values['company_name']) ?>"<?php endif; ?>>
						</label>
						<?php if (isset($errors['company_name'])) : ?><div class="error"><?php echo $errors['company_name']; ?></div><?php endif; ?>
					</div>
					<div>
						<label>
							<div>*P / Z / P</div>
							<input type="text" name="company_id"<?php if (isset($values['company_id'])) : ?> value="<?php echo htmlspecialchars($values['company_id']) ?>"<?php endif; ?>>
						</label>
						<?php if (isset($errors['company_id'])) : ?><div class="error"><?php echo $errors['company_id']; ?></div><?php endif; ?>
					</div>
					<div>
						<label>
							<input type="checkbox" name="agree-rules" value="1">
							<span>Я согласен с <a href="/" class="show-popup" popup-width="1200" popup-height="600" popup-content="<?php echo htmlspecialchars($rules) ?>">условиями конфиденциальности и использования сайта</a></span>
							<?php if (isset($errors['agree-rules'])) : ?><div class="error"><?php echo $errors['agree-rules'] ?></div><?php endif; ?>
						</label>
					</div>
					<input type="submit" class="creativecut-button blue-button" value="Заказать">
				</div>
				<div id="cart-data">
					<div id="cart-data-top">
						<div>
							<span>Цена доставки</span>
							<span>
								<span id="cart-delivery-price"><?php $delivery_price = 0; foreach ($dtimes as $dtime) {if ($dtime['by_default']) $delivery_price = $dtime['price'];} echo number_format($delivery_price, 2, '.', ','); ?></span> ש"ח
							</span>
						</div>
						<div>
							<span>Итого</span>
							<span>
								<span id="cart-price-for-bids"><?php echo number_format($total_price, 2, '.', ',') ?></span> ש"ח
							</span>
						</div>
						<div>
							<span>НДС</span>
							<span>
								<span id="cart-tax"><?php echo number_format($tax, 2, '.', ',') ?></span> ש"ח
							</span>
						</div>
						<div id="cart-discount-wrapper">
							<span>Discount</span>
							<span>
								<span id="cart-discount" discount-percents="0">0</span> ש"ח
							</span>
						</div>
					</div>
					<div id="cart-total-price-wrapper">
						<span>Итого с НДС</span>
						<span>
							<span id="cart-total-price"><?php echo number_format($total_price + $delivery_price + $tax, 2, '.', ',') ?></span> ש"ח
						</span>
					</div>
					<div id="cart-logotips-wrapper">
						<div>Сайт защищен в соответствии с требованиями компаний-эмитентов кредитных карт в соответствии со стандартом PCI. Кредитная информация не сохраняется на сайте</div>
						<ul class="cart-logotips" style="direction: ltr;">
							<?php for ($i = 1; $i <= 2; $i++) : ?>
							<li>
								<img src="/images/logo<?php echo $i ?>.png">
							</li>
							<?php endfor; ?>
						</ul>
						<div>Этот сайт принимает оплату кредитной картой.</div>
						<ul class="cart-logotips">
							<?php for ($i = 3; $i <= 6; $i++) : ?>
							<li>
								<img src="/images/logo<?php echo $i ?>.png">
							</li>
							<?php endfor; ?>
						</ul>
					</div>
				</div>
			</div>
		</form>
		<?php else : ?>
		<div class="empty-cart">Ваша корзина пуста</div>
		<?php endif; ?>
  </div>
</div>