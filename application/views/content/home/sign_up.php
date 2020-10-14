<div class="app signup usersession">
  <div class="session-wrapper">
        <div class="card bg-white no-border">
          <div class="card-block">
            <div class="text-center m-b">
              <h3 class="text-uppercase">CFS-CENTER</h3>
              <p>DAFTAR USER BARU</p>
            </div>
            <?php if($this->session->flashdata('result_error')){
      				$result_er=$this->session->flashdata('result_error');
      				echo "<div class='alert alert-danger' >".$result_er."</div>";
      			}
      			if($this->session->flashdata('result')){
      				$result_r=$this->session->flashdata('result');
      				echo "<div class='alert alert-success' >".$result_r."</div>";
      			}
            ?>
            <form id="formlogin" class="form-horizontal" method="post" autocomplete="off" action="<?php echo site_url(); ?>/home/sign_up_cek">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label-left col-sm-6 text-uppercase"><b>DATA PERUSAHAAN</b></label>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">CUSTOMER NUMBER</label>
                  <div class="col-sm-8">
                    <input name="cust_no" id="cust_no" type="text" class="form-control input-lg" onkeyup="cek();" maxlength="100" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">NAMA PERUSAHAAN</label>
                  <div class="col-sm-8">
                    <input name="kd_company" id="kd_company" type="hidden" class="form-control input-lg">
                    <input name="company" id="company" type="text" class="form-control input-lg" onkeyup="cek();" maxlength="100" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">ALAMAT PERUSAHAAN</label>
                  <div class="col-sm-8">
                    <textarea class="form-control input-lg" name="alamatcompany" id="alamatcompany" onkeyup="cek();" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">EMAIL PERUSAHAAN</label>
                  <div class="col-sm-8">
                    <input name="emailcompany" id="emailcompany" type="email" class="form-control input-lg" maxlength="100" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">NPWP PERUSAHAAN</label>
                  <div class="col-sm-8">
                    <input name="npwpcompany" id="npwpcompany" type="text" class="form-control input-lg" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">NO TELPON PERUSAHAAN</label>
                  <div class="col-sm-8">
                    <input name="telponcompany" id="telponcompany" type="text" class="form-control input-lg" onkeyup="cek();" maxlength="20" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">NO FAX PERUSAHAAN</label>
                  <div class="col-sm-8">
                    <input name="faxcompany" id="faxcompany" onkeyup="cek();" type="text" class="form-control input-lg " maxlength="20" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">JENIS BADAN USAHA</label>
                  <div class="col-sm-8">
                    <select class="form-control input-lg" name="jns_badan" required>
                      <option></option>
                      <option value="BUMN">BUMN</option>
                      <option value="NON-BUMN">NON BUMN</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1 text-uppercase"></label>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label-left col-sm-6 text-uppercase"><b>DATA DIRI</b></label>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">NAMA LENGKAP</label>
                  <div class="col-sm-8">
                    <input name="fullname" id="fullname" type="text" onkeyup="cek();" class="form-control input-lg" maxlength="100" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">USERNAME</label>
                  <div class="col-sm-8">
                    <input name="username" onkeyup="cek();" id="username" type="text" class="form-control input-lg" maxlength="20" required><!--value="<?php #echo $idm->ID;?>" -->
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">EMAIL</label>
                  <div class="col-sm-8">
                    <input name="email" id="email" type="email" class="form-control input-lg" maxlength="100" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">NO HANDPHONE</label>
                  <div class="col-sm-8">
                    <input name="telpon" id="telpon" type="text" class="form-control input-lg" onkeyup="cek();" maxlength="20" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">PASSWORD</label>
                  <div class="col-sm-8">
                    <input name="password" id="password" type="password" class="form-control input-lg" required>
					<p class="help-block" id="cps"></p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">KONFIRMASI PASSWORD</label>
                  <div class="col-sm-8">
                    <input name="conf_password" id="conf_password" type="password" class="form-control input-lg" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label-left col-sm-4 text-uppercase">ROLE</label>
                  <div class="col-sm-8">
                    <select class="form-control input-lg" name="role" required>
                      <option></option>
                      <option value="CONS">CONSIGNEE</option>
                      <option value="FWD">FORWARDER</option>
                     <!-- <option value="TRK">TRUCKER</option> -->
					  <!--option value="USR">TERMINAL</option>
                      <option value="GDG">GUDANG</option-->
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1 text-uppercase"></label>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                  <button class="btn btn-primary btn-block btn-lg m-b" type="submit">DAFTAR</button>
                </div>
              </div>
            </form>
            <div class="row">
      				<div class="pull-left">
      				  <a href="<?php echo site_url(); ?>" class="text-uppercase text-primary">Login</a>
      				</div>
    			  </div>
          </div>
  		  </div>
      </div>
    </div>
