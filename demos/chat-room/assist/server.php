<?php

set_time_limit(0);
require 'web.socket.php';
$webSocket = new WebSocket();
$webSocket->run();