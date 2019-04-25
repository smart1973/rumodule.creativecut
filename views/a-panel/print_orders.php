<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>New files</title>
    <style type="text/css">
      @page {
        margin: 40px 0 0 0;
      }
      body {
        direction: rtl;
        text-align: right;
        margin: 0;
        padding: 0;
        line-height: 1.25;
      }
      img {
        max-width: 100%;
      }
      .center {
        text-align: center;
      }
      #bids-list {
        width: 100%;
        border-collapse: collapse;
      }
      #bids-list > tbody > tr > td, #bids-list > thead > tr > th {
        border: 1px solid #000;
      }
      #orders-list {
        font-size: 0;
        margin: 0 auto;
        padding: 0;
        width: 760px;
      }
      #orders-list > table {
        width: 100%;
        border-collapse: separate;
        page-break-inside: avoid;
        border-spacing: 0px;
      }
      #orders-list > table > tbody > tr > td {
        border: 1px solid #000;
        box-sizing: border-box;
        vertical-align: top;
        padding: 10px;
        width: 365px;
        border-radius: 10px;
      }
      #orders-list > table > tbody > tr > td .top {
        border-bottom: 1px solid #000;
        padding-bottom: 5px;
      }
      #orders-list > table > tbody > tr > td .top .right {
        font-size: 14px;
        display: inline-block;
        vertical-align: middle;
        width: 49%;
        margin-left: 2%;
      }
      #orders-list > table > tbody > tr > td .top .left {
        display: inline-block;
        vertical-align: middle;
        width: 49%;
        text-align: center;
      }
      #orders-list > table > tbody > tr > td .bottom {
        margin-top: 5px;
      }
      #orders-list > table > tbody > tr > td .bottom h2 {
        font-size: 22px;
        font-weight: bold;
        margin: 0;
        padding: 0;
        margin-bottom: 10px;
      }
      #orders-list > table > tbody > tr > td .bottom .right {
        display: inline-block;
        vertical-align: top;
        width: 49%;
      }
      #orders-list > table > tbody > tr > td .bottom .left {
        display: inline-block;
        vertical-align: top;
        width: 49%;
        margin-right: 2%;
        border-right: 1px solid #000;
        box-sizing: border-box;
        padding-right: 2%;
      }
      #orders-list > table > tbody > tr > td .bottom span {
        font-size: 13px;
      }
      .mt-10 {
        margin-top: 10px;
      }
      .bold {
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <?php if ($bids) : ?>
      <?php if (isset($args[2])) : switch ($args[2]) : case 2 : ?>
        <?php foreach ($bids as $mbids) : ?>
        <table id="bids-list" style="page-break-before:always;">
          <thead>
            <th class="center">Order id</th>
            <th class="center">Material name</th>
            <th class="center">Size</th>
            <th class="center">Material size</th>
          </thead>
          <tbody>
            <?php foreach ($mbids as $bid) : ?>
            <tr>
              <td class="center"><?php echo $bid['id'] ?></td>
              <td class="center"><?php echo $bid['material_name'] ?></td>
              <td class="center"><?php echo $bid['size_name'] ?></td>
              <td class="center" style="direction:ltr;"><?php echo $bid['data']['work_width'] ?> X <?php echo $bid['data']['work_height'] ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php endforeach; ?>
      <?php break; case 3 : ?>
      <div id="orders-list">
        <?php foreach ($bids as $k => $bid) : if (!($k % 2)) : if ($k) : ?>
        <table>
          <tbody>
            <tr>
              <td colspan="3" style="padding: 0;border: none;height: 10px;"></td>
            </tr>
          </tbody>
        </table>
        <?php endif; ?>
        <table>
          <tbody>
            <tr>
        <?php endif; ?>
              <td>
                <div class="top">
                  <div class="right"><span class="bold">CreativeCut</span> - שירותי חיתוך<br>הלהב 6, חולון, ביתן 272<br>03-5545584 \ 050-4888822</div>
                  <div class="left">
                    <img src="/logo2.png">
                  </div>
                </div>
                <div class="bottom">
                  <div class="right">
                    <h2>לכבוד</h2>
                    <div>
                      <span>שם: </span>
                      <span><?php echo $bid['name'] . ' ' . $bid['surname'] ?></span>
                    </div>
                    <div>
                      <span>אימייל: </span>
                      <span><?php echo $bid['email'] ?></span>
                    </div>
                    <div>
                      <span>טלפון: </span>
                      <span><?php echo $bid['phone'] ?></span>
                    </div>
                    <div class="mt-10">
                      <span>תאריך: </span>
                      <span><?php echo date('d.m.Y', $bid['date']) ?></span>
                    </div>
                    <div class="bold mt-10">
                      <span>מספר הזמנה: </span>
                      <span><?php echo $bid['id'] ?></span>
                    </div>
                  </div>
                  <div class="left">
                    <h2>כתובת</h2>
                    <div>
                      <span>רחוב: </span>
                      <span><?php echo $bid['street'] ?></span>
                    </div>
                    <div>
                      <span>מספר: </span>
                      <span><?php echo $bid['house_number'] ?></span>
                    </div>
                    <div>
                      <span>עיר: </span>
                      <span><?php echo $bid['city'] ?></span>
                    </div>
                    <div>
                      <span>מיקוד: </span>
                      <span><?php echo $bid['post_index'] ?></span>
                    </div>
                    <div class="mt-10">
                      <span>מספר קבצים: </span>
                      <span><?php echo count($bid['bids']) ?></span>
                    </div>
                    <div>
                      <span>משלוח: </span>
                      <span><?php echo $bid['delivery'] ?></span>
                    </div>
                  </div>
                </div>
              </td>
              <?php if (!($k % 2)) : ?><td style="border: none; width: 30px; padding: 0;"></td><?php endif; ?>
              <?php if (!($k % 2) && $k + 1 == count($bids)) : ?><td style="border: none;"></td><?php endif; ?>
        <?php if (!(($k + 1) % 2) || $k + 1 == count($bids)) : ?>
            </tr>
          </tbody>
        </table>
        <?php endif; endforeach; ?>
      </div>
      <?php endswitch; else : $cutting_types = Models::get('materialsCategoriesSizes')->getCuttingTypes(); ?>
      <table id="bids-list">
        <thead>
          <th class="center">מספר הזמנה</th>
          <th class="center">חומר</th>
          <th class="center">עובי חומר</th>
          <th class="center">שם קובץ</th>
          <th class="center">צבע</th>
          <th class="center">שם משתמש/לקוח</th>
        </thead>
        <tbody>
          <?php foreach ($bids as $bid) : ?>
          <tr>
            <td class="center"><?php echo $bid['id'] ?></td>
            <td class="center"><?php echo $bid['material_name'] ?></td>
            <td class="center"><?php echo $bid['size_name'] ?></td>
            <td class="center"><?php echo $bid['file_name'] ?></td>
            <td>
              <table>
                <tbody>
                  <?php foreach ($bid['data']['cutting_types_values'] as $cutting_types_values) : ?>
                  <tr>
                    <th>
                      <div style="border:10px solid <?php echo $cutting_types_values['color'] ?>"></div>
                    </th>
                    <td><?php echo $cutting_types[$cutting_types_values['type']]['name'] ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </td>
            <td>
              <table>
                <tbody>
                  <tr>
                    <th>Name: </th>
                    <td><?php echo $bid['name'] ?></td>
                  </tr>
                  <tr>
                    <th>Surname: </th>
                    <td><?php echo $bid['surname'] ?></td>
                  </tr>
                  <tr>
                    <th>Email: </th>
                    <td><?php echo $bid['email'] ?></td>
                  </tr>
                  <tr>
                    <th>Phone: </th>
                    <td><?php echo $bid['phone'] ?></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    <?php else : ?>
    <div>Files not found</div>
    <?php endif; ?>
  </body>
</html>