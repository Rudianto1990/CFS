<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab_aju" data-toggle="tab">DATA SP2</a></li>
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
					  <th>NOMOR SP2</th>
					  <td><?php echo $arrhdr['NO_SP2']; ?></td>
					</tr>
					<tr>
					  <th>GUDANG / LAPANGAN</th>
					  <td><?php echo $arrhdr['GUDANGTUJUAN']; ?></td>
					</tr>
					<tr>
					  <th>NAMA PBM</th>
					  <td><?php echo $arrhdr['NAMA_FORWARDER']; ?></td>
					</tr>
					<tr>
					  <th>NPWP PBM</th>
					  <td><?php echo $arrhdr['NPWP_FORWARDER']; ?></td>
					</tr>
					<tr>
					  <th>ALAMAT PBM</th>
					  <td><?php echo $arrhdr['ALAMAT_FORWARDER']; ?></td>
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
