$(document).ready(function(){

	var status_loading_box = '\
	<div class="col-md-12">\
		<div class="alert alert-info" role="alert">\
			<p id="spinner"><i class="fa fa-spinner fa-spin"></i> converting...</p>\
		</div>\
	</div>';

	var status_success_box = '\
	<div class="col-md-12">\
		<div class="alert alert-success" role="alert">\
			<!--<a href="#" id="copy-link">Copy</a>-->\
			<div class="favicon">\
				<img src="http://www.google.com/s2/favicons?domain={long_url}">\
			</div>\
			<code>{converted_url}</code>\
			<div class="clearfix"></div>\
		</div>\
	</div>';

	var status_error_box = '\
	<div class="col-md-12">\
		<div class="alert alert-danger" role="alert">\
			<strong>Error Occurred</strong>: {error_msg}\
		</div>\
	</div>';

	$("#copy-link").bind('click', function(e) {
        $("#status_alert_box code").focus();
        $("#status_alert_box code").select();
		 console.log('clicked');
	});

	var base_url = $('meta[name=base_url]').attr("content");
	console.log(base_url);

	// $("#copy-link").zclip({
	//     path: base_url+'assets/vendor/jquery.zclip/ZeroClipboard.swf',
	//     //path: 'http://zeroclipboard.googlecode.com/svn-history/r10/trunk/ZeroClipboard.swf',
	//     copy: $('#copy-link').text(),	
	//     beforeCopy:function(){
	// 		//console.log('asdfasd');
	// 		alert('Data in clipboard! Now you can paste it somewhere');
	// 	},
	//     afterCopy: function() {
	//       // console.log('copied');
	//       alert('Data in clipboard! Now you can paste it somewhere');
	//     }
	//   });

	

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});

	$("#shorten_url_form").submit(function(e) {
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
					has_success();
					status_success_box_new = status_success_box.replace('{converted_url}', data.short_url);
					status_success_box_new = status_success_box_new.replace('{long_url}', $("#long_url").val());
                    $("#status_alert_box").html(status_success_box_new);
                } else {
                	has_error();
                    console.debug(data.status_msg);
                    status_error_box_new = status_error_box.replace('{error_msg}', data.status_msg);
                    $("#status_alert_box").html(status_error_box_new);
                };

                // replacing the old csrf token
                $("input[name='"+data.csrf_token_name+"']").val(data.csrf_token);
			},
			error: function(jqXhr, textStatus, errorThrown) {
				console.debug(errorThrown);
				$("#status_alert_box").html('');
			}
		});

	});

	has_error = function() {		
		$("#shorten_url_form .form-group").removeClass("has-success");
		$("#shorten_url_form .form-group").addClass("has-error");

		$("#feedback_icon").removeClass("glyphicon-ok-sign");
		$("#feedback_icon").addClass("glyphicon-remove-sign");

		$("#shorten_url_form .btn").removeClass("btn-success");
		$("#shorten_url_form .btn").addClass("btn-danger");
	};

	has_success = function() {		
		$("#shorten_url_form .form-group").removeClass("has-error");
		$("#shorten_url_form .form-group").addClass("has-success");

		$("#feedback_icon").removeClass("glyphicon-remove-sign");
		$("#feedback_icon").addClass("glyphicon-ok-sign");

		$("#shorten_url_form .btn").removeClass("btn-danger");
		$("#shorten_url_form .btn").addClass("btn-success");
	};

});