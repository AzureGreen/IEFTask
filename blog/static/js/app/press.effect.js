define(['jquery'], function ($) {
	
	var canvas = {},
		centerX = 0,
		color = '',
		containers = $('.press-effect'),/*document.getElementsByClassName('press-effect'),*/
		context = {},
		element = {},
		radius = 0,

		requestAnimFrame = function () {
			return (
				window.requestAnimFrame ||
				window.mozRequestAnimFrame ||
				window.oRequestAnimFrame ||
				window.msequestAnimFrame ||
				function (callback) {
					window.setTimeout(callback, 1000 / 60);
				}
				);
		} ();

		init = function () {
			containers = Array.prototype.slice.call(containers);  /* convert object to array */
			for (var i = containers.length - 1; i >= 0; i--) {
				canvas = document.createElement('canvas');
				/*canvas.addEventListener('click', pressEffect);*/
				$('canvas').on('click', pressEffect);
				containers[i].appendChild(canvas);
				canvas.style.width = '100%';
				canvas.style.height = '100%';
				canvas.width = canvas.offsetWidth;
				canvas.height = canvas.offsetHeight;
			}
		},

		pressEffect = function (event) {
			element = event.toElement;
			color = element.parentElement.dataset.color;
			context = element.getContext('2d');
			radius = 0;
			centerX = event.offsetX;
			centerY = event.offsetY;
			context.clearRect(0, 0, element.width, element.height);
			drawEffect();

		},

		drawEffect = function () {
			context.beginPath();
			context.arc(centerX, centerY, radius, 0, 2 * Math.PI, false);
			context.fillStyle = color;
			context.fill();
			radius += 2;
			if (radius < element.width) {
				requestAnimFrame(drawEffect);
			}
		};

	return {
		init: init
	};
});





