<div id="content-wrapper">
  <div id="section-title">
    Public files (<?php echo $total_files ?>)
  </div>
  <table class="list">
    <thead>
      <th>Id</th>
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
      <?php foreach ($materials as $material) : ?>
      <tr>
        <td><?php echo $material['id'] ?></td>
        <td><?php echo date('d.m.Y', $material['date']) ?></td>
        <td><a href="/graphic_files/<?php echo $material['file'] ?>" download><?php echo $material['file'] ?></a></td>
        <td><?php echo $material['file_name'] ?></td>
        <td><?php echo $material['name'] ?></td>
        <td><?php echo $material['mc_name'] ?></td>
        <td><?php echo $material['m_name'] ?></td>
        <td><?php echo $material['ms_name'] ?></td>
        <td><?php echo $material['data']['work_width'] . ' x ' . $material['data']['work_height'] ?></td>
        <td><?php if ($material['paid']) : ?><div class="paid">Paid</div><?php else : ?><div class="not-paid">Not paid</div><?php endif; ?></td>
        <td>
          <a class="actions" href="/a-panel/bids/edit/<?php echo $material['id'] ?>?redirect=/a-panel/publicFiles">Edit</a>
          <a class="actions" onclick="return confirm('Delete bid &quot;<?php echo $material['id'] ?>&quot;?')" href="/a-panel/deleteBid/<?php echo $material['id'] ?>?redirect=/a-panel/publicFiles">Delete</a>
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
</div>