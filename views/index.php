<?php global $controller; ?>
<div class="content file-upload-page">
  <script type="text/javascript" src="/js/save_file.js"></script>
  <div id="file-upload">
    <h1>Загрузить файлы</h1>
    <div class="description">Теперь вы можете загружать файлы DXF. Мы продолжаем совершенствовать систему, и в будущем появится возможность загружать дополнительные типы файлов.</div>
    <div class="file-upload-outer">
      <div class="file-upload-wrapper">
        <div class="drag-and-drop-wrapper">
          <div id="upload-progress"></div>
          <div class="drag-and-drop"> Нажмите, чтобы выбрать файл для загрузки в систему</div>
          <div id="selected-file-name"><span></span><span></span></div>
          <a id="select-graphic-module-file">Выбрать файлы</a>
          <input type="file" id="graphic-module-file">
        </div>
        <div class="drag-and-drop-description"></div>
        <input type="text" id="file-name">
        <div id="file-name-placeholder">
          Вы можете переименовать файл *
        </div>
        <div id="public-wrapper">
          <input type="checkbox" id="public">
          <span>Разрешить клиентам заказывать файл за плату</span>
        </div>
        <button id="upload-file" class="creativecut-button blue-button">הבא</button>
        <?php if (isset($_SESSION['current_file_id']) && Models::get('Bids')->get($_SESSION['current_file_id'])) : ?>
        <a href="/file/<?php echo $_SESSION['current_file_id'] ?>" id="continue-editing" class="creativecut-button blue-button">חזור וערוך קובץ קודם</a>
        <?php endif; ?>
      </div>
    </div>
    <div class="file-upload-bottom">
      Когда вы загружаете файл в CreativeCut, вы соглашаетесь с <a href="/" class="show-popup" popup-width="1200" popup-height="600" popup-content="<?php echo htmlspecialchars($controller->agreeRules) ?>">условиями использования</a>
    </div>
  </div>
</div>