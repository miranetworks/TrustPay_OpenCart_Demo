<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>  
</div>
  <?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">      
<h1 class="panel-title"><i class="fa fa-credit-card fa-lg"></i> <?php echo $heading_title; ?></h1>
<div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>    
</div>
    <div class="content">
<script type="text/javascript">
       function reLoadPage(dropdown){
	var storeid=dropdown.options[dropdown.selectedIndex].value;
	var url = window.location.href;
	console.log(url);
	var i = url.indexOf("&store_id=");
	if(i>0){
		url=url.substring(0,i);
	}
	window.location=url+"&store_id="+storeid;

	}
     </script>


	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
	<tr>
        <td>
                <?php echo $entry_store; ?>
        </td>
        <td>
		<select name="store_id" onchange="reLoadPage(this);" >
		<?php if ($stores) { ?>
            		<?php foreach ($stores as $store) { ?>
				<?php if ($store_id == $store['store_id']) { ?>
				<option value="<?php echo $store['store_id']; ?>" selected><?php echo $store['name']; ?></option>
 				<?php } else { ?>
				 <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>			
				<?php } ?>
		<?php } ?>
               <?php } ?>
		</select>
        </td>
        </tr>
	<tr>
            <td><span class="required">*</span> <?php echo $entry_vendor_id; ?></td>
            <td><input type="text" name="trustpay_vendor_id" value="<?php echo $trustpay_vendor_id; ?>" />
              <span class="help-block"><?php echo $help_vendor_id; ?></span>
            </td>
        </tr>

	 <tr>
            <td><span class="required">*</span> <?php echo $entry_notification_url ?></td>
            <td><input type="text" name="trustpay_notification_url" value="<?php echo $trustpay_notification_url; ?>" />
              <span class="help-block"><?php echo $help_notification_url; ?></span>
            </td>
        </tr>

	<tr>
            <td><span class="required">*</span> <?php echo $entry_shared_secret; ?></td>
            <td><input type="text" name="trustpay_shared_secret" value="<?php echo $trustpay_shared_secret; ?>" />
              <span class="help-block"><?php echo $help_shared_secret; ?></span>
            </td>
        </tr>

	<tr>
            <td><span class="required">*</span> <?php echo $entry_total; ?></td>
            <td><input type="text" name="trustpay_total" value="<?php echo $trustpay_total; ?>" />
              <span class="help-block"><?php echo $help_total; ?></span>
            </td>
        </tr>

        <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="trustpay_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $trustpay_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
        
	  <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="trustpay_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $trustpay_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
	
	<tr>
            <td><?php echo $entry_status; ?></td>
            <td>
            <select name="trustpay_status" id="input-status" class="form-control">
              <?php if ($trustpay_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>
            </td>
       </tr>
 
	<tr>
            <td><span class="required">*</span> <?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="trustpay_sort_order" value="<?php echo $trustpay_sort_order; ?>" />
            </td>
        </tr>
      	
	</table>
	</form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
