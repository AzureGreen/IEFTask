<!DOCTYPE html>
<html>
<head>
	<title>天边的黑雪</title>
	<meta charset="utf-8" />
	<meta keywords="天边的黑雪 zhangjiawei" />
	<meta description="我叫张嘉伟，这是我自己编写的blog，打算在这儿记录些有趣的东西">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
	<link rel="stylesheet" type="text/css" href="https://staticfile.qnssl.com/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="./static/css/index.css" />
	<link rel="Shortcut Icon" href="favicon.ico" />
</head>
<body>

<?php
	include_once './components/header.php';
?>

<section class="container photo">
	
	<div class="time-line">
		<div class="tl-spine"></div>
	</div>
	<div class="pop-up">
		<div class="big-img">
			<img src="" alt="hello world">
			<h2>hello world</h2>
		</div>
	</div>
	
<?php
	include_once './components/showmore.php';
?>

</section>


<template class="tl-template">
	<div class="tl-box">
		<div class="tl-content">
			<div class="tl-image-block">
				<img src="" alt="" class="tl-image">
			</div>
			<h2 class="tl-title"></h2>
			<p class="tl-introduction"></p>
			<div class="tl-extra-info">
				<time class="tl-date"></time>
			</div>
		</div>
		<div class="tl-icon">
			<i class="fa fa-camera" aria-hidden="true"></i>
		</div>
	</div>
</template>


<?php
	include_once './components/footer.php';
?>

<?php
	include_once './components/totop.php';
?>

<script src="./static/js/require.min.js" type="text/javascript" charset="utf-8" async defer></script>
<script src="./static/js/require.config.js" type="text/javascript" charset="utf-8" async defer></script>
<!-- <script src="./static/js/photo.js" type="text/javascript" charset="utf-8" async defer></script> -->
<script src="./static/js/build/photo.js" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>
