<div id="content-wrapper">
  <div id="section-title">
    Bids
    <?php if (isset($total_bids)) echo '(' . $total_bids . ')';  ?>
  </div>
  <?php if ($form) : ?>
		<div class="tabs">
			<ul>
				<li<?php if (!isset($_GET['bids_page'])) : ?> class="active"<?php endif; ?>>
					<a href="javascript:void(0)">Bid data</a>
				</li>
				<li>
					<a href="javascript:void(0)">Bid owner</a>
				</li>
				<li<?php if (isset($_GET['bids_page'])) : ?> class="active"<?php endif; ?>>
					<a href="javascript:void(0)">Another user bids</a>
				</li>
			</ul>
			<ul>
				<li<?php if (!isset($_GET['bids_page'])) : ?> class="active"<?php endif; ?>>
					<form method="post" action="/a-panel/saveBid" enctype="multipart/form-data">
						<table class="form-edit">
							<tbody>
								<tr>
									<th>Date: </th>
									<td><?php echo date('d.m.Y', $bid['date']) ?></td>
								</tr>
								<tr>
									<th>File: </th>
									<td><a href="/graphic_files/<?php echo $bid['file'] ?>" download><?php echo $bid['file'] ?></a></td>
								</tr>
								<tr>
									<th>Name: </th>
									<td><?php echo $bid['name'] ?></td>
								</tr>
								<tr>
									<th>Category: </th>
									<td><?php echo $bid['mcname'] ?></td>
								</tr>
								<tr>
									<th>Material: </th>
									<td><?php echo $bid['mname'] ?></td>
								</tr>
								<tr>
									<th>Thickness: </th>
									<td><?php echo $bid['msname'] ?></td>
								</tr>
								<tr>
									<th>Working area size: </th>
									<td><?php echo $bid['data']['work_width'] . ' x ' . $bid['data']['work_height'] ?></td>
								</tr>
								<tr>
									<th>Data to send: </th>
									<td><?php echo $bid['address'] ?><br><?php echo $bid['delivery_date'] ?> days</td>
								</tr>
								<tr>
									<th>Total price: </th>
									<td><?php echo $bid['data']['total_price'] ?></td>
								</tr>
								<tr>
									<th>Total length: </th>
									<td><?php echo number_format($bid['data']['total_length'], 2, '.', '') ?></td>
								</tr>
								<tr>
									<th>Total area: </th>
									<td><?php echo number_format($bid['data']['total_area'], 2, '.', '') ?></td>
								</tr>
								<tr>
									<th>Status: </th>
									<td>
										<select name="status">
											<?php foreach ($statuses as $k => $status) : ?>
											<option value="<?php echo $k ?>"<?php if ($k == $bid['status']) : ?> selected<?php endif ?>><?php echo $status['name'] ?></option>
											<?php endforeach; ?>
										</select>
										<?php if (isset($errors['status'])) : ?><div class="error"><?php echo $errors['status'] ?></div><?php endif; ?>
									</td>
								</tr>
								<tr>
									<th>Cutting types: </th>
									<td>
										<table>
											<thead>
												<th>Color</th>
												<th>Cutting type</th>
												<th>Line length</th>
												<th>Area</th>
												<th>Price</th>
											</thead>
											<tbody>
												<?php if (isset($bid['data']['cutting_types_values']) && is_array($bid['data']['cutting_types_values'])) : foreach ($bid['data']['cutting_types_values'] as $cutting_types_values) : ?>
												<tr>
													<td><div style="border:1px solid #000;width:48px;height:48px;background:<?php echo $cutting_types_values['color'] ?>"></div></td>
													<td><?php echo $cutting_types[$cutting_types_values['type']] ?></td>
													<td><?php echo number_format($cutting_types_values['line_length'], 2, '.', '') ?></td>
													<td><?php echo number_format($cutting_types_values['area'], 2, '.', '') ?></td>
													<td><?php echo number_format($cutting_types_values['price'], 2, '.', '') ?></td>
												</tr>
												<?php endforeach;endif; ?>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<th></th>
									<td>
										<?php if (isset($_GET['redirect'])) : ?><input type="hidden" name="redirect" value="<?php echo $_GET['redirect'] ?>"><?php endif; ?>
										<input type="hidden" name="id" value="<?php echo $bid['id'] ?>">
										<input type="submit" value="Save" name="save">
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</li>
				<li>
					<table class="form-edit">
						<tbody>
							<tr>
								<th>Email: </th>
								<td><?php echo $bid_owner['email'] ?></td>
							</tr>
							<tr>
								<th>Phone: </th>
								<td><?php echo $bid_owner['phone'] ?></td>
							</tr>
							<tr>
								<th>Name: </th>
								<td><?php echo $bid_owner['name'] ?></td>
							</tr>
							<tr>
								<th>Specialty: </th>
								<td><?php echo $bid_owner['specialty_name'] ?></td>
							</tr>
						</tbody>
					</table>
				</li>
				<li<?php if (isset($_GET['bids_page'])) : ?> class="active"<?php endif; ?>>
					<table class="list">
						<thead>
							<th>Id</th>
							<th>Date</th>
							<th>File</th>
							<th>Name</th>
							<th>Category</th>
							<th>Material</th>
							<th>Thickness</th>
							<th>Working area size</th>
							<th>Paid</th>
							<th>Actions</th>
						</thead>
						<tbody>
							<?php if (isset($bids['bids_list'])) : foreach ($bids['bids_list'] as $material) : ?>
							<tr>
								<td><?php echo $material['id'] ?></td>
								<td><?php echo date('d.m.Y H:i', $material['date']) ?></td>
								<td><a href="/graphic_files/<?php echo $material['file'] ?>" download><?php echo $material['file'] ?></a></td>
								<td><?php echo $material['name'] ?></td>
								<td><?php echo $material['mc_name'] ?></td>
								<td><?php echo $material['m_name'] ?></td>
								<td><?php echo $material['ms_name'] ?></td>
								<td><?php echo $material['data']['work_width'] . ' x ' . $material['data']['work_height'] ?></td>
								<td><?php if ($material['paid']) : ?><div class="paid">Paid</div><?php else : ?><div class="not-paid">Not paid</div><?php endif; ?></td>
								<td>
									<a class="actions" href="/a-panel/bids/edit/<?php echo $material['id'] ?>">Edit</a>
									<a class="actions" onclick="return confirm('Delete bid &quot;<?php echo $material['id'] ?>&quot;?')" href="/a-panel/deleteBid/<?php echo $material['id'] ?>">Delete</a>
								</td>
							</tr>
							<?php endforeach; endif; ?>
						</tbody>
					</table>
					<?php if (isset($bids['bids_pager'])) : ?>
					<ul class="pager">
						<?php foreach ($bids['bids_pager'] as $p) : ?>
						<li>
							<a href="/a-panel/bids/edit/<?php echo $bid['id'] ?>?bids_page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
						</li> 
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</li>
			</ul>
		</div>
  <?php else : ?>
    <table class="list">
      <thead>
				<th>Id</th>
				<th>Date</th>
				<th>File</th>
				<th>Name</th>
				<th>Category</th>
        <th>Material</th>
				<th>Thickness</th>
				<th>Working area size</th>
				<th>Paid</th>
				<th>Actions</th>
      </thead>
      <tbody>
        <?php foreach ($materials as $material) : ?>
        <tr>
          <td><?php echo $material['id'] ?></td>
					<td><?php echo date('d.m.Y H:i', $material['date']) ?></td>
					<td><a href="/graphic_files/<?php echo $material['file'] ?>" download><?php echo $material['file'] ?></a></td>
					<td><?php echo $material['name'] ?></td>
					<td><?php echo $material['mcname'] ?></td>
					<td><?php echo $material['mname'] ?></td>
					<td><?php echo $material['msname'] ?></td>
					<td><?php echo $material['data']['work_width'] . ' x ' . $material['data']['work_height'] ?></td>
					<td><?php if ($material['paid']) : ?><div class="paid">Paid</div><?php else : ?><div class="not-paid">Not paid</div><?php endif; ?></td>
          <td>
            <a class="actions" href="/a-panel/bids/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete bid &quot;<?php echo $material['id'] ?>&quot;?')" href="/a-panel/deleteBid/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/bids?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>