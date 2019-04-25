<h1 class="personal-title">Профиль</h1>
<form method="post" id="personal-data" enctype="multipart/form-data">
	<div class="table">
		<div>
			<div>
				<div>
					<label>
						<span>Дата регистрации</span>
					</label>
				</div>
				<div><?php echo date('d.m.Y', $user['register_date']); ?></div>
			</div>
			<div>
				<div>
					<label>
						<span>Имя</span>
					</label>
				</div>
				<div>
					<input id="field-name" type="text" name="name" value="<?php echo $user['name'] ?>">
					<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Фамилия</span>
					</label>
				</div>
				<div>
					<input id="field-surname" type="text" name="surname" value="<?php echo $user['surname'] ?>">
					<?php if (isset($errors['surname'])) : ?><div class="error"><?php echo $errors['surname'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Email</span>
					</label>
				</div>
				<div>
					<input id="field-email" type="text" name="email" value="<?php echo $user['email'] ?>">
					<?php if (isset($errors['email'])) : ?><div class="error"><?php echo $errors['email'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Телефон</span>
					</label>
				</div>
				<div>
					<input id="field-phone" type="text" name="phone" value="<?php echo $user['phone'] ?>">
					<?php if (isset($errors['phone'])) : ?><div class="error"><?php echo $errors['phone'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Специальность</span>
					</label>
				</div>
				<div><?php echo $specialties[$user['specialty']] ?></div>
			</div>
			<?php if ($user['specialty'] == 1) : ?>
			<div>
				<div>
					<label>
						<span>Наименование учреждения</span>
					</label>
				</div>
				<div>
					<input type="text" id="field-educational-institution" name="educational_institution" value="<?php echo $user['educational_institution'] ?>">
					<?php if (isset($errors['educational_institution'])) : ?><div class="error"><?php echo $errors['educational_institution'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Год обучения</span>
					</label>
				</div>
				<div>
					<input type="text" id="field-department" name="department" value="<?php echo $user['department'] ?>">
					<?php if (isset($errors['department'])) : ?><div class="error"><?php echo $errors['department'] ?></div><?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
			<div>
				<div>
					<label>
						<span>Город</span>
					</label>
				</div>
				<div>
					<input id="field-city" type="text" name="city" value="<?php echo $user['city'] ?>">
					<?php if (isset($errors['city'])) : ?><div class="error"><?php echo $errors['city'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Улица</span>
					</label>
				</div>
				<div>
					<input id="field-street" type="text" name="street" value="<?php echo $user['street'] ?>">
					<?php if (isset($errors['street'])) : ?><div class="error"><?php echo $errors['street'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Номер дома</span>
					</label>
				</div>
				<div>
					<input id="field-house-number" type="text" name="house_number" value="<?php echo $user['house_number'] ?>">
					<?php if (isset($errors['house_number'])) : ?><div class="error"><?php echo $errors['house_number'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Индекс</span>
					</label>
				</div>
				<div>
					<input id="field-index" type="text" name="post_index" value="<?php echo $user['post_index'] ?>">
					<?php if (isset($errors['post_index'])) : ?><div class="error"><?php echo $errors['post_index'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Пароль</span>
					</label>
				</div>
				<div>
					<input id="field-password" type="password" name="password">
					<?php if (isset($errors['password'])) : ?><div class="error"><?php echo $errors['password'] ?></div><?php endif; ?>
				</div>
			</div>
			<div>
				<div>
					<label>
						<span>Фото профиля</span>
					</label>
				</div>
				<div>
					<?php if ($user['image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/files/' . $user['image'])) : ?>
					<img src="<?php echo CropImage::getImage($user['image'], '200x200'); ?>">
					<div class="mt-10 mb-10">
						<label>
							Delete image:
							<input type="checkbox" name="delete_image">
						</label>
					</div>
					<?php endif; ?>
					<input id="field-image" type="file" name="image">
					<?php if (isset($errors['image'])) : ?><div class="error"><?php echo $errors['image'] ?></div><?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<input type="submit" value="Сохранить" class="creativecut-button blue-button">
</form>