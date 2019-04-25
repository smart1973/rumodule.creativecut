<div id="content-wrapper">
  <div id="section-title">
    Users
    <?php if (isset($total_users)) echo '(' . $total_users . ')';  ?>
    <?php if (!$form) : ?><a class="add" href="/a-panel/users/add">Add user</a><?php endif; ?>
  </div>
  <?php if ($form) : ?>
		<div class="tabs">
			<ul>
				<li<?php if (!isset($_GET['orders_page'])) : ?> class="active"<?php endif; ?>>
					<a href="javascript:void(0)">User data</a>
				</li>
				<li<?php if (isset($_GET['orders_page'])) : ?> class="active"<?php endif; ?>>
					<a href="javascript:void(0)">User orders</a>
				</li>
			</ul>
			<ul>
				<li<?php if (!isset($_GET['orders_page'])) : ?> class="active"<?php endif; ?>>
					<form method="post" action="/a-panel/saveUser" enctype="multipart/form-data">
						<table class="form-edit">
							<tbody>
								<tr>
									<th>תאריך הרשמה למערכת: </th>
									<td><?php echo date('d.m.Y', $user['register_date']); ?></td>
								</tr>
								<tr>
									<th>שם פרטי: </th>
									<td>
										<input type="text" name="name"<?php if (isset($user['name'])) : ?> value="<?php echo htmlspecialchars($user['name']) ?>"<?php endif; ?>>
										<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>שם משפחה: </th>
									<td>
										<input type="text" name="surname"<?php if (isset($user['surname'])) : ?> value="<?php echo htmlspecialchars($user['surname']) ?>"<?php endif; ?>>
										<?php if (isset($errors['surname'])) : ?><div class="error"><?php echo $errors['surname'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>אימייל: </th>
									<td>
										<input type="text" name="email"<?php if (isset($user['email'])) : ?> value="<?php echo htmlspecialchars($user['email']) ?>"<?php endif; ?>>
										<?php if (isset($errors['email'])) : ?><div class="error"><?php echo $errors['email'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>טלפון נייד: </th>
									<td>
										<input type="text" name="phone"<?php if (isset($user['phone'])) : ?> value="<?php echo htmlspecialchars($user['phone']) ?>"<?php endif; ?>>
										<?php if (isset($errors['phone'])) : ?><div class="error"><?php echo $errors['phone'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>תחום: </th>
									<td>
										<select name="specialty">
											<?php foreach ($specialties as $id => $specialty) : ?>
											<option<?php if ($id == $user['specialty']) : ?> selected<?php endif; ?> value="<?php echo $id ?>"><?php echo $specialty ?></option>
											<?php endforeach; ?>
										</select>
										<?php if (isset($errors['specialty'])) : ?><div class="error"><?php echo $errors['specialty'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>שם המוסד: </th>
									<td>
										<input type="text" name="educational_institution"<?php if (isset($user['educational_institution'])) : ?> value="<?php echo htmlspecialchars($user['educational_institution']) ?>"<?php endif; ?>>
										<?php if (isset($errors['educational_institution'])) : ?><div class="error"><?php echo $errors['educational_institution'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>שנת לימוד: </th>
									<td>
										<input type="text" name="department"<?php if (isset($user['department'])) : ?> value="<?php echo htmlspecialchars($user['department']) ?>"<?php endif; ?>>
										<?php if (isset($errors['department'])) : ?><div class="error"><?php echo $errors['department'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>עיר: </th>
									<td>
										<input type="text" name="city"<?php if (isset($user['city'])) : ?> value="<?php echo htmlspecialchars($user['city']) ?>"<?php endif; ?>>
										<?php if (isset($errors['city'])) : ?><div class="error"><?php echo $errors['city'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>רחוב: </th>
									<td>
										<input type="text" name="street"<?php if (isset($user['street'])) : ?> value="<?php echo htmlspecialchars($user['street']) ?>"<?php endif; ?>>
										<?php if (isset($errors['street'])) : ?><div class="error"><?php echo $errors['street'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>מספר: </th>
									<td>
										<input type="text" name="house_number"<?php if (isset($user['house_number'])) : ?> value="<?php echo htmlspecialchars($user['house_number']) ?>"<?php endif; ?>>
										<?php if (isset($errors['house_number'])) : ?><div class="error"><?php echo $errors['house_number'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>מיקוד: </th>
									<td>
										<input type="text" name="post_index"<?php if (isset($user['post_index'])) : ?> value="<?php echo htmlspecialchars($user['post_index']) ?>"<?php endif; ?>>
										<?php if (isset($errors['post_index'])) : ?><div class="error"><?php echo $errors['post_index'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>תמונת פרופיל: </th>
									<td>
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
									</td>
								</tr>
								<tr>
									<th>סיסמא: </th>
									<td>
										<input type="password" name="password">
										<?php if (isset($errors['password'])) : ?><div class="error"><?php echo $errors['password'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>Status: </th>
									<td>
										<select name="status">
											<?php foreach (array(0 => 'Not active', 1 => 'Active', 2 => 'Blocked') as $id => $status) : ?>
											<option<?php if ($id == $user['status']) : ?> selected<?php endif; ?> value="<?php echo $id ?>"><?php echo $status ?></option>
											<?php endforeach; ?>
										</select>
										<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>Newbie: </th>
									<td>
										<label>
											<input type="radio" name="newbie" value="1"<?php if (!isset($user['newbie']) || $user['newbie'] == '1') : ?> checked<?php endif; ?>>Yes
										</label>
										<label>
											<input type="radio" name="newbie" value="0"<?php if (isset($user['newbie']) && $user['newbie'] == '0') : ?> checked<?php endif; ?>>No
										</label>
										<?php if (isset($errors['newbie'])) : ?><div class="error"><?php echo $errors['newbie'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th></th>
									<td>
										<?php if (isset($user['id'])) : ?><input type="hidden" name="id" value="<?php echo $user['id'] ?>"><?php endif; ?>
										<input type="submit" value="Save" name="save">
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</li>
				<li<?php if (isset($_GET['orders_page'])) : ?> class="active"<?php endif; ?>>
					<?php if (isset($orders)) : ?>
					<table class="list">
						<thead>
							<th>Id</th>
							<th>Summ</th>
							<th>Date</th>
							<th>Delivery date</th>
							<th>Address</th>
							<th>Count files</th>
							<th>User</th>
							<th>Status</th>
							<th>Actions</th>
						</thead>
						<tbody>
							<?php foreach ($orders['orders_list'] as $order) : ?>
							<tr>
								<td><?php echo $order['id'] ?></td>
								<td><?php echo $order['summ'] ?>₪</td>
								<td><?php echo date('d.m.Y', $order['date']) ?></td>
								<td><?php echo $order['delivery_date'] ?></td>
								<td><?php echo $order['address'] ?></td>
								<td><?php echo count($order['bids']) ?></td>
								<td><?php echo $order['name'] ?></td>
								<td><?php echo $order['status'] ?></td>
								<td>
									<a class="actions" href="/a-panel/orders/edit/<?php echo $order['id'] ?>">Edit</a>
									<a class="actions" onclick="return confirm('Delete order &quot;<?php echo $order['id'] ?>&quot;?')" href="/a-panel/deleteOrder/<?php echo $order['id'] ?>?return_to_user=<?php echo $user['id'] ?>">Delete</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php if ($orders['orders_pager']) : ?>
					<ul class="pager">
						<?php foreach ($orders['orders_pager'] as $p) : ?>
						<li>
							<a href="/a-panel/users/edit/<?php echo $user['id'] ?>?orders_page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
						</li> 
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<?php endif; ?>
				</li>
			</ul>
		</div>
  <?php else : ?>
    <table class="list">
      <thead>
        <th>Id</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Name</th>
				<th>Specialty</th>
				<th>Actions</th>
      </thead>
      <tbody>
        <?php foreach ($materials as $material) : ?>
        <tr>
          <td><?php echo $material['id'] ?></td>
					<td><?php echo $material['email'] ?></td>
					<td><?php echo $material['phone'] ?></td>
					<td><?php echo $material['name'] ?></td>
					<td><?php echo $material['specialty_name'] ?></td>
          <td>
            <a class="actions" href="/a-panel/users/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete user &quot;<?php echo $material['email'] ?>&quot;?')" href="/a-panel/deleteUser/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/users?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>