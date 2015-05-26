<div class="row">
	<div class="col-md-4 col-md-offset-4">
		
		<?php
            $attributes = array('role' => 'form', 'id' => 'shorten_url');
            $action_link = 'home/shorten_url';
            
            echo form_open($action_link, $attributes);
        ?>
			<div class="form-group has-error has-feedback">
				<?php echo form_label('Long URL', 'long_url', array('class'=>'control-label')); ?>
				<input type="text" class="form-control" id="long_url" name="long_url" aria-describedby="form_feedback" placeholder="eg: http://www.example.com/" autofocus>
				<span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Tooltip on left"></span>
			</div>
			<button type="submit" class="btn btn-success btn-block">Shorten</button>
		<?php echo form_close() ?>

	</div><!-- /.col -->
</div><!-- /.row -->

<div id="status_alert_box" class="row"></div><!-- /.row -->