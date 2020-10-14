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
					  <th width="35%">NOMOR ORDER</th>
					  <td width="65%"><?php echo $arrhdr['NO_ORDER']; ?></td>
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
					  <th>TANGGAL D/O</th>
					  <td><?php echo $arrhdr['TGL_DO']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL EXPIRED D/O</th>
					  <td><?php echo $arrhdr['TGL_EXPIRED_DO']; ?></td>
					</tr>
					<tr>
					  <th>NAMA PBM</th>
					  <td><?php echo $arrhdr['NAMA_FORWARDER']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR CONTAINER ASAL</th>
					  <td><?php echo $arrhdr['NO_CONT_ASAL']; ?></td>
					</tr>
					<tr>
					  <th>JENIS DOKUMEN IZIN</th>
					  <td><?php echo $arrhdr['DOK_BC']; ?></td>
					</tr>
					<tr>
					  <th>NOMOR SPPB</th>
					  <td><?php echo $arrhdr['NO_SPPB']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL SPPB</th>
					  <td><?php echo $arrhdr['TGL_SPPB']; ?></td>
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
					  <th>NAMA KAPAL</th>
					  <td><?php echo $arrhdr['NM_ANGKUT']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL TIBA</th>
					  <td><?php echo $arrhdr['TGL_TIBA']; ?></td>
					</tr>
					<tr>
					  <th>NAMA GUDANG</th>
					  <td><?php echo $arrhdr['NM_GUDANG']; ?></td>
					</tr>
					<tr>
					  <th>VOLUME (CBM)</th>
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
					  <th width="35%">NOMOR BL</th>
					  <td width="65%"><?php echo $arrhdr['NO_BL_AWB']; ?></td>
					</tr>
					<tr>
					  <th>WAKTU GATE IN CONTAINER</th>
					  <td><?php echo $arrhdr['WK_IN']; ?></td>
					</tr>
					<tr>
					  <th>STATUS</th>
					  <td><?php echo $arrhdr['JENIS_PEMBAYARAN']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL STRIPPING</th>
					  <td><?php echo $arrhdr['TGL_STRIPPING_B']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL DELIVERY</th>
					  <td><?php echo $arrhdr['TGL_KELUAR']; ?></td>
					</tr>
					<tr>
					  <th>TANGGAL ORDER</th>
					  <td><?php echo $arrhdr['WK_REKAM']; ?></td>
					</tr>
					<?php if($arrhdr['TGL_STATUS']!=null){?>
					<tr>
					  <th>TANGGAL APPROVE</th>
					  <td><?php echo $arrhdr['TGL_STATUS']; ?></td>
					</tr>
					<?php }?>
				  </tbody>
				</table>
			  </div>
			  <br>
				<?php echo $table_billing; ?>
              <!--div class="card bg-white">
                <div class="card-header text-center"><strong>DAFTAR TAGIHAN LAYANAN KEMASAN</strong></div>
                <div class="card-block p-a-0">
				  <div class="table-responsive">
					<table class="table m-b-0">
						<tr>
						  <td>
						  <div class="table-responsive">
							<table class="tabelajax responsive m-b-0">
							  <tbody>
								<tr>
								  <th width="1%">No</th>
								  <th>NAMA ITEM</th>
								  <th>TARIF DASAR</th>
								  <th>QTY</th>
								  <th>TOTAL</th>
								</tr>
								<tr>
								  <td>1</td><td>RDMCargoNormal</td><td style="text-align:right">Rp 90.000,-</td><td style="text-align:right">1</td><td style="text-align:right">Rp 90.000,-</td>
								</tr>
								<tr>
								  <td>2</td><td>MovingdariterminalpetikemaskeGudangCFScenter</td><td style="text-align:right">Rp 900.000,-</td><td style="text-align:right">1</td><td style="text-align:right">Rp 900.000,-</td>
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
              </div-->
			<?php /*echo $PRO." - ".$arrhdr['INVOICE']; if(($arrhdr['INVOICE']=='100' && $PRO=='PRO') || ($arrhdr['INVOICE']=='200' && $PRO=='INV')){?>
			<div class="text-center">
				<button type="button" class="btn btn-danger btn-icon" onclick="jpopup_close();">CANCEL<i class="icon-close"></i></button>
				<button type="button" class="btn btn-primary btn-icon" onclick="print_popup('form_data','<?php echo $url;?>', '<?php echo $id;?>');">PRINT<i class="icon-check"></i></button>
			</div>
			<?php }else{?>
			<div class="text-center">
				<button type="button" class="btn btn-primary btn-icon" onclick="jpopup_close();">CLOSE<i class="icon-close"></i></button>
			</div>
			<?php }*/?>
			<?php if($arrhdr['KD_STATUS']!='700' && $arrhdr['KD_STATUS']!='600'){?>
			<div class="text-center">
				<button type="button" class="btn btn-danger btn-icon" onclick="jpopup_close();">CLOSE<i class="icon-close"></i></button>
				<button type="button" class="btn btn-primary btn-icon" onclick="send_popup('form_data','divtblppbarang','<?php echo $url;?>', '<?php echo $id;?>');">CANCEL ORDER<i class="icon-check"></i></button>
			</div>
			<?php }elseif($arrhdr['KD_STATUS']=='700'){// && $arrhdr['KD_GUDANG_TUJUAN']=='RAYA' ?>
			<div class="text-center">
				<button type="button" class="btn btn-danger btn-icon" onclick="jpopup_close();">CLOSE<i class="icon-close"></i></button>
				<button type="button" class="btn btn-primary btn-icon" onclick="send_popup('form_data','divtblinvoice_kemasan','<?php echo $url;?>', '<?php echo $id;?>');">RESEND INVOICE<i class="icon-check"></i></button>
			</div>
			<?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
