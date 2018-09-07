<?php 

	$server = new \swoole_websocket_server('0.0.0.0', 9501);
	     
	$server->on('open', function (\swoole_websocket_server $server, $request) {
	    echo "server: handshake success with fd{$request->fd}\n";
	});
	 
	$server->on('message', function (\swoole_websocket_server $server, $frame) {
	    foreach($server->connections as $key => $fd) {
	        $user_message = $frame->data;
	        $user_message = json_decode($user_message,true);
			$user_message = json_encode($user_message,JSON_UNESCAPED_UNICODE);
	        $server->push($fd, $user_message);
	    }
	 
	});
	 
	$server->on('close', function ($ser, $fd) {
	    echo "client {$fd} closed\n";
	});
	 
	$server->start();
 
 ?>