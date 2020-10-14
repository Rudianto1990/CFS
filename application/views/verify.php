<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html class="no-js"> 
    <head>
    	<script>
            var base_url = '<?php echo base_url(); ?>';
            var site_url = '<?php echo site_url(); ?>';
        </script>
    	<meta http-equiv="author" content="@_@eriktrianto">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>CFS CENTER</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        {_add_header_}
    </head>
    <body class="page-loading"> 
    	<div class="pageload">
          <div class="pageload-inner">
            <div class="sk-rotating-plane"></div>
          </div>
        </div>
    	<div class="app layout-fixed-header">
        	{_menus_}
            <div class="main-panel">
            	{_header_}
                <div class="main-content">
                	{_breadcrumbs_}
                    <div class="row">
                		{_content_}
                    </div>
                </div>
            </div>
            {_footer_}
        </div>
        {_add_script_}
    </body>
</html>
