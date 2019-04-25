<div id="content-wrapper">
  <div id="section-title">
    Material sizes
    <?php if (isset($total_material_sizes)) echo '(' . $total_material_sizes . ')';  ?>
    <?php if (!$form) : ?><a class="add" href="/a-panel/materialSizes/add">Add material size</a><?php endif; ?>
  </div>
  <?php if ($form) : ?>
  <form method="post" action="/a-panel/saveMaterialSize">
    <table class="form-edit">
      <tbody>
        <tr>
          <th>Name: </th>
          <td>
						<input type="text" name="name"<?php if (isset($material_size['name'])) : ?> value="<?php echo htmlspecialchars($material_size['name']) ?>"<?php endif; ?>>
						<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
					</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <?php if (isset($material_size['id'])) : ?><input type="hidden" name="id" value="<?php echo $material_size['id'] ?>"><?php endif; ?>
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
            <a class="actions" href="/a-panel/materialSizes/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete material size &quot;<?php echo $material['name'] ?>&quot;?')" href="/a-panel/deleteMaterialSize/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/materialSizes?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>