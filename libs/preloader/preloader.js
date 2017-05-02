/**
 * Created by jeyfost on 02.05.2017.
 */

$(window).on('load', function () {
	var $preloader = $('#page-preloader'), $spinner = $preloader.find('.spinner');
	$spinner.delay(500).fadeOut();
	$preloader.delay(850).fadeOut('slow');
});
