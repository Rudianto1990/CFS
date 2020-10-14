<?php //print_r($detail_cont);die(); ?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-file-text margin-0" aria-hidden="true"></i> Denah Lapangan<?php //echo $title; ?>
    </span>
  </div>
  <!--<button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divtblkapal'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  --><BR><BR>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php //echo site_url('execute/process/'.$action.'/delivery/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtbldelivery'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
             <!--  <div class="form-group form-material">
               <div class="col-sm-9">
                 <input type="hidden" name="DATA[ID]" id="ID" class="form-control" value="<?php //echo trim($arrdata[0]->ID); ?>">
                 <input type="hidden" name="DATA[TGL_DOK]" id="ID_REQ" class="form-control" value="<?php //echo trim($arrdata[0]->TGL_DOK_INOUT); ?>">
                 <input type="hidden" name="DATA[NO_BL]" id="NO_BL" class="form-control" value="<?php //echo trim($arrdata[0]->NO_BL_AWB); ?>">
                 <input type="hidden" name="DATA[NM_KAPAL]" id="NO_BL" class="form-control" value="<?php //echo trim($arrdata[0]->NM_ANGKUT); ?>">
                 <div class="hint">TGL_DOK</div>
               </div>
             </div> -->
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">Coloumn</label>
                <div class="col-sm-9">
                  <input type="text" name="cols" id="cols" class="form-control" placeholder="Coloumn" value="<?php //echo $arrdata[0]->NM_ANGKUT; ?>" maxlength="10">
                  <div class="hint">Coloumn</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">Row</label>
                <div class="col-sm-9">
                  <input type="text"  name="rows" id="rows" class="form-control" placeholder="Row" value="<?php //echo $arrdata[0]->NM_ANGKUT; ?>" maxlength="10">
                  <div class="hint">Row</div>
                </div>
              </div>
      <div class="container">      
      </div>  
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php //echo site_url('billing/delivery/post'); ?>"/>
          <input type="hidden" name="cont_post" id="cont_post" readonly="readonly">
        </form>
        <div class="col-sm-9">
          <button type="button" class="btn btn-sm btn-primary navbar-center navbar-btn waves-effect waves-light" onclick='createTable();'>
          <i class="icon md-badge-check"></i> Create Table
          </button>
          </div>
		  
		<script type="text/javascript">
			function createTable()
			{
				var num_rows = document.getElementById('rows').value;
				var num_cols = document.getElementById('cols').value;
				var theader = '<table class="table" border="1">\n';
				var tbody = '';

				for( var i=0; i<num_rows;i++)
				{
					tbody += '<tr>';
					for( var j=0; j<num_cols;j++)
					{
						tbody += '<td>';
						tbody += 'Cell ' + i + ',' + j;
						tbody += '</td>'
					}
					tbody += '</tr>\n';
				}
				var tfooter = '</table>';
				document.getElementById('wrapper').innerHTML = theader + tbody + tfooter;
			}
			</script>
      </div>
    </div>
  </div>
  <div class="col-sm-9">
    <div id="wrapper"></div>
  </div>
</div>