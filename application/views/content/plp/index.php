<div class="panel">
  <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
      <div class="panel">
        <div class="panel-heading" id="exampleHeadingContinuousOne" role="tab">
          <a class="panel-title" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousOne" aria-controls="exampleCollapseContinuousOne" aria-expanded="true">
          	<i class="icon glyphicon glyphicon-send margin-0" aria-hidden="true"></i> REQUEST
          </a>
        </div>
        <div class="panel-collapse collapse in" id="exampleCollapseContinuousOne" aria-labelledby="exampleHeadingContinuousOne" role="tabpanel">
          <div class="panel-body">
            <?php echo $table_request; ?>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading" id="exampleHeadingContinuousTwo" role="tab">
          <a class="panel-title collapsed" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousTwo" aria-controls="exampleCollapseContinuousTwo" aria-expanded="false">
          <i class="icon glyphicon glyphicon-folder-open margin-0" aria-hidden="true"></i> RESPONS</a>
        </a>
        </div>
        <div class="panel-collapse collapse" id="exampleCollapseContinuousTwo" aria-labelledby="exampleHeadingContinuousTwo" role="tabpanel">
          <div class="panel-body container-fluid">
          	<?php echo $table_respon; ?>
          </div>
        </div>
      </div>
  </div>
</div>
