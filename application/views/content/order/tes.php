<?php 
//ini_set('max_file_uploads', "50");
echo "max_file_uploads: " . ini_get('max_file_uploads');
?><div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo $title; ?></a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <?php if($act=='save' || $arrhdr['KD_STATUS']=='100'){?><button type="button" class="btn btn-primary btn-icon" id="buti" onclick="<?php echo ($act=='proses')?'process_popup(\'form_data\',\'divtblppbarang\',\''.$gd.'\');':'save_ajax(\'form_data\');';?> return false;"><?php echo ($act=='proses')?'PROCESS':'SAVE';?><i class="icon-check"></i></button><?php } ?>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo 'order/execute/'.$act.'/tes/'.$id; ?>" enctype= "multipart/form-data" method="post" autocomplete="off" onsubmit="<?php echo ($act=='proses')?'process_popup(\'form_data\',\'divtblppbarang\',\''.$gd.'\');':'save_ajax(\'form_data\');';?> return false;">
			<!--div id="fileuploader">Upload</div-->
			<input id="tes" type="file" name="tes[]" class="file" multiple><?php //data-show-preview="false" ?><br>
			<!--input id="input-706" name="kartik-input-706[]" type="file" multiple=true class="file-loading"-->
          </form><?php echo $ttt;?><?php //echo $qrcode;?>
	  <div class="table-responsive">
		<table class="tabelajax responsive m-b-0">
          <thead>
            <tr><th>No</th><th>ID HDR</th><th>SERI</th><th>NO BL</th><th>KD KEMASAN</th><th>JUMLAH</th><th>NO CONT</th><th>WK IN</th><th>WK OUT</th><th>GUDANG ASAL</th><th>GUDANG TUJUAN</th></tr>
          </thead>
          <tbody>
            <?php $no=1;
              foreach($kms as $row){ ?>
              <tr>
                <td data-th="Id"><?php echo $no;?></td>
                <td data-th="Group Name"><?php echo $row['ID'];?></td>
                <td data-th="Group Name"><?php echo $row['SERI'];?></td>
                <td data-th="Group Name"><?php echo $row['NO_BL_AWB'];?></td>
                <td data-th="Group Name"><?php echo $row['KD_KEMASAN'];?></td>
                <td data-th="Group Name"><?php echo $row['JUMLAH'];?></td>
                <td data-th="Group Name"><?php echo $row['NO_CONT_ASAL'];?></td>
                <td data-th="Group Name"><?php echo $row['WK_IN'];?></td>
                <td data-th="Group Name"><?php echo $row['WK_OUT'];?></td>
                <td data-th="Group Name"><?php echo $row['KD_GUDANG'];?></td>
                <td data-th="Group Name"><?php echo $row['KD_GUDANG_TUJUAN'];?></td>
              </tr>
            <?php $no++;} ?>
          </tbody>
        </table>
		</div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>.krajee-default .file-thumb-progress {top: 55px}</style> <!-- styling overrides -->
<script>
var $el2 = $("#input-706");
 
// custom footer template for the scenario
// the custom tags are in braces
 
var footerTemplate = '<div class="file-thumbnail-footer" style ="height:94px">\n' +
'   <div style="margin:5px 0">\n' +
'       <input class="kv-input kv-new form-control input-sm text-center {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n' +
'       <select class="kv-input kv-new form-control input-sm text-center" name="oke[]"><option value="DO">DO</option><option value="MANIFEST">MANIFEST</option><option value="OTHER">OTHER</option></select>\n' +
'       <input class="kv-input kv-init form-control input-sm text-center {TAG_CSS_INIT}" value="{TAG_VALUE}" placeholder="Enter caption..." disabled>\n' +
'   </div>\n' +
'   {size} {progress} {actions}\n' +
'</div>';
                
$el2.fileinput({
    uploadUrl: '<?php echo site_url('order/execute/'.$act.'/tes/'.$id); ?>',
    uploadAsync: false,
    maxFileCount: 5,
    overwriteInitial: false,
    layoutTemplates: {footer: footerTemplate},
    previewThumbTags: {
        '{TAG_VALUE}': '',        // no value
        '{TAG_CSS_NEW}': '',      // new thumbnail input
        '{TAG_CSS_INIT}': 'hide'  // hide the initial input
    },
    initialPreview: [
        "<img style='height:160px' src='http://lorempixel.com/800/460/city/1'>",
        "<img style='height:160px' src='http://lorempixel.com/800/460/city/2'>",
    ],
    initialPreviewConfig: [
        {caption: "City-1.jpg", size: 327892, width: "120px", url: "/site/file-delete", key: 1},
        {caption: "City-2.jpg", size: 438828, width: "120px", url: "/site/file-delete", key: 2}, 
    ],
    initialPreviewThumbTags: [
        {'{TAG_VALUE}': 'City-1.jpg', '{TAG_CSS_NEW}': 'hide', '{TAG_CSS_INIT}': ''},
        {
            '{TAG_VALUE}': function() { // callback example
                return 'City-2.jpg';
            },
            '{TAG_CSS_NEW}': 'hide',
            '{TAG_CSS_INIT}': ''
        }
    ],
    uploadExtraData: function() {  // callback example
        var out = {}, key, i = 0;
        $('.kv-input:visible').each(function() {
            $el = $(this);
            key = $el.hasClass('kv-new') ? 'new_' + i : 'init_' + i;
            out[key] = $el.val();
            i++;
        });
        return out;
    }
});</script>
<script>
$('#tes').fileinput({
	showUpload: false,
    maxFileCount: 5,
	allowedFileExtensions: ["jpg", "png", "gif","txt","docx"],
	language: 'id'
});
$(document).ready(function()
{
	$("#fileuploader").uploadFile({
	url:"<?php echo site_url('order/execute/'.$act.'/tes/'.$id); ?>",
	multiple:true,
	//maxFileCount:1,
	fileName:"myfile",
	maxFileSize:20*1024*1024
	});
});</script>
