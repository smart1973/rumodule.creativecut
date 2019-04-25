<div class="content">
	<h1 class="you-objects">Счет-фактуры</h1>
	<?php if ($orders) : ?>
  <table id="table-user-orders" class="styled-table">
    <thead>
      <tr>
        <th>Номер заказа</th>
        <th>Дата заказа</th>
        <th><div class="pdf">Накладная</div></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order) : ?>
      <tr>
        <td><?php echo $order['id'] ?></td>
        <td><?php echo date('d.m.Y', $order['date']) ?></td>
        <td>
          <?php if ($order['pdf_link']) : ?>
          <a class="order-pdf-link" title="<?php echo $order['id'] ?>.pdf" href="<?php echo $order['pdf_link'] ?>" target="_blank"><?php echo $order['id'] ?>.pdf</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
	<?php if (isset($pager) && $pager) : ?>
	<ul class="pager">
		<?php foreach ($pager as $p) : ?>
		<li>
			<?php if ((isset($_GET['page']) && $_GET['page'] != $p['link']) || (!isset($_GET['page']) && $p['link'] != 1)) : ?>
			<a href="/your-orders<?php if ($p['link'] != 1) : ?>?page=<?php echo $p['link']; endif; ?>"><?php echo $p['num'] ?></a>
			<?php else : ?>
			<span><?php echo $p['num'] ?></span>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<?php else : ?>
	<div class="your-objects-not-found">עדיין לא העלת קבצים ציבוריים</div>
	<?php endif; ?>
</div>