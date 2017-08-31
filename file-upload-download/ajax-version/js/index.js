requirejs.config({
	baseUrl: './static/js',
	paths: {
		jquery: 'lib/jquery-3.2.1.min'
		
	}
});


require(['jquery'], function ($) {

	/**
	 * initialize sth
	 * @return {void} 
	 */
	$(document).ready(function () {
		//var username = 1;
		var username = prompt('input your name', '');
		if (!username) {
			alert('must input a name!');
			location.reload(false);   // fresh
		}
		var ws = new WebSocket("ws://127.0.0.1:8080/chat-room/assist/server.php");

		ws.onopen = function () {
			console.log('open');
		};

		ws.onmessage = function (e) {
			
			var msg = $.parseJSON(e.data);

			switch (msg.type) {
				case 'handshake':
					console.log('enter handshake\r\n');
					msg = {'type': 'login', 'content': username};
					sendToServer(msg);
					break;
				case 'login':
				case 'logout':
					console.log('enter login / logout \r\n');
					handleUser(msg.type, msg.content, msg.usercount);
					break;
				case 'chat':
					console.log('enter chat \r\n');
					displayMsg(msg.content, msg.user);
					break;

				default:
					break;
			}


			
		};

		ws.onclose = function (e) {
			console.log('close: ' + e.data);
		};

		ws.onerror = function (e) {
			console.log('error:' + e.data);
		};

		$('.chat-send-btn').click(function(){
			sendMsg();
		});

		$('.chat-input-msg').on('keypress', function(event) {
			if (event.keyCode == 13) {
				sendMsg();
			}
		});

		// window.onbeforeunload = function () {
		// 	ws.close();
		// };

		/**
		 * transform msg to json and send msg
		 * @param  {object} msg 
		 * @return {void}     
		 */
		function sendToServer(msg) {
			let data = JSON.stringify(msg);
			ws.send(data);
		}

		/**
		 * handle user login/ logout msg
		 * @param  {string} type  
		 * @param  {string} name  
		 * @param  {int} count 
		 * @return {void}       
		 */
		function handleUser(type, name, count) {
			let template = $('.chat-system-template').html();
			let temp = $(template);
			let text = name + " " + type;
			console.log(text);
			temp.find('span').text(text);
			let chatDlg = $('.chat-dlg');
			chatDlg.append(temp); 
			chatDlg.animate({scrollTop: chatDlg[0].scrollHeight - chatDlg[0].offsetHeight}, 200);

			//updateUserCount
			$('.chat-head').find('em').text(count);
		}

		function displayMsg(content, user) {
			let template = $('.chat-left-template').html();
			let temp = $(template);
			temp.find('.chat-msg').children('span').text(content);
			
			let chatDlg = $('.chat-dlg');
			chatDlg.append(temp); 
			chatDlg.animate({scrollTop: chatDlg[0].scrollHeight - chatDlg[0].offsetHeight}, 200);
		}

		/**
		 * send msg to server and show msg on dlg
		 * @return {void} 
		 */
		sendMsg = function () {
			
			let data = $('.chat-input-msg').val();

			let msg = {'type': 'chat', 'content': data};

			sendToServer(msg);

			$('.chat-input-msg').val('');
			
			let template = $('.chat-right-template').html();
			let temp = $(template);
			temp.find('.chat-msg').children('span').text(data);
			
			let chatDlg = $('.chat-dlg');
			chatDlg.append(temp); 
			chatDlg.animate({scrollTop: chatDlg[0].scrollHeight - chatDlg[0].offsetHeight}, 200);
		};

	});

});

