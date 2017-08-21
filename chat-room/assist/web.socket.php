<?php

/**
* websocket for server
*/
class WebSocket
{
	private $listenSocket;
	private $socketsInfo = array();
	private $mcrypt_key = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
	private $userCount = 0;

	/**
	 * construct function
	 * @param string  $host    host ip address
	 * @param string  $port    port
	 * @param integer $backlog 
	 */
	public function __construct($host = 'localhost', $port = '8080', $backlog = 10)
	{
		$this->listenSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('socket_create failed');
		socket_set_option($this->listenSocket, SOL_SOCKET, SO_REUSEADDR, TRUE);
		socket_bind($this->listenSocket, $host, $port);
		socket_listen($this->listenSocket, $backlog);
  
		$this->socketsInfo[0] = ['socket' => $this->listenSocket];    // save listen socket
	}

	public function run()
	{
		while (true) {
			$write = $except = null;
			$read = array_column($this->socketsInfo, 'socket');	 // save read array for select will only save pendding I/O

			$ret = socket_select($read, $write, $except, 3600);

			if ($ret === false) {
				return;
			}

			foreach ($read as $socket) {
				
				if ($socket == $this->listenSocket) {
					// handle client connect
					$clientSocket = socket_accept($this->listenSocket);
					if ($clientSocket === false) {
						continue;
					}
					$this->connect($clientSocket);
				} else {

					$bytes = @socket_recv($socket, $buf, 2048, 0);
					echo($bytes);
					if (!$this->socketsInfo[(int)$socket]['handshake']) {
						$this->handshake($socket, $buf);
						continue;
					} else if ($bytes < 1) {
						$request = $this->disconnect($socket);
					} else {
						$request = $this->decodeMsg($buf);
					}

	                $msg = $this->handleMsg($socket, $request);
	                echo($msg."\r\n");
	                if ($request['type'] == 'chat') {
	                	$this->sendGroupMsg($msg, $socket);
	                } else {
	                	$this->sendSystemMsg($msg);
	                }
				}
			}
		}
	}

	/**
	 * save client socket info
	 * @param  resource $clientSocket 
	 * @return void               
	 */
	private function connect($clientSocket)
	{
		socket_getpeername($clientSocket, $ip, $port);
		$socketInfo = [
            'socket' => $clientSocket,
            'name' => '',
            'handshake' => false,
            'ip' => $ip,
            'port' => $port,
        ];

        $this->socketsInfo[(int)$clientSocket] = $socketInfo;
	}

	/**
	 * close connection, remove from array
	 * @param  resource $clientSocket 
	 * @return array         
	 */
	private function disconnect($clientSocket)
	{
		$msg = [
            'type' => 'logout',
            'content' => $this->socketsInfo[(int)$clientSocket]['name'],
        ];
 		unset($this->socketsInfo[(int)$clientSocket]);

        return $msg;
	}

	/**
	 * handle handshake protocol
	 * @param  resource $clientSocket 
	 * @param  string $buf          request header
	 * @return void               
	 */
	private function handshake($clientSocket, $buf)
	{
		if (preg_match('/Sec-WebSocket-Key: (.*)\r\n/', $buf, $matches)) {

			$key = base64_encode(sha1($matches[1].$this->mcrypt_key, true));

			$upgrade = "HTTP/1.1 101 Switching Protocols\r\n".
			"Upgrade: websocket\r\n".
			"Connection: Upgrade\r\n".
			"Sec-WebSocket-Accept: ". $key ."\r\n\r\n";

			socket_write($clientSocket, $upgrade, strlen($upgrade));

			$this->socketsInfo[(int)$clientSocket]['handshake'] = true;

			$msg = [
			'type' => 'handshake',
			'content' => 'finished'];

			$data = $this->encodeMsg(json_encode($msg));

			socket_write($clientSocket, $data, strlen($data));

		}
	}

	/**
	 * handle requset from client
	 * @param  resource $clientSocket 
	 * @param  array $request      
	 * @return string               msg wait to send
	 */
	private function handleMsg($clientSocket, $request)
	{
		$response = [];
		switch ($request["type"]) {
			case 'login':
				echo "\r\nenter login\r\n";
				$this->userCount++;
				$this->socketsInfo[(int)$clientSocket]['name'] = $request['content'];   // user name
				$response['type'] = 'login';
				$response['content'] = $request['content'];
				$response['usercount'] = $this->userCount;
				break;
			case 'logout':
				echo "\r\nenter logout\r\n";
				$this->userCount--;
				$this->socketsInfo[(int)$clientSocket]['name'] = $request['content'];   // user name
				$response['type'] = 'logout';
				$response['content'] = $request['content'];
				$response['usercount'] = $this->userCount;
				break;
			case 'chat':
				echo "\r\nenter chat\r\n";
				$response['type'] = 'chat';
				$response['content'] = $request['content'];
				$response['user'] = $this->socketsInfo[(int)$clientSocket]['name'];
				echo($response['content']."r\n");
				break;
			default:
				# code...
				break;
		}
		return $this->encodeMsg(json_encode($response));
	}


	private function sendSystemMsg($data)
	{
		foreach ($this->socketsInfo as $key => $socketInfo) {
			if ($socketInfo['socket'] == $this->listenSocket) {
				continue;
			}
			socket_write($socketInfo['socket'], $data, strlen($data));
		}
	}


	/**
	 * send msg to other user
	 * @param  string $data         
	 * @param  resource $clientSocket 
	 * @return void               
	 */
	private function sendGroupMsg($data, $clientSocket)
	{
		foreach ($this->socketsInfo as $key => $socketInfo) {
			if (($socketInfo['socket'] == $this->listenSocket) || ($socketInfo['socket'] == $clientSocket)) {
				continue;
			}
			socket_write($socketInfo['socket'], $data, strlen($data));
		}
	}


	private function sendPrivateMsg($msg, $socket)
	{
		$data = $this->encodeMsg($msg);
		socket_write($socket, $data);
	}


	/**
	 * decode(websocket)
	 * @param  string $buffer 
	 * @return string         
	 */
	private function decodeMsg($buffer)
	{
        $len = $masks = $data = $decoded = null;
        $len = ord($buffer[1]) & 127;
        if ($len === 126) {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);

        } else if ($len === 127) {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        } else {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }

        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }
        return json_decode($decoded, true);
	}

	/**
	 * encode(websocket)
	 * @param  string $msg 
	 * @return string      
	 */
	private function encodeMsg($msg) {
        $frame = [];
        $frame[0] = '81';
        $len = strlen($msg);
        if ($len < 126) {
            $frame[1] = $len < 16 ? '0' . dechex($len) : dechex($len);
        } else if ($len < 65025) {
            $s = dechex($len);
            $frame[1] = '7e' . str_repeat('0', 4 - strlen($s)) . $s;
        } else {
            $s = dechex($len);
            $frame[1] = '7f' . str_repeat('0', 16 - strlen($s)) . $s;
        }

        $data = '';
        for ($i = 0; $i < $len; $i++) {
            $data .= dechex(ord($msg{$i}));
        }
        $frame[2] = $data;

        $data = implode('', $frame);

        return pack("H*", $data);
    }

}
