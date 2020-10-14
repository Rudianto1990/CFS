<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="author" content="@_@eriktrianto">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script>
var base_url = '<?php echo base_url(); ?>';
var site_url = '<?php echo site_url(); ?>';
</script>
{_add_header_}
<title>{_appname_}</title>
<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/ipc-logo.png">
</head>
<body class="page-loading">
<div class="pageload">
  <div class="pageload-inner">
    <div class="sk-rotating-plane"></div>
  </div>
</div>
{_content_}
</body>
</html>