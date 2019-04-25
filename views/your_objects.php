<div class="content">
	<h1 class="you-objects">Файлы и бронирование</h1>
	<?php if ($bids) : ?>
	<ul class="bids-archive">
		<?php foreach ($bids as $bid) : ?>
		<li>
			<div class="file-type-<?php echo substr(strrchr($bid['file'], '.'), 1) ?> bid-wrapper">
				<div class="bid-inner">
					<div class="file-type">
						<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/graphic_files/preview/' . $bid['id'] . '.png')) : ?>
						<img src="/graphic_files/preview/<?php echo $bid['id'] ?>.png">
						<?php else : ?>
						<img src="/images/<?php echo substr(strrchr($bid['file'], '.'), 1) ?>.png">
						<?php endif; ?>
					</div>
					<h3><span>Имя файла</span> - <?php echo $bid['file_name'] ?></h3>
					<div class="price"><?php if ($bid['data']['total_price']) : ?><span>Цена с НДС</span> - ₪<?php echo $bid['data']['total_price'] + $bid['data']['tax']; endif; ?></div>
					<div class="bid-options">
						<div class="show-bid-options">
							<div></div>
							<div></div>
							<div></div>
						</div>
						<ul>
							<li>
								<a href="/file/<?php echo $bid['id'] ?>">Настроить</a>
							</li>
							<li>
								<a class="view-options" href="/file/<?php echo $bid['id'] ?>">Подробнее</a>
							</li>
							<li>
								<a onclick="return creativecut_confirm('Удалить файл id &quot;<?php echo $bid['id'] ?>&quot;', function () {window.location.href = '/deleteBid/<?php echo $bid['id'] ?>'});" href="/deleteBid/<?php echo $bid['id'] ?>">Удалить файл</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="bid-additional">ID: <?php echo $bid['id'] ?></div>
			<div class="bid-detail-wrapper">
				<div class="bid-detail">
					<ul class="canvas-cutting-types">
					<?php foreach ($bid['data']['cutting_types_values'] as $cutting_type_value) : ?>
					<li>
						<div class="img" style="background:<?php echo $cutting_type_value['color'] ?>"></div>
						<div class="select-wrapper"><?php echo $cutting_types[$cutting_type_value['type']]['name'] ?></div>
					</li>
					<?php endforeach; ?>
					</ul>
					<table>
						<tbody>
							<tr>
								<td>חומרי גלם: </td>
								<td><?php echo $materials_categories[$materials[$bid['material']]['category']]['name']; ?></td>
							</tr>
							<tr>
								<td>צבעים זמינים: </td>
								<td><?php echo $materials[$bid['material']]['name']; ?></td>
							</tr>
							<tr>
								<td>עובי: </td>
								<td><?php echo $materials_sizes[$bid['size']]['name']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php if (isset($pager) && $pager) : ?>
	<ul class="pager">
		<?php foreach ($pager as $p) : ?>
		<li>
			<?php if ((isset($_GET['page']) && $_GET['page'] != $p['link']) || (!isset($_GET['page']) && $p['link'] != 1)) : ?>
			<a href="/<?php echo $link; if ($p['link'] != 1) : ?>?page=<?php echo $p['link']; endif; ?>"><?php echo $p['num'] ?></a>
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