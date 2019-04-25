<div id="content-wrapper">
  <div id="section-title">
    Delivery times
    <?php if (isset($total_dtimes)) echo '(' . $total_dtimes . ')';  ?>
		<?php if (!$form) : ?><a class="add" href="/a-panel/deliverTime/add">Add deliver time</a><?php endif; ?>
  </div>
  <?php if ($form) : ?>
  <form method="post" action="/a-panel/saveDeliveryTime" enctype="multipart/form-data">
    <table class="form-edit">
      <tbody>
				<tr>
          <th>Name: </th>
          <td>
						<input type="text" name="name"<?php if (isset($dtime['name'])) : ?> value="<?php echo $dtime['name'] ?>"<?php endif; ?>>
						<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Price: </th>
          <td>
						<input type="text" name="price"<?php if (isset($dtime['price'])) : ?> value="<?php echo $dtime['price'] ?>"<?php endif; ?>>
						<?php if (isset($errors['price'])) : ?><div class="error"><?php echo $errors['price'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>By default: </th>
          <td>
						<input type="checkbox" name="by_default"<?php if (isset($dtime['by_default']) && $dtime['by_default']) : ?> checked<?php endif; ?>>
					</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <?php if (isset($dtime['id'])) : ?><input type="hidden" name="id" value="<?php echo $dtime['id'] ?>"><?php endif; ?>
            <input type="submit" value="Save" name="save">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <?php else : ?>
    <table class="list">
      <thead>
				<th>Name</th>
				<th>Price</th>
				<th>By default</th>
				<th>Actions</th>
      </thead>
      <tbody>
        <?php foreach ($materials as $material) : ?>
        <tr>
          <td><?php echo $material['name'] ?></td>
					<td><?php echo $material['price'] ?></td>
					<td><?php echo $material['by_default'] ? 'True' : 'False' ?></td>
          <td>
            <a class="actions" href="/a-panel/deliverTime/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete delivery time &quot;<?php echo $material['id'] ?>&quot;?')" href="/a-panel/deleteDeliverTime/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/deliverTime?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>