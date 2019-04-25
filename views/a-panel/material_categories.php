<div id="content-wrapper">
  <div id="section-title">
    Material categories
    <?php if (isset($total_material_categories)) echo '(' . $total_material_categories . ')';  ?>
		<?php if ($form) : ?>
		<a class="add" href="/a-panel/materials/add/<?php echo $material_category['id'] ?>">Add material</a>
    <?php else : ?>
		<a class="add" href="/a-panel/materialCategories/add">Add material category</a>
		<?php endif; ?>
  </div>
  <?php if ($form) : ?>
		<form method="post" action="/a-panel/saveMaterialCategory" enctype="multipart/form-data">
			<table class="form-edit">
				<tbody>
					<tr>
						<th>Name: </th>
						<td>
							<input type="text" name="name"<?php if (isset($material_category['name'])) : ?> value="<?php echo htmlspecialchars($material_category['name']) ?>"<?php endif; ?>>
							<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>Max width: </th>
						<td>
							<input type="text" name="max_width"<?php if (isset($material_category['max_width'])) : ?> value="<?php echo htmlspecialchars($material_category['max_width']) ?>"<?php endif; ?>>
							<?php if (isset($errors['max_width'])) : ?><div class="error"><?php echo $errors['max_width'] ?></div><?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>Max height: </th>
						<td>
							<input type="text" name="max_height"<?php if (isset($material_category['max_height'])) : ?> value="<?php echo htmlspecialchars($material_category['max_height']) ?>"<?php endif; ?>>
							<?php if (isset($errors['max_height'])) : ?><div class="error"><?php echo $errors['max_height'] ?></div><?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>Image: </th>
						<td>
							<?php if (isset($material_category['image']) && $material_category['image']) : ?><img style="display: block; margin-bottom: 10px;" src="<?php echo CropImage::getImage($material_category['image'], '50x50') ?>"><?php endif; ?>
							<input type="file" name="image">
							<?php if (isset($errors['image'])) : ?><div class="error"><?php echo $errors['image'] ?></div><?php endif; ?>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<?php if (isset($material_category['id'])) : ?><input type="hidden" name="id" value="<?php echo $material_category['id'] ?>"><?php endif; ?>
							<input type="submit" value="Save" name="save">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<?php if (isset($materials)) : ?>
			<div>Total materials: <?php echo $total_materials ?></div>
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
					<a href="/a-panel/materialCategories/edit/<?php echo $material_category['id'] ?>?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
				</li> 
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		<?php endif; ?>
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
            <a class="actions" href="/a-panel/materialCategories/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete material category &quot;<?php echo $material['name'] ?>&quot;?')" href="/a-panel/deleteMaterialCategory/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/materialCategories?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>