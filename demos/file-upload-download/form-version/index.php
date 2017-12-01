<!DOCTYPE html>
<html>
<head>
	<title>file upload</title>
	<meta charset="utf-8">
</head>
<body>
<form action="do.upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<label>选择文件：
		<input type="file" name="uploadfile" accept="image/jpeg,image/gif,image/png" />
		<input type="submit" name="upload" value="上传文件">
	</label>
</form>
</body>
</html>