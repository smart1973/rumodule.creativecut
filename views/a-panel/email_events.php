<div id="content-wrapper">
  <div id="section-title">
    Email events
  </div>
  <form method="post" action="/a-panel/emailEvents" enctype="multipart/form-data">
    <script type="text/javascript">
			(function () {
				var picker = document.createElement('input');
				picker.type = 'file';
				tinymce.init({
					selector: 'textarea',
					convert_urls: false,
					height: 250,
					width: 580,
					menubar: false,
					file_browser_callback_types: 'image',
					file_picker_callback: function(callback, value, meta) {
						if (meta.filetype == 'image') {
							picker.click();
							picker.onchange = function () {
								var file = this.files[0];
								var reader = new FileReader();
								reader.onload = function(e) {
									callback(e.target.result, {
										alt: ''
									});
									picker.value = '';
								};
								reader.readAsDataURL(file);
							};
						}
					},
					plugins: [
						'advlist autolink lists link image charmap print preview anchor textcolor colorpicker',
						'searchreplace visualblocks code fullscreen',
						'insertdatetime media table contextmenu paste code directionality'
					],
					toolbar: 'insert | undo redo |  formatselect | bold italic backcolor forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | ltr rtl | link image',
				});
			})();
    </script>
    <table class="form-edit full-width-text wysiwyg va-top">
      <tbody>
        <tr>
          <th>Register event: </th>
          <td>
						<div class="mb-10">
							Tokens: !name, !surname
              <label>
                <div>Subject:</div>
                <input type="text" name="email_events[register_event][subject]"<?php if (isset($email_events['register_event']['subject'])) : ?> value="<?php echo htmlspecialchars($email_events['register_event']['subject']) ?>"<?php endif; ?>>
              </label>
              <?php if (isset($errors['register_event']['subject'])) : ?><div class="error"><?php echo $errors['register_event']['subject'] ?></div><?php endif; ?>
            </div>
            <div>
              <label>
                <div>Body:</div>
                <textarea name="email_events[register_event][body]"><?php if (isset($email_events['register_event']['body'])) echo htmlspecialchars($email_events['register_event']['body']) ?></textarea>
                <div>
                  <a href="javascript:void(0);" onclick="tinymce.execCommand('mceToggleEditor', false, 'email_events[register_event][body]');">Toggle TinyMCE</a>
                </div>
              </label>
              <?php if (isset($errors['register_event']['body'])) : ?><div class="error"><?php echo $errors['register_event']['body'] ?></div><?php endif; ?>
            </div>
					</td>
        </tr>
        <tr>
          <th>Order create: </th>
          <td>
						<div class="mb-10">
							Tokens: !name, !surname, !order_number
              <label>
                <div>Subject:</div>
                <input type="text" name="email_events[order_create][subject]"<?php if (isset($email_events['order_create']['subject'])) : ?> value="<?php echo htmlspecialchars($email_events['order_create']['subject']) ?>"<?php endif; ?>>
              </label>
              <?php if (isset($errors['order_create']['subject'])) : ?><div class="error"><?php echo $errors['order_create']['subject'] ?></div><?php endif; ?>
            </div>
            <div>
              <label>
                <div>Body:</div>
                <textarea name="email_events[order_create][body]"><?php if (isset($email_events['order_create']['body'])) echo htmlspecialchars($email_events['order_create']['body']) ?></textarea>
                <div>
                  <a href="javascript:void(0);" onclick="tinymce.execCommand('mceToggleEditor', false, 'email_events[order_create][body]');">Toggle TinyMCE</a>
                </div>
              </label>
              <?php if (isset($errors['order_create']['body'])) : ?><div class="error"><?php echo $errors['order_create']['body'] ?></div><?php endif; ?>
            </div>
					</td>
        </tr>
        <tr>
          <th>Order not payed 3 days: </th>
          <td>
						<div class="mb-10">
							Tokens: !name, !surname
              <label>
                <div>Subject:</div>
                <input type="text" name="email_events[order_not_payed_3_days][subject]"<?php if (isset($email_events['order_not_payed_3_days']['subject'])) : ?> value="<?php echo htmlspecialchars($email_events['order_not_payed_3_days']['subject']) ?>"<?php endif; ?>>
              </label>
              <?php if (isset($errors['order_not_payed_3_days']['subject'])) : ?><div class="error"><?php echo $errors['order_not_payed_3_days']['subject'] ?></div><?php endif; ?>
            </div>
            <div>
              <label>
                <div>Body:</div>
                <textarea name="email_events[order_not_payed_3_days][body]"><?php if (isset($email_events['order_not_payed_3_days']['body'])) echo htmlspecialchars($email_events['order_not_payed_3_days']['body']) ?></textarea>
                <div>
                  <a href="javascript:void(0);" onclick="tinymce.execCommand('mceToggleEditor', false, 'email_events[order_not_payed_3_days][body]');">Toggle TinyMCE</a>
                </div>
              </label>
              <?php if (isset($errors['order_not_payed_3_days']['body'])) : ?><div class="error"><?php echo $errors['order_not_payed_3_days']['body'] ?></div><?php endif; ?>
            </div>
					</td>
        </tr>
        <tr>
          <th>Order not payed a week: </th>
          <td>
						<div class="mb-10">
							Tokens: !name, !surname
              <label>
                <div>Subject:</div>
                <input type="text" name="email_events[order_not_payed_a_week][subject]"<?php if (isset($email_events['order_not_payed_a_week']['subject'])) : ?> value="<?php echo htmlspecialchars($email_events['order_not_payed_a_week']['subject']) ?>"<?php endif; ?>>
              </label>
              <?php if (isset($errors['order_not_payed_a_week']['subject'])) : ?><div class="error"><?php echo $errors['order_not_payed_a_week']['subject'] ?></div><?php endif; ?>
            </div>
            <div>
              <label>
                <div>Body:</div>
                <textarea name="email_events[order_not_payed_a_week][body]"><?php if (isset($email_events['order_not_payed_a_week']['body'])) echo htmlspecialchars($email_events['order_not_payed_a_week']['body']) ?></textarea>
                <div>
                  <a href="javascript:void(0);" onclick="tinymce.execCommand('mceToggleEditor', false, 'email_events[order_not_payed_a_week][body]');">Toggle TinyMCE</a>
                </div>
              </label>
              <?php if (isset($errors['order_not_payed_a_week']['body'])) : ?><div class="error"><?php echo $errors['order_not_payed_a_week']['body'] ?></div><?php endif; ?>
            </div>
					</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <input type="submit" value="Send" name="send">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>