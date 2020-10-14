<?php //print_r($action);die(); ?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divtbldenah'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('setting/process/'.$action.'/denah/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtbldenah'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                <!--   <input type="hidden" name="DATA[KD_GUDANG_DTL]" id="ID" mandatory="no" class="form-control" value="<?php //echo trim($arrdata['KD_GUDANG_DTL']); ?>"> -->
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KODE GUDANG DETAIL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[KD_GUDANG_DTL]" id="ID" mandatory="yes" class="form-control" placeholder="KODE GUDANG DETAIL" value="<?php echo trim($arrdata['KD_GUDANG_DTL']); ?>">
                  <div class="hint">KODE LAPANGAN/GUDANG</div>
                </div>
              </div>
              <!--<div class="form-group form-material">
                <label class="col-sm-3 control-label">KODE TPS</label>
                <div class="col-sm-8">-->
                  <input type="hidden" name="DATA[KD_TPS]" id="KD_TPS" readonly="readonly" mandatory="yes" class="form-control" placeholder="KODE TPS" value="<?php echo "CMGT";//trim($arrdata['KD_TPS']); ?>">
                 <!-- <div class="hint">KODE TPS</div>
                </div>-->
                <!--<div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mst_gudang/KD_TPS|TIPE/2');"><span class="icon md-search"></span></button>
                </div>
              </div>-->
              <!--<div class="form-group form-material">
                <label class="col-sm-3 control-label">KODE GUDANG</label>
                <div class="col-sm-9">
                 <select class="form-control focus" name="DATA[KD_TIPE_GUDANG]" id="TIPE">
                  <option value="<?php ///echo $arrdata['KD_GUDANG'] ?>"><?php //echo $arrdata['KD_GUDANG'] ?></option>
                  <option value="LAP">LAPANGAN</option>
                  <option value="GDG">GUDANG</option>
                </select> -->
                  <!---->
                  <input type="hidden" name="DATA[KD_GUDANG]" readonly="readonly" id="TIPE" mandatory="yes" class="form-control" placeholder="KODE GUDANG" value="<?php echo "CMGT";//$arrdata['KD_GUDANG']; ?>">
                  <!--<div class="hint">KODE GUDANG</div>
                </div>
              </div>-->
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA LAPANGAN/GUDANG</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NAMA_GUDANG_LAPANGAN]" id="NM_LAP" mandatory="yes" class="form-control" placeholder="NAMA LAPANGAN/GUDANG" value="<?php echo $arrdata['NAMA_GUDANG_LAPANGAN']; ?>">
                  <div class="hint">NAMA LAPANGAN/GUDANG</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PANJANG & LEBAR</label>
                <div class="col-sm-4">
                  <input type="text" name="DATA[PANJANG]" id="P" mandatory="yes" class="form-control" placeholder="PANJANG" value="<?php echo $arrdata['PANJANG']; ?>" maxlength="10">
                  <div class="hint">PANJANG & LEBAR</div>
                </div>
				<div class="col-sm-5">
                  <input type="text" name="DATA[LEBAR]" id="L" mandatory="yes" class="form-control" placeholder="LEBAR" value="<?php echo $arrdata['LEBAR']; ?>" maxlength="10">
                  <div class="hint">LEBAR</div>
                </div>
              </div>
          </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('setting/gudang_detail/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>
