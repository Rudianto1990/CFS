<div class="card bg-white">
	<div class="card-header">DOKUMEN IMPOR</div>
    <div class="card-block">
		<div class="table-responsive">
			<div id="divtblimpor">
				<form id='tblimpor' name='tblimpor' action='http://10.1.6.112/cfs-center/index.php/dokumen/impor_kontainer' onsubmit="newtable_search('tblimpor','divtblimpor','1','DESC','8'); return false;" autocomplete='off' class='form-horizontal'>
					<div class="card-block">
						<div class="row">
							<div class="form-group">
								<label class="col-sm-2 control-label-left">JENIS DOKUMEN</label>
								<div class="col-sm-10">	
									<select name="form[0][]" id="0" class="form-control">
										<option value="" selected='selected'>&nbsp;</option>
										<option value="1" >SPPB PIB (BC 2.0)</option>
										<option value="10" >EMPTY KONTAINER (IMPOR)</option>
										<option value="13" >PIBK</option>
										<option value="14" >RETURNABLE PACKAGE (RP)</option>
										<option value="15" >PENIMBUNAN DILUAR KAWASAN PABEAN</option>
										<option value="16" >PERSETUJUAN SHORT SHIP</option>
										<option value="17" >PERSETUJUAN PART OF (IMPORTIR MITA)</option>
										<option value="18" >PERSETUJUAN PART OF (IMPORTIR NON MITA)</option>
										<option value="19" >SPJM</option>
										<option value="2" >SPPB PIB BC 2.3</option>
										<option value="20" >DOKUMEN BC 1.1A / SP3B IMPOR</option>
										<option value="21" >PENGELUARAN DENGAN PIB MANUAL (CUKAI)</option>
										<option value="22" >PAKET POS</option>
										<option value="23" >PENGELUARAN BARANG UNTUK DIMUSNAHKAN</option>
										<option value="24" >PENGELUARAN BARANG UNTUK BARANG BUKTI KE PENGADILAN </option>
										<option value="25" >PENGELUARAN BARANG HIBAH</option>
										<option value="26" >PENGELUARAN BARANG MILIK NEGARA DAN BARANG TIDAK DIKUASAI YANG DILELANG</option>
										<option value="27" >PENGELUARAN BARANG PERS RELEASE</option>
										<option value="28" >RE-EKSPOR (BC 1.2) BELUM AJU PIB</option>
										<option value="29" >PENGELUARAN BARANG EKS PERGANTIAN KONTAINER</option>
										<option value="3" >PERSETUJUAN PLP</option>
										<option value="30" >PENGELUARAN BARANG PENEGAHAN (SEBAGIAN)</option>
										<option value="31" >PENGELUARAN BARANG PENEGAHAN (SELURUHNYA)</option>
										<option value="4" >SPPB BC 1.2</option>
										<option value="40" >PENGELUARAN KONTAINER EKS STRIPPING</option>
										<option value="5" >BCF 2.6A (PEMERIKSAAN DILOKASI IMPORTIR / SPPF)</option>
										<option value="9" >BCF 1.5 (PINDAH LOKASI DARI TPS KE TPP UNTUK KONTAINER > 30 HARI)</option>	
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label-left">NOMOR DOKUMEN</label>
								<div class="col-sm-10">
									<input type="text" name="form[1][]" class="form-control 1" id="1" value="" tag="" placeholder="NOMOR DOKUMEN">	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label-left">TANGGAL DOKUMEN</label>	
								<div class="col-sm-5">
									<input type="text" name="form[2][]" id="" class="drp form-control 2" value="" placeholder="START DATE" tag="DATERANGE">	
								</div>
								<div class="col-sm-5">
									<input type="text" name="form[2][]" id="" class="drp form-control 2" value="" placeholder="END DATE" tag="DATERANGE">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label-left">NAMA ANGKUT</label>
								<div class="col-sm-10">
									<input type="text" name="form[3][]" class="form-control 3" id="3" value="" tag="" placeholder="NAMA ANGKUT">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label-left">&nbsp;</label>
								<div class="col-sm-10">
									<button type="reset" class="btn btn-danger btn-sm btn-icon"><i class="icon-refresh"></i> Cancel</button>&nbsp;<button type="submit" onclick="newtable_search('tblimpor','divtblimpor','1','DESC','8'); return false;" class="btn btn-primary btn-sm btn-icon"><i class='icon-magnifier'></i> Search</button>	
								</div>
							</div>
							<script>$(function(){ date('drp');});</script>
						</div>
					</div>
					<table class="tabelajax responsive m-b-0" id="tblimpor">
						<tr class="headcontent">
							<th colspan="10">&nbsp;<a href="javascript:void(0)" onclick="button_menu('tblimpor',this.id)" id="tb_menutblimpor0"
							formid="tblimpor" title="DETAIL" met="MODAL" url="dokumen/impor_kontainer/detail" jml="1" status="" div="divtblimpor" w="" type="" get="">
								<button type="button" class="btn btn-default btn-sm btn-icon" title="DETAIL"><i class="md-zoom-in"></i>&nbsp;DETAIL</button></a>&nbsp;
							</th>
						</tr>
						<tr>
							<th width="1">No</th><th width="22"><input type="checkbox" id="tb_chkalltblimpor" onclick="tb_chkall('tblimpor',this.checked)" class="tb_chkall"/></th><th><span onclick="newtable_search('tblimpor','divtblimpor','1','ASC','1')" class="order" title="Order by JENIS DOKUMEN (A-Z)" orderby="1" sortby="ASC">JENIS DOKUMEN</span></th><th><span onclick="newtable_search('tblimpor','divtblimpor','1','ASC','2')" class="order" title="Order by DOKUMEN (A-Z)" orderby="2" sortby="ASC">DOKUMEN</span></th><th><span onclick="newtable_search('tblimpor','divtblimpor','1','ASC','3')" class="order" title="Order by DAFTAR PABEAN (A-Z)" orderby="3" sortby="ASC">DAFTAR PABEAN</span></th><th><span onclick="newtable_search('tblimpor','divtblimpor','1','ASC','4')" class="order" title="Order by NO. VOYAGE/FLIGHT (A-Z)" orderby="4" sortby="ASC">NO. VOYAGE/FLIGHT</span></th><th><span onclick="newtable_search('tblimpor','divtblimpor','1','ASC','5')" class="order" title="Order by NAMA ANGKUT (A-Z)" orderby="5" sortby="ASC">NAMA ANGKUT</span></th><th><span onclick="newtable_search('tblimpor','divtblimpor','1','ASC','6')" class="order" title="Order by JUMLAH (A-Z)" orderby="6" sortby="ASC">JUMLAH</span></th>
						</tr>
						<tr id="tr_1" title="Double click to preview" url="dokumen/impor_kontainer/detail" onmouseover="$(this).addClass('hilite');" onmouseout="$(this).removeClass('hilite');"  type="POPUP" ondblclick="get_detail(this)" onclick="tr_chk('tblimpor',this)" value="1" formdata="tblimpor">
						<tr id="tr_1" title="Double click to preview" url="dokumen/impor_kontainer/detail" onmouseover="$(this).addClass('hilite');" onmouseout="$(this).removeClass('hilite');"  type="POPUP" ondblclick="get_detail(this)" onclick="tr_chk('tblimpor',this)" value="1" formdata="tblimpor">
							<!--td  class="alt">1</td><td  class="alt"><input type="checkbox" name="tb_chktblimpor[]" id="tb_chktblimpor" class="tb_chk"  value="1" validasi="" onclick="tb_chk('tblimpor',this.checked,this.value)" data="1"/></td><td  class="alt">BCF 1.5 (PINDAH LOKASI DARI TPS KE TPP UNTUK KONTAINER > 30 HARI)</td><td  class="alt">NO. : -<BR>TGL. : -</td><td  class="alt">NO. : -<BR>TGL. : -</td><td  class="alt"></td><td  class="alt"></td><td  class="alt"></td-->
						</tr>
						<tr class="headcontent">
							<th colspan="10">
								<!--input type="hidden" class="tb_text" id="tb_view" value="10" readonly/> &nbsp;10 Records Per Page. Showing 1 - 1 Of 1 Record.
								<input type="hidden" class="tb_text" id="tb_haltblimpor" value="1"   ondblclick="" style="width:30px;text-align:right;"/-->
							</th>
						</tr>
					</table>
					<input type="hidden" name="tmpchktblimpor" id="tmpchktblimpor" value="" wajib="yes" readonly>
				</form>
			</div>
		</div>
    </div>
</div>