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

<section class="container">
	
	<div class="article-detail"></div>

</section>

<template class="ad-template">
	<div class="article">
		<div class="block">
			<h2 class="title text-center"></h2>
			<p class="text-center">
				<i class="fa fa-calendar"></i>
				<time class="date"></time>
				<i class="fa fa-eye"></i>
				<span></span>
			</p>
		<div class="content"></div>
	<div class="pre-next">
		<div class="pre">
			<a href="">
				<span></span>
			</a>
		</div>
		<div class="next">
			<a href="">
				<span></span>
			</a>
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
<!-- <script src="./static/js/article.js" type="text/javascript" charset="utf-8" async defer></script> -->
<script src="./static/js/build/article.js" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>