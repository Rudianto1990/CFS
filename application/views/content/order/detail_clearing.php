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
					<!--tr>
					  <th>NOMOR PERMOHONAN CFS</th>
					  <td><?php //echo $arrhdr['NO_PERMOHONAN_CFS']; ?></td>
					</tr-->
					<tr>
					  <th>JENIS PEMBAYARAN</th>
					  <td><?php echo $arrhdr['JENIS_PEMBAYARAN']; ?></td>
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
					<tr>
					  <th>NAMA PEMILIK</th>
					  <td><?php echo $arrhdr['CONSIGNEE']; ?></td>
					</tr>
					<tr>
					  <th>NPWP PEMILIK</th>
					  <td><?php echo $arrhdr['NPWP_CONSIGNEE']; ?></td>
					</tr>
					<tr>
					  <th>ALAMAT PEMILIK</th>
					  <td><?php echo $arrhdr['ALAMAT_CONSIGNEE']; ?></td>
					</tr>
					<tr>
					  <th>TERMINAL ASAL</th>
					  <td><?php echo $arrhdr['GUDANGASAL']; ?></td>
					</tr>
					<tr>
					  <th>GUDANG TUJUAN</th>
					  <td><?php echo $arrhdr['GUDANGTUJUAN']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR BC 1.1</th>
					  <td><?php echo $arrhdr['NO_BC11']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL BC 1.1</th>
					  <td><?php echo $arrhdr['TGL_BC11']; ?></td>
					</tr>
					<tr>
					  <th>NAMA KAPAL</th>
					  <td><?php echo $arrhdr['NM_ANGKUT']; ?></td>
					</tr>
					<tr>
					  <th>CALLSIGN</th>
					  <td><?php echo $arrhdr['CALL_SIGN']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR VOYAGE</th>
					  <td><?php echo $arrhdr['NO_VOYAGE']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL TIBA</th>
					  <td><?php echo $arrhdr['TGL_TIBA']; ?></td>
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
					  <th width="35%">STATUS</th>
					  <td width="65%"><?php echo $arrhdr['JENIS_PEMBAYARAN']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL BUAT</th>
					  <td><?php echo $arrhdr['WK_REKAM']; ?></td>
					</tr>
					<?php if($arrhdr['TGL_STATUS']!=null){?>
					<tr>
					  <th>TANGGAL APPROVE</th>
					  <td><?php echo $arrhdr['TGL_STATUS']; ?></td>
					</tr>
					<?php }?>
					<tr>
					  <th>NO ORDER</th>
					  <td><?php echo $billing['NO_ORDER']; ?></td>
					</tr>
					<tr>
					  <th>SUB TOTAL</th>
					  <td>Rp <?php echo number_format($billing['SUBTOTAL'], '0', ',', '.'); ?>,-</td>
					</tr>
					<!--tr>
					  <th>ADMINISTRASI</th>
					  <td>Rp <?php //echo number_format($billing['ADMINISTRASI'], '0', ',', '.'); ?>,-</td>
					</tr>
					<tr-->
					  <th>PPN</th>
					  <td>Rp <?php echo number_format($billing['PPN'], '0', ',', '.'); ?>,-</td>
					</tr>
					<tr>
					  <th>TOTAL</th>
					  <td>Rp <?php echo number_format($billing['TOTAL'], '0', ',', '.'); ?>,-</td>
					</tr>
				  </tbody>
				</table>
			  </div>
			  <br>
				<?php 
					foreach($table_billing as $table_cont){
						echo $table_cont;
					}
				?>
              <!--div class="card bg-white">
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
              </div-->
			<?php /*echo $PRO." - ".$arrhdr['INVOICE'];*/ if(($arrhdr['INVOICE']=='100' && $PRO=='PRO') || ($arrhdr['INVOICE']=='200' && $PRO=='INV')){?>
			<div class="text-center">
				<button type="button" class="btn btn-danger btn-icon" onclick="jpopup_close();">CANCEL<i class="icon-close"></i></button>
				<button type="button" class="btn btn-primary btn-icon" onclick="print_popup('form_data','<?php echo $url;?>', '<?php echo $id;?>');">PRINT<i class="icon-check"></i></button>
			</div>
			<?php }else{?>
			<div class="text-center">
				<button type="button" class="btn btn-primary btn-icon" onclick="jpopup_close();">CLOSE<i class="icon-close"></i></button>
			</div>
			<?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
