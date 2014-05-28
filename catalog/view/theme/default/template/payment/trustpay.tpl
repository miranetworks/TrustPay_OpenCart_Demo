<form action="<?php echo $action; ?>" method="get">
  <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>" />
  <input type="hidden" name="appuser" value="<?php echo $appuser; ?>" />
  <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
  <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
  <input type="hidden" name="txid" value="<?php echo $txid; ?>" />
  <input type="hidden" name="fail" value="<?php echo $fail; ?>" />
  <input type="hidden" name="success" value="<?php echo $success; ?>" />
  <input type="hidden" name="message" value="Opencart checkout transaction." />
  <input type="hidden" name="istest" value="true" />  
  <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
    </div>
  </div>
</form>
