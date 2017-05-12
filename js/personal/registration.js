/**
 * Created by jeyfost on 06.05.2017.
 */

$(document).on('ready', function() {
	$("#photoInput").fileinput({
		previewFileType: "image",
		browseClass: "btn btn-default btn-block",
		browseLabel: "Pick Image",
		allowedFileExtensions: ["jpg", "jpeg", "png", "gif", "bmp"],
		previewClass: "bg-warning",
		showCaption: false,
		showRemove: false,
		showUpload: false
	});

	$('#yearInput').change(function () {
		var month = $('#monthInput').val();
		var year = parseInt($('#yearInput').val());
		var dayHtml = '';

		if(month === '2') {
			if(year % 4 === 0) {
				for(i = 1; i <= 29; i++) {
					dayHtml += "<option value='" + i + "'>" + i + "</option>";
				}

				$('#dayInput').html(dayHtml);
			}
		}
	});

	$('#monthInput').change(function () {
		var month = $('#monthInput').val();
		var year = parseInt($('#yearInput').val());
		var dayHtml = '';

		if(month === '1' || month === '3' || month === '5' || month === '7' || month === '8' || month === '10' || month === '12') {
			for(var i = 1; i <= 31; i++) {
				dayHtml += "<option value='" + i + "'>" + i + "</option>";
			}
		}

		if(month === '4' || month === '6' || month === '9' || month === '11') {
			for(i = 1; i <= 30; i++) {
				dayHtml += "<option value='" + i + "'>" + i + "</option>";
			}
		}

		if(month === '2') {
			for(i = 1; i <= 28; i++) {
				dayHtml += "<option value='" + i + "'>" + i + "</option>";
			}

			if(year % 4 === 0) {
				dayHtml += "<option value='29'>29</option>";
			}
		}

		$('#dayInput').html(dayHtml);
	});

	$('#registrationButton').click(function () {
		var login = $('#loginInput').val();
		var first_name = $('#firstNameInput').val();
		var last_name = $('#lastNameInput').val();

		if(login !== '') {
			if(first_name !== '') {
				if(last_name !== '') {
					var formData = new FormData($('#continueRegistrationForm').get(0));

					if($('#registrationButton').attr("userid") !== '') {
						formData.append("userID", $('#registrationButton').attr("userid"));
					} else {
						formData.append("hash", $('#registrationButton').attr("hash"));
					}

					if($('#studentRadio').is(":checked")) {
						formData.append("role", 0);
					}

					if($('#teacherRadio').is(":checked")) {
						formData.append("role", 1);
					}

					$.ajax({
						type: "POST",
						data: formData,
						processData: false,
						contentType: false,
						dataType: "json",
						url: "/scripts/personal/ajaxContinueRegistration.php",
						beforeSend: function () {
							$.notify("Your personal information is sending to our server. Please wait...", "info");
						},
						success: function (response) {
							switch(response) {
								case "ok":
									window.location.href = "/personal/login.php";
									break;
								case "failed":
									$.notify("An error has occurred. Please try again.", "error");
									break;
								case "photo":
									$.notify("Your photo has an incorrect extension.", "error");
									break;
								case "login":
									$.notify("Your login is already exists.", "error");
									break;
								default:
									$.notify(response, "warn");
									break;
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							$.notify(textStatus + "; " + errorThrown, "error");
						}
					});
				} else {
					$.notify("Type your last name.", "error");
				}
			} else {
				$.notify("Type your first name.", "error");
			}
		} else {
			$.notify("Type your username.", "error");
		}
	});

	$('#countrySelect').change(function () {
		var iso = $('#countrySelect').val();

		$('#flag').attr("src", "/img/flags/flat/16/" + iso + ".png");
		$('#flag').attr("alt", iso);

		$.ajax({
			type: "POST",
			data: {"iso": iso},
			url: "/scripts/common/ajaxCountryByISO.php",
			success: function (response) {
				$('#flag').attr("title", response);
			}
		});
	})
});