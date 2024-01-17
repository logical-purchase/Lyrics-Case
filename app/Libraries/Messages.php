<?php

namespace App\Libraries;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Messages implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function  onOpen(ConnectionInterface $conn)
    {
        // Almacenar la nueva conexión para enviar mensajes más tarde
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // El remitente no es el receptor, envíar a cada cliente conectado
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // La conexión está cerrada, elimínala, ya que ya no podemos enviarle mensajes
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has ocurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
