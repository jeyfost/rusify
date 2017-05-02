/**
 * Created by jeyfost on 02.05.2017.
 */

$(document).ready(function () {
	var responseField = $('.response-field');

	$('.login-button').click(function () {
		var login = $('#loginInput').val();
		var password = $('#passwordInput').val();

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
							break;
						case "failed":
							$.notify("Something goes wrong. Please try again or contact us.", "error");
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
	})
});

function clearResponseField() {
	$('.response-field').html('');
	$('.response-field').css('opacity', '0');
}