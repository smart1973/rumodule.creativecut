<div id="content-wrapper">
  <div id="section-title">
    Sms events
  </div>
  <form method="post" action="/a-panel/smsEvents" enctype="multipart/form-data">
    <table class="form-edit full-width-text va-top">
      <tbody>
				<tr>
          <th>The order is payed: </th>
          <td>
						<div class="mb-10">
							Tokens: !order_id, !name
            </div>
            <div>
              <label>
                <div>Text:</div>
                <textarea name="sms_events[order_payed]"><?php if (isset($sms_events['order_payed'])) echo htmlspecialchars($sms_events['order_payed']) ?></textarea>
              </label>
              <?php if (isset($errors['order_payed'])) : ?><div class="error"><?php echo $errors['order_payed'] ?></div><?php endif; ?>
            </div>
					</td>
        </tr>
        <tr>
          <th>The order is completed: </th>
          <td>
						<div class="mb-10">
							Tokens: !order_id, !name
            </div>
            <div>
              <label>
                <div>Text:</div>
                <textarea name="sms_events[order_status_3]"><?php if (isset($sms_events['order_status_3'])) echo htmlspecialchars($sms_events['order_status_3']) ?></textarea>
              </label>
              <?php if (isset($errors['order_status_3'])) : ?><div class="error"><?php echo $errors['order_status_3'] ?></div><?php endif; ?>
            </div>
					</td>
        </tr>
				<tr>
          <th>The order is completed(self checkout): </th>
          <td>
						<div class="mb-10">
							Tokens: !order_id, !name
            </div>
            <div>
              <label>
                <div>Text:</div>
                <textarea name="sms_events[order_status_3_selfcheckout]"><?php if (isset($sms_events['order_status_3_selfcheckout'])) echo htmlspecialchars($sms_events['order_status_3_selfcheckout']) ?></textarea>
              </label>
              <?php if (isset($errors['order_status_3_selfcheckout'])) : ?><div class="error"><?php echo $errors['order_status_3_selfcheckout'] ?></div><?php endif; ?>
            </div>
					</td>
        </tr>
				<tr>
          <th>The order in work: </th>
          <td>
						<div class="mb-10">
							Tokens: !order_id, !name
            </div>
            <div>
              <label>
                <div>Text:</div>
                <textarea name="sms_events[order_status_2]"><?php if (isset($sms_events['order_status_2'])) echo htmlspecialchars($sms_events['order_status_2']) ?></textarea>
              </label>
              <?php if (isset($errors['order_status_2'])) : ?><div class="error"><?php echo $errors['order_status_2'] ?></div><?php endif; ?>
            </div>
					</td>
        </tr>
				<tr>
          <th>Confirmation phone number: </th>
          <td>
						<div class="mb-10">
							Tokens: !confirmation_code
            </div>
            <div>
              <label>
                <div>Text:</div>
                <textarea name="sms_events[confirmation_phone_number]"><?php if (isset($sms_events['confirmation_phone_number'])) echo htmlspecialchars($sms_events['confirmation_phone_number']) ?></textarea>
              </label>
              <?php if (isset($errors['confirmation_phone_number'])) : ?><div class="error"><?php echo $errors['confirmation_phone_number'] ?></div><?php endif; ?>
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