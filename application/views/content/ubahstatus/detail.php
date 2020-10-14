<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary"> <span class="ribbon-inner"> <i class="icon md-boat margin-0" aria-hidden="true"></i> DETAIL PERMOHONAN CFS</span> </div>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
         <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material col-sm-12">
                <label class="col-sm-2 control-label"><strong>NO PERMOHONAN CFS</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['NO_PERMOHONAN_CFS'];?>
                 </div>
                  <label class="col-sm-2 control-label"><strong>TGL PERMOHONAN CFS</strong></label>
                    <div class="col-sm-4">
                 <?php echo $arrhdr['TGL_PERMOHONAN_CFS'];?>
                 </div>
              </div>
             <div class="form-group form-material col-sm-12">
                <label class="col-sm-2 control-label"><strong>TERMINAL</strong></label>
                <div class="col-sm-10">
                 <?php echo $arrhdr['GUDANGASAL'];?>
                </div> 
                </div> 
                 <div class="form-group form-material col-sm-12">
                <label class="col-sm-2 control-label"><strong>WAREHOUSE</strong></label>
                <div class="col-sm-10">
                 <?php echo $arrhdr['GUDANGTUJUAN'];?>
                </div></div>
            <div class="form-group form-material col-sm-12">
                <label class="col-sm-2 control-label"><strong>PEMOHON</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['NM_LENGKAP'];?>
                </div><label class="col-sm-2 control-label"><strong>STATUS</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['STATUS'];?>
                </div></div><div class="form-group form-material col-sm-12">
                <label class="col-sm-2 control-label"><strong>NAMA KAPAL</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['NAMA_KAPAL'];?>
                </div><label class="col-sm-2 control-label"><strong>NO. VOYAGE</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['NO_VOY_FLIGHT'];?>
                </div></div><div class="form-group form-material col-sm-12">
                <label class="col-sm-2 control-label"><strong>CALL SIGN</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['CALL_SIGN'];?>
                </div><label class="col-sm-2 control-label"><strong>TGL TIBA</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['TGL_TIBA'];?>
                </div></div><div class="form-group form-material col-sm-12">
                <label class="col-sm-2 control-label"><strong>NO. BC11</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['NO_BC11'];?>
                </div><label class="col-sm-2 control-label"><strong>TGL BC 11</strong></label>
                <div class="col-sm-4">
                 <?php echo $arrhdr['TGL_BC11'];?>
                </div></div>

                
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  <span class="ribbon-inner"> <i class="icon md-collection-item margin-0" aria-hidden="true"></i> DATA DETAIL</span>
  </div>
  <div>&nbsp;</div>
  <div class="nav nav-tabs-horizontal nav-tabs-inverse nav-tabs-animate">
    <ul class="nav nav-tabs nav-tabs" data-plugin="nav-tabs" role="tablist">
      <li class="active" role="presentation">
        <a data-toggle="tab" href="#kontainer" aria-controls="kontainer" role="tab">
            <i class="icon md-view-list margin-0" aria-hidden="true"></i> KONTAINER
        </a>
      </li>
      <li role="presentation">
        <a data-toggle="tab" href="#kontainer1" aria-controls="kontainer1" role="tab">
            <i class="icon md-view-list margin-0" aria-hidden="true"></i> FILE DOKUMEN
        </a>
      </li>
    
    </ul>
    <div class="tab-content">
      <div class="tab-pane active animation-slide-top" id="kontainer" role="tabpanel">
        <?php echo $table_kontainer; ?>
      </div>
      <div class="tab-pane animation-slide-top" id="kontainer1" role="tabpanel">
        <?php echo $table_file; ?>
      </div>
    
    </div>
  </div>
</div>
