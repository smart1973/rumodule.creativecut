<div id="content-wrapper">
  <div id="section-title">
    Mailing
  </div>
  <form method="post" action="/a-panel/sendMailing" enctype="multipart/form-data">
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
								var input = $('.mce-btn.mce-open').prev(), xhr = new XMLHttpRequest(), formData = new FormData();
								input.attr('disabled', 'disabled');
								formData.append('image', this.files[0]);
								formData.append('type', 'temporary');
								xhr.upload.onprogress = function (e) {
									var percents = Math.round(e.loaded / e.total * 100);
									input.val(e.loaded == e.total ? 'Wait please, file is saving.' : percents + '%');
								};
								xhr.onreadystatechange = function () {
									if (this.readyState == 4 && this.status == 200) {
										picker.value = '';
										input.removeAttr('disabled');
										callback(this.responseText, {
											alt: ''
										});
									}
								};
								xhr.open('POST', '/save-mce-image', true);
								xhr.send(formData);
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
    <table class="form-edit">
      <tbody>
        <tr>
          <th>Specialties: </th>
          <td>
						<select name="specialties">
							<option value="0">All</option>
							<?php foreach ($specialties as $id => $specialty) : ?>
							<option value="<?php echo $id ?>"><?php echo $specialty ?></option>
							<?php endforeach; ?>
						</select>
					</td>
        </tr>
				<tr>
          <th>Subject: </th>
          <td>
						<input type="text" name="subject"<?php if (isset($subject)) : ?> value="<?php echo $subject ?>"<?php endif; ?>>
						<?php if (isset($errors['subject'])) : ?><div class="error"><?php echo $errors['subject'] ?></div><?php endif; ?>
					</td>
        </tr>
				<tr>
          <th>Message: </th>
          <td>
						<textarea name="message"><?php if (isset($message)) echo $message ?></textarea>
						<div>
							<a href="javascript:void(0);" onclick="tinymce.execCommand('mceToggleEditor', false, 'message');">Toggle TinyMCE</a>
						</div>
						<?php if (isset($errors['message'])) : ?><div class="error"><?php echo $errors['message'] ?></div><?php endif; ?>
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