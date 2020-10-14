<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">DETAIL</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="print_popup('form_data','<?php echo $url; ?>', '<?php echo $id; ?>'); return false;">PRINT <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="" method="post" autocomplete="off">
            <div class="form-group">
              <label class="col-sm-3 control-label-left">NO BL</label>
              <div class="col-sm-9">
                <input type="text" name="NO_BL" value="<?php echo $arrhdr['NO_BL_AWB']; ?>"  id="NO_BL" class="form-control" placeholder="NOMOR BL" maxlength="50"  readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left" >NO SPPB</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="NO_SPPB" id="NO_SPPB"  placeholder="NOMOR SPPB" value="<?php echo $arrhdr['NO_DOK_INOUT']; ?>" maxlength="50" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">CONSIGNEE</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="NAMA_KAPAL" id="NAMA_KAPAL"  placeholder="NO CONTAINER" value="<?php echo $arrhdr['CONSIGNEE']; ?>" maxlength="50" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left" >NPWP CONSIGNEE</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="NM_PEMOHON" id="NM_PEMOHON"  placeholder="NAMA PEMOHON" value="<?php echo $arrhdr['NPWP']; ?>" maxlength="50" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">GUDANG</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="GUDANG" id="GUDANG_TUJUAN"  placeholder="NAMA GUDANG" value="<?php echo $arrhdr['GUDANG']; ?>" maxlength="50" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left" >NO BC 1.1</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="NM_PEMOHON" id="NM_PEMOHON"  placeholder="NAMA PEMOHON" value="<?php echo $arrhdr['NO_BC11']; ?>" maxlength="50" readonly>
              </div>
              <div class="col-sm-3">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_BC11']; ?>"  placeholder="TANGGAL SPPB" name="TGL_SPPB" id="TGL_SPPB" data-provide="datepicker" wajib="yes" readonly>
                </div>
              </div>
            </div>
          </form>
			<br>
              <div class="card bg-white">
                <div class="card-header">BILLING LAYANAN TERMINAL PLP</div>
                <div class="card-block p-a-0">
					<?php if($arrhdr!=null) echo $table_kemasan; else echo $table_kemasan; ?>
				  <div class="table-responsive">
					<table class="table m-b-0">
						<tr>
						  <td>
						  <div class="table-responsive">
							<table class="tabelajax responsive m-b-0">
							  <tbody>
								<tr class="active">
								  <th width="1%">NO</th>
								  <th>NAMA ITEM</th>
								  <th width="20%">TARIF</th>
								</tr>
								<tr>
								  <td>1</td><td>TES BARANG</td><td style="text-align:right">Rp 100.000,-</td>
								</tr>
								<tr>
								  <th colspan='2' style="text-align:right">SUB TOTAL :</th>
								  <th style="text-align:right">Rp 100.000,-</th>
								</tr>
							  </tbody>
							</table>
						  </div>
						  </td>
						</tr>
						<tr>
						  <th style="text-align:center">TOTAL : Rp 100.000,-</th>
						</tr>
					</table>
				  </div>
                </div>
              </div>
              <div class="card bg-white">
                <div class="card-header">DAFTAR TARIF LAYANAN CFS WAREHOUSE</div>
                <div class="card-block p-a-0">
				  <div class="table-responsive">
					<table class="table m-b-0">
						<tr>
						  <th>1. CFS</th>
						</tr>
						<tr>
						  <td>
						  <div class="table-responsive">
							<table class="tabelajax responsive m-b-0">
							  <tbody>
								<tr>
								  <th width="1%">NO</th>
								  <th>NAMA ITEM</th>
								  <th width="20%">TARIF</th>
								</tr>
								<tr>
								  <td>1</td><td>TES BARANG</td><td style="text-align:right">Rp 100.000,-</td>
								</tr>
								<tr>
								  <th colspan='2' style="text-align:right">SUB TOTAL :</th>
								  <th style="text-align:right">Rp 100.000,-</th>
								</tr>
							  </tbody>
							</table>
						  </div>
						  </td>
						</tr>
						<tr>
						  <th>2. OPERATOR</th>
						</tr>
						<tr>
						  <td>
						  <div class="table-responsive">
							<table class="tabelajax responsive m-b-0">
							  <tbody>
								<tr class="active">
								  <th width="1%">NO</th>
								  <th>NAMA ITEM</th>
								  <th width="20%">TARIF</th>
								</tr>
								<tr>
								  <td>1</td><td>TES BARANG</td><td style="text-align:right">Rp 100.000,-</td>
								</tr>
								<tr>
								  <th colspan='2' style="text-align:right">SUB TOTAL :</th>
								  <th style="text-align:right">Rp 100.000,-</th>
								</tr>
							  </tbody>
							</table>
						  </div>
						  </td>
						</tr>
						<tr>
						  <th style="text-align:center">TOTAL : Rp 200.000,-</th>
						</tr>
					</table>
				  </div>
                </div>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>
