<div id="content-wrapper">
  <div id="section-title">
    IP
    <?php if (isset($total_ip)) echo '(' . $total_ip . ')';  ?>
  </div>
  <table class="list">
    <thead>
      <th>IP</th>
      <th>Site</th>
      <th>Event</th>
      <th>Date</th>
    </thead>
    <tbody>
      <?php foreach ($materials as $material) : ?>
      <tr>
        <td><?php echo $material['ip'] ?></td>
        <td><?php echo $material['site'] ?></td>
        <td><?php echo $material['event'] ?></td>
        <td><?php echo date('d.m.Y H:i', $material['date']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php if ($pager) : ?>
  <ul class="pager">
    <?php foreach ($pager as $p) : ?>
    <li>
      <a href="/a-panel/ipData?page=<?php echo $p['link'] ?>"><?php echo $p['num'] ?></a>
    </li> 
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</div>