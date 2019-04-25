<div id="content-wrapper">
  <div id="section-title">
    Coupon mailing
  </div>
  <form method="post" action="/a-panel/sendCouponMailing" enctype="multipart/form-data">
    <table class="form-edit">
      <tbody>
        <tr>
          <th>Specialties: </th>
          <td>
						<select name="specialties">
							<option value="0">All</option>
							<?php foreach ($specialties as $id => $specialty) : ?>
							<option value="<?php echo $id ?>"<?php if (isset($_POST['specialties']) && $_POST['specialties'] == $id) : ?> selected<?php endif; ?>><?php echo $specialty ?></option>
							<?php endforeach; ?>
						</select>
					</td>
        </tr>
				<tr>
          <th>Email: </th>
          <td>
						<input type="text" name="email"<?php if (isset($email)) : ?> value="<?php echo htmlspecialchars($email) ?>"<?php endif; ?>>
						<?php if (isset($errors['email'])) : ?><div class="error"><?php echo $errors['email'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Name: </th>
          <td>
						<input type="text" name="name"<?php if (isset($name)) : ?> value="<?php echo htmlspecialchars($name) ?>"<?php endif; ?>>
						<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Subject: </th>
          <td>
						<input type="text" name="subject"<?php if (isset($subject)) : ?> value="<?php echo htmlspecialchars($subject) ?>"<?php endif; ?>>
						<?php if (isset($errors['subject'])) : ?><div class="error"><?php echo $errors['subject'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Discount(%): </th>
          <td>
						<input type="text" name="discount"<?php if (isset($discount)) : ?> value="<?php echo htmlspecialchars($discount) ?>"<?php endif; ?>>
						<?php if (isset($errors['discount'])) : ?><div class="error"><?php echo $errors['discount'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Valid till: </th>
          <td>
						<?php $mk = mktime(0, 0, 0, date('n') + 1, date('j'), date('Y')); $next_month = array(date('j', $mk), date('n', $mk), date('Y', $mk)); ?>
						<select name="valid_till_day">
							<?php for ($i = 1; $i <= 31; $i++) : ?>
							<option value="<?php echo $i ?>"<?php if ((isset($valid_till_day) && $valid_till_day == $i) || (!isset($valid_till_day) && $next_month[0] == $i)) : ?> selected<?php endif; ?>><?php echo $i ?></option>
							<?php endfor; ?>
						</select>
						<select name="valid_till_month">
							<?php for ($i = 1; $i <= 12; $i++) : ?>
							<option value="<?php echo $i ?>"<?php if ((isset($valid_till_month) && $valid_till_month == $i) || (!isset($valid_till_month) && $next_month[1] == $i)) : ?> selected<?php endif; ?>><?php echo $i ?></option>
							<?php endfor; ?>
						</select>
						<select name="valid_till_year">
							<?php for ($i = 0; $i < 5; $i++) : ?>
							<option value="<?php echo date('Y') + $i ?>"<?php if ((isset($valid_till_year) && $valid_till_year == date('Y') + $i) || (!isset($valid_till_year) && $next_month[2] == date('Y') + $i)) : ?> selected<?php endif; ?>><?php echo date('Y') + $i ?></option>
							<?php endfor; ?>
						</select>
						<?php if (isset($errors['date'])) : ?><div class="error"><?php echo $errors['date'] ?></div><?php endif; ?>
					</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <input type="submit" value="Send" name="send">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>