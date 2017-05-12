/**
 * Created by jeyfost on 02.05.2017.
 */

$(document).ready(function () {
	var responseField = $('.response-field');

	$('.login-button').click(function () {
		var login = $('#loginInput').val();
		var password = $('#passwordInput').val();

		if(login !== '' && password !== '') {
			$.ajax({
				type: "POST",
				data: {"login": login, "password": password},
				url: "/scripts/index/ajaxLogin.php",
				success: function (response) {
					switch(response) {
						case "ok":
							break;
						case "failed":
							if(responseField.css('opacity') === "0") {
								responseField.html('<hr />Your authorisation data is incorrect.');
								responseField.css('opacity', '1');
							} else {
								responseField.css('opacity', '0');
								setTimeout(function () {
									responseField.html('<hr />Your authorisation data is incorrect.');
									responseField.css('opacity', '1');
								}, 300);
							}
							break;
						default:
							$.notify(response, "warn");
							break;
					}
				}
			});
		} else {
			if(responseField.css('opacity') === "0") {
				responseField.html('<hr />Please fill in your login/email and password.');
				responseField.css('opacity', '1');
			} else {
				responseField.css('opacity', '0');
				setTimeout(function () {
					responseField.html('<hr />Please fill in your login/email and password.');
					responseField.css('opacity', '1');
				}, 300);
			}
		}
	});

	$('.main-sign-up-button').click(function () {
		var email = $('#mainEmailInput').val();
		var password = $('#mainPasswordInput').val();

		if(email !== '' && password !== '') {
			$.ajax({
				type: "POST",
				data: {"email": email, "password": password},
				url: "/scripts/index/ajaxSignUp.php",
				success: function (response) {
					switch(response) {
						case "ok":
							window.location.href = "/personal/registration-continue.php";
							break;
						case "failed":
							$.notify("Something goes wrong. Please try again or contact us.", "error");
							break;
						case "email-format":
							$.notify("Email format is wrong.", "error");
							break;
						case "email-duplicate":
							$.notify("The email address you have entered already exists.", "error");
							break;
						default:
							$.notify(response, "warn");
							break;
					}
				}
			});
		} else {
			$.notify("You should fill email and password fields.", "error");
		}
	});

	$(".modal-sign-up-button").click(function () {
		var email =  $('#modalEmailInput').val();
		var password = $('#modalPasswordInput').val();

		if(email !== '' && password !== '') {
			$.ajax({
				type: "POST",
				data: {"email": email},
				url: "/scripts/common/ajaxValidateEmail.php",
				success: function(validity) {
					if(validity === "valid") {
						$.ajax({
							type: "POST",
							data: {"email": email},
							url: "/scripts/personal/ajaxCheckEmail.php",
							success: function (result) {
								if(result === "free") {
									$.ajax({
										type: "POST",
										data: {"email": email, "password": password},
										url: "/scripts/personal/ajaxModalSignUp.php",
										success: function (response) {
											if(response === "ok") {
												window.location.href = "/personal/registration-continue.php";
											} else {
												if(responseField.css('opacity') === "0") {
													responseField.html('<hr />An error has occured. Please try again.');
													responseField.css('opacity', '1');
												} else {
													responseField.css('opacity', '0');
													setTimeout(function () {
														responseField.html('<hr />An error has occured. Please try again.');
														responseField.css('opacity', '1');
													}, 300);
												}
											}
										},
										error: function(jqXHR, textStatus, errorThrown) {
											$.notify(textStatus + "; " + errorThrown, "error");
										}
									});
								} else {
									if(responseField.css('opacity') === "0") {
										responseField.html('<hr />Your email is already exists.');
										responseField.css('opacity', '1');
									} else {
										responseField.css('opacity', '0');
										setTimeout(function () {
											responseField.html('<hr />Your email is already exists.');
											responseField.css('opacity', '1');
										}, 300);
									}
								}
							},
							error: function(jqXHR, textStatus, errorThrown) {
								$.notify(textStatus + "; " + errorThrown, "error");
							}
						});
					} else {
						if(responseField.css('opacity') === "0") {
							responseField.html('<hr />Email format is incorrect.');
							responseField.css('opacity', '1');
						} else {
							responseField.css('opacity', '0');
							setTimeout(function () {
								responseField.html('<hr />Email format is incorrect.');
								responseField.css('opacity', '1');
							}, 300);
						}
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$.notify(textStatus + "; " + errorThrown, "error");
				}
			});
		} else {
			if(responseField.css('opacity') === "0") {
				responseField.html('<hr />Please fill in your email and password.');
				responseField.css('opacity', '1');
			} else {
				responseField.css('opacity', '0');
				setTimeout(function () {
					responseField.html('<hr />Please fill in your email and password.');
					responseField.css('opacity', '1');
				}, 300);
			}
		}
	});
});

function clearResponseField() {
	$('.response-field').html('');
	$('.response-field').css('opacity', '0');
	$('body').css('padding-right', '0');
}