<style>
.captche{
	font-size:22px; 
	color:#4347AC;
	background: #EBD7D6 none repeat scroll 0 0;
	display: block;
	-khtml-user-select:none;
	-webkit-user-select:none;
	-moz-user-select:none;
	-ms-user-select: none;
	-o-user-select:none;
	user-select:none;
	unselectable:on;
}
</style>
<div class="app signin usersession">
  <div class="session-wrapper">
    <div class="page-height-o row-equal align-middle">
      <div class="column">
        <div class="card bg-white no-border">
          <div class="card-block">
          	<form id="form-login" class="form-layout" method="post" autocomplete="off" onSubmit="javascript:return login()" action="<?php echo site_url(); ?>/home/ceklogin/<?php echo $this->session->userdata('session_id'); ?>">
              <div class="text-center m-b">
                <h4 class="text-uppercase">CFS-CENTER</h4>
                <p>SILAKAN LOGIN</p>
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
              <div class="form-inputs">
                <label class="text-uppercase">EMAIL / USERNAME</label>
                <input name="username" id="username" type="text" class="form-control input-lg" placeholder="Email / Username">
                <label class="text-uppercase">PASSWORD</label>
                <input name="password" id="password" type="password" class="form-control input-lg capsWarn" placeholder="Password" required>
                <label class="text-uppercase">Captcha</label>
				<span class="captche text-center"><?php echo $chaptca ?></span>
				<input type="text" class="form-control input-lg focus empty" name="txt_chaptca_real" placeholder="Captcha" value="<?php //echo $chaptca ?>">
				<input type="hidden" class="form-control focus empty" name="txt_chaptca" value="<?php echo $chaptca ?>">
				<p class="help-block" id="cps"></p>
              </div>
              <button class="btn btn-primary btn-block btn-lg m-b"type="submit">Login</button>
			  <div class="row">
				<!--div class="pull-left">
				  <a href="<?php echo site_url('home/sign_up'); ?>" class="text-uppercase text-primary">daftar</a>
				</div-->
				<!-- /.col -->
				<div class="pull-right">
				  <a href="<?php echo site_url('home/forgot_password'); ?>" class="text-uppercase text-primary">lupa password</a>
				</div>
				<!-- /.col -->
			  </div>
			</form>
		  </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
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