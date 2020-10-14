<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">USER BARU</a></li>
       <li class="active"><a href="#tab1" data-toggle="tab">DETAIL</a></li>
      </ul>
      <div class="tab-content" style="overflow: auto">
        <div class="tab-pane p-x-lg active" id="tab1" style="overflow: auto">
         <!-- FORM HERE -->
            <table width="90%">
              <tr>
                  <td colspan="2"><b>DATA PERUSAHAAN</b></td>
              </tr>
              <tr >
                <td colspan="2">
                    <table style="margin-left:2%" width="100%">
                        <tr><td width="15%">Nama</td><td><?php echo $arrhdr['NAMAPERS']; ?></td></tr>
                        <tr><td>Alamat</td><td><?php echo $arrhdr['ALAMATPERS']; ?></td></tr>
                        <tr><td>e-Mail</td><td><?php echo $arrhdr['EMAILPERS']; ?></td></tr>
                        <tr><td>NPWP</td><td><?php echo $arrhdr['NPWP']; ?></td></tr>
                        <tr><td>No Telp</td><td><?php echo $arrhdr['NOTELP']; ?></td></tr>
                        <tr><td>No Fax</td><td><?php echo $arrhdr['NOFAX']; ?></td></tr>        
                    </table>
                </td>
              </tr>              
              <tr>
                  <td colspan="2"><b>DATA USER</b></td>
              </tr>
              <tr >
                <td colspan="2">
                    <table style="margin-left:2%" width="100%">
                        <tr><td width="15%">Nama</td><td><?php echo $arrhdr['NM_LENGKAP']; ?></td></tr>
                        <tr><td>email</td><td><?php echo $arrhdr['EMAIL']; ?></td></tr>
                        <tr><td>Hp</td><td><?php echo $arrhdr['HANDPHONE']; ?></td></tr>
                        <tr><td>Role</td><td><?php echo $arrhdr['KD_GROUP']; ?></td></tr>
                  </table>
                </td>
              </tr>  
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>