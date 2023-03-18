<?php

namespace process;

use localzet\Server\Connection\TcpConnection;

class WSS
{
    public function onConnect(TcpConnection $connection)
    {
        $connection->send(["messages" => 8]);
        echo "onConnect\n";
    }

    public function onWebSocketConnect(TcpConnection $connection, $http_buffer)
    {
    }

    public function onMessage(TcpConnection $connection, $data)
    {
        $connection->send("Оно прислало мне " . $data);
    }

    public function onClose(TcpConnection $connection)
    {
        echo "onClose\n";
    }
}
