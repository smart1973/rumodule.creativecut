<div id="content-wrapper">
	<iframe src="/a-panel/printOrders" style="display:none;" name="printOrders"></iframe>
	<iframe src="/a-panel/printOrders/2" style="display:none;" name="printOrders2"></iframe>
	<iframe src="/a-panel/printOrders/3" style="display:none;" name="printOrders3"></iframe>
  <div id="section-title">
    Orders
    <?php if (isset($total_orders)) echo '(' . $total_orders . ')';  ?>
		<?php if (!$form) : ?>
		<a class="add" href="javascript:frames.printOrders.print()">הדפסת הזמנות</a>
		<a class="add" style="right: 86px;" href="javascript:frames.printOrders2.print()">הדפסת חומרים</a>
		<a class="add" style="right: 164px;" href="javascript:frames.printOrders3.print()">הדפסת משלוח</a>
		<?php endif; ?>
  </div>
  <?php if ($form) : ?>
	<div class="tabs">
		<ul>
			<li<?php if (!isset($_GET['orders_page'])) : ?> class="active"<?php endif; ?>>
				<a href="javascript:void(0)">Order files</a>
			</li>
			<li>
				<a href="javascript:void(0)">Order data</a>
			</li>
			<li>
				<a href="javascript:void(0)">Order owner</a>
			</li>
			<li<?php if (isset($_GET['orders_page'])) : ?> class="active"<?php endif; ?>>
				<a href="javascript:void(0)">Another user orders</a>
			</li>
		</ul>
		<ul>
			<li<?php if (!isset($_GET['orders_page'])) : ?> class="active"<?php endif; ?>>
				<table class="list">
					<thead>
						<th>Id</th>
						<th>Quantity</th>
						<th>Date</th>
						<th>File</th>
						<th>File name</th>
						<th>Name</th>
						<th>Category</th>
						<th>Material</th>
						<th>Thickness</th>
						<th>Working area size</th>
						<th>Paid</th>
						<th>Actions</th>
					</thead>
					<tbody>
						<?php $bids = array(); foreach ($order['bids'] as $bid) $bids[$bid->b] = $bid->q; foreach (Models::get('Bids')->get(array_keys($bids)) as $bid) : ?>
						<tr>
							<td><?php echo $bid['id'] ?></td>
							<td><?php echo $bids[$bid['id']] ?></td>
							<td><?php echo date('d.m.Y', $bid['date']) ?></td>
							<td><a href="/graphic_files/<?php echo $bid['file'] ?>" download><?php echo $bid['file'] ?></a></td>
							<td><?php echo $bid['file_name'] ?></td>
							<td><?php echo $bid['name'] ?></td>
							<td><?php echo $bid['mcname'] ?></td>
							<td><?php echo $bid['mname'] ?></td>
							<td><?php echo $bid['msname'] ?></td>
							<td><?php echo $bid['data']['work_width'] . ' x ' . $bid['data']['work_height'] ?></td>
							<td><?php if ($bid['paid']) : ?><div class="paid">Paid</div><?php else : ?><div class="not-paid">Not paid</div><?php endif; ?></td>
							<td>
								<a class="actions" href="/a-panel/bids/edit/<?php echo $bid['id'] ?>?redirect=/a-panel/orders/edit/<?php echo $order['id'] ?>">Edit</a>
								<a class="actions" onclick="return confirm('Delete bid &quot;<?php echo $bid['id'] ?>&quot;?')" href="/a-panel/deleteBid/<?php echo $bid['id'] ?>?redirect=/a-panel/orders/edit/<?php echo $order['id'] ?>">Delete</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</li>
			<li>
				<form method="post" action="/a-panel/orders" enctype="multipart/form-data">
					<table class="form-edit">
						<tbody>
							<tr>
								<th>Summ: </th>
								<td><?php echo $order['summ'] ?>₪</td>
							</tr>
							<tr>
								<th>Date: </th>
								<td><?php echo date('d.m.Y', $order['date']) ?></td>
							</tr>
							<tr>
								<th>Delivery date: </th>
								<td><?php echo $order['delivery_date'] ?></td>
							</tr>
							<tr>
								<th>Address: </th>
								<td>
									<div>
										<span>עיר: </span>
										<span><?php echo $order['city'] ?></span>
									</div>
									<div>
										<span>רחוב: </span>
										<span><?php echo $order['street'] ?></span>
									</div>
									<div>
										<span>מספר: </span>
										<span><?php echo $order['house_number'] ?></span>
									</div>
									<div>
										<span>מיקוד: </span>
										<span><?php echo $order['post_index'] ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<th>User: </th>
								<td><?php echo $order['name'] ?></td>
							</tr>
							<?php if ($order['pdf_link']) : ?>
							<tr>
								<th>PDF file: </th>
								<td>
									<a href="<?php echo $order['pdf_link'] ?>" target="_blank"><?php echo $order['pdf_link'] ?></a>
								</td>
							</tr>
							<?php endif; ?>
							<tr>
								<th>Status: </th>
								<td>
									<select name="status">
										<?php foreach ($statuses as $k => $s) : ?>
										<option value="<?php echo $k ?>"<?php if ($k == $order['status']) : ?> selected<?php endif; ?>><?php echo $s['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="hidden" name="id" value="<?php echo $order['id'] ?>">
									<input type="submit" value="Save">
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
							<td><?php echo $order_owner['email'] ?></td>
						</tr>
						<tr>
							<th>Phone: </th>
							<td><?php echo $order_owner['phone'] ?></td>
						</tr>
						<tr>
							<th>Name: </th>
							<td><?php echo $order_owner['name'] ?></td>
						</tr>
						<tr>
							<th>Specialty: </th>
							<td><?php echo $order_owner['specialty_name'] ?></td>
						</tr>
					</tbody>
				</table>
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
						<?php foreach ($orders['orders_list'] as $ord) : ?>
						<tr>
							<td><?php echo $ord['id'] ?></td>
							<td><?php echo $ord['summ'] ?>₪</td>
							<td><?php echo date('d.m.Y', $ord['date']) ?></td>
							<td><?php echo $ord['delivery_date'] ?></td>
							<td>
								<div>
									<span>עיר: </span>
									<span><?php echo $ord['city'] ?></span>
								</div>
								<div>
									<span>רחוב: </span>
									<span><?php echo $ord['street'] ?></span>
								</div>
								<div>
									<span>מספר: </span>
									<span><?php echo $ord['house_number'] ?></span>
								</div>
								<div>
									<span>מיקוד: </span>
									<span><?php echo $ord['post_index'] ?></span>
								</div>
							</td>
							<td><?php echo count($ord['bids']) ?></td>
							<td><?php echo $ord['name'] ?></td>
							<td><?php echo $ord['status'] ?></td>
							<td>
								<a class="actions" href="/a-panel/orders/edit/<?php echo $ord['id'] ?>">Edit</a>
								<a class="actions" onclick="return confirm('Delete order &quot;<?php echo $ord['id'] ?>&quot;?')" href="/a-panel/deleteOrder/<?php echo $ord['id'] ?>">Delete</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php if ($orders['orders_pager']) : ?>
				<ul class="pager">
					<?php foreach ($orders['orders_pager'] as $p) : ?>
					<li>
						<a href="/a-panel/orders/edit/<?php echo $order['id'] ?>?orders_page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
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
				<th>Summ</th>
				<th>Date</th>
				<th>Delivery date</th>
				<th>Address</th>
				<th>Count files</th>
				<th>User</th>
				<th>Status</th>
				<th>Paid</th>
				<th>Actions</th>
      </thead>
      <tbody>
        <?php foreach ($materials as $material) : ?>
        <tr>
          <td><?php echo $material['id'] ?></td>
					<td><?php echo $material['summ'] ?>₪</td>
					<td><?php echo date('d.m.Y H:i', $material['date']) ?></td>
					<td><?php echo $material['delivery'] ?></td>
					<td>
						<div>
							<span>עיר: </span>
							<span><?php echo $material['city'] ?></span>
						</div>
						<div>
							<span>רחוב: </span>
							<span><?php echo $material['street'] ?></span>
						</div>
						<div>
							<span>מספר: </span>
							<span><?php echo $material['house_number'] ?></span>
						</div>
						<div>
							<span>מיקוד: </span>
							<span><?php echo $material['post_index'] ?></span>
						</div>
					</td>
					<td><?php echo count($material['bids']) ?></td>
					<td><?php echo $material['name'] ?></td>
					<td<?php if (array_key_exists($material['status'], $statuses)) : ?> style="background:<?php echo $statuses[$material['status']]['color'] ?>"<?php endif; ?>>
						<select class="select-order-status" order-id="<?php echo $material['id'] ?>">
							<?php foreach ($statuses as $key => $status) : ?>
							<option value="<?php echo $key ?>"<?php if ($material['status'] == $key) : ?> selected<?php endif; ?>><?php echo $status['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td><?php echo $material['paid'] ?></td>
          <td>
            <a class="actions" href="/a-panel/orders/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete order &quot;<?php echo $material['id'] ?>&quot;?')" href="/a-panel/deleteOrder/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/orders?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>