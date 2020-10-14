<div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="card text-white no-border relative" style="min-height:250px">
        <div class="slide absolute tp lt rt bt" data-ride="carousel" data-interval="3000">
          <div class="carousel-inner" role="listbox">
            <div class="item active" style="background-image:url(<?php echo base_url().'assets/images/slide/13.jpg';?>);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;width:100%;height:100%;"> </div>
            <div class="item" style="background-image:url(<?php echo base_url().'assets/images/slide/15.jpg';?>);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;width:100%;height:100%;"> </div>
            <div class="item" style="background-image:url(<?php echo base_url().'assets/images/slide/13.jpg';?>);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;width:100%;height:100%;"> </div>
            <div class="item" style="background-image:url(<?php echo base_url().'assets/images/slide/1.jpg';?>);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;width:100%;height:100%;"> </div>
            <div class="item" style="background-image:url(<?php echo base_url().'assets/images/slide/4.jpg';?>);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;width:100%;height:100%;"> </div>
            <div class="item" style="background-image:url(<?php echo base_url().'assets/images/slide/5.jpg';?>);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;width:100%;height:100%;"> </div>

          </div>
        </div>
        <div class="absolute tp lt rt bt" style="background:rgba(0,0,0,.1)"></div>
        <div class="card-block">
          <div class="block text-right"> <i class="icon-action-redo"></i> </div>
          <div class="absolute lt rt bt p-a">
            <h4>CFS CENTER</h4>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row same-height-cards">
    <div class="col-md-12 col-lg-6">
      <div class="card bg-white no-border">
    <div class="p-a bb card-header"> PROFILE PERUSAHAAN </div>
    <ul class="list-unstyled">
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('NPWP'); ?></span> <i class="fa fa-circle text-danger m-r"></i>NPWP</li>
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('NM_PERSH'); ?></span> <i class="fa fa-circle text-danger m-r"></i>NAME</li>
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('NOTELP'); ?></span> <i class="fa fa-circle text-danger m-r"></i>PHONE</li>
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('NOFAX'); ?></span> <i class="fa fa-circle text-danger m-r"></i>FAX</li>
    </ul>
  	</div>
    </div>
    <div class="col-md-12 col-lg-6">
      <div class="card bg-white no-border">
    <div class="p-a bb card-header"> PROFILE USER </div>
    <ul class="list-unstyled">
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('USERLOGIN'); ?></span> <i class="fa fa-circle text-primary m-r"></i>USERLOGIN</li>
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('NM_LENGKAP'); ?></span> <i class="fa fa-circle text-primary m-r"></i>FULL NAME</li>
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('HANDPHONE'); ?></span> <i class="fa fa-circle text-primary m-r"></i>HANDPHONE</li>
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('EMAIL_USER'); ?></span> <i class="fa fa-circle text-primary m-r"></i>EMAIL</li>
      <!--li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('NM_TPS'); ?></span> <i class="fa fa-circle text-primary m-r"></i>TPS</li>
      <li class="b-t p-a-md"> <span class="pull-right"><?php echo $this->newsession->userdata('NM_GUDANG'); ?></span> <i class="fa fa-circle text-primary m-r"></i>GUDANG</li-->
    </ul>
  </div>
    </div>
  </div>
