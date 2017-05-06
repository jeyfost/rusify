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

	});
});