<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
     <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">TRACKING</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
           </a> </li>
      </ul>
      <br>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
 <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url(); ?>/tracking/cek/detail" method="post" autocomplete="off" onsubmit="save_post2('form_data'); return false;">



<div class="form-group">
              <label class="col-sm-3 control-label-left">NO BL / AWB</label>

<div class="col-sm-6"> <input type="text" name="NO_BL_AWB" wajib="yes" id="NO_BL_AWB" class="form-control" placeholder="NO BL / AWB"> </div>
<div class="col-sm-3"><button type="submit" id="submit" class="btn btn-primary btn-icon"  onclick="save_post2('form_data'); return false;">Search <i class="icon-check"></i></button>
</div>


</div>



<!-- // FORM HERE -->
<div id="pencarian-list"></div>





          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
function save_post2(form,id){
  if(validasi(form)){
    if(validasi(form)){
    swal({title:'Confirm',
      text:'Apakah ingin proses data ?',
      type:'info',
      showCancelButton:true,
      closeOnConfirm:true,
      showLoaderOnConfirm:true,
     },function(r){
       if(r){
        $.ajax({
        type: 'POST',
        url: $('[name="'+form+'"]').attr('action'),
        data: $('[name="'+form+'"]').serialize(),
        beforeSend: function(){Loading(true)},
        complete:function(){Loading(false)},
        success: function(data){
          if(data.search("MSG")>=0){
            arrdata = data.split('#');
            if(arrdata[1]=="OK"){

              notify('success',arrdata[2]);
              setTimeout(function(){location.href = arrdata[3];}, 1500);
              return false;

            }else{
              notify('error',arrdata[2]);
            }
          }
          else
          {
            $("#pencarian-list").html(data);
          }
        }
        });
       }else{
        return false
       }
    });
  }
  }
}
</script>