<script>
  /*$(function(){
      autocomplete('company','/autocomplete/signup_cek/organisasi/nama',function(event, ui){
      $('#kd_company').val(ui.item.KODE);
      $('#company').val(ui.item.NAMA);
      $('#alamatcompany').val(ui.item.ALAMAT);
      $('#emailcompany').val(ui.item.EMAIL);
      $('#npwpcompany').val(ui.item.NPWP);
      $('#telponcompany').val(ui.item.NOTELP);
      $('#faxcompany').val(ui.item.NOFAX);
    });
	
  });*/

  function cek() {
    var company = document.getElementById('company');
    company.value = company.value.replace(/[^a-zA-Z0-9. ]+/, ''); 
	var alamatcompany = document.getElementById('alamatcompany');
    alamatcompany.value = alamatcompany.value.replace(/[^a-zA-Z0-9. -]+/, '');
//var npwpcompany = document.getElementById('npwpcompany');
  //  npwpcompany.value = npwpcompany.value.replace(/[^0-9+]+/, '');
var telponcompany = document.getElementById('telponcompany');
    telponcompany.value = telponcompany.value.replace(/[^0-9+]+/, '');
var cust_no = document.getElementById('cust_no');
    cust_no.value = cust_no.value.replace(/[^0-9+]+/, '');
var telpon = document.getElementById('telpon');
    telpon.value = telpon.value.replace(/[^0-9+]+/, '');
var faxcompany = document.getElementById('faxcompany');
    faxcompany.value = faxcompany.value.replace(/[^0-9+]+/, '');
var fullname = document.getElementById('fullname');
    fullname.value = fullname.value.replace(/[^a-zA-Z. ]+/, '');
var username = document.getElementById('username');
    username.value = username.value.replace(/[^a-zA-Z0-9_-]+/, '');

	
	};
  jQuery(function($){
      $("#npwpcompany").mask("99.999.999.9-999.999");
  });
  
/*  jQuery.validator.addMethod("noSpace", function(value, element) {
    return value.indexOf(" ") < 0 && value !== "";
  }, "Tidak boleh menggunakan spasi");
  jQuery.validator.addMethod("regex",function(value, element, regexp) {
    var re = new RegExp(regexp);
    return this.optional(element) || re.test(value);
  }, "Please check your input.");    */
  $("#formlogin").validate({
			rules: {
        username: {
					//noSpace: true,
					//regex: "^[a-zA-Z.\\s]{1,40}$",
          remote: {
            url: "<?php echo site_url();?>/home/uname",
            type: "post",
            data: {
              login: function(){
                return $('#formlogin :input[name="username"]').val();
              }
            }
          }
				},
        email: {
          remote: {
            url: "<?php echo site_url();?>/home/umail",
            type: "post",
            data: {
              login: function(){
                return $('#formlogin :input[name="email"]').val();
              }
            }
          }
				},
				conf_password: {
					equalTo: "#password"
				},
				npwpcompany: {
					//minlength: 15
					required: true
				}
      },
      onfocusout: function (element)
      {
          if (!this.checkable(element) && (element.name in this.submitted || !this.optional(element)))
          {
              var currentObj = this;
              var currentElement = element;
              var delay = function () { currentObj.element(currentElement); };
              setTimeout(delay, 0);
          }
      },
      messages:{
        username:{
         remote: jQuery.validator.format("username sudah terdaftar.")
       },
         email:{
          remote: jQuery.validator.format("email sudah terdaftar.")
          }
       }
    });
	$("input[type='password']").keypress(function(e) {

		var $warn = $(this).next(".capsWarn");//can be removed since you are just using alert
		var kc = e.which; //get keycode
		var isUp = (kc >= 65 && kc <= 90) ? true : false; // uppercase
		var isLow = (kc >= 97 && kc <= 122) ? true : false; // lowercase
		// event.shiftKey does not seem to be normalized by jQuery(?) for IE8-
		var isShift = ( e.shiftKey ) ? e.shiftKey : ( (kc == 16) ? true : false ); // shift is pressed

		// uppercase w/out shift or lowercase with shift == caps lock
		if ( (isUp && !isShift) || (isLow && isShift) ) {
			capLock('yes'); // alerts "CAPSLOCK is ON"
		}else{
			 capLock('no');
		}

	});
	function capLock(id) {
		var inputBox = document.getElementById('password');
		if(id=='yes'){
			inputBox.onkeyup = function(){
				document.getElementById('cps').innerHTML = 'CAPSLOCK IS ON';
				document.getElementById('cps').style.display="block";
				document.getElementById('cps').style.visibility = 'visible';
			}
		}else{
			inputBox.onkeyup = function(){
				document.getElementById('cps').innerHTML = '';
				document.getElementById('cps').style.display="none";
				document.getElementById('cps').style.visibility = 'hidden';
			}
		}
	}
</script>
