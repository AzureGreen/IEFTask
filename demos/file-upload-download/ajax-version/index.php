<!DOCTYPE html>
<html>
<head>
	<title>file upload</title>
	<meta charset="utf-8">
	<style type="text/css">
		.upload-img {
			display: block;
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}
	</style>
</head>
<body>
<form action="do.upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<label>选择文件：
		<input type="file" name="uploadfile" accept="image/jpeg,image/gif,image/png" id="uploadfile" />
	</label>
</form>
<script src="./js/lib/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="./js/lib/jquery.ajaxfileupload.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		
		var interval;

		function applyAjaxFileUpload(ele) {
			$(ele).AjaxFileUpload({
				// 当前this表示 ele对象
				action: "do.upload.php",
				onChange: function (fileName) {
					var $span = $("<span />")
					.attr('class', $(this).attr('id'))
					.text('uploading')
					.insertAfter($(this));

					$(this).remove();

					interval = window.setInterval(function () {
						let text = $span.text();
						if (text.length < 13) {
							$span.text(text + ".");
						} else {
							$span.text('uploading');
						}
					}, 200);
				},
				onSubmit: function (fileName) {
					return true;
				},
				onComplete: function (fileName, response) {
					window.clearInterval(interval);
					var $span = $("span." + $(this).attr('id')).text(fileName + ' '),
						$fileInput = $('<input />')
							.attr({
								type: 'file',
								name: $(this).attr('name'),
								id: $(this).attr('id')
							});
					if (typeof(response.error) === "string") {
						$span.replaceWith($fileInput);					
						applyAjaxFileUpload($fileInput);
						alert(response.error);
						return;
					} else {
						$("<a />")
						.attr("href", "#")
						.text("x")
						.bind("click", function(e) {
							var img = $('img.upload-img');
							img.remove();
							$span.replaceWith($fileInput);
							applyAjaxFileUpload($fileInput);
						})
						.appendTo($span);
						$('<img />')
						.attr({
							src: "./" + response.name,
							alt: fileName,
							class: "upload-img"
						})
						.insertAfter($span);
					}
				}
			});
		}
		applyAjaxFileUpload('#uploadfile');
	});
</script>
</body>
</html>