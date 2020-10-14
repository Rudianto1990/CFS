<div class="app forgot-password usersession">
  <div class="session-wrapper">
    <div class="page-height-o row-equal align-middle">
      <div class="column">
        <div class="card bg-white no-border">
          <div class="card-block">
          	<form id="form-login" class="form-layout" method="post" autocomplete="off" action="<?php echo site_url().'/reset_password/token/'.$token; ?>">
              <div class="text-center m-b">
                <h4 class="text-uppercase">CFS-CENTER</h4>
                <p>MASUKAN PASSWORD BARU ANDA</p>
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
                <label class="text-uppercase">Password Baru</label>
                <input name="password" id="password" type="password" class="form-control input-lg" placeholder="Password Baru">
                <?php echo form_error('password'); ?>
				<p class="help-block" id="cps"></p>
                <label class="text-uppercase">Konfirmasi Password Baru</label>
                <input name="passconf" id="password" type="password" class="form-control input-lg" placeholder="Konfirmasi Password Baru">
                <?php echo form_error('passconf'); ?>
              </div>
              <button class="btn btn-primary btn-block btn-lg m-b" type="submit">UBAH PASSWORD</button>
			  <!--div class="row">
				<div class="pull-left">
				  <a href="<?php echo site_url(); ?>" class="text-uppercase text-primary">Login</a>
				</div>
				<div class="pull-right">
				  <a href="<?php echo site_url('home/sign_up'); ?>" class="text-uppercase text-primary">sign up</a>
				</div>
			  </div-->
			</form>
		  </div>
        </div>
      </div>
    </div>
  </div>
</div>
