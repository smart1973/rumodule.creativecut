<div id="content-wrapper">
  <div id="section-title">
    Prompts
    <?php if (isset($total_prompts)) echo '(' . $total_prompts . ')';  ?>
    <?php if (!$form) : ?><a class="add" href="/a-panel/prompts/add">Add promt</a><?php endif; ?>
  </div>
  <?php if ($form) : ?>
		<form method="post" action="/a-panel/savePrompt" enctype="multipart/form-data">
      <table class="form-edit">
        <tbody>
          <tr>
            <th>Title: </th>
            <td>
              <input type="text" name="title"<?php if (isset($prompt['title'])) : ?> value="<?php echo htmlspecialchars($prompt['title']) ?>"<?php endif; ?>>
              <?php if (isset($errors['title'])) : ?><div class="error"><?php echo $errors['title'] ?></div><?php endif; ?>
            </td>
          </tr>
          <tr>
            <th>Text: </th>
            <td>
              <textarea name="text"><?php if (isset($prompt['text'])) echo htmlspecialchars($prompt['text']); ?></textarea>
              <?php if (isset($errors['text'])) : ?><div class="error"><?php echo $errors['text'] ?></div><?php endif; ?>
            </td>
          </tr>
          <tr>
            <th></th>
            <td>
              <?php if (isset($prompt['id'])) : ?><input type="hidden" name="id" value="<?php echo $prompt['id'] ?>"><?php endif; ?>
              <input type="submit" value="Save" name="save">
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  <?php else : ?>
    <table class="list">
      <thead>
        <th>Id</th>
				<th>Title</th>
        <th>Actions</th>
      </thead>
      <tbody>
        <?php foreach ($materials as $material) : ?>
        <tr>
          <td><?php echo $material['id'] ?></td>
					<td><?php echo $material['title'] ?></td>
          <td>
            <a class="actions" href="/a-panel/prompts/edit/<?php echo $material['id'] ?>">Edit</a>
            <a class="actions" onclick="return confirm('Delete prompt &quot;<?php echo $material['title'] ?>&quot;?')" href="/a-panel/deletePrompt/<?php echo $material['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($pager) : ?>
    <ul class="pager">
      <?php foreach ($pager as $p) : ?>
      <li>
        <a href="/a-panel/prompts?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
      </li> 
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>