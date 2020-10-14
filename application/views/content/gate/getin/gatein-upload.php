<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">UPLOAD GATE IN</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">

        	
<form name="form_data" id="form_data" class="form-horizontal" role="form" action="execute/process/upload/codeco/gatein" method="post" autocomplete="off" enctype="multipart/form-data">
<!-- FORM HERE -->

<div class="form-group">
              <label class="col-sm-3 control-label-left">UPLOAD FILE</label>
              <div class="col-sm-4">  <input type="file" name="files" id="files" class="files" mandatory="yes"> </div>
<div class="col-sm-5">  <a href="<?php echo site_url('execute/download/excel/gatein'); ?>" class="btn btn-primary" data-toggle="tooltip" title="FORMAT EXCEL">
                          <i class="icon md-attachment">DOWNLOAD FORMAT FILE</i>
                        </a> </div>

</div>




          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function process(form,url){
	if(validasi(form)){
		var arrform = new FormData(document.getElementById(form));
		$.ajax({
		type: 'POST',
		url : site_url+'/'+url,
		data: arrform,
		dataType : 'json',
		enctype: 'multipart/form-data',
		processData: false,
		contentType: false,
		cache: false,
		beforeSend: function(){Loading(true)},
		complete: function(){Loading(false)},
		success: function(data){
			if(data.html!=null){
				$('#div_html').html(data.html);
				if(data.error==0){
					//$('.files').attr('disabled',true);
				}
			}else{
				$('#div_html').html('');
				notify(data.message,'error');
			}
		}
		});	
	}
}
</script>