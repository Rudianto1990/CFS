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

          
                <form name="form_data" id="form_data" class="form-horizontal" role="form" action="execute/process/upload/codeco/gateout" method="post" autocomplete="off" enctype="multipart/form-data">
                  <div class="panel-body container-fluid">
                    <div class="form-group">
                      <div class="col-sm-2">&nbsp;</div>
                      <label class="col-sm-1 control-label">UPLOAD</label>
                      <div class="col-sm-5">


                          		<input type="file" name="files" id="files" class="files" mandatory="yes">
                         

                      </div>
                      <div class="col-sm-2">
                      	<a href="<?php echo site_url('execute/download/excel/gateout'); ?>" class="btn btn-primary" data-toggle="tooltip" title="FORMAT EXCEL">
                        	<i class="icon md-attachment">DONWLOAD FORMAT LAMPIRAN</i>
                       	</a>
                      </div>
                    </div>
                  </div>
                  <div id="div_html" style="overflow:auto">&nbsp;</div>
                  <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('gate/out_container'); ?>"/>
                </form>
                     </div>
      </div>
    </div>
  </div>
</div>

          <!--<div class="panel">
            <div class="panel-heading" id="HeadingTwo" role="tab">
            	<a class="panel-title collapsed" data-parent="#exampleAccordion" data-toggle="collapse" href="#CollapseTwo" aria-controls="CollapseTwo" aria-expanded="false">KEMASAN</a>
            </div>
            <div class="panel-collapse collapse" id="CollapseTwo" aria-labelledby="HeadingTwo" role="tabpanel">
              <div class="panel-body">BELUM TERSEDIA</div>
            </div>
          </div>-->
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