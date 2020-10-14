<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li><a href="#tab_aju" data-toggle="tab">DATA USER</a></li>
        <li class="active"><a href="#tab_kms" data-toggle="tab">DETAIL TAGIHAN</a></li>
        <li style="width:100%;">&nbsp;</li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg" id="tab_aju">
          <div class="row">
			  <div class="table-responsive">
				<table class="table m-b-0">
				  <tbody>
					<tr>
					  <th width="35%">NOMOR CLEARING PLP</th>
					  <td width="65%"><?php echo $arrhdr['NO_ORDER']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR PERMOHONAN CFS</th>
					  <td><?php echo $arrhdr['NO_BL']; ?></td>
					</tr>
					<tr>
					  <th>NAMA FORWARDER</th>
					  <td><?php echo $arrhdr['NAMA_FORWARDER']; ?></td>
					</tr>
					<tr>
					  <th>TERMINAL ASAL</th>
					  <td><?php echo $arrhdr['NM_GUDANG']; ?></td>
					</tr>
					<tr>
					  <th>GUDANG TUJUAN</th>
					  <td><?php echo $arrhdr['NM_GUDANG']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR BC 1.1</th>
					  <td><?php echo $arrhdr['NO_DO']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL BC 1.1</th>
					  <td><?php echo $arrhdr['TGL_DO']; ?></td>
					</tr>
					<tr>
					  <th>NAMA KAPAL</th>
					  <td><?php echo $arrhdr['NO_CONT_ASAL']; ?></td>
					</tr>
					<tr>
					  <th>CALLSIGN</th>
					  <td><?php echo $arrhdr['DOK_BC']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR VOYAGE</th>
					  <td><?php echo $arrhdr['NO_SPPB']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL TIBA</th>
					  <td><?php echo $arrhdr['TGL_SPPB']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR CONTAINER</th>
					  <td><?php echo $arrhdr['NAMA_IMP']; ?></td>
					</tr>
					<tr>
					  <th>STATUS</th>
					  <td><?php echo $arrhdr['NPWP_IMP']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL KONFIRMASI</th>
					  <td><?php echo $arrhdr['NAMA_KAPAL']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL BUAT</th>
					  <td><?php echo $arrhdr['TGL_TIBA']; ?></td>
					</tr>
					<tr>
					  <th>PETUGAS</th>
					  <td><?php echo $arrhdr['VOLUME']; ?></td>
					</tr>
				  </tbody>
				</table>
			  </div>
          </div>
        </div>
        <div class="tab-pane p-x-lg active" id="tab_kms">
			  <div class="table-responsive">
				<table class="table m-b-0">
				  <tbody>
					<tr>
					  <th width="35%">NOMOR CONTAINER</th>
					  <td width="65%"><?php echo $arrhdr['NO_BL']; ?></td>
					</tr>
					<tr>
					  <th>WAKTU GATE IN CONTAINER</th>
					  <td><?php echo $arrhdr['WK_GATE_IN']; ?></td>
					</tr>
					<tr>
					  <th>STATUS</th>
					  <td><?php echo $arrhdr['STATUS']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL BUAT</th>
					  <td><?php echo $arrhdr['WK_REKAM']; ?></td>
					</tr>
					<?php if($arrhdr['TGL_STATUS']!=null){?>
					<tr>
					  <th>TANGGAL GENERATE BILLING</th>
					  <td><?php echo $arrhdr['TGL_STATUS']; ?></td>
					</tr>
					<?php }?>
				  </tbody>
				</table>
			  </div>
              <div class="card bg-white">
                <div class="card-header">BILLING LAYANAN PETI KEMAS</div>
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
			<div class="text-center">
			<?php if($arrhdr['TGL_STATUS']!=null){?>
				<button type="button" class="btn btn-primary btn-icon" onclick="print_popup('form_data','<?php echo $url;?>', '<?php echo $id;?>');">PRINT<i class="icon-check"></i></button>
			<?php }else{?>
				<button type="button" class="btn btn-danger btn-icon" onclick="jpopup_close();">CANCEL<i class="icon-close"></i></button>
				<button type="button" class="btn btn-primary btn-icon" onclick="">SUBMIT<i class="icon-check"></i></button>
			<?php }?>
			</div>
        </div>
      </div>
    </div>
  </div>
</div>
