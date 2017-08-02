define(['jquery'], function ($) {

	var currentWantedGroup = 1,    /* int */

		bNoMore = false,           /* bool */

		/**
		 * request for photo block from server
		 * @return {void} 
		 */
		showPhotoBlock = function () {

			$.ajax({
				url: 'assist/getPhoto.php?wantedgroup=' + currentWantedGroup,
				type: 'GET',
				dataType: 'json',
				
			})
			.done(function(data) {
				
				if (!data.length) {
					bNoMore = true;
					return;
				}

				var innerHTML = '';
				/* insert innerhtml */
				data.forEach(function (value, index, array) {
					if (index % 2 == 0) {
						directionClass = "tl-left";
					} else {
						directionClass = "tl-right";
					}

					innerHTML += '\
					<div class="tl-box ' + directionClass + '"> \
						<div class="tl-content"> \
							<div class="tl-image-block"> \
								<img src="' + array[index]["image"] + '" alt="' + array[index]["title"] + '" class="tl-image"> \
							</div> \
							<h2 class="tl-title">' + array[index]["title"] + '</h2> \
							<p class="tl-introduction">' + array[index]["introduction"] + '</p> \
							<div class="tl-extra-info"> \
								<time class="tl-date">photographed on ' + array[index]["date"] + '</time> \
							</div> \
						</div> \
						<div class="tl-icon"> \
							<i class="fa fa-camera" aria-hidden="true"></i> \
						</div> \
					</div> ';
				});
				
				$('.time-line').append(innerHTML);
			})
			.fail(function(jqXHR, textStatus) {
				console.log("ajax: 请求图片 失败" + textStatus);
			});
		},

		/**
		 * respond to the click of showmore
		 * @return {void} 
		 */
		showMorePhoto = function () {
			/* 向服务器请求数据，新添加文章块 */
			if (!bNoMore) {
				currentWantedGroup++;

				showPhotoBlock();

				console.log("showMorePhoto: " + currentWantedGroup);
			} else {
				console.log("No more articles");
			}
		},

		/**
		 * display or hide pop-up image
		 * @param  {bool} bShow 
		 * @return {void}       
		 */
		popupImage = function (bShow) {
			if (bShow) {
				$('.pop-up').fadeIn(200);
			} else
			{
				$('.pop-up').fadeOut(200);			
			}
		},

		/**
		 * set up url & title
		 * @param {string} imgUrl   
		 * @param {string} imgTitle 
		 */
		setPopupImg = function (imgUrl, imgTitle) {
			var popUp = $('.pop-up');
			var img = popUp.find('img');
			var title = popUp.find('h2');

			img.attr('src',imgUrl);
			img.attr('alt',imgTitle);
			title.html(imgTitle);
		};

	return {

		showPhotoBlock: showPhotoBlock,

		showMorePhoto: showMorePhoto,

		setPopupImg: setPopupImg,

		popupImage: popupImage
	};
});