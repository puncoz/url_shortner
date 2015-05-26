$(document).ready(function(){

	var status_loading_box = '\
	<div class="col-md-4 col-md-offset-4">\
		<div class="alert alert-info text-centered" role="alert">\
			<p id="spinner"><i class="fa fa-spinner fa-spin"></i> converting...</p>\
		</div>\
	</div>';

	var status_success_box = '\
	<div class="col-md-4 col-md-offset-4">\
		<div class="alert alert-success text-centered" role="alert">\
			<code>{converted_url}</code>\
		</div>\
	</div>';

	var status_error_box = '\
	<div class="col-md-4 col-md-offset-4">\
		<div class="alert alert-danger text-centered" role="alert">\
			Error Occurred: {error_msg}\
		</div>\
	</div>';

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});

	$("#shorten_url").submit(function(e) {
		e.preventDefault();
		var obj = $(this);
		var url = $(obj).attr('action');
		var data = $(obj).serialize();
		$.ajax({
			url: url,
			type: 'post',
			data: data,
			beforeSend: function() {
				$("#status_alert_box").html(status_loading_box);
			},
			success: function(response_data, textStatus, jQxhr) {
				$("#status_alert_box").html(' ');
				var data = jQuery.parseJSON( response_data );
				if (data.status_code == "200") {
					status_success_box = status_success_box.replace('{converted_url}', data.short_url);
                    $("#status_alert_box").html(status_success_box);
                } else {
                    console.debug(data.status_msg);
                    status_error_box = status_error_box.replace('{error_msg}', data.status_msg);
                    $("#status_alert_box").html(status_error_box);
                };
			},
			error: function(jqXhr, textStatus, errorThrown) {
				console.debug(errorThrown);
				$("#status_alert_box").html('');
			}
		});

	});

});