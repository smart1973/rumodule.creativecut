<?php global $controller; ?>
<div class="content file-page">
  <script type="text/javascript" src="/js/nurbs.js"></script>
  <script type="text/javascript">
    var cuttingTypes = JSON.parse('<?php echo $cutting_types ?>'), materialSizes = JSON.parse('<?php echo $material_sizes ?>'),
    materials = JSON.parse('<?php echo $materials ?>'), options = JSON.parse('<?php echo $options ?>'), unitsOfMeasurement = JSON.parse('<?php echo json_encode($units_of_measurement); ?>'),
    isAdmin = <?php echo isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == 1 ? 'true' : 'false'  ?>,
    bid = JSON.parse('<?php echo $controller->json_for_js($bid) ?>');
  </script>
  <script type="text/javascript" src="/js/creativecut.js"></script>
  <script type="text/javascript" src="/js/draft.js"></script>
  <div id="file-upload">
    <h1 class="file-type-<?php echo $file_type = substr(strrchr($bid['file'], '.'), 1) ?>"><?php echo $bid['file_name'] ?></h1>
    <div class="file-upload-outer">
      <div class="file-upload-wrapper">
        <div class="drag-and-drop-wrapper">
          <div id="upload-progress"></div>
          <div id="selected-file-name" class="file-type-<?php echo $file_type ?>"><span>המתן בבקשה, הקובץ נטען</span><span></span></div>
        </div>
      </div>
    </div>
  </div>
  <div id="draft-page"<?php if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == 1) : ?> class="admin"<?php endif; ?>>
    <div class="top">
      <h1 class="file-type-<?php echo $file_type ?>">שם הקובץ</h1>
      <div class="price-wrapper">
        <?php echo Models::get('Prompts')->getHTML(2); ?>
        <div class="unit-price">מחיר ליחידה</div>
        <div class="price-value">₪<span id="creative-cut-total-price-value">0</span></div>
        <div class="tax-value">מע"מ: ₪<span id="creative-cut-tax-value">0</span></div>
      </div>
    </div>
    <div class="main">
      <div class="main-left">
        <div class="left-inner">
          <?php echo Models::get('Prompts')->getHTML(3); ?>
          <div class="draft-sizes">
            <div>
              <label>
                <span>רוחב:</span>
                <input type="text" autocomplete="off" class="creative-cut-work-width-value" onchange="creativeCutPainter.changeZoom(this, 'w');" onkeyup="creativeCutPainter.changeZoom(this, 'w');" value="0">
                מ"מ
              </label>
            </div>
            <div>
              <label>
                <span>גובה:</span>
                <input type="text" autocomplete="off" class="creative-cut-work-height-value" onchange="creativeCutPainter.changeZoom(this, 'h');" onkeyup="creativeCutPainter.changeZoom(this, 'h');" value="0">
                מ"מ
              </label>
            </div>
<!--            <div>
              <label>
                <span>המרת מידות:</span>
                <select onchange="creativeCutPainter.changeZoom(this, 'u');">
                  <?php //foreach ($units_of_measurement as $k => $v) : ?>
                  <option value="<?php //echo $k ?>"><?php //echo $k ?></option>
                  <?php //endforeach; ?>
                </select>
              </label>
            </div>-->
            <?php if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == 1) : ?>
            <br>
            <div class="mt-10">
              <label>
                <span>Total length:</span>
                <span id="creative-cut-total-length-value">0</span>
              </label>
            </div>
            <div class="mt-10">
              <label>
                <span>Total area:</span>
                <span id="creative-cut-total-area-value">0</span>
              </label>
            </div>
            <div class="mt-10">
              <label>
                <span>Time line:</span>
                <span id="creative-cut-distance-between-objects">0</span>
              </label>
            </div>
            <?php endif; ?>
            <?php echo Models::get('Prompts')->getHTML(1); ?>
          </div>
          <div id="creative-cut-canvas-draft">
            <ul id="creative-cut-canvas-controls">
              <li>
                <a onclick="creativeCutPainter.canvasScale('+')" href="javascript:void(0)"></a>
              </li>
              <li>
                <a onclick="creativeCutPainter.canvasScale('-')" href="javascript:void(0)"></a>
              </li>
              <li>
                <a onclick="creativeCutPainter.resetDraft()" href="javascript:void(0)"></a>
              </li>
            </ul>
            <div id="creative-cut-canvas-draft-left">
              <div id="creative-cut-canvas-wrapper">
                <canvas id="creative-cut-canvas" width="625" height="465"></canvas>
              </div>
              <div id="creative-cut-canvas-draft-left-arrow">
                <div></div>
                <input type="text" autocomplete="off" class="creative-cut-work-width-value" onchange="creativeCutPainter.changeZoom(this, 'w');" onkeyup="creativeCutPainter.changeZoom(this, 'w');" value="0">
              </div>
            </div>
            <div id="creative-cut-canvas-draft-right">
              <?php echo Models::get('Prompts')->getHTML(4); ?>
              <div id="creative-cut-canvas-draft-right-arrow">
                <div></div>
                <input type="text" autocomplete="off" class="creative-cut-work-height-value" onchange="creativeCutPainter.changeZoom(this, 'h');" onkeyup="creativeCutPainter.changeZoom(this, 'h');" value="0">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="main-right">
        <?php echo Models::get('Prompts')->getHTML(5); ?>
        <?php echo Models::get('Prompts')->getHTML(6); ?>
        <div id="creative-cut-settings"></div>
        <div id="creative-cut-file-buttons">
          <?php echo Models::get('Prompts')->getHTML(7); ?>
          <a href="/" id="upload-additional-file" class="creativecut-button">העלה קובץ אחר</a>
          <button class="creativecut-button blue-button" onclick="creativeCutPainter.submitDraftData('/');">שמור והעלה קובץ נוסף</button>
          <button class="creativecut-button blue-button" onclick="creativeCutPainter.submitDraftData('/cart');">שמור ועבור לביצוע הזמנה</button>
        </div>
      </div>
    </div>
  </div>
</div>