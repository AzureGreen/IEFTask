define(["jquery"],function(o){var n=function(){var n=o("html, body");0!=o(window).scrollTop()&&(n.is(":animated")||n.animate({scrollTop:0},400))},t=function(n){o(window).scrollTop()>n?o(".to-top").fadeIn(200):o(".to-top").fadeOut(200)};return{move:n,hide:t}});