<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab_aju" data-toggle="tab">DATA SURAT JALAN</a></li>
        <li style="width:100%;">&nbsp;</li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab_aju">
          <div class="row">
			  <div class="table-responsive">
				<table class="table m-b-0">
				  <tbody>
					<tr>
					  <th width="35%">NOMOR ORDER</th>
					  <td width="65%"><?php echo $arrhdr['NO_ORDER']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR SURAT JALAN</th>
					  <td><?php echo $arrhdr['NO_SP2']; ?></td>
					</tr>
					<tr>
					  <th>GUDANG / LAPANGAN</th>
					  <td><?php echo $arrhdr['GUDANG']; ?></td>
					</tr>
					<tr>
					  <th>NAMA KAPAL</th>
					  <td><?php echo $arrhdr['NM_ANGKUT']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR VOYAGE</th>
					  <td><?php echo $arrhdr['NO_VOYAGE']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL KEDATANGAN</th>
					  <td><?php echo $arrhdr['TGL_TIBA']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR POLISI TRUCK</th>
					  <td><?php echo $arrhdr['NO_POLISI_TRUCK']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR BL</th>
					  <td><?php echo $arrhdr['NO_BL_AWB']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR D/O</th>
					  <td><?php echo $arrhdr['NO_DO']; ?></td>
					</tr>
					<tr>
					  <th>NAMA PEMILIK</th>
					  <td><?php echo $arrhdr['CONSIGNEE']; ?></td>
					</tr>
					<tr>
					  <th>ALAMAT PEMILIK</th>
					  <td><?php echo $arrhdr['ALAMAT_CONSIGNEE']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL BERLAKU</th>
					  <td><?php echo $arrhdr['TGL_KELUAR']; ?></td>
					</tr>
				  </tbody>
				</table>
			  </div>
          </div>
			  <br>
				<?php echo $table_billing; ?>
			<div class="text-center">
				<button type="button" class="btn btn-danger btn-icon" onclick="jpopup_close();">CANCEL<i class="icon-close"></i></button>
				<button type="button" class="btn btn-primary btn-icon" onclick="print_popup('form_data','<?php echo $url;?>', '<?php echo $id;?>');">PRINT<i class="icon-check"></i></button>
			</div>
        </div>
      </div>
    </div>
  </div>
</div>
