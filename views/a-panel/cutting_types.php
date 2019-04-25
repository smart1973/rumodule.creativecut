<div id="content-wrapper">
  <div id="section-title">
    Cutting types
    <?php if (isset($total_cutting_types)) echo '(' . $total_cutting_types . ')';  ?>
    <?php if (!$form) : ?><a class="add" href="/a-panel/cuttingTypes/add">Add cutting type</a><?php endif; ?>
  </div>
  <?php if ($form) : ?>
  <form method="post" action="/a-panel/saveCuttingType">
    <table class="form-edit">
      <tbody>
        <tr>
          <th>Name: </th>
          <td>
						<input type="text" name="name"<?php if (isset($cutting_type['name'])) : ?> value="<?php echo htmlspecialchars($cutting_type['name']) ?>"<?php endif; ?>>
						<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Size type: </th>
          <td>
						<select name="size_type">
							<?php foreach ($size_types as $k => $v) : ?>
							<option value="<?php echo $k ?>"<?php if (isset($cutting_type['size_type']) && $cutting_type['size_type'] == $k) : ?> selected<?php endif; ?>><?php echo $v ?></option>
							<?php endforeach; ?>
						</select>
						<?php if (isset($errors['size_type'])) : ?><div class="error"><?php echo $errors['size_type'] ?></div><?php endif; ?>
					</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <?php if (isset($cutting_type['id'])) : ?><input type="hidden" name="id" value="<?php echo $cutting_type['id'] ?>"><?php endif; ?>
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
        <th>Size type</th>
				<th>Actions</th>
      </thead>
      <tbody>
        <?php foreach ($materials as $material) : ?>
        <tr>
          <td><?php echo $material['name'] ?></td>
					<td><?php echo $size_types[$material['size_type']] ?></td>
          <td>
            <a class="actions" href="/a-panel/cuttingTypes/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete cutting type &quot;<?php echo $material['name'] ?>&quot;?')" href="/a-panel/deleteCuttingType/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/cuttingTypes?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>