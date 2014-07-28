<?php echo $header; ?>
<script type="text/javascript">
var doStuff = function loadXMLDoc() {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log("Got back from AJAX:"+xmlhttp.responseText);
                if(xmlhttp.responseText=='5'){
                        clearTimeout(timeOutId);
                        document.location = "index.php?route=checkout/success";
                } else if(xmlhttp.responseText=='10'){
                        clearTimeout(timeOutId);
                        document.location = "index.php?route=checkout/failure";
                } else {
                        timeOutId =setTimeout(doStuff, 1000);
                }
        }
    }
    console.log("CALLING AJAX!!!!!"+"http://127.0.0.1/index.php?route=payment/trustpay/getstatus&transaction_id="+txid);
    xmlhttp.open("GET", "index.php?route=payment/trustpay/getstatus&transaction_id="+txid, true);
    xmlhttp.send();
}
var txid=location.search.split('transaction_id=')[1];

timeOutId =setTimeout(doStuff, 1000);
</script>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php echo $text_message; ?>
        <div>
        <p style="text-align:center">
        <img src="/image/spinner.gif" alt="Busy!">
        </p>
        </div>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
<?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
                           

