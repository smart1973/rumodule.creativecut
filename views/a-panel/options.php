<div id="content-wrapper">
  <div id="section-title">
    Options
  </div>
  <form method="post" action="/a-panel/saveOptions" enctype="multipart/form-data">
    <table class="form-edit">
      <tbody>
        <tr>
          <th>Laser price per minute: </th>
          <td>
						<input type="text" name="options[laser_price_per_minute]"<?php if (isset($options['laser_price_per_minute'])) : ?> value="<?php echo htmlspecialchars($options['laser_price_per_minute']) ?>"<?php endif; ?>>
						<?php if (isset($errors['laser_price_per_minute'])) : ?><div class="error"><?php echo $errors['laser_price_per_minute'] ?></div><?php endif; ?>
					</td>
        </tr>
				<?php foreach (Models::get('Specialties')->get() as $id => $name) : ?>
				<tr>
          <th>Laser price per minute for <?php echo $name ?>: </th>
          <td>
						<input type="text" name="options[laser_price_per_minute_<?php echo $id ?>]"<?php if (isset($options['laser_price_per_minute_' . $id])) : ?> value="<?php echo htmlspecialchars($options['laser_price_per_minute_' . $id]) ?>"<?php endif; ?>>
						<?php if (isset($errors['laser_price_per_minute_' . $id])) : ?><div class="error"><?php echo $errors['laser_price_per_minute_' . $id] ?></div><?php endif; ?>
					</td>
        </tr>
				<?php endforeach; ?>
				<tr>
          <th>Time line speed: </th>
          <td>
						<input type="text" name="options[distance_between_objects_speed]"<?php if (isset($options['distance_between_objects_speed'])) : ?> value="<?php echo htmlspecialchars($options['distance_between_objects_speed']) ?>"<?php endif; ?>>
						<?php if (isset($errors['distance_between_objects_speed'])) : ?><div class="error"><?php echo $errors['distance_between_objects_speed'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Time line price: </th>
          <td>
						<input type="text" name="options[distance_between_objects_price]"<?php if (isset($options['distance_between_objects_price'])) : ?> value="<?php echo htmlspecialchars($options['distance_between_objects_price']) ?>"<?php endif; ?>>
						<?php if (isset($errors['distance_between_objects_price'])) : ?><div class="error"><?php echo $errors['distance_between_objects_price'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Tax: </th>
          <td>
						<input type="text" name="options[tax]"<?php if (isset($options['tax'])) : ?> value="<?php echo htmlspecialchars($options['tax']) ?>"<?php endif; ?>>
						<?php if (isset($errors['tax'])) : ?><div class="error"><?php echo $errors['tax'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Price minimum: </th>
          <td>
						<input type="text" name="options[price_minimum]"<?php if (isset($options['price_minimum'])) : ?> value="<?php echo htmlspecialchars($options['price_minimum']) ?>"<?php endif; ?>>
						<?php if (isset($errors['price_minimum'])) : ?><div class="error"><?php echo $errors['price_minimum'] ?></div><?php endif; ?>
					</td>
        </tr>
				<?php foreach (Models::get('Specialties')->get() as $id => $name) : ?>
				<tr>
          <th>Price minimum for <?php echo $name ?>: </th>
          <td>
						<input type="text" name="options[price_minimum_<?php echo $id ?>]"<?php if (isset($options['price_minimum_' . $id])) : ?> value="<?php echo htmlspecialchars($options['price_minimum_' . $id]) ?>"<?php endif; ?>>
						<?php if (isset($errors['price_minimum_' . $id])) : ?><div class="error"><?php echo $errors['price_minimum_' . $id] ?></div><?php endif; ?>
					</td>
        </tr>
				<?php endforeach; ?>
        <tr>
          <th></th>
          <td>
            <input type="submit" value="Save" name="save">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>