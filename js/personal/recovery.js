/**
 * Created by jeyfost on 15.05.2017.
 */

$(window).load(function () {
	$('.btn-password-recovery').click(function () {
		var password = $('#passwordInput').val();
		var hash = $('.btn-password-recovery').attr("hash");

		if(password !== '') {
			$.ajax({
				type: "POST",
				data: {"password": password, "hash": hash},
				url: "/scripts/personal/ajaxSetRecoveredPassword.php",
				success: function (response) {
					switch(response) {
						case "ok":
							$('.form-400').css("opacity", "0");
							setTimeout(function () {
								$('.form-400').html("Your password was updated successfully. You may now <a href='' data-toggle='modal' data-target='#sign-in'>sign in</a> using your new password.");
								$('.form-400').css("opacity", "1");
							}, 300);
							break;
						case "failed":
							$.notify("Something goes wrong. Please try again or contact us.");
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
			$.notify("Enter new password", "error");
		}
	});
});