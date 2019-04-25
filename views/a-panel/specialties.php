<div id="content-wrapper">
  <div id="section-title">
    Specialties
    <?php if (isset($total_specialties)) echo '(' . $total_specialties . ')';  ?>
    <?php if (!$form) : ?><a class="add" href="/a-panel/specialties/add">Add specialty</a><?php endif; ?>
  </div>
  <?php if ($form) : ?>
  <form method="post" action="/a-panel/saveSpecialty" enctype="multipart/form-data">
    <table class="form-edit">
      <tbody>
        <tr>
          <th>Name: </th>
          <td>
						<input type="text" name="name"<?php if (isset($specialty['name'])) : ?> value="<?php echo htmlspecialchars($specialty['name']) ?>"<?php endif; ?>>
						<?php if (isset($errors['name'])) : ?><div class="error"><?php echo $errors['name'] ?></div><?php endif; ?>
					</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <?php if (isset($specialty['id'])) : ?><input type="hidden" name="id" value="<?php echo $specialty['id'] ?>"><?php endif; ?>
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
            <a class="actions" href="/a-panel/specialties/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete specialty &quot;<?php echo $material['name'] ?>&quot;?')" href="/a-panel/deleteSpecialty/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/specialties?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>