<div id="content-wrapper">
  <div id="section-title">
    Materials
    <?php if (isset($total_materials)) echo '(' . $total_materials . ')';  ?>
    <?php if (!$form) : ?><a class="add" href="/a-panel/materials/add">Add material</a><?php endif; ?>
  </div>
  <?php if ($form) : ?>
  <form method="post" action="/a-panel/saveMaterial" enctype="multipart/form-data">
    <table class="form-edit">
      <tbody>
        <tr>
          <th>Name: </th>
          <td>
						<input type="text" name="name"<?php if (isset($material['name'])) : ?> value="<?php echo htmlspecialchars($material['name']) ?>"<?php endif; ?>>
						<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Category: </th>
          <td>
						<select name="category">
							<option value="0">-- Select --</option>
							<?php foreach ($material_categories as $material_category) : ?>
							<option value="<?php echo $material_category['id'] ?>"<?php if ($material_category['id'] == $material['category']) : ?> selected<?php endif; ?>><?php echo $material_category['name'] ?></option>
							<?php endforeach; ?>
						</select>
						<?php if (isset($errors['category'])) : ?><div class="error"><?php echo $errors['category'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
					<td colspan="2">
						<table id="material-sizes">
							<thead>
								<tr>
									<th></th>
									<?php foreach ($cutting_types as $cutting_type) : ?>
									<th>Speed for <?php echo $cutting_type['name'] ?></th>
									<?php endforeach; ?>
									<th>Price</th>
									<th>Image</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($material_sizes as $material_size) : ?>
								<tr>
									<th><?php echo $material_size['name'] ?></th>
									<?php foreach ($cutting_types as $cutting_type) : ?>
									<td>
										<input type="text" name="speed[<?php echo $material_size['id'] ?>][<?php echo $cutting_type['id'] ?>]"<?php if (isset($material_speed[$material_size['id']][$cutting_type['id']])) : ?> value="<?php echo $material_speed[$material_size['id']][$cutting_type['id']] ?>"<?php endif; ?>>
										<?php if (isset($errors['speed' . $material_size['id']][$cutting_type['id']])) : ?><div class="error"><?php echo $errors['speed' . $material_size['id']][$cutting_type['id']] ?></div><?php endif; ?>
									</td>
									<?php endforeach; ?>
									<td>
										<input type="text" name="prices[<?php echo $material_size['id'] ?>]"<?php if (isset($material_prices[$material_size['id']])) : ?> value="<?php echo $material_prices[$material_size['id']] ?>"<?php endif; ?>>
										<?php if (isset($errors['price' . $material_size['id']])) : ?><div class="error"><?php echo $errors['price' . $material_size['id']] ?></div><?php endif; ?>
									</td>
									<td>
										<?php if (isset($material_images[$material_size['id']]) && $material_images[$material_size['id']]) : ?><img style="display: block; margin-bottom: 10px;" src="<?php echo CropImage::getImage($material_images[$material_size['id']], '50x50') ?>"><?php endif; ?>
										<input type="file" name="size_image[<?php echo $material_size['id'] ?>]">
										<?php if (isset($errors['size_image' . $material_size['id']])) : ?><div class="error"><?php echo $errors['size_image' . $material_size['id']] ?></div><?php endif; ?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
          <th>Image: </th>
          <td>
						<?php if (isset($material['image']) && $material['image']) : ?><img style="display: block; margin-bottom: 10px;" src="<?php echo CropImage::getImage($material['image'], '50x50') ?>"><?php endif; ?>
						<input type="file" name="image">
						<?php if (isset($errors['image'])) : ?><div class="error"><?php echo $errors['image'] ?></div><?php endif; ?>
					</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <?php if (isset($material['id'])) : ?><input type="hidden" name="id" value="<?php echo $material['id'] ?>"><?php endif; ?>
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
				<th>Actions</th>
      </thead>
      <tbody>
        <?php foreach ($materials as $material) : ?>
        <tr>
          <td><?php echo $material['name'] ?></td>
          <td>
            <a class="actions" href="/a-panel/materials/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete material &quot;<?php echo $material['name'] ?>&quot;?')" href="/a-panel/deleteMaterial/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/materials?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>