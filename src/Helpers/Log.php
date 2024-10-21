<?php

namespace app\Helpers;

use app\Interfaces\LogHandlerInterface;

class Log
{
    private $handler;

    public function __construct(LogHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function writeLine($type, $message): void
    {
        $date = new \DateTime();
        $formattedMessage = "[" . $type . "][" . $date->format('Y-m-d H:i:s') . "]: " . $message;
        $this->handler->write($formattedMessage);
    }

    public function __destruct()
    {
        $this->handler->close();
    }
}
